<?php
	session_start();
	require_once("connect.php");

	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		echo "<script>window.location.href='index.php';</script>";
		exit;
	}

	if ($_SESSION["access"] !== "Admin") {
		echo "<script>alert('Access Denied'); window.location.href='index.php';</script>";
		exit;
	}

	require("header.php");
	require("menunav.php");
?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Server Monitoring</h1>
        <span>Track the uptime of hosted clients and services</span>
      </div>
    </div>
  </div>
</div>
<br>
<div class="container mb-4">
    <div class="row">
        <div class="col-md-12">
            <div style="background:var(--bg-card); padding:20px; border-radius:10px; border: 1px solid var(--border-glass); display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h4 style="color:#fff; margin-bottom:5px;"><i class="fa fa-money"></i> FOSSBilling Metrics</h4>
                    <span class="text-muted" style="font-size:14px;">Live data from your billing portal</span>
                </div>
                <div style="display:flex; gap:20px;">
                    <div class="text-center">
                        <h3 id="metric-income" style="color:#28a745;">$--</h3>
                        <small class="text-muted">Total Income</small>
                    </div>
                    <div class="text-center">
                        <h3 id="metric-clients" style="color:#007bff;">--</h3>
                        <small class="text-muted">Active Clients</small>
                    </div>
                    <div class="text-center">
                        <h3 id="metric-tickets" style="color:#ffc107;">--</h3>
                        <small class="text-muted">Open Tickets</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="margin-top:-60px"></div>
<div class="services" style="margin-bottom:20px">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div style="background:var(--bg-card); padding:20px; border-radius:10px; border: 1px solid var(--border-glass);">
            <h4 style="color:#fff; margin-bottom: 20px;">Add Server</h4>
            <form id="serverForm">
                <input type="hidden" name="action" value="add_server">
                <div class="mb-3">
                    <label>Server Name / Domain</label>
                    <input type="text" class="form-control" name="server_name" placeholder="Client Website" required>
                </div>
                <div class="mb-3">
                    <label>URL (Include http/https)</label>
                    <input type="url" class="form-control" name="url" placeholder="https://client.com" required>
                </div>
                <button type="submit" class="btn btn-primary filled-button w-100">Add Server</button>
            </form>
        </div>
      </div>
      
      <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 style="color:#fff;">Monitored Servers</h4>
            <button class="btn btn-success" onclick="runAllChecks()" id="runChecksBtn"><i class="fa fa-refresh"></i> Run All Checks</button>
        </div>
        
        <div id="serverList">
             <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>

let serverIds = [];

\$(document).ready(function() {
    loadServers();
    loadBillingMetrics();

    \$("#serverForm").submit(function(e) {
        e.preventDefault();
        // Gi-update ang action identifier parameters alang sa server insertion rules
        let formData = \$(this).serialize() + "&action=add_server";
        \$.post("ajax_monitoring_servers.php", formData, function(res) {
            if(res.status == 'success') {
                \$("#serverForm")[0].reset();
                loadServers();
            } else {
                alert(res.message);
            }
        }, 'json');
    });
});

function loadBillingMetrics() {
    // Karon nag-target na sa bag-ong unified endpoint query variable string rule
    \$.get("ajax_monitoring_servers.php?action=fetch_billing", function(res) {
        if(res.status == 'success' || res.income !== undefined) {
            \$("#metric-income").text("\$" + parseFloat(res.income).toFixed(2));
            \$("#metric-clients").text(res.clients);
            \$("#metric-tickets").text(res.tickets);
        } else {
            console.error("Billing Application Core Error:", res.message);
        }
    }, 'json').fail(function(xhr, status, error) {
        console.error("Unified Billing Pipeline Failure:", error, xhr.responseText);
    });
}

