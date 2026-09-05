<?php
	// user_register.php
	require("connect.php");
	require("header.php");
	require("menunav.php");

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$fullname = trim($_POST['fullname']);
		$access   = $_POST['access'] ?? 'User';
		$username = trim($_POST['username']);
		$password = $_POST['password'];
		$jeltoken = "93cc2300dbe64aaf98e878aca88813dd";
		
		// ✅ Hash password for local DB
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		// ✅ Validate image upload
		if (!isset($_FILES['image']) || empty($_FILES['image']['tmp_name'])) {
			echo "<script>alert('Profile picture is required.'); window.history.back();</script>";
			exit();
		}

		$file       = $_FILES['image']['tmp_name'];
		$image_name = basename($_FILES['image']['name']);
		$image_info = getimagesize($file);

		if ($image_info === false) {
			echo "<script>alert('Invalid image file.'); window.history.back();</script>";
			exit();
		}

		$allowed_extensions = ['jpg','jpeg','png','gif','webp'];
		$extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

		if (!in_array($extension, $allowed_extensions)) {
			echo "<script>alert('Invalid image format.'); window.history.back();</script>";
			exit();
		}

		$new_image_name = uniqid('user_', true) . '.' . $extension;
		$upload_path    = "images/users/" . $new_image_name;

		if (!move_uploaded_file($file, $upload_path)) {
			echo "<script>alert('Failed to upload profile picture.'); window.history.back();</script>";
			exit();
		}

		try {
			// ✅ Step 1: Insert into local DB
			$stmt = $conn->prepare(
				"INSERT INTO users (fullname, access, jellyfin, username, password, imgUrl, status, last_active, validity) 
				 VALUES (?, ?, ?, ?, ?, ?, 'active', NOW(), DATE_ADD(CURDATE(), INTERVAL 1 YEAR))"
			);
			$stmt->bind_param("ssssss", $fullname, $access, $jeltoken, $username, $hashed_password, $new_image_name);

			if ($stmt->execute()) {
				$uno = $stmt->insert_id;
				$stmt->close();

				// ✅ Step 2: Create Jellyfin user via API
				$url = "https://media.mcjim-server.com/Users/New";
				$payload = json_encode([
					"Name" => $username,
					"Password" => $password,
					"Policy" => new stdClass(),
					"Configuration" => new stdClass()
				]);
				$headers = [
					"Content-Type: application/json",
					"X-Emby-Authorization: MediaBrowser Client=\"PHP\", Device=\"Web\", DeviceId=\"12345\", Version=\"1.0\", Token=\"$jeltoken\""
				];

				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				$response = curl_exec($ch);
				curl_close($ch);

				$data = json_decode($response, true);
				$jellyfinUserId = $data["Id"] ?? null;

				if ($jellyfinUserId) {
					// ✅ Step 3: Store Jellyfin userId in DB
					$updateStmt = $conn->prepare("UPDATE users SET jellyfin_userid=? WHERE uno=?");
					$updateStmt->bind_param("si", $jellyfinUserId, $uno);
					$updateStmt->execute();
					$updateStmt->close();
				}

				echo "<script>alert('User account successfully created.'); window.location='login.php';</script>";
			} else {
				unlink($upload_path);
				echo "<script>alert('Failed to create account.'); window.history.back();</script>";
			}
		} catch (mysqli_sql_exception $e) {
			unlink($upload_path);
			echo "<script>alert('Database error: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
		}
	}
?>

<script>setActive("signup");</script>

<style>
.page-heading{background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center;}
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
          <div style="margin-top:-10px"><h1 style="margin-bottom:20px">Signup</h1></div>

          <!-- Progress bar -->
          <div id="progressContainer" style="background:#eee;border-radius:5px;height:10px">
            <div id="progressFill" style="height:100%;width:0%;background:green;border-radius:5px;transition:width 0.3s"></div>
          </div>
          <small id="progressText" class="text-muted">0% complete</small>

          <form id="signupForm" action="user_register.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="access" value="User">    

            <div class="form-group text-left" style="margin-top:10px">
              <!--<label class="text-muted">Full Name</label>-->
              <input class="form-control" type="text" name="fullname" id="fullname" placeholder="Full Name" required>
            </div>

            <div class="form-group text-left">
              <!--<label class="text-muted">Username</label>-->
              <input class="form-control" type="text" name="username" id="username" placeholder="Username" required>
              <small id="usernameMsg" class="text-muted"></small>
            </div>

            <div class="form-group text-left">
              <!--<label class="text-muted">Password</label>-->
              <div style="position:relative">
                <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
                <button type="button" onclick="togglePassword('password')" 
                        style="position:absolute;right:0;top:50%;transform:translateY(-50%);
                               background:none;border:none;cursor:pointer">👁</button>
              </div>
              <small class="text-muted">Minimum 6 characters</small>
              <div id="strengthBar" style="height:8px;background:#ddd;margin-top:5px;border-radius:4px;overflow:hidden">
                <div id="strengthFill" style="height:100%;width:0%;background:red;transition:width 0.3s"></div>
              </div>
              <span id="strengthText" class="text-muted"></span>
            </div>

            <div class="form-group text-left">
             <!--<label class="text-muted">Confirm Password</label>-->
              <div style="position:relative">
                <input class="form-control" type="password" id="confirmPassword" placeholder="Confirm Password" required>
                <button type="button" onclick="togglePassword('confirmPassword')" 
                        style="position:absolute;right:0;top:50%;transform:translateY(-50%);
                               background:none;border:none;cursor:pointer">👁</button>
              </div>
              <small id="confirmMsg" class="text-muted"></small>
            </div>

            <div class="form-group text-left">
              <!--<label class="text-muted">Profile Picture</label>--> 
              <input type="file" name="image" id="b_file" style="display:none" required onchange="previewFile(this)">
              <input class="form-control" id="fileBtn" value="Select Picture" 
                     onclick="document.getElementById('b_file').click();" required style="margin-top:-5px">
              <div id="preview" style="margin-top:10px;text-align:center"></div>
            </div>

            <div class="form-group text-center" style="margin-top:30px;margin-bottom:-5px">
              <input style="width:49%" class="btn" type="button" value="Cancel" onclick="window.history.back()"> 
              <input style="width:49%" class="btn" type="submit" name="submit" id="submitBtn" value="Submit" disabled>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("footer.php");?>

