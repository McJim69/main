// -------------------- LOAD POSTS --------------------
function loadPosts() {
  fetch('ajax_posts.php')
    .then(res => res.text())
    .then(html => {
      document.querySelector('.blog').innerHTML = html;
    })
    .catch(err => Swal.fire('Error', 'Failed to load posts', 'error'));
}

// -------------------- EVENT DELEGATION --------------------
document.body.addEventListener('click', function(e) {
  const editCommentBtn = e.target.closest('.edit-comment-btn');
  if (editCommentBtn) {
    e.preventDefault();
    const commentId = editCommentBtn.dataset.commentId;
    const commentText = editCommentBtn.dataset.commentText;

    console.log('Edit button dataset:', editCommentBtn.dataset); // debug

    if (typeof handleCommentEdit === 'function') {
      handleCommentEdit(commentId, commentText);
    } else if (typeof editComment === 'function') {
      editComment(commentId, commentText);
    }
    return;
  }

  // 2. Delete Comment Button
  const deleteCommentBtn = e.target.closest('.delete-comment-btn');
  if (deleteCommentBtn) {
    e.preventDefault();
    const commentId = deleteCommentBtn.dataset.commentId;
    
    // Safely executes whichever function name is defined in your file
    if (typeof handleCommentDelete === 'function') {
      handleCommentDelete(commentId);
    } else if (typeof deleteCommentAction === 'function') {
      deleteCommentAction(commentId);
    } else if (typeof deleteComment === 'function') {
      deleteComment(commentId);
    }
    return;
  }

  // 3. Delete Post Button
  const deletePostBtn = e.target.closest('.delete-post-btn');
  if (deletePostBtn) {
    e.preventDefault();
    if (typeof deletePost === 'function') deletePost(deletePostBtn.dataset.postId);
    return;
  }

  // 4. Edit Post Button
  const editPostBtn = e.target.closest('.edit-btn');
  if (editPostBtn) {
    e.preventDefault();
    if (typeof editPost === 'function') {
      editPost(editPostBtn.dataset.id, editPostBtn.dataset.title, editPostBtn.dataset.content);
    }
    return;
  }

  // 5. Delete Image Button
  const deleteImageBtn = e.target.closest('.delete-btn');
  if (deleteImageBtn) {
    e.preventDefault();
    if (typeof deleteImage === 'function') deleteImage(deleteImageBtn.dataset.imageId);
    return;
  }

  // 6. Add Post Button
  if (e.target.closest('#btnAddPost')) {
    e.preventDefault();
    if (typeof addPostModal === 'function') addPostModal();
    return;
  }
});

// A quick helper to create the drag-and-drop event binds inside SweetAlert
function initializeDropzone(zoneId, inputId) {
  const dropzone = document.getElementById(zoneId);
  const fileInput = document.getElementById(inputId);

  if (!dropzone || !fileInput) return;

  // Highlight drop area when dragging file over it
  ['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.add('drag-active');
    }, false);
  });

  // Remove highlight when dragging leaves or drops
  ['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.remove('drag-active');
    }, false);
  });

  // Handle files dropped directly onto the target element
  dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    fileInput.files = dt.files; // Assign dropped files straight to hidden native selector
    updateDropzoneLabel(dropzone, dt.files);
  }, false);

  // Still allow clicking the box to trigger standard system file selectors
  dropzone.addEventListener('click', () => fileInput.click());

  // Update visual text if files are chosen via standard manual picker click instead
  fileInput.addEventListener('change', () => {
    updateDropzoneLabel(dropzone, fileInput.files);
  });
}

function updateDropzoneLabel(zoneElement, filesList) {
  if (filesList.length > 0) {
    zoneElement.innerHTML = `<strong>Selected ${filesList.length} file(s)</strong><br><span style="font-size:12px;color:#666;">Click or drag to replace</span>`;
  } else {
    zoneElement.innerHTML = `Drag & Drop your images here or <strong>Browse</strong>`;
  }
}

// A quick helper to create the drag-and-drop event binds inside SweetAlert
function initializeDropzone(zoneId, inputId) {
  const dropzone = document.getElementById(zoneId);
  const fileInput = document.getElementById(inputId);

  if (!dropzone || !fileInput) return;

  // Highlight drop area when dragging file over it
  ['dragenter', 'dragover'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.add('drag-active');
    }, false);
  });

  // Remove highlight when dragging leaves or drops
  ['dragleave', 'drop'].forEach(eventName => {
    dropzone.addEventListener(eventName, (e) => {
      e.preventDefault();
      dropzone.classList.remove('drag-active');
    }, false);
  });

  // Handle files dropped directly onto the target element
  dropzone.addEventListener('drop', (e) => {
    const dt = e.dataTransfer;
    fileInput.files = dt.files; // Assign dropped files straight to hidden native selector
    updateDropzoneLabel(dropzone, dt.files);
  }, false);

  // Still allow clicking the box to trigger standard system file selectors
  dropzone.addEventListener('click', () => fileInput.click());

  // Update visual text if files are chosen via standard manual picker click instead
  fileInput.addEventListener('change', () => {
    updateDropzoneLabel(dropzone, fileInput.files);
  });
}

