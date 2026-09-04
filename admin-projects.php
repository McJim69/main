<?php
	require_once("connect.php");
//	require("setup_projects_db.php"); // Ensure tables are created
	require("header.php");
	require("menunav.php");

	// Admin-only guard
	if (!isset($_SESSION['user']) || !isset($_SESSION['access']) || $_SESSION['access'] !== 'Admin') {
		header("Location: index.php");
		exit;
	}

	$stmt = $conn->prepare("SELECT p.pid, p.pname, p.plink, p.pimgUrl FROM projects p ORDER BY p.pid DESC");
	$stmt->execute();
	$result = $stmt->get_result();
?>

<script>setActive("projects");</script>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>PROJECTS ADMIN</h1>
        <span>Manage Projects & Details</span>
      </div>
    </div>
  </div>
</div>

<style>
.project-table {
  margin-top:20px;
  margin-bottom:20px;
  justify-content:center;
  border:2px solid #bbb;
  -webkit-border-radius:10px;
  -moz-border-radius:10px;
  border-radius:10px;  
  box-shadow:rgba(255, 255, 255, 0.08);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);  
}
</style>

<div class="container">
    <div class="row mt-4">
        <div class="col-md-12 text-right mb-3">
            <button class="btn btn-primary" onclick="showAddProjectModal()">Add New Project</button>
        </div>
    </div>

	<div class="table-responsive project-table">
		<table class="table text-light">
			<tr style="border:0;background: linear-gradient(135deg, #6366f1 0%, #3b82f6 50%, #06b6d4 100%)">
				<th class="text-center">Logo</th>
				<th class="text-center">Name</th>
				<th class="text-center">Link</th>
				<th class="text-center">Action</th>
			</tr>
			<tbody id="projectListBody">
				<?php while ($row = $result->fetch_assoc()) { ?>
				<tr id="projRow_<?php echo $row['pid']; ?>">
					<td class="text-center">
                        <img src="images/projects/<?php echo htmlspecialchars($row['plink']); ?>/logo.png" style="height:45px;border-radius:5px;" onerror="this.src='images/favicon.png';" />
                    </td>
					<td class="text-center"><?php echo htmlspecialchars($row['pname']); ?></td>
					<td class="text-center"><?php echo htmlspecialchars($row['plink']); ?></td>
					<td class="text-center">
                        <button class="btn btn-sm btn-info" onclick="editProject(<?php echo $row['pid']; ?>)" style="width:60px">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProject(<?php echo $row['pid']; ?>)" style="width:60px">Delete</button>
					</td>
				</tr>
				<?php } $stmt->close(); ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal for Add/Edit Project -->
