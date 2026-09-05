<?php
require("connect.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

$isAdmin = ($_SESSION["access"] === "Admin");

require("header.php");
require("menunav.php");
?>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp)no-repeat;background-size:cover;background-position:center center; padding: 100px 0 50px 0;">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Secure File Drop</h1>
        <span>Securely exchange files with McJim Cyberworks</span>
      </div>
    </div>
  </div>
</div>

<div class="services" style="padding-top: 50px;">
  <div class="container">
    
    <div class="row">
      <div class="col-md-4 mb-4">
        <div style="background:var(--bg-card); padding:20px; border-radius:10px; border: 1px solid var(--border-glass);">
            <h4 style="color:#fff; margin-bottom: 20px;">Upload File</h4>
            <form id="uploadForm">
                <div class="mb-3">
                    <label>Select File</label>
                    <input type="file" class="form-control" name="file" id="fileInput" required>
                    <small class="text-muted">Max file size depends on server limits. Blocked extensions: php, exe, sh, bat.</small>
                </div>
                <div class="mb-3">
                    <label>Project ID (Optional)</label>
                    <input type="number" class="form-control" name="project_id" placeholder="0">
                </div>
                <button type="submit" class="btn btn-primary filled-button w-100" id="uploadBtn">Upload</button>
                <div id="uploadStatus" class="mt-2 text-center"></div>
            </form>
        </div>
      </div>
      
      <div class="col-md-8">
        <h4 style="color:#fff; margin-bottom: 20px;"><?php echo $isAdmin ? 'All Uploaded Files' : 'Your Uploaded Files'; ?></h4>
        <div id="fileList">
             <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function() {
    loadFiles();

    $("#uploadForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append("action", "upload");
        
        $("#uploadBtn").prop("disabled", true).text("Uploading...");
        $("#uploadStatus").html("");
        
        $.ajax({
            url: "ajax_files.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                $("#uploadBtn").prop("disabled", false).text("Upload");
                if(res.status == 'success') {
                    $("#uploadForm")[0].reset();
                    $("#uploadStatus").html(`<span class="text-success">${res.message}</span>`);
                    loadFiles();
                } else {
                    $("#uploadStatus").html(`<span class="text-danger">${res.message}</span>`);
                }
            },
            error: function() {
                $("#uploadBtn").prop("disabled", false).text("Upload");
                $("#uploadStatus").html(`<span class="text-danger">Upload error. File might be too large.</span>`);
            }
        });
    });
});

function loadFiles() {
    let url = "ajax_files.php?action=fetch_files";
    <?php if($isAdmin) { echo 'url += "&all=1";'; } ?>
    
    $.get(url, function(response) {
        if(response.status === 'success') {
            if(response.data.length === 0) {
                $("#fileList").html('<div class="alert alert-info">No files found.</div>');
                return;
            }
            let html = '<table class="table table-dark table-striped"><thead><tr><th>File Name</th><th>Size</th><th>Uploaded By</th><th>Date</th><th>Action</th></tr></thead><tbody>';
            response.data.forEach(f => {
                let sizeMB = (f.file_size / (1024*1024)).toFixed(2);
                html += `
                <tr>
                    <td>${f.filename}</td>
                    <td>${sizeMB} MB</td>
                    <td>${f.fullname || f.uploader_username}</td>
                    <td>${f.uploaded_at}</td>
                    <td>
                        <a href="download.php?id=${f.id}" class="btn btn-sm btn-success" target="_blank"><i class="fa fa-download"></i></a>
                        <button class="btn btn-sm btn-danger" onclick="deleteFile(${f.id})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            $("#fileList").html(html);
        }
    });
}

function deleteFile(id) {
    if(confirm("Are you sure you want to delete this file? This cannot be undone.")) {
        $.post("ajax_files.php", {action: 'delete', id: id}, function(res) {
            if(res.status == 'success') loadFiles();
            else alert(res.message);
        });
    }
}
</script>

<?php require("footer.php"); ?>