function loadServers() {
    \$.get("ajax_monitoring_servers.php?action=fetch_servers", function(response) {
        if(response.status === 'success') {
            serverIds = [];
            if(response.data.length === 0) {
                \$("#serverList").html('<div class="alert alert-info">No servers being monitored.</div>');
                return;
            }
            let html = '<table class="table table-dark table-striped"><thead><tr><th>Server</th><th>Status</th><th>Response</th><th>Last Checked</th><th>Action</th></tr></thead><tbody>';
            response.data.forEach(s => {
                serverIds.push(s.id);
                let badge = s.status == 'Online' ? 'success' : (s.status == 'Offline' ? 'danger' : 'secondary');
                let ping = s.response_time_ms ? s.response_time_ms + ' ms' : '-';
                let last = s.last_checked || 'Never';
                
                html += `
                <tr id="server-row-${s.id}">
                    <td>
                        <strong>${s.server_name}</strong><br>
                        <small><a href="${s.url}" target="_blank" style="color:var(--text-muted);">${s.url}</a></small>
                    </td>
                    <td class="status-cell"><span class="badge bg-${badge}">${s.status}</span></td>
                    <td class="ping-cell">${ping}</td>
                    <td class="last-cell">${last}</td>
                    <td>
                        <button class="btn btn-sm btn-info check-btn" onclick="checkServer(${s.id})"><i class="fa fa-refresh"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteServer(${s.id})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            \$("#serverList").html(html);
        } else {
            \$("#serverList").html(`<div class="alert alert-danger">Error: ${response.message}</div>`);
        }
    }, 'json').fail(function(xhr, status, error) {
        \$("#serverList").html(`<div class="alert alert-danger">AJAX Request Failed. Check console.</div>`);
        console.error("Servers Infrastructure Pipe Broken:", error, xhr.responseText);
    });
}

function checkServer(id) {
    let row = \$(`#server-row-${id}`);
    row.find('.status-cell').html('<i class="fa fa-spinner fa-spin"></i> Checking...');
    row.find('.check-btn').prop('disabled', true);
    
    \$.post("ajax_monitoring_servers.php", {action: 'check_server', id: id}, function(res) {
        if(res.status == 'success') {
            let data = res.data;
            let badge = data.server_status == 'Online' ? 'success' : 'danger';
            row.find('.status-cell').html(`<span class="badge bg-${badge}">${data.server_status}</span>`);
            row.find('.ping-cell').html(data.response_time_ms + ' ms');
            row.find('.last-cell').html(data.last_checked);
        } else {
            row.find('.status-cell').html('<span class="badge bg-warning">Error</span>');
        }
        row.find('.check-btn').prop('disabled', false);
    }, 'json').fail(function() {
        row.find('.status-cell').html('<span class="badge bg-danger">Failed</span>');
        row.find('.check-btn').prop('disabled', false);
    });
}

function runAllChecks() {
    if(serverIds.length === 0) return;
    \$("#runChecksBtn").prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Checking...');
    
    let promises = [];
    serverIds.forEach(id => {
        let row = \$(`#server-row-${id}`);
        row.find('.status-cell').html('<i class="fa fa-spinner fa-spin"></i>');
        
        let p = \$.post("ajax_monitoring_servers.php", {action: 'check_server', id: id}, function(res) {
            if(res.status == 'success') {
                let data = res.data;
                let badge = data.server_status == 'Online' ? 'success' : 'danger';
                row.find('.status-cell').html(`<span class="badge bg-${badge}">${data.server_status}</span>`);
                row.find('.ping-cell').html(data.response_time_ms + ' ms');
                row.find('.last-cell').html(data.last_checked);
            } else {
                row.find('.status-cell').html('<span class="badge bg-warning">Error</span>');
            }
        }, 'json');
        promises.push(p);
    });
    
    \$.when.apply(\$, promises).always(function() {
        \$("#runChecksBtn").prop('disabled', false).html('<i class="fa fa-refresh"></i> Run All Checks');
    });
}

function deleteServer(id) {
    if(confirm("Are you sure you want to delete this server?")) {
        \$.post("ajax_monitoring_servers.php", {action: 'delete_server', id: id}, function(res) {
            if(res.status == 'success') loadServers();
            else alert(res.message);
        }, 'json');
    }
}
</script>

<?php require("footer.php"); ?>
