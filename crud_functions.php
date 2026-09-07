<?php
// =======================
// crud_functions.php
// =======================
// Blog Posts CRUD

// -------------------- CREATE --------------------
function createBlogPost($conn, $user_uno, $title, $content, $images = []) {
    $sql = "INSERT INTO blog_posts (user_uno, title, content, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("iss", $user_uno, $title, $content);
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }
    
    $post_id = $stmt->insert_id;
    $stmt->close();

    if (!empty($images) && is_array($images)) {
        $sqlImg = "INSERT INTO post_images (post_id, uploaded_by, image_url, uploaded_at) VALUES (?, ?, ?, NOW())";
        $stmtImg = $conn->prepare($sqlImg);
        
        if ($stmtImg) {
            foreach ($images as $img) {
                $stmtImg->bind_param("iis", $post_id, $user_uno, $img);
                $stmtImg->execute();
            }
            $stmtImg->close();
        }
    }
    return $post_id;
}

// -------------------- IMAGE HELPER FUNCTIONS --------------------
if (!function_exists('cleanPath')) {
    function cleanPath($path) {
        return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    }
}

if (!function_exists('convertAndResizeToWebp')) {
    function convertAndResizeToWebp($sourcePath, $maxWidth = 1920, $maxHeight = 1920, $quality = 80) {
        if (!function_exists('imagecreatetruecolor')) {
            return $sourcePath;
        }

        $info = @getimagesize($sourcePath);
        if (!$info) return $sourcePath;

        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg': 
            case 'image/jpg':
                $srcImage = @imagecreatefromjpeg($sourcePath); 
                break;
            case 'image/png':  
                $srcImage = @imagecreatefrompng($sourcePath); 
                break;
            case 'image/gif':  
                $srcImage = @imagecreatefromgif($sourcePath); 
                break;
            case 'image/webp': 
                if (function_exists('imagecreatefromwebp')) {
                    $srcImage = @imagecreatefromwebp($sourcePath); 
                } else {
                    return $sourcePath;
                }
                break;
            default: return $sourcePath;
        }

        if (!$srcImage) return $sourcePath;

        $origWidth  = imagesx($srcImage);
        $origHeight = imagesy($srcImage);

        $ratio = $origWidth / $origHeight;
        $newWidth  = $origWidth;
        $newHeight = $origHeight;

        if ($newWidth > $maxWidth) {
            $newWidth  = $maxWidth;
            $newHeight = round($newWidth / $ratio);
        }

        if ($newHeight > $maxHeight) {
            $newHeight = $maxHeight;
            $newWidth  = round($newHeight * $ratio);
        }

        $finalImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($mime == 'image/png' || $mime == 'image/webp' || $mime == 'image/gif') {
            imagealphablending($finalImage, false);
            imagesavealpha($finalImage, true);
        }

        imagecopyresampled($finalImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        $pathInfo = pathinfo($sourcePath);
        $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

        if (function_exists('imagewebp')) {
            if (imagewebp($finalImage, $webpPath, $quality)) {
                imagedestroy($srcImage);
                imagedestroy($finalImage);

                if (cleanPath($sourcePath) !== cleanPath($webpPath) && file_exists($sourcePath)) {
                    @unlink($sourcePath);
                }
                return $webpPath;
            }
        }

        imagedestroy($srcImage);
        imagedestroy($finalImage);
        return $sourcePath;
    }
}

// -------------------- READ SINGLE --------------------
function readBlogPost($conn, $id) {
    if ($id <= 0) return null;

    $sql = "SELECT bp.*, u.username, u.fullname, u.imgUrl 
            FROM blog_posts bp 
            JOIN users u ON bp.user_uno = u.uno 
            WHERE bp.id = ?";
            
    $stmt = $conn->prepare($sql);
    if (!$stmt) return null;

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $post = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$post) return null;

    if (function_exists('getPostImages')) {
        $post['images'] = getPostImages($conn, $id);
    } else {
        $post['images'] = [];
    }
    
    return $post;
}

// -------------------- READ LIST (OPTIMIZED) --------------------
function listBlogPosts($conn, $limit = 10) {
    $sql = "SELECT bp.*, u.username, u.fullname, u.imgUrl 
            FROM blog_posts bp 
            JOIN users u ON bp.user_uno = u.uno 
            ORDER BY bp.created_at DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];

    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    if (empty($posts)) return [];

    $postIds = array_column($posts, 'id');
    $inClause = implode(',', array_fill(0, count($postIds), '?'));
    
    $sqlImg = "SELECT id, post_id, image_url, uploaded_by FROM post_images WHERE post_id IN ($inClause)";
    $stmtImg = $conn->prepare($sqlImg);
    if ($stmtImg) {
        $types = str_repeat('i', count($postIds));
        $stmtImg->bind_param($types, ...$postIds);
        $stmtImg->execute();
        $allImages = $stmtImg->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmtImg->close();

        $imageMap = [];
        foreach ($allImages as $img) {
            $imageMap[$img['post_id']][] = [
                'id' => $img['id'],
                'image_url' => $img['image_url'],
                'uploaded_by' => $img['uploaded_by']
            ];
        }

        foreach ($posts as &$post) {
            $post['images'] = $imageMap[$post['id']] ?? [];
        }
    }

    return $posts;
}

