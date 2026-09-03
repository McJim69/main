<!DOCTYPE html>
<html lang="en">
<head>
	<?php require_once("version.php");?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>mcjim-server.com</title>
	<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=<?= SITE_VERSION ?>">

<style>
	* {margin:0; padding:0; box-sizing:border-box;}
	body {font-family:Arial, sans-serif; line-height:1.6; background:#121212; color:#eee;}

	/* Hero */
	#hero {position:relative; height:100vh; overflow:hidden;}
	.video-container {position:relative; height:100%;}
	.video-container video {width:100%; height:100%; object-fit:cover; transform:translateY(0); transition:transform 0.2s ease-out;}
	.overlay {position:absolute; top:0; left:0; width:100%; height:100%; background:linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.7));}
	.content {position:absolute; top:60%; left:50%; transform:translate(-50%,-50%); text-align:center;}
	.intro-btn {position:absolute; top:87%; left:50%; transform:translate(-50%,-50%); text-align:center;}
	.cta-btn, .skip-btn, .audio-btn {
		display:inline-block; margin:10px; padding:12px 24px; border-radius:6px;
		background:#444; color:#fff; text-decoration:none; font-weight:bold;
		transition:background 0.3s, transform 0.2s;
	}
	.cta-btn:hover, .skip-btn:hover, .audio-btn:hover {background:#666; transform:scale(1.05);}

	/* Particle canvas */
	#particles {position:absolute; top:0; left:0; width:100%; height:100%; pointer-events:none;}

	/* Features */
	.features {display:flex; flex-wrap:wrap; justify-content:center; gap:20px; padding:40px;}
	.feature {
		flex:1 1 250px; background:#1e1e1e; border-radius:8px; padding:20px;
		box-shadow:0 4px 8px rgba(0,0,0,0.4); transition:transform 0.3s, box-shadow 0.3s, opacity 0.6s ease;
		opacity:0; transform:translateY(20px); color:#eee;
	}
	.feature.visible {opacity:1; transform:translateY(0);}
	.feature:hover {transform:translateY(-8px) scale(1.02); box-shadow:0 8px 16px rgba(0,0,0,0.6);}

	/* Footer */
	footer {text-align:center; padding:20px; background:#000; color:#fff;}
	footer a {color:#ff6600; text-decoration:none;}

	@media(max-width:760px){
		.feature h3{font-size:18px} 
		.feature p {font-size:12px} 		
	}
</style>

</head>

<body>

<header id="hero">
	<div class="video-container">
		<video id="introVideo" autoplay muted loop playsinline poster="images/mcjim-cyberworks2.webp">
			<source src="mcjim-server.com2.mp4" type="video/mp4" media="(max-width: 768px)">
			<source src="mcjim-server.com1.mp4" type="video/mp4">
		</video>
    </div>
	<canvas id="particles"></canvas>
	<div class="overlay"></div>
	<div class="content">
		<a class="filled-button" id="enableAudio" class="audio-btn">Enable Audio</a>
    </div>
	<div class="intro-btn">
		<a class="filled-button skip-btn" href="index.php">Get Started</a>
    </div>
</header>

  <!-- Features -->
  <section class="features">
    <div class="feature"><h3><i class="fas fa-code fa-bounce"></i> Full-Stack Developer</h3><p>Powered by advanced PHP and SQL, ensuring seamless performance.</p></div>
    <div class="feature"><h3><i class="fa-solid fa-screwdriver-wrench fa-spin"></i> Repair and Maintenance</h3><p>Professional IT Repair and Maintenance Services for Business and Home.</p></div>
    <div class="feature"><h3><i class="fa fa-server fa-fade"></i> Server Management</h3><p>Enterprise server setup and configuration tailored to customers’ needs.</p></div>
    <div class="feature"><h3><i class="fas fa-network-wired fa-shake"></i> Network Deployment</h3><p>Large-scale network deployment services, scalable from small businesses to enterprise environments.</p></div>
  </section>

<div class="sub-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<p style="color:#bbb">
					Copyright &copy; 2020 - <?php echo date("Y");?> <a href="https://mcjim-server.com">McJim Cyberworks</a> Pagadian City, Philippines
				</p>
			</div>
		</div>
	</div>
</div>

  <script>
    const vid = document.getElementById("introVideo");
    const audioBtn = document.getElementById("enableAudio");
    const skipBtn = document.querySelector(".skip-btn");
    const hero = document.getElementById("hero");

    // Enable audio
    audioBtn.addEventListener("click", () => { vid.muted = false; vid.play(); audioBtn.style.display = "none"; });

    // Skip intro with fade
    skipBtn.addEventListener("click", (e) => { e.preventDefault(); hero.classList.add("fade-out"); setTimeout(() => { window.location.href = 'index.php'; }, 1000); });

    // Scroll reveal
    const features = document.querySelectorAll('.feature');
    window.addEventListener('scroll', () => {
      features.forEach(f => {
        const rect = f.getBoundingClientRect();
        if (rect.top < window.innerHeight - 50) f.classList.add('visible');
      });
    });

    // Parallax effect
    window.addEventListener('scroll', () => {
      const offset = window.scrollY * 0.3;
      vid.style.transform = `translateY(${offset}px)`;
    });

    // Particle animation
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let particles = [];
    canvas.width = window.innerWidth; canvas.height = window.innerHeight;

    class Particle {
      constructor() {
        this.x = Math.random() * canvas.width;
        this.y = Math.random() * canvas.height;
        this.size = Math.random() * 2 + 1;
        this.speedX = (Math.random() - 0.5) * 0.5;
        this.speedY = (Math.random() - 0.5) * 0.5;
      }
      update() { this.x += this.speedX; this.y += this.speedY; if(this.size > 0.2) this.size -= 0.01; }
      draw() { ctx.fillStyle = 'rgba(255,255,255,0.8)'; ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI*2); ctx.fill(); }
    }

    function initParticles() { particles = []; for(let i=0;i<100;i++){ particles.push(new Particle()); } }
    function animateParticles() {
      ctx.clearRect(0,0,canvas.width,canvas.height);
      particles.forEach(p => { p.update(); p.draw(); });
      requestAnimationFrame(animateParticles);
    }
    initParticles(); animateParticles();
    window.addEventListener('resize', () => { canvas.width = window.innerWidth; canvas.height = window.innerHeight; initParticles(); });
  </script>

</body>
</html>
