// 1. POST LOADER
function getActivePostId() {
  const detailsSection = document.querySelector('.blog-details');
  if (detailsSection && detailsSection.dataset.postId) {
    return detailsSection.dataset.postId;
  }  
  const fallbackBtn = document.querySelector('.add-comment-btn');
  if (fallbackBtn && fallbackBtn.dataset.postId) {
    return fallbackBtn.dataset.postId;
  }
  return null;
}

// Core dynamic AJAX page container reloader
function loadPosts(postId) {
  const id = postId || getActivePostId();  
  if (!id) {
    console.warn("Sync Notice: No active Post ID could be resolved from layout structure.");
    return;
  }
  console.log(`Refreshing template container via AJAX for Post ID: ${id}`);
  fetch(`ajax_posts_details.php?id=${id}`)
    .then(res => {
      if (!res.ok) throw new Error(`HTTP error status: ${res.status}`);
      return res.text();
    })
    .then(html => {
      const targetContainer = document.querySelector('.blog-details') || document.querySelector('.blog');      
      if (targetContainer) {
        if (targetContainer.classList.contains('blog-details')) {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const innerContent = doc.querySelector('.blog-details');
          targetContainer.innerHTML = innerContent ? innerContent.innerHTML : html;
        } else {
          targetContainer.innerHTML = html;
        }
        console.log("DOM content synchronized cleanly.");
      } else {
        console.error("Target content container not detected on this layout markup template.");
      }
      if (typeof jQuery !== 'undefined' && jQuery().venobox) {
        jQuery('.venobox').venobox({
          numeratio: true,
          infinigall: true,
          share: false
        });
        console.log("VenoBox instances synchronized onto new elements.");
      } else if (typeof lightbox !== 'undefined' && lightbox.option) {
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        });
      }
    })
    .catch(err => {
      console.error("Fetch Container Exception Handled:", err);
      Swal.fire('Error', 'Failed to refresh post details view contents.', 'error');
    });  
}

// 2. GLOBAL EVENT DELEGATION ACTION ROUTERS
document.body.addEventListener('click', function(e) {
  // 1. Edit Comment Trigger
  const editCommentBtn = e.target.closest('.edit-comment-btn');
  if (editCommentBtn) {
    e.preventDefault();
    const commentId = editCommentBtn.dataset.commentId;
    const commentText = editCommentBtn.dataset.commentText;
    if (typeof editComment === 'function') editComment(commentId, commentText);
    return;
  }
  const deleteCommentBtn = e.target.closest('.delete-comment-btn');
  if (deleteCommentBtn) {
    e.preventDefault();
    const commentId = deleteCommentBtn.dataset.commentId;
    if (typeof deleteComment === 'function') deleteComment(commentId);
    return;
  }
  // 2. Delete Post Trigger
  const deletePostBtn = e.target.closest('.delete-post-btn');
  if (deletePostBtn) {
    e.preventDefault();
    if (typeof deletePost === 'function') deletePost(deletePostBtn.dataset.postId);
    return;
  }
  // 3. Edit Post Button (CLEAN WRAPPER ROUTE WITH LOGS)
  const editPostBtn = e.target.closest('.edit-btn');
  if (editPostBtn) {
    e.preventDefault();
    console.log("%c[Debug] Edit Button Clicked!", "color: cyan; font-weight: bold;"); 
    // Check raw attributes on the button element
    console.log("Raw Button Dataset:", editPostBtn.dataset);
    const id = editPostBtn.dataset.id;
    const titleText = document.querySelector('.blog-title h2')?.textContent.trim() || '';
    // Extracting content layout safely
    const contentContainer = document.querySelector('.blog-content');
    let contentHtml = '';
    if (contentContainer) {
      const clone = contentContainer.cloneNode(true);
      const controls = clone.querySelector('.blog-control');
      if (controls) controls.remove();
      contentHtml = clone.innerHTML.trim();
    }
    console.log("DOM Extraction Results:", { id: id, title: titleText, contentLength: contentHtml.length });
    if (typeof editPost === 'function' && id) {
      editPost(id, titleText, contentHtml);
    } else {
      console.error("[Error] Action cancelled: Either editPost function is missing or ID is empty!");
    }
    return;
  }
  // 4. Delete Single Image Asset Trigger
  const deleteImageBtn = e.target.closest('.delete-btn');
  if (deleteImageBtn) {
    e.preventDefault();
    const imgId = deleteImageBtn.dataset.imageId || deleteImageBtn.getAttribute('data-image-id');
    if (typeof deleteImage === 'function') deleteImage(imgId);
    return;
  }
  // 5. Global Navbar Add Post Modal Trigger
  if (e.target.closest('#btnAddPost')) {
    e.preventDefault();
    if (typeof addPostModal === 'function') addPostModal();
    return;
  }
});

