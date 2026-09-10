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
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Gallery Section -->
<?php if (count($images) > 0): ?>
    
<!-- Venobox CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.0.4/venobox.min.css" type="text/css" media="screen" />    

<div class="container mt-5">
    <div class="row mt-5">
        <div class="col-md-12">
            <h3 class="border-bottom pb-2 mb-4">Project Screenshots</h3>
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
