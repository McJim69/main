<?php
	require("connect.php");
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		header("Location: login.php");
		exit;
	}

	require("header.php");
	require("menunav.php");
?>

<script>setActive("home");</script>

<style>
.dashboard-card {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    color: #bbb;
    height: 220px;
    padding: 20px;
    text-align: center;
    border-radius: 12px;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    background: rgba(255, 255, 255, 0.05);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: 0.3s all ease;
    text-decoration: none !important;
}
.dashboard-card:hover {
    color: #fff;
    transform: translateY(-5px);
    box-shadow: 0px 10px 25px rgba(56, 189, 248, 0.3);
    border-color: rgba(56, 189, 248, 0.5);
    background: linear-gradient(135deg, rgba(2, 28, 122, 0.8) 0%, rgba(107, 30, 50, 0.8) 100%);
}
.dashboard-card i {
    transition: 0.3s;
}
.dashboard-card:hover i {
    transform: scale(1.1);
    color: #38bdf8 !important;
}
</style>

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
        
        <div class="col-md-4 mb-4">
            <a href="support.php" class="dashboard-card">
                <i class="fa fa-life-ring fa-4x mb-3 text-info"></i>
                <h4 class="text-white">Support Tickets</h4>
                <p class="small text-muted mt-2">Get help & track your issues</p>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="invoices.php" class="dashboard-card">
                <i class="fa fa-file-text fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Invoices</h4>
                <p class="small text-muted mt-2">View and track your billing</p>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="file-drop.php" class="dashboard-card">
                <i class="fa fa-cloud-upload fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Secure File Drop</h4>
                <p class="small text-muted mt-2">Share files securely with our team</p>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="docs.php" class="dashboard-card">
                <i class="fa fa-book fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Knowledge Base</h4>
                <p class="small text-muted mt-2">Access guides and documentation</p>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="downloads.php" class="dashboard-card">
                <i class="fa fa-download fa-4x mb-3 text-danger"></i>
                <h4 class="text-white">Downloads Hub</h4>
                <p class="small text-muted mt-2">Download software and assets</p>
            </a>
        </div>

        <div class="col-md-4 mb-4">
            <a href="chat/" class="dashboard-card">
                <i class="fa fa-comments fa-4x mb-3" style="color: #a855f7;"></i>
                <h4 class="text-white">Live Chat</h4>
                <p class="small text-muted mt-2">Communicate with our team instantly</p>
            </a>
        </div>

    </div>
</div>

<?php require("footer.php"); ?>