function updateDropzoneLabel(zoneElement, filesList) {
  if (filesList.length > 0) {
    zoneElement.innerHTML = `<strong>Selected ${filesList.length} file(s)</strong><br><span style="font-size:12px;color:#666;">Click or drag to replace</span>`;
  } else {
    zoneElement.innerHTML = `Drag & Drop your images here or <strong>Browse</strong>`;
  }
}

// -------------------- ADD POST --------------------
function addPostModal() {
  Swal.fire({
    title: 'Create New Post',
    html: `
      <input id="swal-title" class="swal-input" placeholder="Title" required>
      <div id="quill-editor" class="editor"></div>
      
      <!-- New Modern Visual Drag Target Wrapper Container Box -->
      <div id="swal-dropzone" class="custom-dropzone">
         Drag & Drop your images here or <strong>Browse</strong>
      </div>
      <!-- Hidden file element kept underneath to pass raw array data -->
      <input id="swal-image" type="file" style="display:none;" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
    `,
    didOpen: () => {
      window.quill = new Quill('#quill-editor', { theme: 'snow' });
      initializeDropzone('swal-dropzone', 'swal-image'); // Instantly binds drop listeners inside DOM
    },
    showCancelButton: true,
    confirmButtonText: 'Publish',
    preConfirm: () => {
      const title = document.getElementById('swal-title').value.trim();
      const content = window.quill.root.innerHTML.trim();
      
      if (!title || !content || content === '<p><br></p>') {
        Swal.showValidationMessage('Title and content are required');
        return false;
      }
      
      const fd = new FormData();
      fd.append('title', title);
      fd.append('content', content);
      
      const files = document.getElementById('swal-image').files;
      const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      const maxSizeBytes = 10 * 1024 * 1024; // 10MB
      
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const extension = file.name.split('.').pop().toLowerCase();
        
        if (file.size > maxSizeBytes) {
          Swal.showValidationMessage(`"${file.name}" is too heavy! Max allowed size is 10MB.`);
          return false;
        }
        if (!allowedExtensions.includes(extension)) {
          Swal.showValidationMessage(`"${file.name}" is invalid. Only JPG, PNG, GIF, and WebP are allowed.`);
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
        .catch(() => Swal.showValidationMessage('Request failed. Check server error logs.'));
    }
  }).then(result => {
    if (result.value && result.value.status === 'OK') {
      Swal.fire('Success', 'Post added successfully!', 'success');
      if (typeof loadPosts === 'function') loadPosts();
    } else if (result.value) {
      Swal.fire('Error', result.value.message || 'Insert failed', 'error');
    }
  });
}

// -------------------- EDIT POST --------------------
function editPost(id, title, content) {
  Swal.fire({
    title: 'Edit Post',
    // 1. Give Swal an empty structural wrapper container
    html: `<div id="swal-custom-container" style="display: flex; flex-direction: column; gap: 15px; text-align: left;"></div>`,
    showCancelButton: true,
    confirmButtonText: 'Update',
    
    // 2. Build the children components programmatically via DOM methods
    didOpen: () => {
      const container = document.getElementById('swal-custom-container');
      if (!container) return;

      // Create Title Input
      const titleInput = document.createElement('input');
      titleInput.id = 'swal-title';
      titleInput.className = 'swal-input';
      titleInput.value = title;
      titleInput.required = true;
      titleInput.style.width = '100%';
      titleInput.style.boxSizing = 'border-box';
      container.appendChild(titleInput);

      // Create Editor Parent Box
      const editorWrapper = document.createElement('div');
      editorWrapper.style.width = '100%';
      editorWrapper.style.boxSizing = 'border-box';
      
      const editorDiv = document.createElement('div');
      editorDiv.id = 'quill-editor';
      editorDiv.className = 'editor';
      editorDiv.style.height = '150px';
      editorDiv.style.background = '#1e1e1e';
      
      editorWrapper.appendChild(editorDiv);
      container.appendChild(editorWrapper);

      // Create Custom Dropzone Wrapper Frame
      const dropzoneDiv = document.createElement('div');
      dropzoneDiv.id = 'swal-dropzone-edit';
      dropzoneDiv.className = 'custom-dropzone';
      dropzoneDiv.style.cssText = "border: 2px dashed #444; padding: 20px; text-align: center; cursor: pointer; border-radius: 6px; background: #1a1a1a; color: #aaaaaa;";
      dropzoneDiv.innerHTML = `Drag & Drop new images here or <strong>Browse</strong>`;
      container.appendChild(dropzoneDiv);

      // Create Hidden File Input Element
      const fileInput = document.createElement('input');
      fileInput.type = 'file';
      fileInput.id = 'swal-image-edit';
      fileInput.style.cssText = "display: none !important;";
      fileInput.accept = ".jpg,.jpeg,.png,.gif,.webp";
      fileInput.multiple = true;
      container.appendChild(fileInput);

      // 3. Initialize plugins AFTER elements are physically appended to the active DOM
      initializeDropzone('swal-dropzone-edit', 'swal-image-edit');

      window.quill = new Quill('#quill-editor', { theme: 'snow' });
      let normalizedContent = content;
      if (normalizedContent === '<p><br></p>' || normalizedContent === '<p></p>') {
        normalizedContent = '';
      }
      window.quill.root.innerHTML = normalizedContent;
    },

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
        .then(res => res.json())
        .catch(() => false);
    }
  }).then(result => {
    if (result.value && result.value.status === 'OK') {
      Swal.fire('Updated!', 'Post updated successfully!', 'success').then(() => {
        if (typeof loadPosts === 'function') loadPosts(id);
        else window.location.reload();
      });
    }
  });
}