// 🌐 GLOBAL DRAG & DROP EVENT BINDING UTILITY
function initializeDropzone(zoneId, inputId) {
  const dropzone = document.getElementById(zoneId);
  const fileInput = document.getElementById(inputId);
  if (!dropzone || !fileInput) return;
  // Add highlight visual tracking states when item hovers over layout zone
  ['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.add('drag-active');
    }, false);
  });
  // Remove highlight visual tracking states when item leaves tracking field
  ['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.remove('drag-active');
    }, false);
  });
  // Intercept data streams on physical asset drops
  dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    fileInput.files = dt.files; // Bypasses system array layouts to populate the element state directly
    updateDropzoneLabel(dropzone, dt.files);
  }, false);
  // Still support fallback traditional click execution windows on box click targets
  dropzone.addEventListener('click', () => fileInput.click());
  // Watch manual input adjustments to keep display text updated
  fileInput.addEventListener('change', () => {
    updateDropzoneLabel(dropzone, fileInput.files);
  });
}

function updateDropzoneLabel(zoneElement, filesList) {
  if (filesList.length > 0) {
    zoneElement.innerHTML = `<strong>Selected ${filesList.length} file(s)</strong><br><span style="font-size:12px;color:#64748b;">Click or drag to replace selection</span>`;
  } else {
    zoneElement.innerHTML = `Drag & Drop your images here`;
  }
}

