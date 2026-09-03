<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");

	if (!isset($_SESSION["uno"])) {
		header("location:login.php");
		exit();
	}

	$UID = $_SESSION["uno"];

	if (isset($_POST['update'])) {
		$fname = $_POST['fullname'];
		$uname = $_POST['username'];
		$new_pass = $_POST['password'];

		try {
			if (!empty($new_pass)) {
				$hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
				$stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ?, password = ? WHERE uno = ?");
				$stmt->bind_param("sssi", $fname, $uname, $hashed_pass, $UID);
			} else {
				$stmt = $conn->prepare("UPDATE users SET fullname = ?, username = ? WHERE uno = ?");
				$stmt->bind_param("ssi", $fname, $uname, $UID);
			}

			if ($stmt->execute()) {
				$_SESSION["fullname"] = $fname;
				$_SESSION["user"] = $uname;
				if (!empty($new_pass)) $_SESSION["pass"] = $hashed_pass;

				echo "<script>window.history.back();</script>";
			}

			$stmt->close();

		} catch (mysqli_sql_exception $e) {
			if (strpos($e->getMessage(), 'Duplicate') !== false) {
				echo "<script>alert('ERROR! Duplicate entry. Fullname or Username already exists.'); window.history.back();</script>";
			} else {
				echo "<script>alert('ERROR! " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
			}
		}
	}
	
	if (isset($_POST['remove'])) {
		$UID = $_SESSION["uno"];

		try {
			$stmt = $conn->prepare("UPDATE users SET status='inactive' WHERE uno=?");
			$stmt->bind_param("i", $UID);

			if ($stmt->execute()) {
				echo "<script>alert('Your account has been deactivated.'); window.location='logout.php';</script>";
			}
			$stmt->close();

		} catch (mysqli_sql_exception $e) {
			echo "<script>alert('ERROR! " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
		}
	}

	if (isset($_POST["b_upImg_$UID"]) && !empty($_FILES["b_file_$UID"]["tmp_name"])) {
		$file = $_FILES["b_file_$UID"]["tmp_name"];
		$image_name = basename($_FILES["b_file_$UID"]["name"]);
		$image_info = getimagesize($file);

		if ($image_info !== false) {
			$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
			$extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

			if (in_array($extension, $allowed_extensions)) {
				// Generate secure, unique filename
				$new_image_name = uniqid('user_', true) . '.' . $extension;
				$upload_path = "images/users/" . $new_image_name;

				if (move_uploaded_file($file, $upload_path)) {
					// Delete old image if exists and not default
					$old_img_name = isset($_SESSION['imgUrl']) ? $_SESSION['imgUrl'] : '';
					$old_image = "images/users/" . $old_img_name;
					if (!empty($old_img_name) && file_exists($old_image) && $old_img_name !== 'mcjim.jpg') {
						unlink($old_image);
					}

					// Update DB only if account is active
					$update_stmt = $conn->prepare("UPDATE users SET imgUrl=? WHERE uno=? AND status='active'");
					$update_stmt->bind_param("si", $new_image_name, $UID);
					$update = $update_stmt->execute();
					$update_stmt->close();

					if ($update === TRUE) {
						$_SESSION['imgUrl'] = $new_image_name;
						echo "<script>window.history.back();</script>";
						exit();
					}
				}
			}
		}
		echo "<script>alert('ERROR! Invalid file format or upload error.'); window.location='index.php';</script>";
		exit();
	}
?>

<script>setActive("user");</script>

<style>
@media(min-width:1200px){.desk{display:none}}
@media(max-width: 768px){.mobi{display:none}.mobi h1{font-size:20px}}
.closebtn img{background:#bbb;padding:10px;height:30px;width:30px;border-radius:50%}
.closebtn{position:absolute;top:10px;right:10px;opacity:.5}
.closebtn:hover{opacity:1.0;}
</style>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat; background-size:cover;background-position:center center">
	<div class="container">
		<div class="row justify-content-center" style="margin-top:-70px">                       
			<div class="col-lg-5">
				<div class="login-card" style="position:relative">
				<div class="closebtn" onclick="window.history.back()">
					<img src="images/close.png" />
				</div>
				<form action="user_profile.php" method="post" enctype="multipart/form-data">	
				<?php
					if (isset($_SESSION['user'])) {
					$disp_img = "images/user.webp";
					if (isset($_SESSION['imgUrl']) && !empty($_SESSION['imgUrl'])) {
						$imgPath = "images/users/" . $_SESSION['imgUrl'];
						if (file_exists(__DIR__ . "/" . $imgPath)) {
							$disp_img = $imgPath;
						}
					}
					$disp_user   = htmlspecialchars($_SESSION['user']);
					$disp_access = isset($_SESSION['access']) ? htmlspecialchars($_SESSION['access']) : '';
					$uid         = $UID; // make sure $UID is defined earlier

				?>
				<div style="text-align:center">
					<input type="file" name="b_file_<?php echo $uid; ?>" id="b_file_<?php echo $uid; ?>" style="display:none" onchange="if(this.value!='')$('#b_upImg_<?php echo $uid; ?>').click();"/>
					<input type="submit" name="b_upImg_<?php echo $uid; ?>" id="b_upImg_<?php echo $uid; ?>" value="Upload" style="display:none"/>

					<img src="<?php echo htmlspecialchars($disp_img) . '?' . date('H:i:s'); ?>"
						 onclick="$('#b_file_<?php echo $uid; ?>').click();" style="width:100px;border-radius:50%;margin-top:-10px;aspect-ratio:2/2;cursor:pointer;object-fit:cover;"/>
				</div>
				<div style="text-align:center;margin:20px">
					<b><?php echo" ".$disp_user." - ".$disp_access.""; ?> <x class="mobi"> Account</b>
				</div>
				<?php } ?>
					<div class="my-2">
						<div class="text-muted text-left"><small>Full Name</small></div>
						<div class="form-group">
							<input class="form-control" name="fullname" type="text" value="<?php echo htmlspecialchars(isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '');?>" required>
						</div>
						<div class="text-muted text-left"><small>Username</small></div>
						<div class="form-group">
							<input class="form-control" name="username" type="text" value="<?php echo htmlspecialchars(isset($_SESSION['user']) ? $_SESSION['user'] : '');?>" required>
						</div>	
						<div class="text-muted text-left"><small>Password</small></div>
						<div class="form-group" style="position:relative">
							<input class="form-control" id="password" name="password" type="password" placeholder="Leave blank to keep current">
							<button type="button" onclick="togglePassword('password')" 
									style="position:absolute;right:0;top:50%;transform:translateY(-50%);
										   background:none;border:none;cursor:pointer">👁</button>
						</div>
						<div style="width:100%;margin-top:20px">
							<input  style="width:49%" class="btn" type="submit" name="update" value="Update" title="Update Profile">
							<button style="width:49%" class="btn" type="submit" name="remove" onclick="return confirm('Are you sure you want to deactivate your account?');">Remove</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
// --- Toggle show/hide password ---
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}
</script>

<?php include("footer.php");?>
