<?php
	session_start();
	require("connect.php");

	// Auth + Admin guard — only admins can remove users
	if (!isset($_SESSION['user']) || !isset($_SESSION['access']) || $_SESSION['access'] !== 'Admin') {
		header("Location: login.php");
		exit;
	}

	if (isset($_POST['delete'])) {
		$UID = $_POST['uno']; // gikan sa hidden input sa grid list

		try {
			// Get user info first (para ma‑unlink ang image)
			$stmt = $conn->prepare("SELECT imgUrl FROM users WHERE uno=?");
			$stmt->bind_param("i", $UID);
			$stmt->execute();
			$result = $stmt->get_result();
			$user = $result->fetch_assoc();
			$stmt->close();

			// Unlink image if exists and not blank
			if (!empty($user['imgUrl'])) {
				$imgPath = "images/users/" . $user['imgUrl'];
				if (file_exists($imgPath)) {
					unlink($imgPath);
				}
			}

			// Hard delete user record
			$del_stmt = $conn->prepare("DELETE FROM users WHERE uno=?");
			$del_stmt->bind_param("i", $UID);

			if ($del_stmt->execute()) {
				echo "<script>alert('User account has been permanently removed.'); window.location='admin-users.php';</script>";
				exit();
			}

			$del_stmt->close();

		} catch (mysqli_sql_exception $e) {
			echo "<script>alert('ERROR! " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
			exit();
		}
	}
?>