// 📝 ------ ADD POST (STABILIZED) ------
function addPostModal() {
  Swal.fire({
    title: 'Create New Post',
    html: `
      <input id="swal-title" class="swal-input" placeholder="Title" required style="width:100%; margin-bottom:15px; padding:8px;">
      <div id="quill-editor" class="editor" style="height:200px; margin-bottom:15px;"></div>
      
      <!-- Drag & Drop Box Container Integration -->
      <div id="swal-dropzone-add" class="custom-dropzone">
         Drag & Drop your images here or <strong>Browse</strong>
      </div>
      <input id="swal-image" type="file" style="display:none;" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
    `,
    didRender: () => {
      initializeDropzone('swal-dropzone-add', 'swal-image');      
      if (document.getElementById('quill-editor')) {
        window.quill = new Quill('#quill-editor', { theme: 'snow' });
      }
    },
    showCancelButton: true,
    confirmButtonText: 'Publish',
    preConfirm: () => {
      const title = document.getElementById('swal-title').value.trim();
      const content = window.quill.root.innerHTML.trim();
      const plainText = window.quill.getText().trim();

      if (!title || plainText.length === 0 || content === '<p><br></p>') {
        Swal.showValidationMessage('Title and content are required fields.');
        return false;
      }
      const fd = new FormData();
      fd.append('title', title);
      fd.append('content', content);
      const files = document.getElementById('swal-image').files;
      const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      const maxSizeBytes = 10 * 1024 * 1024;
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const extension = file.name.split('.').pop().toLowerCase();
        if (file.size > maxSizeBytes) {
          Swal.showValidationMessage(`"${file.name}" is too heavy! Max size limit is 10MB.`);
          return false;
        }
        if (!allowedExtensions.includes(extension)) {
          Swal.showValidationMessage(`"${file.name}" format is invalid. Only JPG, PNG, GIF, and WebP are allowed.`);
          return false;
        }
        fd.append('images[]', file);
      }
      Swal.showLoading();
      return fetch('ajax_add_post.php', { method: 'POST', body: fd })
        .then(res => {
          if (!res.ok) throw new Error('Internal Server Error');
          return res.json();
        })
        .catch(() => {
          Swal.showValidationMessage('Request execution aborted by network rules.');
          return false;
        });
    }
  }).then(result => {
    if (result.value && result.value.status === 'OK') {
      Swal.fire('Success', 'Post added successfully!', 'success')
        .then(() => {
          const newId = result.value.id || (typeof getActivePostId === 'function' ? getActivePostId() : null);
          if (newId && typeof loadPosts === 'function') {
            loadPosts(newId);
          } else {
            window.location.href = 'blog.php';
          }
        });
    } else if (result.value) {
      Swal.fire('Error', result.value.message || 'Insert failed', 'error');
    }
  });
}
// 🔄 ------- EDIT POST (STABILIZED) --------
function editPost(id, title, content) {
  Swal.fire({
    title: 'Edit Post',
    html: `
      <input id="swal-title" class="swal-input" value="${title.replace(/"/g, '&quot;')}" required style="width:100%; margin-bottom:15px; padding:8px;">
      <div style="width:100%; margin-bottom:15px;">
        <div id="quill-editor" class="editor" style="height:200px;"></div>
      </div>      
      <div id="swal-dropzone-edit" class="custom-dropzone">
         Drag & Drop new images here or <strong>Browse</strong>
      </div>
      <input id="swal-image-edit" type="file" style="display:none" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
    `,
    didRender: () => {
      initializeDropzone('swal-dropzone-edit', 'swal-image-edit');      
      const container = document.getElementById('quill-editor');
      if (container) {
        if (window.quill) {
          container.classList.remove('ql-container', 'ql-snow');
          container.innerHTML = '';
          const oldToolbars = document.querySelectorAll('.ql-toolbar');
          oldToolbars.forEach(tb => tb.remove());
          window.quill = null;
        }
        window.quill = new Quill('#quill-editor', { theme: 'snow' });        
        let normalizedContent = content;
        if (normalizedContent === '<p><br></p>' || normalizedContent === '<p></p>') {
          normalizedContent = '';
        }
        window.quill.root.innerHTML = normalizedContent;
      }
    },
    showCancelButton: true,
    confirmButtonText: 'Update',
    preConfirm: () => {
      const newTitle = document.getElementById('swal-title').value.trim();
      const newContent = window.quill.root.innerHTML.trim();
      const plainText = window.quill.getText().trim();
      
      if (!newTitle || plainText.length === 0 || newContent === '<p><br></p>') {
        Swal.showValidationMessage('Title and content are required fields.');
        return false;
      }
      const fd = new FormData();
      fd.append('post_id', id);
      fd.append('title', newTitle);
      fd.append('content', newContent);
      const fileInput = document.getElementById('swal-image-edit');
      const files = fileInput ? fileInput.files : [];
      const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      const maxSizeBytes = 10 * 1024 * 1024;
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const extension = file.name.split('.').pop().toLowerCase();
        if (file.size > maxSizeBytes) {
          Swal.showValidationMessage(`"${file.name}" is too heavy! Max size is 10MB.`);
          return false;
        }
        if (!allowedExtensions.includes(extension)) {
          Swal.showValidationMessage(`"${file.name}" format is invalid.`);
          return false;
        }
        fd.append('images[]', file);
      }
      Swal.showLoading();
      return fetch('ajax_edit_post.php', { method: 'POST', body: fd })
        .then(res => {
          if (!res.ok) throw new Error('Network error');
          return res.json();
        })
        .catch(() => {
          Swal.showValidationMessage('Request execution aborted by network rules.');
          return false;
        });
    }
  }).then(result => {
    if (result.value && result.value.status === 'OK') {
      Swal.fire('Updated!', 'Post updated successfully!', 'success').then(() => {
        if (typeof loadPosts === 'function') loadPosts(id);
        else window.location.reload();
      });
    } else if (result.value) {
      Swal.fire('Error', result.value.message || 'Update failed', 'error');
    }
  });
}

