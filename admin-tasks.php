<?php
require("connect.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

if ($_SESSION["access"] !== "Admin") {
    echo "<script>alert('Access Denied'); window.location.href='index.php';</script>";
    exit;
}

// Fetch all staff/admins for assignment dropdown
$users = [];
$res = mysqli_query($conn, "SELECT uno as id, username, fullname FROM users WHERE access IN ('Admin', 'Staff') ORDER BY username ASC");
while ($r = mysqli_fetch_assoc($res)) {
    $users[] = $r;
}

require("header.php");
require("menunav.php");
?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>IT Maintenance Tasks</h1>
        <span>Schedule and track automated or manual IT tasks</span>
      </div>
    </div>
  </div>
</div>

<div class="services" style="padding-top: 50px;">
  <div class="container">
    
    <div class="row">
      <div class="col-md-4">
        <div style="background:var(--bg-card); padding:20px; border-radius:10px; border: 1px solid var(--border-glass);">
            <h4 style="color:#fff; margin-bottom: 20px;">Schedule Task</h4>
            <form id="taskForm">
                <input type="hidden" name="action" value="add_task">
                <div class="mb-3">
                    <label>Task Name</label>
                    <input type="text" class="form-control" name="task_name" required>
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label>Scheduled For</label>
                    <input type="datetime-local" class="form-control" name="scheduled_for" required>
                </div>
                <div class="mb-3">
                    <label>Assign To (Optional)</label>
                    <select class="form-control" name="assigned_to">
                        <option value="0">-- Unassigned --</option>
                        <?php foreach($users as $u) { ?>
                        <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['fullname'] ?: $u['username']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary filled-button w-100">Schedule Task</button>
            </form>
        </div>
      </div>
      
      <div class="col-md-8">
        <h4 style="color:#fff; margin-bottom: 20px;">Upcoming Tasks</h4>
        
        <div id="taskList">
             <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php require("footer.php"); ?>

<script>
$(document).ready(function() {
    loadTasks();

    $("#taskForm").submit(function(e) {
        e.preventDefault();
        $.post("ajax_tasks.php", $(this).serialize(), function(res) {
            if(res.status == 'success') {
                $("#taskForm")[0].reset();
                loadTasks();
            } else {
                alert(res.message);
            }
        }, 'json');
    });
});

function loadTasks() {
    $.get("ajax_tasks.php?action=fetch_tasks", function(response) {
        if(response.status === 'success') {
            if(response.data.length === 0) {
                $("#taskList").html('<div class="alert alert-info">No tasks scheduled.</div>');
                return;
            }
            let html = '';
            response.data.forEach(t => {
                let badge = 'secondary';
                if(t.status == 'Completed') badge = 'success';
                else if(t.status == 'Failed') badge = 'danger';
                else if(t.status == 'In Progress') badge = 'primary';
                else if(t.status == 'Pending') badge = 'warning';
                
                let assignee = t.fullname || t.assigned_username || 'Unassigned';
                
                html += `
                <div class="service-item" style="padding: 20px; background: var(--bg-card); border-radius: 10px; margin-bottom:15px; border-left: 5px solid var(--bs-${badge});">
                    <div class="d-flex justify-content-between">
                        <h4 style="margin-top:0;">${t.task_name}</h4>
                        <div>
                            <select class="form-control form-control-sm d-inline-block w-auto" onchange="updateStatus(${t.id}, this.value)">
                                <option value="Pending" ${t.status=='Pending'?'selected':''}>Pending</option>
                                <option value="In Progress" ${t.status=='In Progress'?'selected':''}>In Progress</option>
                                <option value="Completed" ${t.status=='Completed'?'selected':''}>Completed</option>
                                <option value="Failed" ${t.status=='Failed'?'selected':''}>Failed</option>
                            </select>
                            <button class="btn btn-sm btn-danger ms-2" onclick="deleteTask(${t.id})"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                    <p style="margin-bottom: 10px;">${t.description}</p>
                    <small class="text-muted"><i class="fa fa-calendar"></i> ${t.scheduled_for} &nbsp; | &nbsp; <i class="fa fa-user"></i> ${assignee}</small>
                </div>`;
            });
            $("#taskList").html(html);
        }
    });
}

function updateStatus(id, status) {
    $.post("ajax_tasks.php", {action: 'update_status', id: id, status: status}, function(res) {
        if(res.status == 'success') loadTasks();
        else alert(res.message);
    });
}

function deleteTask(id) {
    if(confirm("Are you sure you want to delete this task?")) {
        $.post("ajax_tasks.php", {action: 'delete_task', id: id}, function(res) {
            if(res.status == 'success') loadTasks();
            else alert(res.message);
        });
    }
}
</script>
