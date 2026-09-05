<?php
	// blog_details.php
	require_once("connect.php");
	require_once("crud_functions.php");

	$post = null; 
	$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
	$post = readBlogPost($conn, $post_id); // single post object
?>

<!-- Combined with an absolute link structure to prevent relative nesting issues -->
<script src="/ajax_call_details.js?v=<?= SITE_VERSION ?>"></script>

<section class="blog blog-details" data-post-id="<?php echo $post['id']; ?>">
  <div class="container">
	<div class="blog-card">
     <!-- Images -->
      <?php if (!empty($post['images']) && is_array($post['images'])): ?>
       <div class="d-flex flex-wrap justify-content-center">
        <?php foreach ($post['images'] as $img): ?>
        <div class="col-12 col-md-4 image-wrapper position-relative">
          <!-- FIXED: Anchored links with a leading slash '/' to ensure flawless path rendering -->
          <a class="venobox" 
             data-gall="post-<?php echo $post['id']; ?>" 
             data-title="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>" 
             data-type="image"
             href="/<?php echo htmlspecialchars($img['image_url']); ?>">
            <img src="/<?php echo htmlspecialchars($img['image_url']); ?>" alt="Post Image" class="img-fluid"/>
          </a>
          <?php 
            $userUno    = $_SESSION['uno']    ?? null;
            $userAccess = $_SESSION['access'] ?? '';
            // Secure validation block matches user access permissions perfectly
            if ($userUno && ($userAccess === 'Admin' || $userUno == $img['uploaded_by'])): ?>
              <button type="button" class="delete-btn btn btn-sm btn-danger position-absolute top-0 end-0 m-2" data-image-id="<?php echo (int)$img['id']; ?>">✖</button>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <!-- Default fallback layout placeholder -->
      <img src="/uploads/mcjim-cyberworks2.webp" alt="Default Image" class="img-fluid mb-2"/>
      <?php endif; ?>

      <!-- Title -->
      <div class="blog-title">
        <h2 style="margin:10px"><?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
      </div>

      <!-- Author -->
      <div class="blog-created">
        <img src="/images/users/<?php echo htmlspecialchars($post['imgUrl'] ?: 'mcjim.jpg'); ?>" 
             alt="avatar" class="rounded-circle me-2">
        <?php echo htmlspecialchars($post['fullname']); ?> • <?php echo $post['created_at']; ?>
      </div>

      <!-- Content + Controls -->
      <div class="blog-content mt-3">
        <?php echo $post['content']; ?>
        <div class="blog-control mt-2">
          <?php if(isset($_SESSION['uno']) && $_SESSION['uno'] == $post['user_uno']): ?>
          <!-- FIXED: Hardened attribute data outputs to ensure complex Quill HTML doesn't break script bindings -->
          <button type="button" class="filled-button edit-btn"
                  data-id="<?php echo $post['id']; ?>"
                  data-title="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8'); ?>"
                  data-content="<?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8'); ?>">
				Edit
          </button> &nbsp;
          <button type="button" class="filled-button delete-post-btn"
                  data-post-id="<?php echo $post['id']; ?>">
				Delete
          </button>
          <?php endif; ?>
        </div>
      </div>

      <!-- Comments Section -->
      <?php 
        $comments = listCommentsByPost($conn, $post['id']);   
        $count = count($comments); 
      ?> 
      <div class="blog-comment mt-3"> 
        <h6 style="margin-bottom:10px">Comments (<b><?php echo $count; ?></b>):</h6>    

        <!-- COMMENTS LOOP -->
        <?php foreach($comments as $c): ?>             
        <div class="row mb-1">       
          <div class="col-md-1 text-right" style="width:0%">       
            <img src="/images/users/<?php echo htmlspecialchars($c['imgUrl'] ?: 'mcjim.jpg'); ?>">       
          </div>       
          <div class="col-md-11" style="width:90%">        
            <strong><?php echo htmlspecialchars($c['fullname']); ?>:</strong>          
            <?php echo htmlspecialchars($c['comment']); ?> &nbsp;      
            <?php if(isset($_SESSION['uno']) && $_SESSION['uno'] == $c['user_uno']): ?>           
            <span class="text-truncate">            
              <button type="button" class="btn btn-sm btn-link edit-comment-btn p-0 border-0 align-baseline"                      
                      data-comment-id="<?php echo (int)$c['id']; ?>"                     
                      data-comment-text="<?php echo htmlspecialchars($c['comment'], ENT_QUOTES, 'UTF-8'); ?>">               
                <i class="fa fa-edit text-warning"></i> Edit             
              </button> &nbsp;            
              <button type="button" class="btn btn-sm btn-link delete-comment-btn ms-2 p-0 border-0 align-baseline"                      
                      data-comment-id="<?php echo (int)$c['id']; ?>">               
                <i class="fa fa-trash text-danger"></i> Delete             
              </button>          
            </span>         
            <?php endif; ?>
          </div>     
        </div>     
        <?php endforeach; ?>    

        <!-- NEW COMMENT -->
        <?php if(isset($_SESSION['uno'])): ?>     
        <div class="addb-comment">       
          <form class="add-comment-form">
            <div class="form-group mb-2">
              <textarea name="comment" rows="1" placeholder="Write a comment cleanly..." required></textarea>
            </div>
			<div class="text-center">
			  <button type="submit" class="filled-button add-comment-btn" data-post-id="<?php echo $post['id']; ?>">         
				Add Comment       
			  </button>
			</div>
          </form>
        </div>   
        <?php else: ?>
        <div class="form-control alert alert-light mt-3 py-2 small" role="alert">
			<span class="text-muted">Please sign in to join <x class="thid">the conversation</x>.</span>
        </div>
        <?php endif; ?> 
      </div>
    </div>
  </div>
</section>