// -------------------- DELETE POST --------------------
function deletePost(id) {
  Swal.fire({
    title: 'Delete Post?',
    text: 'This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, delete it!'
  }).then(result => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('post_id', id);
      fetch('ajax_delete_post.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.status === 'OK') {
            Swal.fire('Deleted!', 'Post has been deleted.', 'success');
            loadPosts();
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        });
     }
  });
}

// -------------------- DELETE IMAGE --------------------
function deleteImage(id) {
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
            Swal.fire('Deleted!', 'Image has been deleted.', 'success');
            loadPosts();
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        });
    }
  });
}

// ============================================
// COMMENT SECTION (Insulated Event Delegation)
// ============================================

document.addEventListener('submit', (e) => {
  const form = e.target.closest('.add-comment-form');
  if (!form) return;
  e.preventDefault();
  const submitBtn = form.querySelector('.add-comment-btn');
  const postId = submitBtn ? submitBtn.getAttribute('data-post-id') : null;
  const textarea = form.querySelector('textarea[name="comment"]');
  const text = textarea ? textarea.value.trim() : '';
  if (!postId) {
    Swal.fire('Error', 'Target post identifier missing', 'error');
    return;
  }
  if (!text) {
    Swal.fire('Error', 'Comment cannot be empty', 'error');
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
        if (typeof loadPosts === "function") loadPosts();
      } else {
        Swal.fire('Error', data.message, 'error');
      }
    })
    .catch(err => console.error("Error:", err));
});

// -------------------- EDIT COMMENT --------------------
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
            Swal.fire('Notice', 'No changes were made.', 'info');
          } else {
            Swal.fire('Error', data.message, 'error');
          }
        })
        .catch(err => {
          Swal.fire('Error', 'Invalid JSON response', 'error');
          console.error(err);
        });
    }
  });
}

// -------------------- DELETE COMMENT --------------------
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
        });
    }
  });
}

// -------------------- SEARCH HANDLER --------------------
document.addEventListener('DOMContentLoaded', function() {
  const searchForm = document.getElementById('search_form');
  if (searchForm) {
    searchForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const q = searchForm.q.value;

      fetch('ajax_search_post.php?q=' + encodeURIComponent(q))
        .then(res => res.json())
        .then(data => {
          const resultsDiv = document.getElementById('searchResults');
          resultsDiv.innerHTML = 'SEARCH RESULTS';	
          if (data.status === 'OK' && data.results.length > 0) {
            let ul = document.createElement('ul');
            data.results.forEach(r => {
              let li = document.createElement('li');
              li.innerHTML = `
                <a href="blog_details.php?id=${r.id}">
                  ${r.title}
                </a><br>
                <small>
                  <i class="fa fa-user"></i> ${r.fullname}
                  &nbsp;|&nbsp; <i class="fa fa-calendar"></i> ${r.created_at}
                </small>
              `;
              ul.appendChild(li);
            });
            resultsDiv.appendChild(ul);
          } else {
            resultsDiv.innerHTML = '<p>No results found.</p>';
          }
        });
    });
  }
});

