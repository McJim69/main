<?php
	require("connect.php");
	
	$conn->query("DELETE FROM videos");
	
	$videoDir = '../supjavs';        
	$thumbDir = '../supjavs/thumbs'; 
	$timestamp = '00:05:00';       

	if (!is_dir($thumbDir)) {
		if (!mkdir($thumbDir, 0777, true)) {
			die("Failed to create thumbnails directory.");
		}
	}

	exec("ffmpeg -version", $output, $returnCode);
	if ($returnCode !== 0) {
		die("FFmpeg is not installed or not in PATH. Install it and try again.");
	}

	$files = glob($videoDir . '/*.mp4');
	if (empty($files)) {
		die("No MP4 files found in $videoDir");
	}

	foreach ($files as $filePath) {
		$fileName = pathinfo($filePath, PATHINFO_FILENAME);
		$thumbPath = $thumbDir . '/' . $fileName . '.jpg';
			
		$escapedVideo = escapeshellarg($filePath);
		$escapedThumb = escapeshellarg($thumbPath);

		$cmd = "ffmpeg -ss $timestamp -i $escapedVideo -frames:v 1 -q:v 2 $escapedThumb -y";
		exec($cmd, $cmdOutput, $cmdReturn);

		if ($cmdReturn === 0 && file_exists($thumbPath)) {
			$stmt = $conn->prepare("INSERT INTO videos (filename, filepath, thumbpath, created_date) VALUES (?, ?, ?, NOW())");
			if ($stmt) {
				$stmt->bind_param("sss", $fileName, $filePath, $thumbPath);
				$stmt->execute();
				$stmt->close();
			}
		}
	}

	header("location:supjavs.php");
	exit();
?>