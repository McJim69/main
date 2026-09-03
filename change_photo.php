<?php
session_start();
require("connect.php");

if(isset($_POST['post_id']) && isset($_FILES['photo'])){
    $post_id = (int)$_POST['post_id'];
    $file = $_FILES['photo'];

    // basic validation
    if($file['error'] == 0){
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = "post_".$post_id."_".time().".".$ext;
        $target = "uploads/".$newName;

        if(move_uploaded_file($file['tmp_name'], $target)){
            // update DB
            $stmt = $conn->prepare("UPDATE blog_posts SET image=? WHERE id=?");
            $stmt->bind_param("si", $newName, $post_id);
            $stmt->execute();

            header("Location: blog_details.php?id=".$post_id);
            exit;
        } else {
            echo "Upload failed.";
        }
    } else {
        echo "File error.";
    }
}
?>