<script>
// --- Toggle show/hide password ---
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = field.type === "password" ? "text" : "password";
}

// --- Debounce helper ---
function debounce(func, delay) {
    let timer;
    return function(...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

// --- Validation state ---
let usernameValid = false;
let passwordValid = false;
let confirmValid = false;
let fullnameValid = false;

// --- Enable/disable submit ---
function updateSubmitState() {
    const btn = document.getElementById('submitBtn');
    btn.disabled = !(usernameValid && passwordValid && confirmValid && fullnameValid);
    updateProgress();
}

// --- Progress bar ---
function updateProgress() {
    let progress = 0;
    const fullname = document.getElementById('fullname').value.trim();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const file = document.getElementById('b_file').files.length;

    if (fullname.length >= 3) progress += 20;
    if (usernameValid) progress += 20;
    if (passwordValid) progress += 20;
    if (confirmValid) progress += 20;
    if (file > 0) progress += 20;

    document.getElementById('progressFill').style.width = progress + "%";
    document.getElementById('progressText').textContent = progress + "% complete";
}

// --- Fullname check ---
document.getElementById('fullname').addEventListener('input', function() {
    fullnameValid = this.value.trim().length >= 3;
    updateSubmitState();
});

// --- Username availability check ---
const checkUsername = debounce(function() {
    const username = document.getElementById('username').value.trim();
    const msg = document.getElementById('usernameMsg');

    if (username.length < 3) {
        msg.textContent = "✘ Username must be at least 3 characters.";
        msg.style.color = "red";
        usernameValid = false;
        updateSubmitState();
        return;
    }

    msg.textContent = "⏳ Checking...";
    msg.style.color = "blue";

    fetch("check_username.php?username=" + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                msg.textContent = "✔ Username is available";
                msg.style.color = "green";
                usernameValid = true;
            } else {
                msg.textContent = "✘ Username is already taken";
                msg.style.color = "red";
                usernameValid = false;
            }
            updateSubmitState();
        })
        .catch(() => {
            msg.textContent = "⚠ Error checking username.";
            msg.style.color = "orange";
            usernameValid = false;
            updateSubmitState();
        });
}, 500);

document.getElementById('username').addEventListener('input', checkUsername);

// --- Password strength meter ---
document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    let score = 0;

    if (val.length >= 6) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    let strength = "", color = "red", width = "25%";

    switch(score) {
        case 0:
        case 1:
            strength = "Weak"; color = "red"; width = "25%"; passwordValid = false; break;
        case 2:
            strength = "Fair"; color = "orange"; width = "50%"; passwordValid = true; break;
        case 3:
            strength = "Good"; color = "blue"; width = "75%"; passwordValid = true; break;
        case 4:
            strength = "Strong"; color = "green"; width = "100%"; passwordValid = true; break;
    }

    strengthFill.style.width = width;
    strengthFill.style.background = color;
    strengthText.textContent = strength;
    updateSubmitState();
});

// --- Confirm password live check ---
document.getElementById('confirmPassword').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmMsg = document.getElementById('confirmMsg');
    if (this.value === password && password.length >= 6) {
        confirmMsg.textContent = "✔ Passwords match";
        confirmMsg.style.color = "green";
        confirmValid = true;
    } else {
        confirmMsg.textContent = "✘ Passwords do not match";
        confirmMsg.style.color = "red";
        confirmValid = false;
    }
    updateSubmitState();
});

// --- Image preview ---
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        document.getElementById('fileBtn').value = file.name;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').innerHTML = 
                '<img src="'+ e.target.result +'" style="max-width:100%;height:auto;border:1px solid #ccc;padding:5px;border-radius:5px">';
        }
        reader.readAsDataURL(file);
    } else {
        document.getElementById('preview').innerHTML = "";
    }
    updateProgress();
}
</script>
