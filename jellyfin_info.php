<?php
	// jellyfin_info.php
	session_start();
	require("connect.php");
	
	function jellyfin_api($endpoint) {
		$token = '93cc2300dbe64aaf98e878aca88813dd';
		$url = "https://media.mcjim-server.com" . $endpoint;
		$headers = [
			"X-Emby-Authorization: MediaBrowser Client=\"PHP\", Device=\"Web\", DeviceId=\"12345\", Version=\"1.0\", Token=\"$token\""
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // disable SSL check if self-signed
		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			echo "cURL Error: " . curl_error($ch);
		}

		curl_close($ch);
		return $response;
	}

	// ✅ Fetch Jellyfin server info
	$response = jellyfin_api("/System/Info");
	$data = json_decode($response, true);

	// ✅ Extract basic info
	$serverName = $data["ServerName"] ?? "Unknown";
	$version    = $data["Version"] ?? "Unknown";
	$os         = $data["OperatingSystemDisplayName"] ?? "Unknown";
	$arch       = $data["SystemArchitecture"] ?? "Unknown";

	require("header.php");
	require("menunav.php");
?>

<!-- Heading -->
<div class="page-heading header-text" style="background:url(images/mcjim-cyberworks1.webp?<?php echo time();?>)no-repeat;background-size:cover;background-position:center center">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Media Server Info</h1>
				<span>McJim Media Server Info</span>
			</div>
		</div>
	</div>
</div>

<div class="container mt-4">
    <h2>Jellyfin Server Info</h2>
    <table class="table table-bordered">
        <tr>
            <th>Server Name</th>
            <td><?php echo htmlspecialchars($serverName); ?></td>
        </tr>
        <tr>
            <th>Version</th>
            <td><?php echo htmlspecialchars($version); ?></td>
        </tr>
        <tr>
            <th>Operating System</th>
            <td><?php echo htmlspecialchars($os); ?></td>
        </tr>
        <tr>
            <th>Architecture</th>
            <td><?php echo htmlspecialchars($arch); ?></td>
        </tr>
    </table>
</div>

<?php require("footer.php");?>