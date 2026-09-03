<?php
	require("connect.php");
	require("header.php");
	require("menunav.php");

	// Admin-only guard
	if (!isset($_SESSION['user']) || !isset($_SESSION['access']) || $_SESSION['access'] !== 'Admin') {
		header("Location: index.php");
		exit;
	}

	// Fetch all users
	$stmt = $conn->prepare("SELECT uno, fullname, username, access, imgUrl, status, last_active FROM users ORDER BY fullname ASC");
	$stmt->execute();
	$result = $stmt->get_result();
?>

<script>setActive("users");</script>

<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp) no-repeat;background-size:cover;background-position:center center">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>USERS LIST</h1>
        <span>Users Status and Validity</span>
      </div>
    </div>
  </div>
</div>

<style>
.user-table{
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
  -webkit-box-shadow:0 0 18px rgba(0,0,0,0.4);
  -moz-box-shadow:0 0 18px rgba(0,0,0,0.4);
}
.user-table table{
  margin-bottom:0;
  border:none;
}

th.desk,
td.desk {
  height: 40px;
  margin:none;
  padding:-5px;
}

@media (max-width: 768px) {
  th.mobi,
  td.mobi {
    display: none;
  }
}
</style>

<div class="container">
	<div class="table-responsive user-table">
		<table class="table">
			<tr style="border:0;background: linear-gradient(135deg, #6366f1 0%, #3b82f6 50%, #06b6d4 100%)">
				<th class="text-center">ID</th>
				<th class="text-center">Photo</th>
				<th class="text-center">Fullname</th>
				<th class="text-center">Users</th>
				<th class="text-center">Last Active</th>
				<th class="text-center">Access</th>
				<th class="text-center">Status</th>
				<th class="text-center">Action</th>
			</tr>
			<tbody>
				<?php while ($row = $result->fetch_assoc()) { ?>
				<tr class="user-row">
					<td class="text-center"><button class="btn btn-sm btn-outline-light" style="font-size:12px;width:40px"><?php echo $row['uno']; ?></button></td>
					<td class="text-center" style="padding:0;margin:0"><img src="images/users/<?php echo htmlspecialchars($row['imgUrl']); ?>" style="border-radius:50%;height:45px;margin-top:5px;border:1px solid #545454;aspect-ratio:2/2" /></td>
					<td class="text-center"><button class="btn btn-sm btn-outline-light" style="width:170px;overflow:hidden"><?php echo htmlspecialchars($row['fullname']); ?></button></td>
					<td class="text-center"><button class="btn btn-sm btn-outline-light" style="width:90px;overflow:hidden"><?php echo htmlspecialchars($row['username']); ?></button></td>
					<td class="text-center text-muted"><button class="btn btn-sm btn-outline-light" style="width:160px;overflow:hidden"><?php echo htmlspecialchars($row['last_active']); ?></button></td>
					<td class="text-center">
						<select class="btn btn-sm" style="font-size:12px;color:#fff;width:90px;background:<?php echo $row['access']=='Admin'?'blue':'magenta'; ?>"
								id="access_<?php echo $row['uno']; ?>"
								onchange="updateAccess(this.value,'<?php echo $row['uno']; ?>')">
							<option value="User"  <?php echo ($row["access"]==="User"  ? "selected":"");?>>User</option>
							<option value="Admin" <?php echo ($row["access"]==="Admin" ? "selected":"");?>>Admin</option>
						</select>
					</td>
					<td class="text-center">
						<select class="btn btn-sm"
								style="font-size:12px;color:#fff;width:90px;background:<?php echo $row['status']=='active'?'green':'gray'; ?>"
								id="status_<?php echo $row['uno']; ?>"
								onchange="updateStatus(this.value,'<?php echo $row['uno']; ?>')">
							<option value="active"  <?php echo ($row["status"]==="active"  ? "selected":"");?>>Active</option>
							<option value="inactive"<?php echo ($row["status"]==="inactive"? "selected":"");?>>Inactive</option>
						</select>
					</td>
					<td class="text-center">
						<form method="post" action="remove.php" onsubmit="return confirmAction('remove');">
							<input type="hidden" name="uno" value="<?php echo $row['uno']; ?>">
							<button class="btn btn-sm btn-danger" style="font-size:12px" type="submit" name="delete" style="width:90px">Remove</button>
						</form>
					</td>
				</tr>
				<?php } $stmt->close(); ?>
			</tbody>
		</table>
	</div>
</div>
	
<script>
	function updateAccess(value, uno) {
		if (confirm("Are you sure you want to set access to " + value + "?")) {
			var url = "users_update.php?uno=" + uno + "&value=" + value + "&target=access";
			fetch(url)
				.then(response => response.json())
				.then(data => {
					if (data.status === "OK") {
						// Update dropdown value
						document.getElementById("access_" + uno).value = data.value;
						// Update background color dynamically
						document.getElementById("access_" + uno).style.background =
							(data.value === "Admin" ? "blue" : "magenta");
						alert("Access updated to " + data.value + " for user #" + data.uno);
					} else {
						alert("Update failed: " + data.message);
					}
				})
			.catch(err => alert("Error: " + err));
		}
	}
	function updateStatus(value, uno) {
		if (confirm("Are you sure you want to set status to " + value + "?")) {
			var url = "users_update.php?uno=" + uno + "&value=" + value + "&target=status";
			fetch(url)
				.then(response => response.json())
				.then(data => {
					if (data.status === "OK") {
						// Update dropdown background color
						document.getElementById("status_" + uno).style.background = 
							(data.value === "active" ? "green" : "gray");
					} else {
						alert("Update failed: " + data.message);
					}
				})
				.catch(err => alert("Error: " + err));
		}
	}
</script>

<?php require("footer.php"); ?>
