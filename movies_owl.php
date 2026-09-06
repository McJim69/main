<?php 
	require_once("connect.php");
	require_once("jellyfin_token.php");
	
	$server = WEB_HOST;
    $apiKey = API_KEY;
	
    // Hybrid cache setup
    if (class_exists('Memcached')) {
        $mem = new Memcached();
        $mem->addServer("127.0.0.1", 11211);
        $useMemcached = true;
    } else {
        $useMemcached = false;
    }

    function fetchDataHybrid($url, $apiKey, $cacheKey, $ttl=300) {
        global $mem, $useMemcached;
        if ($useMemcached) {
            $data = $mem->get($cacheKey);
            if ($data === false) {
                $opts = ["http" => ["method" => "GET", "header" => "X-Emby-Token: $apiKey"]];
                $context = stream_context_create($opts);
                $response = file_get_contents($url, false, $context);
                $mem->set($cacheKey, $response, $ttl);
                $data = $response;
            }
            return json_decode($data, true);
        } else {
            $cacheDir = __DIR__ . "/cache";
            if (!is_dir($cacheDir)) mkdir($cacheDir, 0777, true);
            $cacheFile = $cacheDir . "/cache_$cacheKey.json";

            if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $ttl)) {
                $response = file_get_contents($cacheFile);
            } else {
                $opts = ["http" => ["method" => "GET", "header" => "X-Emby-Token: $apiKey"]];
                $context = stream_context_create($opts);
                $response = file_get_contents($url, false, $context);
                file_put_contents($cacheFile, $response);
            }
            return json_decode($response, true);
        }
    }

    function getLibraries($server, $apiKey) {
        return fetchDataHybrid("$server/Library/MediaFolders", $apiKey, "libraries", 600);
    }

    // Force SortBy=Random
    function getItems($server, $apiKey, $libraryId, $query="", $genre="", $start=0, $limit=100, $sortBy="Random", $sortOrder="Ascending") {
        $cacheKey = "movies_" . $libraryId . "_" . md5($query.$genre.$start.$limit.$sortBy.$sortOrder);
        $url = "$server/Items?Fields=PrimaryImageAspectRatio,Overview,ProductionYear,RunTimeTicks,Genres,MediaSources"
             . "&IncludeItemTypes=Movie&StartIndex=$start&Limit=$limit&ParentId=$libraryId&Recursive=true"
             . "&SortBy=" . urlencode($sortBy)
             . "&SortOrder=" . urlencode($sortOrder);

        if ($query != "") $url .= "&SearchTerm=".urlencode($query);
        if ($genre != "") $url .= "&Genres=".urlencode($genre);

        return fetchDataHybrid($url, $apiKey, $cacheKey, 300);
    }

    $libraries = getLibraries($server, $apiKey);
    $searchTerm = isset($_GET['q']) ? trim($_GET['q']) : "";
    $genre = isset($_GET['genre']) ? trim($_GET['genre']) : "";
    $sortBy = isset($_GET['sortby']) ? trim($_GET['sortby']) : "Random";
    $sortOrder = isset($_GET['sortorder']) ? trim($_GET['sortorder']) : "Ascending";
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 100;
    $start = ($page - 1) * $limit;

    // find Movies library ID
    $moviesLibraryId = "";
    foreach ($libraries["Items"] as $lib) {
        if ($lib["Name"] === "Movies") {
            $moviesLibraryId = $lib["Id"];
            break;
        }
    }

    $items = $moviesLibraryId 
        ? getItems($server, $apiKey, $moviesLibraryId, $searchTerm, $genre, $start, $limit, $sortBy, $sortOrder) 
        : ["Items"=>[], "TotalRecordCount"=>0];

    // Optional: shuffle locally for extra randomness if sorting by Random
    if ($sortBy === "Random" && !empty($items["Items"])) {
        shuffle($items["Items"]);
    }

    $totalItems = $items["TotalRecordCount"];
    $totalPages = $totalItems > 0 ? ceil($totalItems / $limit) : 1;

    require("header.php");
    require("menunav.php");
?>

<script>setActive("media");</script>
<script>setActive("movies");</script>

<link rel="stylesheet" href="assets/css/movies-owl.css?v=<?= SITE_VERSION ?>">

