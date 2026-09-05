<!DOCTYPE html>
<html lang="en">
<?php
	require_once("version.php");
	// Dynamic SEO Settings based on active page script
	$current_file = basename($_SERVER['SCRIPT_NAME']);
	
	// Default values
	$seo_title = "McJim Cyberworks";
	$seo_desc = "Official website of McJim Cyberworks, Pagadian City, Philippines. Access web services, video conference, mail service, media server, instant messenger and blogs.";
	$seo_keywords = "McJim, Cyberworks, McJim Media, McJim Mail, McJim Server, McJim Meet, McJim Cyberworks";
	$seo_robots = "noindex, nofollow"; // Secure default for administrative pages

	if ($current_file === 'index.php') {
		$seo_title = "McJim Cyberworks";
		$seo_desc = "Official website of McJim Cyberworks, Pagadian City Philippines. Free Video Conference, Free Media Streams, Free Instant Messenger, Free Mail Services and Open Blogs.";
		$seo_keywords = "McJim Cyberworks, McJim Server, McJim Meet, McJim Mail, McJim Blogs";
		$seo_robots = "index, follow";
	} else if ($current_file === 'blog.php') {
		$seo_title = "Blogs | McJim Cyberworks";
		$seo_desc = "Interactive public and logged users for blogging and for any other informations.";
		$seo_keywords = "McJim Blogs, My Blogs, @mcjimblogs";
		$seo_robots = "index, follow";
	} else if ($current_file === 'movies.php') {
		$seo_title = "Movies | McJim Cyberworks";
		$seo_desc = "List of latest decent streamed movies. Seachable, sorted by genre, year and randomized.";
		$seo_keywords = "McJim Movies, Movie List, Movie Carousel, Decent Movies";
		$seo_robots = "index, follow";
	} else if ($current_file === 'movies_owl.php') {
		$seo_title = "Movies | McJim Cyberworks";
		$seo_desc = "List of latest decent streamed movies. Seachable, sorted by genre, year and randomized.";
		$seo_keywords = "McJim Movies, Movie List, Movie Carousel, Decent Movies";
		$seo_robots = "index, follow";
	} else if ($current_file === 'about.php') {
		$seo_title = "About | McJim Cyberworks";
		$seo_desc = "We have over 10 years of experience empowering Digital Transformation with Tailored IT Solutions.";
		$seo_keywords = "About McJim, About McJim Cyberworks";
		$seo_robots = "index, follow";
	} else if ($current_file === 'projects.php') {
		$seo_title = "Projects | McJim Cyberworks";
		$seo_desc = "McJim Cyberworks Web Development Projects.";
		$seo_keywords = "McJim Web Development, McJim Web Projects, McJim Fullstack Developer";
		$seo_robots = "index, follow";
	} else if ($current_file === 'contact.php') {
		$seo_title = "Contact | McJim Cyberworks";
		$seo_desc = "McJim Cyberworks Contact Information.";
		$seo_keywords = "McJim Contact, Contact Us, McJim Contact Informations";
		$seo_robots = "index, follow";
	} else if ($current_file === 'user_register.php') {
		$seo_title = "Signup | McJim Cyberworks";
		$seo_desc = "Join Us on McJim Cyberworks. Signup for Us";
		$seo_keywords = "McJim Signup, McJim Join Us, McJim Register Us";
		$seo_robots = "index, follow";

		// Fix login condition
		} else if ($current_file === 'login.php') {
			$seo_title = "Login | McJim Cyberworks";
			$seo_desc = "Logged users has access to all services offered.";
			$seo_keywords = "McJim Users, McJim User Login, McJim Cyberwork Access";
			$seo_robots = "noindex, nofollow";
		}
	
	// Allow individual page scripts to override if they set variables before inclusion
	if (isset($page_title)) {
		$seo_title = $page_title;
	}
	if (isset($page_description)) {
		$seo_desc = $page_description;
	}
	if (isset($page_keywords)) {
		$seo_keywords = $page_keywords;
	}
	if (isset($page_robots)) {
		$seo_robots = $page_robots;
	}
?>

<head>
    <meta charset="utf-8">
    <meta name="author" content="McJim Cyberworks"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo htmlspecialchars($seo_desc); ?>"/>

	<meta property="og:type" content="website"/>
	<meta property="og:url" content="https://<?php echo htmlspecialchars($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"/>
	<meta property="og:title" content="<?php echo htmlspecialchars($seo_title); ?>"/>
	<meta property="og:description" content="<?php echo htmlspecialchars($seo_desc); ?>"/>
	<meta property="og:image" content="https://<?php echo htmlspecialchars($_SERVER['HTTP_HOST']); ?>/images/logo.webp"/>

	<meta name="twitter:card" content="summary_large_image"/>
	<meta name="twitter:url" content="https://<?php echo htmlspecialchars($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"/>
	<meta name="twitter:title" content="<?php echo htmlspecialchars($seo_title); ?>"/>
	<meta name="twitter:description" content="<?php echo htmlspecialchars($seo_desc); ?>"/>
	<meta name="twitter:image" content="https://<?php echo htmlspecialchars($_SERVER['HTTP_HOST']); ?>/images/logo.webp"/>

	<link rel="canonical" href="https://<?php echo htmlspecialchars($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>"/>

	<title><?php echo htmlspecialchars($seo_title); ?></title>

	<script type="application/ld+json">
	{
	  "@context": "https://schema.org",
	  "@type": "Organization",
	  "name": "McJim Cyberworks",
	  "url": "https://mcjim-server.com",
	  "logo": "https://mcjim-server.com/images/logo.webp",
	  "sameAs": [
		"https://www.facebook.com/mcjimserver",
		"https://www.linkedin.com/in/mcjim-cyberworks-5092a6186/"
	  ]
	}
	</script>

	<!-- Adsense -->
	<meta name="google-adsense-account" content="ca-pub-4818333944764715">
	<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4818333944764715" crossorigin="anonymous"></script>
		
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-CW0ZYMCM2S"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-CW0ZYMCM2S');
	</script>
    
    <!-- Fonts & Favicon -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/images/favicon.png" type="image/x-icon">

    <!-- Bootstrap core CSS -->
    <link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">   

    <!-- Additional CSS Files -->
    <link href="/vendor/owlcarousel/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/assets/css/fontawesome.css">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= SITE_VERSION ?>">		
	
	<!-- Chat Notifications Style & Polling -->
    <?php if (isset($_SESSION['user'])): ?>
    <link rel="stylesheet" href="/chat/chat_notification.css?v=<?= SITE_VERSION ?>">
	<script src="/chat/chat_notification.js"></script>
    <?php endif; ?>

	<!-- SweetAlert2 & Quill -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
	<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
</head>

<body>

<script>
	if (window.XMLHttpRequest)
		xmlhttp=new XMLHttpRequest();
	else
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");				

	function conf(){
		return confirm("Are you sure??");
	}

	function jump(page){
		window.location=page;
	}
	
	function getID(id){
		return document.getElementById(id);
	}

	function setActive(id){
		var el = getID(id);
		if (el) {
			el.classList.add("nav-active-glow");
		}
	}	
</script>

<!-- Fresh reload script -->
<script>
	window.onload = function() {
		const params = new URLSearchParams(window.location.search);
		if (params.has("fresh")) {
			window.location.replace("index.php");
		}
	};
</script>