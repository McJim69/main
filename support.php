<?php
    require("connect.php");
    require("header.php");
    require("menunav.php");

    if (!isset($_SESSION["user"])) {
        echo "<script>window.location='login.php';</script>";
        exit;
    }
?>
<script>setActive("support");</script>
<link href="assets/css/card-grid.css" rel="stylesheet">

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>IT Support</h1>
        <span>Submit a ticket and track your requests.</span>
      </div>
    </div>
  </div>
</div>

<div class="container mt-5 mb-5 text-light">
    <div class="row">
        <!-- New Ticket Form -->
        <div class="col-md-4 mb-4">
            <div class="p-4" style="background: rgba(255, 255, 255, 0.05); border-radius: 10px; border: 1px solid #444;">
                <h4 class="mb-3 border-bottom pb-2">Submit a Ticket</h4>
                <form id="newTicketForm">
                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_subject" required>
                    </div>
                    <div class="form-group">
                        <label>Priority</label>
                        <select class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_priority">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_description" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Submit Ticket</button>
                </form>
            </div>
        </div>

        <!-- Ticket List -->
        <div class="col-md-8">
            <h3 class="mb-4">My Tickets</h3>
            <div id="ticketListFeed">
                <div class="text-center text-muted"><i class="fas fa-spinner fa-spin"></i> Loading...</div>
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
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="p-3 mb-4 rounded" style="background: rgba(255,255,255,0.05); border: 1px solid #333;">
            <div class="d-flex justify-content-between mb-2">
                <span class="badge badge-info" id="modalTicketStatus">Status</span>
                <small class="text-muted" id="modalTicketDate">Date</small>
            </div>
            <p id="modalTicketDesc" class="mb-0" style="white-space: pre-wrap;"></p>
        </div>
        
        <h6 class="border-bottom border-secondary pb-2">Replies</h6>
        <div id="ticketRepliesFeed" style="max-height: 300px; overflow-y: auto; padding-right: 10px;" class="mb-3">
            <!-- Replies go here -->
        </div>

        <form id="replyForm">
            <input type="hidden" id="replyTicketId">
            <div class="input-group">
                <input type="text" class="form-control text-light" style="background: #222; border: 1px solid #555;" id="replyMessage" placeholder="Type your reply..." required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function loadTickets() {
        $.ajax({
            url: 'ajax_support.php?action=fetch_tickets',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    let html = '';
                    if (res.tickets.length === 0) {
                        html = '<div class="alert alert-dark text-center" style="background: rgba(255,255,255,0.05); border:1px solid #444;">No tickets found.</div>';
                    } else {
                        res.tickets.forEach(t => {
                            let badgeClass = t.status === 'Resolved' || t.status === 'Closed' ? 'badge-secondary' : 'badge-primary';
                            if (t.status === 'Open') badgeClass = 'badge-success';
                            if (t.status === 'In Progress') badgeClass = 'badge-warning';

                            html += `
                                <div class="p-3 mb-3" style="background: rgba(255,255,255,0.05); border: 1px solid #444; border-radius: 8px; cursor: pointer; transition: 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.1)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'" onclick="openTicket(${t.id})">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0 text-info">#${t.id} - ${$('<div>').text(t.subject).html()}</h5>
                                        <span class="badge ${badgeClass}">${t.status}</span>
                                    </div>
                                    <div class="text-muted small d-flex justify-content-between">
                                        <span>Priority: ${t.priority}</span>
                                        <span>Updated: ${t.updated_at}</span>
                                    </div>
                                </div>
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
                    $('#modalTicketStatus').text(t.status);
                    $('#modalTicketDate').text('Created: ' + t.created_at);
                    $('#modalTicketDesc').text(t.description);
                    $('#replyTicketId').val(t.id);
                    
                    if (t.status === 'Closed') {
                        $('#replyForm').hide();
                    } else {
                        $('#replyForm').show();
                    }

                    let rHtml = '';
                    res.replies.forEach(r => {
                        let isMe = r.username === '<?php echo $_SESSION["user"]; ?>';
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

    $(document).ready(function() {
        loadTickets();

        $('#newTicketForm').submit(function(e) {
            e.preventDefault();
            let btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');
            
            $.ajax({
                url: 'ajax_support.php?action=create_ticket',
                type: 'POST',
                data: {
                    subject: $('#t_subject').val(),
                    priority: $('#t_priority').val(),
                    description: $('#t_description').val()
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#newTicketForm')[0].reset();
                        loadTickets();
                    } else {
                        alert(res.message);
                    }
                    btn.prop('disabled', false).text('Submit Ticket');
                }
            });
        });

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

<?php require("footer.php"); ?>
