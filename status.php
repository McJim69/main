<?php
	$progressFile = __DIR__ . "/progress.txt";
	$outputDir = __DIR__ . "/compressed/";
	$durationFile = __DIR__ . "/duration.txt";

	$response = ["progress" => 0, "done" => false, "file" => "", "duration" => 1];

	if (file_exists($durationFile)) {
		$response["duration"] = floatval(file_get_contents($durationFile));
	}

	if (file_exists($progressFile)) {
		$data = file_get_contents($progressFile);

		if (strpos($data, "progress=end") !== false) {
			$files = glob($outputDir . "compressed_*");
			$latest = end($files);

			$response["progress"] = $response["duration"];
			$response["done"] = true;
			$response["file"] = basename($latest);
		} else {
			preg_match("/out_time_ms=(\d+)/", $data, $matches);
			if (!empty($matches[1])) {
				$seconds = intval($matches[1]) / 1000000;
				$response["progress"] = $seconds;
			}
		}
	}

	echo json_encode($response);
?>
