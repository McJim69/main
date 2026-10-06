<?php
require_once("connect.php");

// Turn off output buffering artifacts & ensure JSON output
if (ob_get_length()) { ob_clean(); }
header('Content-Type: application/json; charset=utf-8');

try {
    // Ensure user is admin
    if (!isset($_SESSION['user']) || !isset($_SESSION['access']) || $_SESSION['access'] !== 'Admin') {
        echo json_encode(["status" => "ERROR", "message" => "Unauthorized access."]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
        echo json_encode(["status" => "ERROR", "message" => "Total upload payload size exceeds PHP post_max_size limit (" . ini_get('post_max_size') . "). Please select smaller files."]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'] ?? '';
        if ($action === 'get') {
            $pid = intval($_GET['pid'] ?? 0);
            if ($pid > 0) {
                $stmt = $conn->prepare("
                    SELECT p.*, d.long_desc, d.how_itworks, d.management, d.mgt_public, d.mgt_admin, d.features, d.tech_used 
                    FROM projects p 
                    LEFT JOIN projects_details d ON p.pid = d.pid 
                    WHERE p.pid = ?
                ");
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($row = $result->fetch_assoc()) {
                    // Fetch images
                    $img_stmt = $conn->prepare("SELECT sid, imgUrl FROM projects_images WHERE pid = ?");
                    $img_stmt->bind_param("i", $pid);
                    $img_stmt->execute();
                    $img_res = $img_stmt->get_result();
                    $images = [];
                    while ($img_row = $img_res->fetch_assoc()) {
                        $images[] = $img_row;
                    }
                    $img_stmt->close();
                    $row['images'] = $images;

                    echo json_encode(["status" => "OK", "data" => $row]);
                } else {
                    echo json_encode(["status" => "ERROR", "message" => "Project not found."]);
                }
                $stmt->close();
            } else {
                echo json_encode(["status" => "ERROR", "message" => "Invalid ID."]);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        
        if ($action === 'delete') {
            $pid = intval($_POST['pid'] ?? 0);
            if ($pid > 0) {
                $stmt = $conn->prepare("DELETE FROM projects WHERE pid = ?");
                $stmt->bind_param("i", $pid);
                if ($stmt->execute()) {
                    echo json_encode(["status" => "OK"]);
                } else {
                    echo json_encode(["status" => "ERROR", "message" => $stmt->error]);
                }
                $stmt->close();
            }
        } elseif ($action === 'delete_image') {
            $sid = intval($_POST['sid'] ?? 0);
            if ($sid > 0) {
                // Get imgUrl to delete file
                $stmt = $conn->prepare("SELECT imgUrl FROM projects_images WHERE sid = ?");
                $stmt->bind_param("i", $sid);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($row = $res->fetch_assoc()) {
                    $file_path = __DIR__ . '/' . $row['imgUrl'];
                    if (file_exists($file_path) && !is_dir($file_path)) {
                        @unlink($file_path);
                    }
                }
                $stmt->close();

                // Delete from DB
                $stmt2 = $conn->prepare("DELETE FROM projects_images WHERE sid = ?");
                $stmt2->bind_param("i", $sid);
                if ($stmt2->execute()) {
                    echo json_encode(["status" => "OK"]);
                } else {
                    echo json_encode(["status" => "ERROR", "message" => $stmt2->error]);
                }
                $stmt2->close();
            }
        } elseif ($action === 'create' || $action === 'update') {
            $pid = intval($_POST['pid'] ?? 0);
            $pname = $_POST['pname'] ?? '';
            $desc = $_POST['description'] ?? '';
            $plink = $_POST['plink'] ?? '';
            $pimgUrl = $_POST['pimgUrl'] ?? '';
            
            $long_desc = $_POST['long_desc'] ?? '';
            $how_itworks = $_POST['how_itworks'] ?? '';
            $management = $_POST['management'] ?? '';
            $mgt_public = $_POST['mgt_public'] ?? '';
            $mgt_admin = $_POST['mgt_admin'] ?? '';
            $features = $_POST['features'] ?? '';
            $tech_used = $_POST['tech_used'] ?? '';

            if (empty($pimgUrl) && !empty($plink)) {
                $pimgUrl = "images/projects/" . preg_replace('/[^a-zA-Z0-9_-]/', '_', $plink) . "/logo.png";
            }

            if ($action === 'create') {
                $stmt = $conn->prepare("INSERT INTO projects (pname, description, plink, pimgUrl) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $pname, $desc, $plink, $pimgUrl);
                if ($stmt->execute()) {
                    $target_pid = $stmt->insert_id;
                    $stmt->close();
                    
                    $stmt2 = $conn->prepare("INSERT INTO projects_details (pid, long_desc, how_itworks, management, mgt_public, mgt_admin, features, tech_used) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt2->bind_param("isssssss", $target_pid, $long_desc, $how_itworks, $management, $mgt_public, $mgt_admin, $features, $tech_used);
                    $stmt2->execute();
                    $stmt2->close();

                    // Handle file uploads
                    handleUploadedImages($conn, $target_pid, $plink);
                    echo json_encode(["status" => "OK"]);
                } else {
                    echo json_encode(["status" => "ERROR", "message" => $stmt->error]);
                }
            } elseif ($action === 'update' && $pid > 0) {
                $stmt = $conn->prepare("UPDATE projects SET pname=?, description=?, plink=?, pimgUrl=? WHERE pid=?");
                $stmt->bind_param("ssssi", $pname, $desc, $plink, $pimgUrl, $pid);
                if ($stmt->execute()) {
                    $stmt->close();
                    
                    // Check if details exist
                    $check = $conn->prepare("SELECT did FROM projects_details WHERE pid=?");
                    $check->bind_param("i", $pid);
                    $check->execute();
                    $res = $check->get_result();
                    if ($res->num_rows > 0) {
                        $stmt2 = $conn->prepare("UPDATE projects_details SET long_desc=?, how_itworks=?, management=?, mgt_public=?, mgt_admin=?, features=?, tech_used=? WHERE pid=?");
                        $stmt2->bind_param("sssssssi", $long_desc, $how_itworks, $management, $mgt_public, $mgt_admin, $features, $tech_used, $pid);
                        $stmt2->execute();
                        $stmt2->close();
                    } else {
                        $stmt2 = $conn->prepare("INSERT INTO projects_details (pid, long_desc, how_itworks, management, mgt_public, mgt_admin, features, tech_used) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt2->bind_param("isssssss", $pid, $long_desc, $how_itworks, $management, $mgt_public, $mgt_admin, $features, $tech_used);
                        $stmt2->execute();
                        $stmt2->close();
                    }
                    $check->close();

                    // Handle file uploads for update
                    handleUploadedImages($conn, $pid, $plink);
                    echo json_encode(["status" => "OK"]);
                } else {
                    echo json_encode(["status" => "ERROR", "message" => $stmt->error]);
                }
            }
        }
    }
} catch (Throwable $e) {
    if (ob_get_length()) { ob_clean(); }
    echo json_encode(["status" => "ERROR", "message" => $e->getMessage()]);
    exit;
}

function handleUploadedImages($conn, $pid, $plink) {
    if (!empty($_FILES['project_images']['name'][0])) {
        $clean_folder = preg_replace('/[^a-zA-Z0-9_-]/', '_', $plink);
        $upload_dir = __DIR__ . '/images/projects/' . $clean_folder . '/';
        if (!is_dir($upload_dir)) {
            @mkdir($upload_dir, 0777, true);
        }
        foreach ($_FILES['project_images']['name'] as $key => $filename) {
            $err = $_FILES['project_images']['error'][$key] ?? UPLOAD_ERR_NO_FILE;
            $tmp_name = $_FILES['project_images']['tmp_name'][$key] ?? '';
            if ($err === UPLOAD_ERR_OK && is_uploaded_file($tmp_name)) {
                $clean_filename = time() . '_' . $key . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($filename));
                $target_file = $upload_dir . $clean_filename;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $img_db_path = 'images/projects/' . $clean_folder . '/' . $clean_filename;
                    $stmt3 = $conn->prepare("INSERT INTO projects_images (pid, imgUrl) VALUES (?, ?)");
                    if ($stmt3) {
                        $stmt3->bind_param("is", $pid, $img_db_path);
                        $stmt3->execute();
                        $stmt3->close();
                    }
                }
            }
        }
    }
}
?>
