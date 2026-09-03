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
		// FIXED: Formatted the SQL structure to align flawlessly with your phpMyAdmin schema columns
		$sqlImg = "INSERT INTO post_images (post_id, uploaded_by, image_url, uploaded_at) VALUES (?, ?, ?, NOW())";
		$stmtImg = $conn->prepare($sqlImg);
		
		if ($stmtImg) {
			foreach ($images as $img) {
				// "iis" maps perfectly to:
				// 1st (?) -> integer: $post_id
				// 2nd (?) -> integer: $user_uno (the user tracking identity)
				// 3rd (?) -> string:  $img (the clean relative asset path)
				$stmtImg->bind_param("iis", $post_id, $user_uno, $img);
				$stmtImg->execute();
			}
			$stmtImg->close();
		}
	}
    return $post_id;
}

// -------------------- READ SINGLE --------------------
function readBlogPost($conn, $id) {
    // If ID is 0 or negative, don't waste a database query
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

    // Fixed: Added a check for getPostImages in case it doesn't exist
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

    // FIXED: Replaced the N+1 loop with a single aggregate mapping pass
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

        // Map images to their respective posts efficiently
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
function updateBlogPostWithImages($conn, $post_id, $title, $content, $user_uno, $images = []) {
    // SECURITY ENFORCEMENT: Ensure the active user actually owns the post they are trying to update
    $sql = "UPDATE blog_posts SET title=?, content=?, updated_at=NOW() WHERE id=? AND user_uno=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("ssii", $title, $content, $post_id, $user_uno);
    
    // Execute the statement securely
    $executed = $stmt->execute();
    $stmt->close();

    // If the database query itself crashes (syntax error/connection drop), abort
    if (!$executed) return false;

    // Proceed to process the images array
    if (!empty($images) && is_array($images)) {
        // Aligned perfectly with your physical phpMyAdmin schema columns: (post_id, uploaded_by, image_url)
        $sqlImg = "INSERT INTO post_images (post_id, uploaded_by, image_url, uploaded_at) VALUES (?, ?, ?, NOW())";
        $stmtImg = $conn->prepare($sqlImg);
        
        if ($stmtImg) {
            foreach ($images as $img) {
                // "iis" perfectly maps to: 
                // 1st (?) -> integer: $post_id
                // 2nd (?) -> integer: $user_uno
                // 3rd (?) -> string:  $img
                $stmtImg->bind_param("iis", $post_id, $user_uno, $img);
                $stmtImg->execute();
            }
            $stmtImg->close();
        }
    }
    
    // Always return true if the query executed, even if the text wasn't modified!
    return true; 
}

// -------------------- DELETE SINGLE IMAGE --------------------
function deletePostImage($conn, $image_id) {
    // 1. Locate and erase physical asset off disk first
    $sqlSelect = "SELECT image_url FROM post_images WHERE id=?";
    $stmtSel = $conn->prepare($sqlSelect);
    if ($stmtSel) {
        $stmtSel->bind_param("i", $image_id);
        $stmtSel->execute();
        $res = $stmtSel->get_result()->fetch_assoc();
        $stmtSel->close();
        
        if ($res && !empty($res['image_url'])) {
            // FIXED: Using direct __DIR__ linking context to ensure accurate web-root asset targets
            $physicalPath = __DIR__ . '/' . ltrim($res['image_url'], '/');
            if (file_exists($physicalPath)) {
                @unlink($physicalPath);
            }
        }
    }

    // 2. Erase the database record line row entry
    $sql = "DELETE FROM post_images WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("i", $image_id);
    $ok = $stmt->execute();
    $stmt->close();
    return $ok;
}

// -------------------- DELETE POST WITH CASCADE IMAGES --------------------
function deleteBlogPost($conn, $post_id) {
    // 1. Fetch all matching sub-table entries linked to this post
    $images = getPostImages($conn, $post_id);
    foreach ($images as $img) {
        // FIXED: Explicit root pathing resolution context
        $physicalPath = __DIR__ . '/' . ltrim($img['image_url'], '/');
        if (file_exists($physicalPath)) {
            @unlink($physicalPath); // Erases raw physical webp file from disk space
        }
    }

    // 2. Wipe image records from sub-table rows
    $sqlDelImg = "DELETE FROM post_images WHERE post_id=?";
    $stmtDelImg = $conn->prepare($sqlDelImg);
    if ($stmtDelImg) {
        $stmtDelImg->bind_param("i", $post_id);
        $stmtDelImg->execute();
        $stmtDelImg->close();
    }

    // 3. Drop primary post parent entry from blog_posts table rows securely
    $sql = "DELETE FROM blog_posts WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) return false;

    $stmt->bind_param("i", $post_id);
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

// Create Comment
function createComment($conn, $post_id, $user_uno, $comment) {
    $sql = "INSERT INTO blog_comments (post_id, user_uno, comment, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $post_id, $user_uno, $comment);
    return $stmt->execute() ? $conn->insert_id : false;
}

// Read Single Comment
function readComment($conn, $id) {
    $sql = "SELECT bc.*, u.username, u.fullname, u.imgUrl 
            FROM blog_comments bc 
            JOIN users u ON bc.user_uno = u.uno 
            WHERE bc.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// List Comments by Post
function listCommentsByPost($conn, $post_id) {
    $sql = "SELECT bc.*, u.username, u.fullname, u.imgUrl 
            FROM blog_comments bc 
            JOIN users u ON bc.user_uno = u.uno 
            WHERE bc.post_id = ? 
            ORDER BY bc.created_at ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Update Comment
function updateComment($conn, $comment_id, $comment) {
	$sql = "UPDATE blog_comments SET comment=?, created_at=NOW() WHERE id=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("si", $comment, $comment_id);
	return $stmt->execute();
}

// Delete Comment with Authorization Check
function deleteComment($conn, $comment_id, $user_uno) {
    $sql = "DELETE FROM blog_comments WHERE id=? AND user_uno=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $comment_id, $user_uno);
    return $stmt->execute();
}
?>
