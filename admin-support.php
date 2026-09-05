<?php
    require("connect.php");
    require("header.php");
    require("menunav.php");

    if (!isset($_SESSION["user"]) || $_SESSION["access"] !== "Admin") {
        echo "<script>window.location='index.php';</script>";
        exit;
    }
?>
<script>setActive("support");</script>
<link href="assets/css/card-grid.css" rel="stylesheet">

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Support Tickets (Admin)</h1>
        <span>Manage and resolve client support requests.</span>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5 mb-5 text-light">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-dark table-hover" style="background: #111;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Subject</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="ticketListFeed">
                        <tr><td colspan="7" class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content" style="background: #111; border: 1px solid #444; color: #fff; border-radius: 12px;">
      <div class="modal-header border-bottom border-secondary">
        <h5 class="modal-title" id="modalTicketSubject">Ticket</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="$('#ticketModal').modal('hide')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <div>
                <strong id="modalTicketClient" class="text-info"></strong> &bull; <small class="text-muted" id="modalTicketDate"></small>
            </div>
            <div>
                <select id="modalStatusSelect" class="form-control form-control-sm text-light d-inline-block w-auto" style="background: #222; border: 1px solid #555;">
                    <option value="Open">Open</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Closed">Closed</option>
                </select>
                <button class="btn btn-sm btn-success" onclick="updateStatus()"><i class="fas fa-save"></i> Save</button>
            </div>
        </div>
        
        <div class="p-3 mb-4 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid #333;">
            <p id="modalTicketDesc" class="mb-0" style="white-space: pre-wrap;"></p>
        </div>
        
        <h6 class="border-bottom border-secondary pb-2">Conversation Thread</h6>
        <div id="ticketRepliesFeed" style="max-height: 300px; overflow-y: auto; padding-right: 10px;" class="mb-3">
            <!-- Replies go here -->
        </div>

        <form id="replyForm">
            <input type="hidden" id="replyTicketId">
            <div class="input-group">
                <input type="text" class="form-control text-light" style="background: #222; border: 1px solid #555;" id="replyMessage" placeholder="Type your reply to the client..." required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>

<script>
    function loadTickets() {
        $.ajax({
            url: 'ajax_support.php?action=fetch_tickets&all=1',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    let html = '';
                    if (res.tickets.length === 0) {
                        html = '<tr><td colspan="7" class="text-center text-muted">No tickets found.</td></tr>';
                    } else {
                        res.tickets.forEach(t => {
                            let badgeClass = t.status === 'Resolved' || t.status === 'Closed' ? 'badge-secondary' : 'badge-primary';
                            if (t.status === 'Open') badgeClass = 'badge-success';
                            if (t.status === 'In Progress') badgeClass = 'badge-warning';

                            let priorityClass = '';
                            if (t.priority === 'High') priorityClass = 'text-danger font-weight-bold';

                            html += `
                                <tr>
                                    <td>#${t.id}</td>
                                    <td>${t.fullname} <small class="text-muted">(@${t.username})</small></td>
                                    <td>${$('<div>').text(t.subject).html()}</td>
                                    <td class="${priorityClass}">${t.priority}</td>
                                    <td><span class="badge ${badgeClass}">${t.status}</span></td>
                                    <td>${t.updated_at}</td>
                                    <td><button class="btn btn-sm btn-info" onclick="openTicket(${t.id})">Manage</button></td>
                                </tr>
                            `;
                        });
                    }
                    $('#ticketListFeed').html(html);
                }
            }
        });
    }

    function openTicket(id) {
        $.ajax({
            url: 'ajax_support.php?action=fetch_ticket&id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    let t = res.ticket;
                    $('#modalTicketSubject').text('#' + t.id + ' - ' + t.subject);
                    $('#modalTicketClient').text(t.fullname + ' (@' + t.username + ')');
                    $('#modalStatusSelect').val(t.status);
                    $('#modalTicketDate').text('Created: ' + t.created_at);
                    $('#modalTicketDesc').text(t.description);
                    $('#replyTicketId').val(t.id);

                    let rHtml = '';
                    res.replies.forEach(r => {
                        let isMe = r.username.toLowerCase() === '<?php echo strtolower(htmlspecialchars($_SESSION["user"])); ?>';
                        let align = isMe ? 'text-right' : 'text-left';
                        let bg = isMe ? 'background: #0056b3;' : 'background: #333;';
                        let marginClass = isMe ? 'ml-auto' : 'mr-auto';
                        let badge = r.access === 'Admin' ? '<span class="badge badge-danger ml-2">Admin</span>' : '';
                        
                        rHtml += `
                            <div class="mb-3 ${align}">
                                <small class="text-muted">${r.fullname} ${badge} &bull; ${r.created_at}</small>
                                <div class="p-2 mt-1 rounded ${marginClass}" style="${bg} max-width: 80%; display: inline-block; text-align: left;">
                                    ${$('<div>').text(r.message).html()}
                                </div>
                            </div>
                        `;
                    });
                    
                    if (rHtml === '') rHtml = '<div class="text-center text-muted small py-3">No replies yet.</div>';
                    
                    $('#ticketRepliesFeed').html(rHtml);
                    $('#ticketModal').modal('show');
                    
                    setTimeout(() => {
                        let feed = document.getElementById("ticketRepliesFeed");
                        feed.scrollTop = feed.scrollHeight;
                    }, 200);
                }
            }
        });
    }
    
    function updateStatus() {
        let tId = $('#replyTicketId').val();
        let newStatus = $('#modalStatusSelect').val();
        
        $.ajax({
            url: 'ajax_support.php?action=update_status',
            type: 'POST',
            data: { ticket_id: tId, status: newStatus },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    alert('Status updated successfully');
                    loadTickets();
                } else {
                    alert(res.message);
                }
            }
        });
    }

    $(document).ready(function() {
        loadTickets();

        $('#replyForm').submit(function(e) {
            e.preventDefault();
            let btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            
            let tId = $('#replyTicketId').val();
            
            $.ajax({
                url: 'ajax_support.php?action=add_reply',
                type: 'POST',
                data: {
                    ticket_id: tId,
                    message: $('#replyMessage').val()
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#replyMessage').val('');
                        openTicket(tId);
                        loadTickets(); // Refresh background list for status update
                    } else {
                        alert(res.message);
                    }
                    btn.prop('disabled', false);
                }
            });
        });
    });
</script>
