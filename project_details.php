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

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1><?php echo htmlspecialchars($project['pname']); ?></h1>
        <span><?php echo htmlspecialchars($project['description']); ?></span>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5 mb-5 text-light">
    <div class="row">
        <!-- Main Info -->
        <div class="col-md-8">
            <?php ?>
                <img src="images/projects/<?php echo htmlspecialchars($project['plink']); ?>/logo.png" class="img-fluid rounded mb-4" onerror="this.src='images/default.jpg';" alt="Logo" style="height:150px">
			<?php ?>
            <h3 class="mb-3">Overview</h3>
            <p><?php echo nl2br(htmlspecialchars($project['long_desc'] ?? '')); ?></p>

            <?php if (!empty($project['how_itworks'])): ?>
                <h4 class="mt-4 text-info">How It Works</h4>
                <p><?php echo nl2br(htmlspecialchars($project['how_itworks'])); ?></p>
            <?php endif; ?>

            <?php if (!empty($project['features'])): ?>
                <h4 class="mt-4 text-info">Key Features</h4>
                <p><?php echo nl2br(htmlspecialchars($project['features'])); ?></p>
            <?php endif; ?>

            <div class="mt-5">
                <a href="../projects/<?php echo htmlspecialchars($project['plink']); ?>/" target="_blank" class="btn btn-primary btn-lg">Live Demo</a> &nbsp;
                <a href="https://github.com/McJim69/<?php echo htmlspecialchars($project['plink']); ?>" target="_blank" class="btn btn-primary btn-lg">Github Repo</a>
            </div><br>
        </div>

        <!-- Sidebar Info -->
        <div class="col-md-4">
            <div class="p-4" style="background: rgba(255, 255, 255, 0.05); border-radius: 10px; border: 1px solid #444;">
                <h4 class="mb-3 border-bottom pb-2">Tech Stack</h4>
                <?php 
                    $techs = explode(',', $project['tech_used'] ?? '');
                    foreach ($techs as $tech) {
                        $tech = trim($tech);
                        if (!empty($tech)) {
                            echo "<span class='badge badge-info mr-1 mb-1 p-2'>".htmlspecialchars($tech)."</span>";
                        }
                    }
                ?>
                
                <h4 class="mt-4 mb-3 border-bottom pb-2">Management Features</h4>
                <?php if (!empty($project['management'])): ?>
                    <strong>General:</strong><br>
                    <p class="small"><?php echo nl2br(htmlspecialchars($project['management'])); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($project['mgt_public'])): ?>
                    <strong class="text-success">Public/User Facing:</strong><br>
                    <p class="small"><?php echo nl2br(htmlspecialchars($project['mgt_public'])); ?></p>
                <?php endif; ?>
                
                <?php if (!empty($project['mgt_admin'])): ?>
                    <strong class="text-danger">Admin Facing:</strong><br>
                    <p class="small"><?php echo nl2br(htmlspecialchars($project['mgt_admin'])); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <?php if (count($images) > 0): ?>
    
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/venobox/2.0.4/venobox.min.css" type="text/css" media="screen" />
    
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