// 🔄 ------- DELETE POST (STABILIZED) --------
function deletePost(id) {
  Swal.fire({
    title: 'Delete Post?',
    text: 'This destructive administrative action cannot be undone.',
    icon: 'warning',showCancelButton: true,
    confirmButtonText: 'Yes, delete it!'
  })
    .then(result => {if (result.isConfirmed) {
      const formData = new FormData();
	  formData.append('post_id', id);
	  fetch('ajax_delete_post.php', {
  	    method: 'POST', body: formData 
	  })
	  .then(res => res.json()).then(data => {
	    if (data.status === 'OK') {
	      Swal.fire('Deleted!', 'Post dropped out cleanly.', 'success')
	      .then(() => {
		   window.location.href = 'blog.php';
	      });
	    } else {
	      Swal.fire('Error', data.message, 'error');
	    }
	  });
    }
  });
}

// 4. COMMENT SECTION SUBSYSTEM ACTIONS
document.addEventListener('submit', (e) => {
  const form = e.target.closest('.add-comment-form');
  if (!form) return;
  e.preventDefault();
  const submitBtn = form.querySelector('.add-comment-btn');
  const postId = submitBtn ? submitBtn.getAttribute('data-post-id') : getActivePostId();
  const textarea = form.querySelector('textarea[name="comment"]');
  const text = textarea ? textarea.value.trim() : '';
  if (!postId) {
    Swal.fire('Error', 'Target post identifier parameter is missing.', 'error');
    return;
  }
  if (!text) {
    Swal.fire('Error', 'Comment payload body strings cannot be left empty.', 'error');
    return;
  }
  const formData = new FormData();
  formData.append('post_id', postId);
  formData.append('comment', text);
  fetch('ajax_add_comment.php', { method: 'POST', body: formData })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'OK') {
        Swal.fire('Success', 'Comment added!', 'success');
        if (textarea) textarea.value = '';
        loadPosts(postId);
      } else {
        Swal.fire('Error', data.message || 'Processing boundary context breakdown error.', 'error');
      }
    })
    .catch(err => console.error("Dynamic comment post submission crash: ", err));
});

// Edit Comment
function editComment(commentId, oldText) {
  Swal.fire({
    title: 'Edit Comment',
    input: 'textarea',
    inputValue: oldText,
    showCancelButton: true
  }).then(result => {
    if (result.value) {
      const formData = new FormData();
      formData.append('comment_id', commentId);
      formData.append('comment', result.value);
      
      fetch('ajax_edit_comment.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'OK') {
            Swal.fire('Updated!', 'Comment updated!', 'success');
            loadPosts();
          } else if (data.status === 'NOCHANGE') {
            Swal.fire('Notice', 'No changes were detected.', 'info');
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(err => console.error("Edit request communication exception: ", err));
    }
  });
}

// Delete Comment
function deleteComment(commentId) {
  Swal.fire({
    title: 'Delete Comment?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!'
  }).then(result => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('comment_id', commentId);
      fetch('ajax_delete_comment.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'OK') {
            Swal.fire('Deleted!', 'Comment has been deleted.', 'success');
            loadPosts();
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(err => console.error("Delete request communication exception: ", err));
    }
  });
}

// 5. IMAGES AND POSTS MANAGERS
function deleteImage(id) {
  if (!id) {
    Swal.fire('Error', 'Image target data ID reference value parameter is missing.', 'error');
    return;
  }
  Swal.fire({
    title: 'Delete Image?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!'
  }).then(result => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('image_id', id);

      fetch('ajax_delete_image.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'OK') {
            Swal.fire('Deleted!', 'Image has been removed from database listings.', 'success');
            loadPosts();
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(err => console.error("Image processing transaction exception: ", err));
    }
  });
}