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

// Fetch all users for dropdown
$users = [];
$res = mysqli_query($conn, "SELECT uno as id, username, fullname FROM users ORDER BY username ASC");
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
        <h1>Manage Invoices</h1>
        <span>Generate and track client billing</span>
      </div>
    </div>
  </div>
</div>

<div class="services" style="padding-top: 50px;">
  <div class="container">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 style="color:#fff;">All Invoices</h4>
        <button class="btn btn-primary filled-button" onclick="showInvoiceForm()">+ New Invoice</button>
    </div>
    
    <div id="adminInvoiceList">
         <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
    </div>

  </div>
</div>

<!-- Modal for Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background:var(--bg-card); border: 1px solid var(--border-glass);">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#fff;">Create Invoice</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="invoiceForm">
            <input type="hidden" name="action" value="create_invoice">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Client</label>
                    <select class="form-control" name="client_id" required>
                        <option value="">-- Select Client --</option>
                        <?php foreach($users as $u) { ?>
                        <option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['fullname'] ?: $u['username']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Invoice Number</label>
                    <input type="text" class="form-control" name="invoice_number" id="invNumber" value="INV-<?php echo date('Y-'); ?>" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Issue Date</label>
                    <input type="date" class="form-control" name="issue_date" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Due Date</label>
                    <input type="date" class="form-control" name="due_date" required>
                </div>
            </div>
            
            <hr style="border-color: rgba(255,255,255,0.1);">
            
            <h5 style="color:#fff; margin-bottom:15px;">Line Items</h5>
            <div id="lineItemsContainer">
                <!-- Items appended here -->
            </div>
            <button type="button" class="btn btn-sm btn-secondary mb-3" onclick="addLineItem()">+ Add Item</button>
            
            <hr style="border-color: rgba(255,255,255,0.1);">
            
            <div class="row">
                <div class="col-md-6">
                    <label>Notes / Payment Instructions</label>
                    <textarea class="form-control" name="notes" rows="4">Please make payment via bank transfer to XYZ Bank. Account: 12345678.</textarea>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between mb-2">
                        <label>Subtotal</label>
                        <input type="number" step="0.01" class="form-control w-50 text-right" name="subtotal" id="invSubtotal" readonly>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <label>Tax Amount</label>
                        <input type="number" step="0.01" class="form-control w-50 text-right" name="tax_amount" id="invTax" value="0.00" onchange="calculateTotals()">
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <label><b>Total Amount</b></label>
                        <input type="number" step="0.01" class="form-control w-50 text-right" name="total_amount" id="invTotal" readonly>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary filled-button w-100 mt-4">Save & Issue Invoice</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>

<script>
$(document).ready(function() {
    loadAdminInvoices();

    $("#invoiceForm").submit(function(e) {
        e.preventDefault();
        
        // Gather line items
        let items = [];
        $(".line-item-row").each(function() {
            let desc = $(this).find('.item-desc').val();
            let qty = $(this).find('.item-qty').val();
            let price = $(this).find('.item-price').val();
            if(desc && qty && price) {
                items.push({description: desc, quantity: qty, unit_price: price});
            }
        });
        
        if(items.length === 0) {
            alert("Please add at least one line item.");
            return;
        }
        
        let formData = $(this).serializeArray();
        formData.push({name: 'items', value: JSON.stringify(items)});
        
        $.post("ajax_invoices.php", formData, function(res) {
            if(res.status == 'success') {
                $("#invoiceModal").modal('hide');
                loadAdminInvoices();
            } else {
                alert(res.message);
            }
        }, 'json');
    });
});

function loadAdminInvoices() {
    $.get("ajax_invoices.php?action=fetch_invoices&all=1", function(response) {
        if(response.status === 'success') {
            if(response.data.length === 0) {
                $("#adminInvoiceList").html('<div class="alert alert-info">No invoices found.</div>');
                return;
            }
            let html = '<table class="table table-dark table-striped"><thead><tr><th>Invoice #</th><th>Client</th><th>Issue Date</th><th>Due Date</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>';
            response.data.forEach(inv => {
                let badge = inv.status == 'Paid' ? 'success' : (inv.status == 'Cancelled' ? 'danger' : 'warning');
                html += `
                <tr>
                    <td>${inv.invoice_number}</td>
                    <td>${inv.fullname || inv.client_username}</td>
                    <td>${inv.issue_date}</td>
                    <td>${inv.due_date}</td>
                    <td>$${parseFloat(inv.total_amount).toFixed(2)}</td>
                    <td><span class="badge bg-${badge}">${inv.status}</span></td>
                    <td>
                        <a href="view-invoice.php?id=${inv.id}" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i></a>
                        <button class="btn btn-sm btn-success" onclick="updateStatus(${inv.id}, 'Paid')" title="Mark Paid"><i class="fa fa-check"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteInvoice(${inv.id})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            $("#adminInvoiceList").html(html);
        }
    });
}

function updateStatus(id, status) {
    if(confirm(`Mark invoice as ${status}?`)) {
        $.post("ajax_invoices.php", {action: 'update_status', id: id, status: status}, function(res) {
            if(res.status == 'success') loadAdminInvoices();
            else alert(res.message);
        });
    }
}

function deleteInvoice(id) {
    if(confirm("Are you sure you want to delete this invoice?")) {
        $.post("ajax_invoices.php", {action: 'delete_invoice', id: id}, function(res) {
            if(res.status == 'success') loadAdminInvoices();
            else alert(res.message);
        });
    }
}

function showInvoiceForm() {
    $("#invoiceForm")[0].reset();
    $("#lineItemsContainer").html("");
    addLineItem();
    $("#invNumber").val("INV-<?php echo date('Y-'); ?>" + Math.floor(1000 + Math.random() * 9000));
    $("#invoiceModal").modal('show');
}

function addLineItem() {
    let row = `
    <div class="row line-item-row mb-2">
        <div class="col-md-5">
            <input type="text" class="form-control item-desc" placeholder="Description" required>
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" class="form-control item-qty" value="1" placeholder="Qty" onkeyup="calculateTotals()" onchange="calculateTotals()" required>
        </div>
        <div class="col-md-3">
            <input type="number" step="0.01" class="form-control item-price" placeholder="Price" onkeyup="calculateTotals()" onchange="calculateTotals()" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger w-100" onclick="$(this).closest('.line-item-row').remove(); calculateTotals();"><i class="fa fa-times"></i></button>
        </div>
    </div>`;
    $("#lineItemsContainer").append(row);
}

function calculateTotals() {
    let subtotal = 0;
    $(".line-item-row").each(function() {
        let qty = parseFloat($(this).find('.item-qty').val()) || 0;
        let price = parseFloat($(this).find('.item-price').val()) || 0;
        subtotal += (qty * price);
    });
    let tax = parseFloat($("#invTax").val()) || 0;
    let total = subtotal + tax;
    
    $("#invSubtotal").val(subtotal.toFixed(2));
    $("#invTotal").val(total.toFixed(2));
}
</script>