// -------------------- UPDATE --------------------
function updateBlogPostWithImages($conn, $post_id, $title, $content, $user_uno, $images = [], $user_access = '') {
    if ($user_access === 'Admin') {
        $sql = "UPDATE blog_posts SET title=?, content=?, updated_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("ssi", $title, $content, $post_id);
    } else {
        $sql = "UPDATE blog_posts SET title=?, content=?, updated_at=NOW() WHERE id=? AND user_uno=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("ssii", $title, $content, $post_id, $user_uno);
    }
    
    $executed = $stmt->execute();
    $stmt->close();

    if (!$executed) return false;

    if (!empty($images) && is_array($images)) {
        $sqlImg = "INSERT INTO post_images (post_id, uploaded_by, image_url, uploaded_at) VALUES (?, ?, ?, NOW())";
        $stmtImg = $conn->prepare($sqlImg);
        
        if ($stmtImg) {
            foreach ($images as $img) {
                $stmtImg->bind_param("iis", $post_id, $user_uno, $img);
                $stmtImg->execute();
            }
            $stmtImg->close();
        }
    }
    
    return true; 
}

// -------------------- DELETE SINGLE IMAGE --------------------
function deletePostImage($conn, $image_id) {
    $sqlSelect = "SELECT image_url FROM post_images WHERE id=?";
    $stmtSel = $conn->prepare($sqlSelect);
    if ($stmtSel) {
        $stmtSel->bind_param("i", $image_id);
        $stmtSel->execute();
        $res = $stmtSel->get_result()->fetch_assoc();
        $stmtSel->close();
        
        if ($res && !empty($res['image_url'])) {
            $physicalPath = __DIR__ . '/' . ltrim($res['image_url'], '/');
            if (file_exists($physicalPath)) {
                @unlink($physicalPath);
            }
        }
    }

    $sql = "DELETE FROM post_images WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("i", $image_id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

// -------------------- DELETE POST WITH CASCADE IMAGES --------------------
function deleteBlogPost($conn, $post_id, $user_uno = 0, $user_access = '') {
    $images = getPostImages($conn, $post_id);
    foreach ($images as $img) {
        $physicalPath = __DIR__ . '/' . ltrim($img['image_url'], '/');
        if (file_exists($physicalPath)) {
            @unlink($physicalPath);
        }
    }

    $stmtDelImg = $conn->prepare("DELETE FROM post_images WHERE post_id=?");
    if ($stmtDelImg) {
        $stmtDelImg->bind_param("i", $post_id);
        $stmtDelImg->execute();
        $stmtDelImg->close();
    }
    
    $stmtDelCom = $conn->prepare("DELETE FROM blog_comments WHERE post_id=?");
    if ($stmtDelCom) {
        $stmtDelCom->bind_param("i", $post_id);
        $stmtDelCom->execute();
        $stmtDelCom->close();
    }

    if ($user_access === 'Admin' || $user_uno == 0) {
        $sql = "DELETE FROM blog_posts WHERE id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $post_id);
    } else {
        $sql = "DELETE FROM blog_posts WHERE id=? AND user_uno=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("ii", $post_id, $user_uno);
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

// -------------------- HELPER READS --------------------
function getPostImages($conn, $post_id) {
    $sql = "SELECT id, image_url, uploaded_by FROM post_images WHERE post_id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];

    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $images;
}

function listRecentPosts($conn, $limit = 10) {
    $sql = "SELECT bp.id, bp.title, bp.created_at, u.fullname
            FROM blog_posts bp
            JOIN users u ON bp.user_uno = u.uno
            ORDER BY bp.created_at DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];

    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $posts;
}

// =========================================================================
// Blog Comments CRUD Functions
// =========================================================================

function createComment($conn, $post_id, $user_uno, $comment) {
    $sql = "INSERT INTO blog_comments (post_id, user_uno, comment, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;
    $stmt->bind_param("iis", $post_id, $user_uno, $comment);
    $ok = $stmt->execute();
    $insert_id = $stmt->insert_id;
    $stmt->close();
    return $ok ? $insert_id : false;
}

function readComment($conn, $id) {
    $sql = "SELECT bc.*, u.username, u.fullname, u.imgUrl 
            FROM blog_comments bc 
            JOIN users u ON bc.user_uno = u.uno 
            WHERE bc.id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return null;
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $comment = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $comment;
}

function listCommentsByPost($conn, $post_id) {
    $sql = "SELECT bc.*, u.username, u.fullname, u.imgUrl 
            FROM blog_comments bc 
            JOIN users u ON bc.user_uno = u.uno 
            WHERE bc.post_id = ? 
            ORDER BY bc.created_at ASC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return [];
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $comments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $comments;
}

function updateComment($conn, $comment_id, $comment, $user_uno = 0, $user_access = '') {
    if ($user_access === 'Admin' || $user_uno == 0) {
        $sql = "UPDATE blog_comments SET comment=?, created_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("si", $comment, $comment_id);
    } else {
        $sql = "UPDATE blog_comments SET comment=?, created_at=NOW() WHERE id=? AND user_uno=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("sii", $comment, $comment_id, $user_uno);
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

function deleteComment($conn, $comment_id, $user_uno = 0, $user_access = '') {
    if ($user_access === 'Admin' || $user_uno == 0) {
        $sql = "DELETE FROM blog_comments WHERE id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $comment_id);
    } else {
        $sql = "DELETE FROM blog_comments WHERE id=? AND user_uno=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("ii", $comment_id, $user_uno);
    }
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}
?>
