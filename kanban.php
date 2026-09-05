<?php
    require("connect.php");
    require("header.php");
    require("menunav.php");

    // Require Admin access for tasks for now
    if (!isset($_SESSION["user"]) || $_SESSION["access"] !== "Admin") {
        echo "<script>window.location='index.php';</script>";
        exit;
    }
?>
<script>setActive("projects");</script>
<style>
    .kanban-board {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 20px;
        min-height: 500px;
    }
    .kanban-column {
        flex: 1;
        min-width: 250px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid #333;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
    }
    .kanban-header {
        padding: 15px;
        font-weight: bold;
        border-bottom: 1px solid #333;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px 10px 0 0;
    }
    .kanban-items {
        padding: 10px;
        flex: 1;
        min-height: 100px;
    }
    .kanban-card {
        background: #222;
        border: 1px solid #444;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        cursor: grab;
        position: relative;
    }
    .kanban-card:active {
        cursor: grabbing;
    }
    .kanban-card h6 {
        margin-bottom: 5px;
        color: #fff;
    }
    .kanban-card p {
        font-size: 12px;
        color: #aaa;
        margin-bottom: 10px;
    }
    .kanban-card .delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #dc3545;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        opacity: 0.5;
    }
    .kanban-card .delete-btn:hover {
        opacity: 1;
    }
    .drag-over {
        background: rgba(255, 255, 255, 0.08) !important;
    }
</style>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center; padding: 60px 0 30px;">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1>Task Management</h1>
        <span>Kanban board for internal tracking</span>
      </div>
      <div class="col-md-4 text-right align-self-center">
        <button class="btn btn-primary" data-toggle="modal" data-target="#newTaskModal"><i class="fas fa-plus"></i> New Task</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid mt-4 mb-5 text-light px-4">
    <div class="kanban-board" id="kanbanBoard">
        <!-- Columns will be rendered here -->
    </div>
</div>

<!-- New Task Modal -->
<div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background: #111; border: 1px solid #444; color: #fff; border-radius: 12px;">
      <div class="modal-header border-bottom border-secondary">
        <h5 class="modal-title">Create Task</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="newTaskForm">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_title" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Assign To (Username)</label>
                <input type="text" class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_assigned" placeholder="Optional">
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" class="form-control text-light" style="background: #222; border: 1px solid #555;" id="t_due">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Create Task</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    const columns = ['To Do', 'In Progress', 'Review', 'Done'];
    
    function renderBoard(tasks) {
        let html = '';
        columns.forEach(col => {
            html += `
                <div class="kanban-column" data-status="${col}">
                    <div class="kanban-header d-flex justify-content-between">
                        <span>${col}</span>
                        <span class="badge badge-secondary badge-pill">${tasks[col] ? tasks[col].length : 0}</span>
                    </div>
                    <div class="kanban-items" ondrop="drop(event, '${col}')" ondragover="allowDrop(event)" ondragleave="dragLeave(event)">
            `;
            
            if (tasks[col]) {
                tasks[col].forEach(t => {
                    let assignee = t.fullname ? `<small class="text-info"><i class="fas fa-user"></i> ${t.fullname}</small>` : '';
                    let due = t.due_date_formatted ? `<small class="text-warning ml-2"><i class="far fa-calendar-alt"></i> ${t.due_date_formatted}</small>` : '';
                    
                    html += `
                        <div class="kanban-card" draggable="true" ondragstart="drag(event, ${t.id})" id="task_${t.id}">
                            <button class="delete-btn" onclick="deleteTask(${t.id})" title="Delete Task"><i class="fas fa-trash"></i></button>
                            <h6>${$('<div>').text(t.title).html()}</h6>
                            <p>${$('<div>').text(t.description).html()}</p>
                            <div class="d-flex justify-content-start align-items-center">
                                ${assignee} ${due}
                            </div>
                        </div>
                    `;
                });
            }
            
            html += `</div></div>`;
        });
        
        $('#kanbanBoard').html(html);
    }

    function loadTasks() {
        $.ajax({
            url: 'ajax_kanban.php?action=fetch_tasks',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    renderBoard(res.tasks);
                }
            }
        });
    }

    // HTML5 Drag and Drop
    function allowDrop(ev) {
        ev.preventDefault();
        $(ev.currentTarget).addClass('drag-over');
    }
    function dragLeave(ev) {
        $(ev.currentTarget).removeClass('drag-over');
    }

    function drag(ev, taskId) {
        ev.dataTransfer.setData("taskId", taskId);
    }

    function drop(ev, newStatus) {
        ev.preventDefault();
        $(ev.currentTarget).removeClass('drag-over');
        
        let taskId = ev.dataTransfer.getData("taskId");
        
        // Optimistic UI update (optional, but good for snappy feel)
        // For simplicity we just make the ajax call and reload
        $.ajax({
            url: 'ajax_kanban.php?action=update_status',
            type: 'POST',
            data: { task_id: taskId, status: newStatus },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    loadTasks();
                } else {
                    alert(res.message);
                }
            }
        });
    }

    function deleteTask(id) {
        if (!confirm("Are you sure you want to delete this task?")) return;
        $.ajax({
            url: 'ajax_kanban.php?action=delete_task',
            type: 'POST',
            data: { task_id: id },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    loadTasks();
                }
            }
        });
    }

    $(document).ready(function() {
        loadTasks();

        $('#newTaskForm').submit(function(e) {
            e.preventDefault();
            let btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            
            $.ajax({
                url: 'ajax_kanban.php?action=create_task',
                type: 'POST',
                data: {
                    title: $('#t_title').val(),
                    description: $('#t_description').val(),
                    assigned_to: $('#t_assigned').val(),
                    due_date: $('#t_due').val()
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#newTaskForm')[0].reset();
                        $('#newTaskModal').modal('hide');
                        loadTasks();
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
