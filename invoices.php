<?php
require("connect.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

require("header.php");
require("menunav.php");
?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>My Invoices</h1>
        <span>View and pay your billing statements</span>
      </div>
    </div>
  </div>
</div>

<div class="services" style="padding-top: 50px;">
  <div class="container">
    
    <div id="invoiceList">
         <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
    </div>

  </div>
</div>

<?php require("footer.php"); ?>
<script>
$(document).ready(function() {
    loadInvoices();
});

function loadInvoices() {
    $.get("ajax_invoices.php?action=fetch_invoices", function(response) {
        if(response.status === 'success') {
            if(response.data.length === 0) {
                $("#invoiceList").html('<div class="alert alert-info">You have no invoices.</div>');
                return;
            }
            let html = '<table class="table table-dark table-striped"><thead><tr><th>Invoice #</th><th>Issue Date</th><th>Due Date</th><th>Amount</th><th>Status</th><th>Action</th></tr></thead><tbody>';
            response.data.forEach(inv => {
                let badge = inv.status == 'Paid' ? 'success' : (inv.status == 'Cancelled' ? 'danger' : 'warning');
                html += `
                <tr>
                    <td>${inv.invoice_number}</td>
                    <td>${inv.issue_date}</td>
                    <td>${inv.due_date}</td>
                    <td>$${parseFloat(inv.total_amount).toFixed(2)}</td>
                    <td><span class="badge bg-${badge}">${inv.status}</span></td>
                    <td>
                        <a href="view-invoice.php?id=${inv.id}" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-eye"></i> View / Print</a>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            $("#invoiceList").html(html);
        }
    });
}
</script>

