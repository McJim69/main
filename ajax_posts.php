<?php
	// ajax_posts.php
	require_once("connect.php");
	require_once("crud_functions.php");

	$posts = listBlogPosts($conn, 10);
	$recent = listRecentPosts($conn, 10);
?>

<script src="/ajax_call_posts.js?v=<?= SITE_VERSION ?>"></script>

<section class="blog">
  <div class="container">
	 <div class="row">
		<div class="col-md-8">
		  <?php foreach($posts as $p): ?>
			<div class="blog-card">
				<!-- Images -->
				<?php if (!empty($p['images'])): ?>
				<div class="d-flex flex-wrap justify-content-center">
					<?php foreach (array_slice($p['images'], 0, 6) as $img): ?>
					<div class="col-12 col-md-4 image-wrapper">
						<a 	class="venobox" 
							data-gall="post-<?php echo $p['id']; ?>" 
							data-title="<?php echo htmlspecialchars($p['title']); ?>" 
							data-type="image"
							href="/<?php echo htmlspecialchars($img['image_url']); ?>">
							<img src="/<?php echo htmlspecialchars($img['image_url']); ?>" alt="Post Image" class="img-fluid"/>
						</a>

						<?php 
						  $userUno    = $_SESSION['uno']    ?? null;
						  $userAccess = $_SESSION['access'] ?? '';
						  // Show delete button if Admin OR owner/uploader
						  if ($userUno && ($userAccess === 'Admin' || $userUno == $img['uploaded_by'])): ?>
							<button class="delete-btn btn btn-sm btn-danger" data-image-id="<?php echo (int)$img['id']; ?>">✖</button>
						<?php endif; ?>

					</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
				<img src="/uploads/mcjim-cyberworks2.webp" alt="Default Image" class="img-fluid mb-2"/>
				<?php endif; ?>

				<!-- Title -->
				<div class="blog-title">
					<h4>
						<a href="/blog_details.php?id=<?php echo $p['id']; ?>">
						<?php echo htmlspecialchars($p['title']); ?>
						</a>
					</h4>
				</div>

				<!-- Author -->
				<div class="blog-created">
					<img src="/images/users/<?php echo htmlspecialchars($p['imgUrl'] ?: 'mcjim.jpg'); ?>" 
						alt="avatar" class="rounded-circle me-2">
					<?php echo htmlspecialchars($p['fullname']); ?> &bull; <?php echo $p['created_at']; ?>
				</div>

				<!-- Content + Controls -->
				<div class="blog-content">
					<?php 
					  $plain_content = trim(strip_tags($p['content'])); 
					  if (strlen($plain_content) > 0) {
						echo (strlen($plain_content) > 200) ? htmlspecialchars(mb_substr($plain_content, 0, 100)) . '...' : htmlspecialchars($plain_content); 
					  } else {
						echo "No content available.";
					  }						
					?>
					<div class="blog-control d-flex justify-content-center">
						<button class="filled-button" 
								onclick="jump('blog_details.php?id=<?php echo $p['id']; ?>')">
							More
						</button> &nbsp;
						<?php if(isset($_SESSION['uno']) && $_SESSION['uno'] == $p['user_uno']): ?>
						<button class="filled-button edit-btn"
								data-id="<?php echo $p['id']; ?>"
								data-title="<?php echo htmlspecialchars($p['title'], ENT_QUOTES); ?>"
								data-content="<?php echo htmlspecialchars($p['content'], ENT_QUOTES); ?>">
							Edit
						</button> &nbsp;
						<button class="filled-button delete-post-btn"
								data-post-id="<?php echo $p['id']; ?>">
							Delete
						</button>
						<?php endif; ?>
					</div>
				</div>

				<!-- Comments Section-->
				<?php 
					// Fetch comments array and count length safely
					$comments = listCommentsByPost($conn, $p['id']);   
					$count = count($comments); 
				?> 
				<div class="blog-comment"> 
					<h6 style="margin-bottom:10px">Comments (<b><?php echo $count; ?></b>):</h6>    
					<!-- 1. COMMENTS DISPLAY LIST LOOP -->
					<?php foreach($comments as $c): ?>             
					<div class="row mb-1">       
						<div class="col-md-1 text-right" style="width:0%">       
							<img src="/images/users/<?php echo htmlspecialchars($c['imgUrl'] ?: 'mcjim.jpg'); ?>">       
						</div>       
						<div class="col-md-11" style="width:90%">        
							<strong><?php echo htmlspecialchars($c['fullname']); ?>:</strong>          
							<?php echo htmlspecialchars($c['comment']); ?> &nbsp;      
				
							<!-- Authorization Actions -->
							<?php if(isset($_SESSION['uno']) && $_SESSION['uno'] == $c['user_uno']): ?>           
							<span class="text-truncate">            
								<button type="button" class="btn-link edit-comment-btn p-0 border-0 align-baseline"                      
										data-comment-id="<?php echo (int)$c['id']; ?>"                     
										data-comment-text="<?php echo htmlspecialchars($c['comment'], ENT_QUOTES, 'UTF-8'); ?>">               
									<i class="fa fa-edit text-warning"></i>Edit             
								</button> &nbsp;            
								<button type="button" class="btn-link delete-comment-btn ms-2 p-0 border-0 align-baseline"                      
										data-comment-id="<?php echo (int)$c['id']; ?>">               
									<i class="fa fa-trash text-danger"></i>Delete             
								</button>          
							</span>         
							<?php endif; ?>
						</div>     
					</div>     
					<?php endforeach; ?>    

					<!-- 2. NEW COMMENT SUBMISSION CONTAINER -->
					<?php if(isset($_SESSION['uno'])): ?>     
					<div class="addb-comment">       
						<form class="add-comment-form">
							<div class="form-group mb-2">
								<textarea name="comment" rows="1" placeholder="Write a comment cleanly..." required></textarea>
							</div>
							<div class="text-center">
								<button type="submit" class="filled-button add-comment-btn"                
										data-post-id="<?php echo $p['id']; ?>">         
									Add Comment       
								</button>
							</div>
						</form>
					</div>   
					<?php else: ?>
					<div class="form-control alert mt-3 py-2 small" role="alert">
						<span class="text-muted">Please sign in to join <x class="thid">the conversation</x>.</span>
					</div>
					<?php endif; ?> 
				</div>
			</div>
		<?php endforeach;?>
		</div>
		<!-- Sidebar -->
		<div class="col-md-4">
		  <div class="blog-card">
			<div style="margin:5px">
				<h4 class="h4">Search Posts</h4>
				<form id="search_form" name="gs">
					<div class="input-group">
						<input style="width:80%" type="text" class="form-control" name="q" placeholder="Type keyword..." autocomplete="on">
						<button style="width:20%" type="submit" class="form-control"><i class="fa fa-search"></i></button>
					</div>
				</form>
			<div id="searchResults" style="margin:20px 0 20px 0"></div>
			<h4>Recent Posts</h4>
				<ul>
					<?php foreach($recent as $r): ?>
					<li style="margin:10px auto;color:#bbb">
					<b><a href="/blog_details.php?id=<?php echo $r['id']; ?>">
						<?php echo htmlspecialchars($r['title']); ?>
					</a><br>
					<small>
						<i class="fa fa-user"></i> <?php echo htmlspecialchars($r['fullname']); ?>  
						&nbsp;|&nbsp; <i class="fa fa-calendar"></i> <?php echo $r['created_at']; ?>
					</small>
					</b>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		 </div>
	  </div>
	</div>
  </div>
</section>