<div class="page-heading header-text">
	<div class="container" style="margin-top:0;margin-bottom:-50px">
		<div class="row d-flex justify-content-center align-items-center" style="margin-top:-50px">>
			<div class="col">
				<div>
					<h1>MOVIE GRID</h1>
				</div>
				<div style="margin-top:-10px;margin-bottom:20px">
					<small>More Media Libraries <i class="fa fa-arrow-right text-success"></i> 
						<a href="https://media.mcjim-server.com" target="_blank">media.mcjim-server.com</a>
					</small>
				</div>
				<form method="GET">
				<div class="row">
					<div class="col-md-4" style="width:100%;margin-bottom:10px">
						<input  style="width:74%" type="text" name="q" placeholder="Search movies..." value="<?php echo htmlspecialchars($searchTerm); ?>">
						<button  style="width:24%" class="btn btn-sm btn-outline-warning" type="submit"><i class="fa fa-search"></i> Go!</button>
					</div>
					<div class="col-md-4" style="width:100%;margin-bottom:10px">
						<select class="btn btn-sm btn-outline-warning text-left" name="genre"  style="width:49%">
							<option value="">All Genres</option>
							<option value="Action" <?php if($genre=="Action") echo "selected"; ?>>Action</option>
							<option value="Crime" <?php if($genre=="Crime") echo "selected"; ?>>Crime</option>
							<option value="Thriller" <?php if($genre=="Thriller") echo "selected"; ?>>Thriller</option>
							<option value="Family" <?php if($genre=="Family") echo "selected"; ?>>Family</option>
							<option value="Drama" <?php if($genre=="Drama") echo "selected"; ?>>Drama</option>
							<option value="Fantasy" <?php if($genre=="Fantasy") echo "selected"; ?>>Fantasy</option>
							<option value="Comedy" <?php if($genre=="Comedy") echo "selected"; ?>>Comedy</option>
							<option value="Romance" <?php if($genre=="Romance") echo "selected"; ?>>Romance</option>
							<option value="Animation" <?php if($genre=="Animation") echo "selected"; ?>>Animation</option>
							<option value="Adventure" <?php if($genre=="Adventure") echo "selected"; ?>>Adventure</option>
							<option value="Science Fiction" <?php if($genre=="Science Fiction") echo "selected"; ?>>Science Fiction</option>
						</select>
						<select class="btn btn-sm btn-outline-warning text-left" name="sortby"  style="width:49%">
							<option value="Random" <?php if($sortBy=="Random") echo "selected"; ?>>Random</option>
							<option value="Name" <?php if($sortBy=="Name") echo "selected"; ?>>Title</option>
							<option value="ProductionYear" <?php if($sortBy=="ProductionYear") echo "selected"; ?>>Year</option>
							<option value="Runtime" <?php if($sortBy=="Runtime") echo "selected"; ?>>Runtime</option>
						</select>
					</div>
					</form>
					<div class="col-md-4" style="width:100%;margin-bottom:10px">		
						<a  style="width:32%" class="btn btn-sm btn-success" href="movies_owl.php"><i class="fa fa-refresh"></i> Refresh</a>
						<a  style="width:32%" href="movies.php" class="btn btn-sm btn-warning btn-rounded-pill"><i class="fa fa-th"></i> Grid</a>
						<a  style="width:32%" href="https://media.mcjim-server.com" target="_blank" class="btn btn-sm btn-info btn-rounded-pill"><i class="fa fa-archive"></i> Libraries</a>
					</div>
				</div>		
			</div>
		</div>
	</div>
</div>

<div class="container-fluid library">
	<div class="row justify-content-center items">
		<div class="owl-carousel slider_carousel col-12 col-sm-4 col-md-8 col-lg-12">
			<?php 
			$shown = []; // associative array to track unique IDs
			foreach ($items["Items"] as $item):
				if (isset($shown[$item["Id"]])) continue;
				$shown[$item["Id"]] = true;

				$imgUrl = isset($item["ImageTags"]["Primary"]) ? "$server/Items/".$item["Id"]."/Images/Primary?X-Emby-Token=$apiKey" : "";
				$sourceId = isset($item["MediaSources"][0]["Id"]) ? $item["MediaSources"][0]["Id"] : "";
				$videoUrl = "$server/Videos/".$item["Id"]."/stream?Static=true&MediaSourceId=".$sourceId."&X-Emby-Token=$apiKey";
			?>
			<div class="item">
				<a class="lightbox" href="<?php echo $videoUrl; ?>">
					<img src="<?php echo $imgUrl ?: 'images/poster.jpg'; ?>" alt="<?php echo $item["Name"]; ?>" class="img-fluid rounded shadow-sm" loading="lazy">
					<div class="play-overlay"><img src="images/play.png"></div>
				</a>
				<div class="meta">
					<h6 class="mt-2 text-truncate"><?php echo $item["Name"]; ?></h6>
					<div class="meta text-truncate">
						<b>Year</b>: <?php echo $item["ProductionYear"]; ?><br>
						<b>Runtime</b>: <?php echo round($item["RunTimeTicks"]/600000000); ?> mins<br>
						<b>Genre</b>: 
						<?php
							$genres = implode(", ", $item["Genres"]);
							$shortGenres = mb_strimwidth($genres, 0, 22, "...");
							echo htmlspecialchars($shortGenres);
						?>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php require("footer.php"); ?>

<script src="vendor/owlcarousel/js/owl.carousel.min.js"></script>

<script>	
	function slider_carouselInit() {
		$('.owl-carousel.slider_carousel').owlCarousel({
			dots: false,
			loop: true,
			margin: 30,
			stagePadding: 2,
			autoplay: true,
			autoplayTimeout: 1500,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1
				},
				768: {
					items: 2
				},
				992: {
					items: 7
				}
			}
		});
	}
	slider_carouselInit();
</script>

