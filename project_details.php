<?php
	require_once("connect.php");
	require_once("header.php");
	require_once("menunav.php");

    $pid = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($pid <= 0) {
        echo "<div class='container mt-5'><h3>Invalid Project ID.</h3></div>";
        require_once("footer.php");
        exit;
    }

    $stmt = $conn->prepare("
        SELECT p.*, d.long_desc, d.how_itworks, d.management, d.mgt_public, d.mgt_admin, d.features, d.tech_used 
        FROM projects p 
        LEFT JOIN projects_details d ON p.pid = d.pid 
        WHERE p.pid = ?
    ");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo "<div class='container mt-5'><h3>Project not found.</h3></div>";
        require_once("footer.php");
        exit;
    }

    $project = $result->fetch_assoc();
    $stmt->close();

    // Fetch images
    $img_stmt = $conn->prepare("SELECT imgUrl FROM projects_images WHERE pid = ?");
    $img_stmt->bind_param("i", $pid);
    $img_stmt->execute();
    $img_res = $img_stmt->get_result();
    $images = [];
    while ($img_row = $img_res->fetch_assoc()) {
        $images[] = $img_row['imgUrl'];
    }
    $img_stmt->close();
?>

<script>setActive("projects");</script>

<style>
/* Login Modal */
.modal-overlay {
    position: fixed;
    top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.modal-content {
    width: 100%;
    max-width: 400px;
    padding: 40px;
    position: relative;
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.modal-overlay.active .modal-content {
    transform: translateY(0);
}
.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.5rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: color 0.2s;
}
.close-modal:hover { color: white; }
.modal-header h3 { font-size: 1.8rem; margin-bottom: 5px; }
.modal-header p { color: var(--text-muted); margin-bottom: 25px; font-size: 0.9rem; }
.input-group { margin-bottom: 20px; text-align: left; }
.input-group label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: var(--text-muted); }
.input-group input {
    width: 100%;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(10, 10, 15, 0.5);
    color: white;
    font-family: var(--font-main);
    outline: none;
    transition: all 0.3s ease;
}
.input-group input:focus {
    border-color: var(--accent-blue);
    box-shadow: 0 0 10px rgba(59, 130, 246, 0.2);
}
</style>
<link href="assets/css/parsedown.css" rel="stylesheet">   

<div class="page-heading header-text" style="z-index:1">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1><?php echo htmlspecialchars($project['pname']); ?></h1>
        <span><?php echo htmlspecialchars($project['description']); ?></span>
      </div>
    </div>
  </div>
</div>

<?php
	// Fetch Project Link
	$proj_stmt = $conn->prepare("SELECT plink FROM projects WHERE pid = ?");
	$proj_stmt->bind_param("i", $pid);
	$proj_stmt->execute();
	$proj_res = $proj_stmt->get_result();

	$plink = [];
	while ($proj_row = $proj_res->fetch_assoc()) {
		$plink[] = $proj_row['plink'];
	}
	$proj_stmt->close();
	$path         = 'projects';
	$readme       = 'README.md'; // ✅ semicolon
	$project      = $plink[0];   // ✅ get first plink
	$readme_path  = $path . '/' . $project . '/' . $readme;
	$html_content = '';

	if (file_exists($readme_path)) {
		// Include the standalone lightweight markdown parser engine
		require_once 'Parsedown.php';
		
		// Read the raw text strings out of your markdown asset
		$markdown_text = file_get_contents($readme_path);
		
		// Convert text blocks straight into HTML layout structures
		$parsedown = new Parsedown();
		$html_content = $parsedown->text($markdown_text);
	} else {
		$html_content = "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle me-2'></i>System Error: README.md file is missing from the project directory.</div>";
	}
?>

<div class="container mt-5 main-content pt-4">
  <div class="row justify-content-center" style="margin-top:-100px">
    <div class="col-lg-12">
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-5 text-start markdown-body">
            <?= $html_content ?>
		  <div align="center" style="margin:20px 0 -20px 0">
			<a href="projects/<?php echo $project ?>" class="filled-button" target="_blank"><i class="fa fa-eye"></i> Live Demo</a>
            <a href="<?= isset($_SESSION['user']) ? 'https://billing.mcjim-server.com/order?product='.$pid.'' : '#' ?>" 
				<?= !isset($_SESSION['user']) ? "onclick=\"document.getElementById('loginModal').classList.add('active'); return false;\"" : "" ?> class="filled-button">
				<i class="fa fa-download"></i> Download
			</a>
		  </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="/webhosting/script.js?v=1790022913"></script>

<!-- Login Modal -->
<div class="modal-overlay" id="loginModal">
	<div class="modal-content glass-panel login-card" style="">
		<span class="close-modal" onclick="document.getElementById('loginModal').classList.remove('active');">&times;</span>
		<div>
			<h3>Client Login</h3>
			<p>Access your McJim Server dashboard</p><br>
		</div>
		<form action="login.php?return=billing_sso.php" method="POST" class="login-form">
			<input type="hidden" name="login" value="1">
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="user" required placeholder="Enter your username">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="pass" required placeholder="Enter your password">
			</div>
			<button type="submit" class="btn btn-primary btn-block glow-effect">Login</button>
		</form>
		<div id="login-error" style="color: #ef4444; margin-top: 15px; font-size: 0.9rem; display: none;">Invalid credentials. Please try again.</div>
	</div>
</div>

<script>
	const urlParams = new URLSearchParams(window.location.search);
	if (urlParams.get('error')) {
		document.getElementById('loginModal').classList.add('active');
		document.getElementById('login-error').style.display = 'block';
	}
</script>
	
<!-- Gallery Section -->
<?php if (count($images) > 0): ?>
    
<!-- Venobox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.0.4/venobox.min.css" type="text/css" media="screen" />    

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <?php foreach ($images as $img): ?>
                    <div class="col-md-3 col-sm-6 mb-4">
                        <a href="<?php echo htmlspecialchars($img); ?>" class="venobox" data-gall="projectGallery">
                            <img src="<?php echo htmlspecialchars($img); ?>" class="img-fluid shadow-sm" style="border-radius: 8px; border: 1px solid #555; width:100%; height:150px; object-fit:cover;">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Venobox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.0.4/venobox.min.js"></script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		new VenoBox({
			selector: '.venobox',
			numeratio: true,
			infinigall: true,
			share: false,
			spinner: 'rotating-plane'
		});
	});
</script>
<?php endif; ?>

</div>
	
<?php require_once("footer.php"); ?>