<div style="margin-top:100px" class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header">
        <h5 class="modal-title" id="projectModalLabel">Manage Project</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="$('#projectModal').modal('hide')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="projectForm" onsubmit="saveProject(event)">
      <div class="modal-body">
            <input type="hidden" id="pid" name="pid" value="">
            <input type="hidden" id="action" name="action" value="create">
            
            <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab">Basic Info</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" role="tab">Details</a>
                </li>
            </ul>
            
            <div class="tab-content mt-3" id="projectTabsContent">
                <!-- Basic Info Tab -->
                <div class="tab-pane fade show active" id="basic" role="tabpanel">
                    <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" class="form-control" name="pname" id="pname" required>
                    </div>
                    <div class="form-group">
                        <label>Description (Short)</label>
                        <input type="text" class="form-control" name="description" id="description" required>
                    </div>
                    <div class="form-group">
                        <label>Project Link/Folder</label>
                        <input type="text" class="form-control" name="plink" id="plink" required>
                    </div>
                    <div class="form-group">
                        <label>Cover Image URL / Path</label>
                        <input type="text" class="form-control" name="pimgUrl" id="pimgUrl" value="images/projects/<?php echo htmlspecialchars($row['plink']); ?>/logo.png" required>
                    </div>
                </div>
                
                <!-- Details Tab -->
                <div class="tab-pane fade" id="details" role="tabpanel">
                    <div class="form-group">
                        <label>Long Description</label>
                        <textarea class="form-control" name="long_desc" id="long_desc" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>How It Works</label>
                        <textarea class="form-control" name="how_itworks" id="how_itworks" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Management</label>
                        <textarea class="form-control" name="management" id="management" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Public Management</label>
                        <textarea class="form-control" name="mgt_public" id="mgt_public" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Admin Management</label>
                        <textarea class="form-control" name="mgt_admin" id="mgt_admin" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <textarea class="form-control" name="features" id="features" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tech Used (comma separated)</label>
                        <input type="text" class="form-control" name="tech_used" id="tech_used">
                    </div>
                    <div class="form-group">
                        <label>Project Images (Multiple Upload)</label>
                        <input type="file" class="form-control-file" name="project_images[]" id="project_images" multiple accept="image/*">
                    </div>
                    <div class="form-group" id="existing_images_container" style="display:none;">
                        <label>Existing Images</label>
                        <div id="existing_images" class="d-flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#projectModal').modal('hide')">Close</button>
        <button type="submit" class="btn btn-primary">Save Project</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
    function showAddProjectModal() {
        document.getElementById("projectForm").reset();
        document.getElementById("pid").value = "";
        document.getElementById("action").value = "create";
        document.getElementById("existing_images_container").style.display = "none";
        document.getElementById("existing_images").innerHTML = "";
        document.getElementById("projectModalLabel").innerText = "Add New Project";
        $('#projectModal').modal('show');
    }

    function editProject(pid) {
        // Fetch project details
        fetch("ajax_projects_crud.php?action=get&pid=" + pid)
            .then(res => res.json())
            .then(data => {
                if(data.status === "OK") {
                    document.getElementById("pid").value = data.data.pid;
                    document.getElementById("action").value = "update";
                    document.getElementById("pname").value = data.data.pname;
                    document.getElementById("description").value = data.data.description;
                    document.getElementById("plink").value = data.data.plink;
                    document.getElementById("pimgUrl").value = data.data.pimgUrl;
                    
                    document.getElementById("long_desc").value = data.data.long_desc || "";
                    document.getElementById("how_itworks").value = data.data.how_itworks || "";
                    document.getElementById("management").value = data.data.management || "";
                    document.getElementById("mgt_public").value = data.data.mgt_public || "";
                    document.getElementById("mgt_admin").value = data.data.mgt_admin || "";
                    document.getElementById("features").value = data.data.features || "";
                    document.getElementById("tech_used").value = data.data.tech_used || "";
                    
                    // Display existing images
                    const imagesContainer = document.getElementById("existing_images");
                    imagesContainer.innerHTML = "";
                    if (data.data.images && data.data.images.length > 0) {
                        document.getElementById("existing_images_container").style.display = "block";
                        data.data.images.forEach(img => {
                            const imgDiv = document.createElement("div");
                            imgDiv.style.marginRight = "10px";
                            imgDiv.style.marginBottom = "10px";
                            imgDiv.style.position = "relative";
                            imgDiv.id = "img_box_" + img.sid;
                            imgDiv.innerHTML = `
                                <img src="${img.imgUrl}" style="height:80px;border-radius:5px;border:1px solid #555;">
                                <button type="button" class="btn btn-sm btn-danger" style="position:absolute;top:0;right:0;padding:0 5px;" onclick="deleteImage(${img.sid})">&times;</button>
                            `;
                            imagesContainer.appendChild(imgDiv);
                        });
                    } else {
                        document.getElementById("existing_images_container").style.display = "none";
                    }

                    document.getElementById("projectModalLabel").innerText = "Edit Project";
                    $('#projectModal').modal('show');
                } else {
                    alert("Failed to fetch data.");
                }
            });
    }

    function deleteProject(pid) {
        if(confirm("Are you sure you want to delete this project?")) {
            fetch("ajax_projects_crud.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "action=delete&pid=" + pid
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "OK") {
                    document.getElementById("projRow_" + pid).remove();
                    alert("Deleted successfully.");
                } else {
                    alert("Error: " + data.message);
                }
            });
        }
    }

    function deleteImage(sid) {
        if(confirm("Are you sure you want to delete this image?")) {
            fetch("ajax_projects_crud.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "action=delete_image&sid=" + sid
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "OK") {
                    document.getElementById("img_box_" + sid).remove();
                } else {
                    alert("Error: " + data.message);
                }
            });
        }
    }

    function saveProject(e) {
        e.preventDefault();
        const formData = new FormData(document.getElementById("projectForm"));

        fetch("ajax_projects_crud.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === "OK") {
                alert("Project saved successfully!");
                $('#projectModal').modal('hide');
                location.reload(); // Reload to show new data
            } else {
                alert("Error: " + data.message);
            }
        });
    }
</script>

<?php require("footer.php"); ?>
