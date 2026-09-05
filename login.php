<?php
	// login.php
	session_start();
	require("connect.php");

	$m = "";

	if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["login"])) {
		$user = trim($_POST["user"] ?? "");
		$pass = $_POST["pass"] ?? "";

		try {
			$stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
			$stmt->bind_param("s", $user);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($rs = $result->fetch_assoc()) {
				if ($rs['status'] !== 'active') {
					$m = "ACCESS DENIED! Account inactive.";
				} else {
					$login_ok = false;

					// ✅ Password check (hashed or legacy plaintext)
					if (password_verify($pass, $rs['password'])) {
						$login_ok = true;
					} elseif ($pass === $rs['password']) {
						// ⚠ Legacy plaintext → migrate to hash
						$newHash = password_hash($pass, PASSWORD_DEFAULT);
						$update_stmt = $conn->prepare("UPDATE users SET password=? WHERE uno=?");
						$update_stmt->bind_param("si", $newHash, $rs['uno']);
						$update_stmt->execute();
						$update_stmt->close();
						$login_ok = true;
					}

					if ($login_ok) {
						// ✅ Per-user validity check
						$today = date("Y-m-d");
						if (!empty($rs['validity']) && $rs['validity'] > $today) {
							
							// 🔒 Secure session
							session_regenerate_id(true);

							// Set session variables
							$_SESSION["uno"]      = $rs["uno"];
							$_SESSION["user"]     = $rs["username"];
							$_SESSION["fullname"] = $rs["fullname"];
							$_SESSION["access"]   = $rs["access"];
							$_SESSION["imgUrl"]   = $rs["imgUrl"];
							$_SESSION["jellyfin"] = $rs["jellyfin"]; 				
							
							session_write_close();
							// Redirect to dashboard
							header("Location: dashboard.php");
							exit();
							
						} else {
							$m = "ACCESS DENIED! Your Access Validity has Expired.";
						}
					} else {
						$m = "ACCESS DENIED! Invalid Username or Password.";
					}
				}
			} else {
				$m = "ACCESS DENIED! Invalid Username or Password.";
			}

			$stmt->close();

		} catch (mysqli_sql_exception $e) {
			$m = "ERROR! " . htmlspecialchars($e->getMessage());
		}
	}

	// Render UI
	require("header.php");
	require("menunav.php");
?>

<script>setActive("login");</script>

<style>
@media(min-width:1200px){.desk{display:none}}
@media(max-width: 768px){.mobi{display:none}.mobi h1{font-size:20px}}
.closebtn img{background:#bbb;padding:10px;height:30px;width:30px;border-radius:50%}
.closebtn{position:absolute;top:10px;right:10px;opacity:.5}
.closebtn:hover{opacity:1.0;}
</style>

<div class="page-heading header-text">
	<div class="container">
		<div class="row justify-content-center" style="margin-top:-70px">                       
			<div class="col-lg-5">
				<div class="login-card" style="position:relative">
					<div class="closebtn" onclick="window.history.back()">
						<img src="images/close.png" />
					</div>				
					<div style="margin-top:-10px"><h1 style="margin-bottom:20px">Login</h1></div>
					<div class="text-muted"><small>Enter a valid username and password.</small></div>
					<div class="text-danger"><small><?php echo $m; ?></small></div>
					<form method="post" class="text-left"><br>
						<label>Username</label>
						<div class="form-group">
							<input class="form-control" name="user" type="text" placeholder="Username" required>
						</div>
						<label>Password</label>
						<div class="form-group" style="position:relative">
							<input class="form-control" id="password" name="pass" type="password" placeholder="Password" required>
			                <button type="button" onclick="togglePassword('password')" 
								style="position:absolute;right:0;top:50%;transform:translateY(-50%);
									   background:none;border:none;cursor:pointer">👁</button>
						</div><br>
						<div class="form-group">
							<button class="filled-button w-100" type="submit" name="login">
								Login
							</button>
						</div>
					</form>
					<small>
						<i class="fa fa-home"></i> <a href="index.php">Home</a> &nbsp; &bull; &nbsp;
						No Account? <a href="user_register.php"> <i class="fa fa-user-o"></i> Signup!</a>
					</small>
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

<noscript>
!Warning! Javascript must be enabled for proper operation of the Administrator.
</noscript>

<?php require("footer.php");?>