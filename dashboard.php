<?php
	require("connect.php");
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		header("Location: login.php");
		exit;
	}

	require("header.php");
	require("menunav.php");
?>

<script>setActive("dashboard");</script>

<link rel="stylesheet" href="/assets/css/dashboard.css?v=<?= SITE_VERSION ?>">	

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Client Dashboard</h1>
        <span>Welcome back, <?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['user']); ?>!</span>
      </div>
    </div>
  </div>
</div>

<div class="container mb-5" style="margin-top: 50px;">
    <div class="row">
        
        <div class="col-md-3 mb-4">
            <a href="support.php" class="dashboard-card">
                <i class="fa fa-life-ring fa-4x mb-3 text-info"></i>
                <h4 class="text-white">Support Tickets</h4>
                <p class="small text-muted mt-2">Get help & track your issues</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="invoices.php" class="dashboard-card">
                <i class="fa fa-file-text fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Invoices</h4>
                <p class="small text-muted mt-2">View and track your billing</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="file-drop.php" class="dashboard-card">
                <i class="fa fa-cloud-upload fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Secure File Drop</h4>
                <p class="small text-muted mt-2">Share files securely to us</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="docs.php" class="dashboard-card">
                <i class="fa fa-book fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Knowledge Base</h4>
                <p class="small text-muted mt-2">Guides and documentation</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="downloads.php" class="dashboard-card">
                <i class="fa fa-download fa-4x mb-3 text-danger"></i>
                <h4 class="text-white">Downloads Hub</h4>
                <p class="small text-muted mt-2">Download software and assets</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="chat/" class="dashboard-card">
                <i class="fa fa-comments fa-4x mb-3" style="color: #a855f7;"></i>
                <h4 class="text-white">Live Chat</h4>
                <p class="small text-muted mt-2">Contact with us instantly</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="https://meet.mcjim-server.com" class="dashboard-card">
                <i class="fa fa-users fa-4x mb-3 text-info"></i>
                <h4 class="text-white">McJim Meet</h4>
                <p class="small text-muted mt-2">Free video conference in instant</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="user_profile.php" class="dashboard-card">
                <i class="fa fa-comments fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Profile</h4>
                <p class="small text-muted mt-2">View your profile and update</p>
            </a>
        </div>		
	  <?php if ($_SESSION["access"]=="Admin"){ ?>
        <div class="col-md-3 mb-4">
            <a href="admin-docs.php" class="dashboard-card">
                <i class="fa fa-file fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Mange Wiki</h4>
                <p class="small text-muted mt-2">Publish and manage wikis</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="admin-invoices.php" class="dashboard-card">
                <i class="fa fa-file-text fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Manage Invoices</h4>
                <p class="small text-muted mt-2">Issue and manage invoices </p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="kanban.php" class="dashboard-card">
                <i class="fa fa-archive fa-4x mb-3 text-danger"></i>
                <h4 class="text-white">Kanban</h4>
                <p class="small text-muted mt-2">Manage and improve workflow</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="admin-support.php" class="dashboard-card">
                <i class="fa fa-comments fa-4x mb-3" style="color: #a855f7;"></i>
                <h4 class="text-white">Tickets</h4>
                <p class="small text-muted mt-2">Manage support tickets</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="admin-projects.php" class="dashboard-card">
                <i class="fa fa-comments fa-4x mb-3 text-info"></i>
                <h4 class="text-white">Projects</h4>
                <p class="small text-muted mt-2">CRUD projects details</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="admin-users.php" class="dashboard-card">
                <i class="fa fa-users fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Users</h4>
                <p class="small text-muted mt-2">Users list management</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="admin-monitoring.php" class="dashboard-card">
                <i class="fa fa-server fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Server Monitor</h4>
                <p class="small text-muted mt-2">Monitor and manage servers</p>
            </a>
        </div>
        <div class="col-md-3 mb-4">
            <a href="admin-tasks.php" class="dashboard-card">
                <i class="fa fa-tasks fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Scheduled Tasks</h4>
                <p class="small text-muted mt-2">Manage & track scheduled task</p>
            </a>
        </div>
	  <?php } ?>
    </div>
</div>

<?php require("footer.php"); ?>
