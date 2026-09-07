<?php
	require("connect.php");
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		header("Location: login.php");
		exit;
	}

	// Helper function for safe query counting
	function get_table_count($conn, $query, $params = [], $types = "") {
		try {
			if (!empty($params)) {
				$stmt = $conn->prepare($query);
				if (!$stmt) return 0;
				$stmt->bind_param($types, ...$params);
				$stmt->execute();
				$res = $stmt->get_result();
				$row = $res ? $res->fetch_row() : [0];
				$stmt->close();
				return (int)($row[0] ?? 0);
			} else {
				$res = $conn->query($query);
				$row = $res ? $res->fetch_row() : [0];
				return (int)($row[0] ?? 0);
			}
		} catch (Exception $e) {
			return 0;
		}
	}

	// User UNO lookup
	$user_uno = 0;
	if (isset($_SESSION['user'])) {
		$uStmt = $conn->prepare("SELECT uno FROM users WHERE username = ?");
		if ($uStmt) {
			$uStmt->bind_param("s", $_SESSION['user']);
			$uStmt->execute();
			$uRes = $uStmt->get_result();
			if ($uRow = $uRes->fetch_assoc()) {
				$user_uno = (int)$uRow['uno'];
			}
			$uStmt->close();
		}
	}

	// Notification metrics calculations
	$count_user_tickets  = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_tickets WHERE user_uno = ? AND LOWER(status) != 'closed'", [$user_uno], "i");
	$count_user_invoices = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_invoices WHERE client_id = ? AND LOWER(status) = 'unpaid'", [$user_uno], "i");
	$count_user_files    = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_client_files WHERE uploader_id = ?", [$user_uno], "i");
	$count_wiki_articles = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_wiki_articles");

	$count_downloads = 0;
	if (file_exists(__DIR__ . '/cache_libraries.json')) {
		$libData = json_decode(file_get_contents(__DIR__ . '/cache_libraries.json'), true);
		if (is_array($libData)) {
			$count_downloads = count($libData);
		}
	}

	$count_chat_unread = get_table_count($conn, "
		SELECT COUNT(m.id) 
		FROM mcjim_chat_messages m
		INNER JOIN mcjim_chat_room_members mrm ON m.room_id = mrm.room_id
		WHERE mrm.username = ?
		  AND m.sender != ?
		  AND m.id > mrm.last_seen_message_id
		  AND m.is_unsent = 0
	", [$_SESSION['user'], $_SESSION['user']], "ss");

	// Admin metrics calculations
	$count_admin_wiki      = $count_wiki_articles;
	$count_admin_invoices  = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_invoices WHERE LOWER(status) = 'unpaid'");
	$count_admin_kanban    = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_tasks WHERE LOWER(status) != 'done'");
	$count_admin_tickets   = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_tickets WHERE LOWER(status) != 'closed'");
	$count_admin_projects  = get_table_count($conn, "SELECT COUNT(*) FROM projects");
	$count_admin_users     = get_table_count($conn, "SELECT COUNT(*) FROM users");
	$count_admin_servers   = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_monitored_servers");
	$count_admin_tasks     = get_table_count($conn, "SELECT COUNT(*) FROM mcjim_scheduled_tasks WHERE LOWER(status) = 'pending'");

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
                <?php if ($count_user_tickets > 0): ?>
                    <span class="dashboard-badge badge-danger"><?= $count_user_tickets ?> Open</span>
                <?php else: ?>
                    <span class="dashboard-badge badge-secondary">0 Open</span>
                <?php endif; ?>
                <i class="fa fa-life-ring fa-4x mb-3 text-info"></i>
                <h4 class="text-white">Support Tickets</h4>
                <p class="small text-muted mt-2">Get help & track your issues</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="invoices.php" class="dashboard-card">
                <?php if ($count_user_invoices > 0): ?>
                    <span class="dashboard-badge badge-warning"><?= $count_user_invoices ?> Unpaid</span>
                <?php else: ?>
                    <span class="dashboard-badge badge-success">Paid</span>
                <?php endif; ?>
                <i class="fa fa-file-text fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Invoices</h4>
                <p class="small text-muted mt-2">View and track your billing</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="file-drop.php" class="dashboard-card">
                <span class="dashboard-badge badge-warning"><?= $count_user_files ?> Files</span>
                <i class="fa fa-cloud-upload fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Secure File Drop</h4>
                <p class="small text-muted mt-2">Share files securely to us</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="docs.php" class="dashboard-card">
                <span class="dashboard-badge badge-info"><?= $count_wiki_articles ?> Articles</span>
                <i class="fa fa-book fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Knowledge Base</h4>
                <p class="small text-muted mt-2">Guides and documentation</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="downloads.php" class="dashboard-card">
                <span class="dashboard-badge badge-danger"><?= $count_downloads > 0 ? $count_downloads . ' Assets' : 'Active' ?></span>
                <i class="fa fa-download fa-4x mb-3 text-danger"></i>
                <h4 class="text-white">Downloads Hub</h4>
                <p class="small text-muted mt-2">Download software and assets</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="chat/" class="dashboard-card">
                <?php if ($count_chat_unread > 0): ?>
                    <span class="dashboard-badge badge-danger"><?= $count_chat_unread ?> Unread</span>
                <?php else: ?>
                    <span class="dashboard-badge badge-purple">Online</span>
                <?php endif; ?>
                <i class="fa fa-comments fa-4x mb-3" style="color: #a855f7;"></i>
                <h4 class="text-white">Live Chat</h4>
                <p class="small text-muted mt-2">Contact with us instantly</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="https://meet.mcjim-server.com" target="_blank" class="dashboard-card">
                <span class="dashboard-badge badge-info">Live</span>
                <i class="fa fa-users fa-4x mb-3 text-info"></i>
                <h4 class="text-white">McJim Meet</h4>
                <p class="small text-muted mt-2">Free video conference in instant</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="user_profile.php" class="dashboard-card">
                <span class="dashboard-badge badge-success">Active</span>
                <i class="fa fa-user fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Your Profile</h4>
                <p class="small text-muted mt-2">View profile details & update </p>
            </a>
        </div>		

	  <?php if ($_SESSION["access"] == "Admin"){ ?>
        <div class="col-md-3 mb-4">
            <a href="admin-docs.php" class="dashboard-card">
                <span class="dashboard-badge badge-warning"><?= $count_admin_wiki ?> Articles</span>
                <i class="fa fa-file fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Manage Wiki</h4>
                <p class="small text-muted mt-2">Publish and manage wikis</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="admin-invoices.php" class="dashboard-card">
                <?php if ($count_admin_invoices > 0): ?>
                    <span class="dashboard-badge badge-warning"><?= $count_admin_invoices ?> Unpaid</span>
                <?php else: ?>
                    <span class="dashboard-badge badge-success">Clear</span>
                <?php endif; ?>
                <i class="fa fa-file-text fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Manage Invoices</h4>
                <p class="small text-muted mt-2">Issue and manage invoices </p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="kanban.php" class="dashboard-card">
                <span class="dashboard-badge badge-danger"><?= $count_admin_kanban ?> Pending</span>
                <i class="fa fa-archive fa-4x mb-3 text-danger"></i>
                <h4 class="text-white">Kanban</h4>
                <p class="small text-muted mt-2">Manage and track workflow</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="admin-support.php" class="dashboard-card">
                <?php if ($count_admin_tickets > 0): ?>
                    <span class="dashboard-badge badge-purple"><?= $count_admin_tickets ?> Open</span>
                <?php else: ?>
                    <span class="dashboard-badge badge-secondary">0 Open</span>
                <?php endif; ?>
                <i class="fa fa-comments fa-4x mb-3" style="color: #a855f7;"></i>
                <h4 class="text-white">Tickets</h4>
                <p class="small text-muted mt-2">Manage support tickets</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="admin-projects.php" class="dashboard-card">
                <span class="dashboard-badge badge-info"><?= $count_admin_projects ?> Projects</span>
                <i class="fa fa-folder-open fa-4x mb-3 text-info"></i>
                <h4 class="text-white">Projects</h4>
                <p class="small text-muted mt-2">CRUD projects details</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="admin-users.php" class="dashboard-card">
                <span class="dashboard-badge badge-success"><?= $count_admin_users ?> Users</span>
                <i class="fa fa-users fa-4x mb-3 text-success"></i>
                <h4 class="text-white">Users</h4>
                <p class="small text-muted mt-2">Users list management</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="admin-monitoring.php" class="dashboard-card">
                <span class="dashboard-badge badge-warning"><?= $count_admin_servers ?> Servers</span>
                <i class="fa fa-server fa-4x mb-3 text-warning"></i>
                <h4 class="text-white">Server Monitor</h4>
                <p class="small text-muted mt-2">Monitor and manage servers</p>
            </a>
        </div>

        <div class="col-md-3 mb-4">
            <a href="admin-tasks.php" class="dashboard-card">
                <span class="dashboard-badge badge-info"><?= $count_admin_tasks ?> Due</span>
                <i class="fa fa-tasks fa-4x mb-3 text-primary"></i>
                <h4 class="text-white">Scheduled Tasks</h4>
                <p class="small text-muted mt-2">Manage & track scheduled task</p>
            </a>
        </div>
	  <?php } ?>
    </div>
</div>

<?php require("footer.php"); ?>
