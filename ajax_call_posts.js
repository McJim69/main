// =========================================================================
// BLOG MANAGER CLASS (Object-Oriented Architecture)
// =========================================================================
class BlogManager {
  /**
   * Resolve active Post ID from URL parameters or active DOM elements
   */
  static getActivePostId() {
    // 1. URL search params: ?id=51 or ?post_id=51 or ?posted_id=51
    const urlParams = new URLSearchParams(window.location.search);
    for (const key of ['id', 'post_id', 'posted_id']) {
      const val = urlParams.get(key);
      if (val && val !== '0' && val !== 0 && !isNaN(val)) {
        return val;
      }
    }

    // 2. Element dataset check: .blog[data-post-id]
    const detailsSec = document.querySelector('.blog');
    if (detailsSec && detailsSec.dataset.postId && detailsSec.dataset.postId !== '0') {
      return detailsSec.dataset.postId;
    }

    // 3. Any element with data-post-id (e.g. buttons, comment form)
    const elWithPostId = document.querySelector('[data-post-id]');
    if (elWithPostId && elWithPostId.dataset.postId && elWithPostId.dataset.postId !== '0') {
      return elWithPostId.dataset.postId;
    }

    // 4. Edit button data-id
    const editBtn = document.querySelector('.edit-btn[data-id]');
    if (editBtn && editBtn.dataset.id && editBtn.dataset.id !== '0') {
      return editBtn.dataset.id;
    }

    return null;
  }

  /**
   * Intelligently refresh post details page, targeted post card, or main list feed
   */
  static loadPosts(postId) {
    const detailsContainer = document.querySelector('.blog');
    const isDetailsPage = !!detailsContainer;
    let id = (postId && postId !== 0 && postId !== '0') ? String(postId) : BlogManager.getActivePostId();
    const timestamp = Date.now();

    // Mode 1: Details View Page (blog_details.php?id=XX)
    if (isDetailsPage) {
      if (!id || id === '0') {
        console.warn("[BlogManager] Cannot resolve Post ID on details page. Performing fallback reload.");
        window.location.reload();
        return Promise.resolve();
      }

      console.log(`[BlogManager] Refreshing single post details page for ID: ${id}`);
      return fetch(`ajax_posts_details.php?id=${id}&_=${timestamp}`, { cache: 'no-store' })
        .then(res => {
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          return res.text();
        })
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newDetails = doc.querySelector('.blog');
          const currentDetails = document.querySelector('.blog');

          if (newDetails && currentDetails) {
            currentDetails.outerHTML = newDetails.outerHTML;
          } else if (currentDetails) {
            currentDetails.innerHTML = html;
          }
          BlogManager.reinitVenobox();
        })
        .catch(err => {
          console.error("[BlogManager] loadPosts error on details page:", err);
          window.location.reload();
        });
    }

    // Mode 2: Main Feed List Page (blog.php)
    return BlogManager.refreshFullFeed();
  }

  /**
   * Helper to refresh the full feed container on blog.php
   */
  static refreshFullFeed() {
    const timestamp = Date.now();
    console.log("[BlogManager] Refreshing entire blog feed list");
    return fetch(`ajax_posts.php?_=${timestamp}`, { cache: 'no-store' })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.text();
      })
      .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newBlog = doc.querySelector('.blog:not(.blog)') || doc.querySelector('.blog');
        const currentBlog = document.querySelector('.blog:not(.blog)') || document.querySelector('.blog');

        if (newBlog && currentBlog) {
          currentBlog.outerHTML = newBlog.outerHTML;
        } else if (currentBlog) {
          currentBlog.innerHTML = html;
        }
        BlogManager.reinitVenobox();
      })
      .catch(err => {
        console.error("[BlogManager] refreshFullFeed error:", err);
      });
  }

  /**
   * Safely re-initialize Venobox lightbox plugin
   */
  static reinitVenobox() {
    try {
      if (typeof $ !== 'undefined' && typeof $.fn.venobox === 'function') {
        $('.venobox').venobox({
          framewidth: 'auto',
          border: '6px',
          bgcolor: '#000',
          spinner: 'cube-grid',
          spinColor: '#fff',
          closeBackground: '#000',
          closeColor: '#fff'
        });
      }
    } catch (vErr) {
      console.warn("Venobox re-init notice:", vErr);
    }
  }

  /**
   * Initialize Drag and Drop dropzone listeners for modal uploads
   */
  static initializeDropzone(zoneId, inputId) {
    const dropzone = document.getElementById(zoneId);
    const fileInput = document.getElementById(inputId);
    if (!dropzone || !fileInput) return;

    ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropzone.classList.add('drag-active');
      }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropzone.classList.remove('drag-active');
      }, false);
    });

    dropzone.addEventListener('drop', (e) => {
      const dt = e.dataTransfer;
      fileInput.files = dt.files;
      BlogManager.updateDropzoneLabel(dropzone, dt.files);
    }, false);

    dropzone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', () => {
      BlogManager.updateDropzoneLabel(dropzone, fileInput.files);
    });
  }

  /**
   * Update visual label text inside the dropzone
   */
  static updateDropzoneLabel(zoneElement, filesList) {
    if (filesList.length > 0) {
      zoneElement.innerHTML = `<strong>Selected ${filesList.length} file(s)</strong><br><span style="font-size:12px;color:#aaa;">Click or drag to replace</span>`;
    } else {
      zoneElement.innerHTML = `Drag & Drop your images here or <strong>Browse</strong>`;
    }
  }

  /**
   * Open modal for creating a new post
   */
  static addPostModal() {
    Swal.fire({
      title: 'Create New Post',
      html: `
        <input id="swal-title" class="swal-input" placeholder="Title" required style="width:100%; margin-bottom:15px; padding:8px;">
        <div id="quill-editor-wrapper" style="width:100%; margin-bottom:15px;">
          <div id="quill-editor" class="editor" style="height:180px;"></div>
        </div>
        <div id="swal-dropzone-add" class="custom-dropzone">
           Drag & Drop your images here or <strong>Browse</strong>
        </div>
        <input id="swal-image" type="file" style="display:none;" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
      `,
      didOpen: () => {
        BlogManager.initializeDropzone('swal-dropzone-add', 'swal-image');
        const container = document.getElementById('quill-editor');
        if (container) {
          if (window.quill) {
            container.classList.remove('ql-container', 'ql-snow');
            container.innerHTML = '';
            document.querySelectorAll('.ql-toolbar').forEach(tb => tb.remove());
            window.quill = null;
          }
          window.quill = new Quill('#quill-editor', { theme: 'snow' });
        }
      },
      showCancelButton: true,
      confirmButtonText: 'Publish',
      preConfirm: () => {
        const title = document.getElementById('swal-title').value.trim();
        const content = window.quill ? window.quill.root.innerHTML.trim() : '';
        const plainText = window.quill ? window.quill.getText().trim() : '';
        
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
            Swal.showValidationMessage(`"${file.name}" exceeds max allowed size of 10MB.`);
            return false;
          }
          if (!allowedExtensions.includes(extension)) {
            Swal.showValidationMessage(`"${file.name}" format is invalid.`);
            return false;
          }
          fd.append('images[]', file);
        }
        
        Swal.showLoading();
        
        return fetch('ajax_add_post.php', { method: 'POST', body: fd })
          .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
          })
          .catch(() => {
            Swal.showValidationMessage('Request failed. Check network or server status.');
            return false;
          });
      }
    }).then(result => {
      if (result.value && result.value.status === 'OK') {
        const newId = result.value.id || result.value.post_id || result.value.posted_id;
        Swal.fire('Success', 'Post added successfully!', 'success').then(() => {
          if (newId) {
            window.location.href = 'blog_details.php?id=' + newId;
          } else {
            window.location.href = 'blog.php';
          }
        });
      } else if (result.value) {
        Swal.fire('Error', result.value.message || 'Insert failed', 'error');
      }
    });
  }

  /**
   * Open modal for editing an existing post
   */
  static editPost(id, title, content) {
    Swal.fire({
      title: 'Edit Post',
      html: `
        <input id="swal-title" class="swal-input" value="${(title || '').replace(/"/g, '&quot;')}" required style="width:100%; margin-bottom:15px; padding:8px;">
        <div style="width:100%; margin-bottom:15px;">
          <div id="quill-editor" class="editor" style="height:180px;"></div>
        </div>
        <div id="swal-dropzone-edit" class="custom-dropzone">
           Drag & Drop new images here or <strong>Browse</strong>
        </div>
        <input id="swal-image-edit" type="file" style="display:none;" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
      `,
      didOpen: () => {
        BlogManager.initializeDropzone('swal-dropzone-edit', 'swal-image-edit');
        const container = document.getElementById('quill-editor');
        if (container) {
          if (window.quill) {
            container.classList.remove('ql-container', 'ql-snow');
            container.innerHTML = '';
            document.querySelectorAll('.ql-toolbar').forEach(tb => tb.remove());
            window.quill = null;
          }
          window.quill = new Quill('#quill-editor', { theme: 'snow' });
          let normalizedContent = content || '';
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
        const newContent = window.quill ? window.quill.root.innerHTML.trim() : '';
        const plainText = window.quill ? window.quill.getText().trim() : '';

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
            Swal.showValidationMessage(`"${file.name}" exceeds max size of 10MB.`);
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
            if (!res.ok) throw new Error('Network response error');
            return res.json();
          })
          .then(data => {
            if (data.status === 'OK') {
              // IMMEDIATELY TRIGGER INSTANT RELOAD WHEN STATUS IS OK
              BlogManager.loadPosts(id);
              return data;
            } else {
              Swal.showValidationMessage(data.message || 'Update failed');
              return false;
            }
          })
          .catch(() => {
            Swal.showValidationMessage('Request failed. Check network connection.');
            return false;
          });
      }
    }).then(result => {
      if (result.value && result.value.status === 'OK') {
        BlogManager.loadPosts(id);
        Swal.fire('Updated!', 'Post updated successfully!', 'success').then(() => {
          BlogManager.loadPosts(post_id);
        });
      } else if (result.value) {
        Swal.fire('Error', result.value.message || 'Update failed', 'error');
      }
    });
  }

  /**
   * Delete a post
   */
  static deletePost(id) {
    if (!id) return;
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
              if (document.querySelector('.blog')) {
                Swal.fire('Deleted!', 'Post has been deleted.', 'success').then(() => {
                  window.location.href = 'blog.php';
                });
              } else {
                // Instantly remove target card node on OK status
                const cardSelector = `.blog-card[data-post-id="${id}"], .blog-card [data-post-id="${id}"], .blog-card [data-id="${id}"], .blog-card a[href*="id=${id}"]`;
                const targetCardEl = document.querySelector(cardSelector);
                const targetCard = targetCardEl ? targetCardEl.closest('.blog-card') : null;
                if (targetCard) {
                  targetCard.remove();
                }
                BlogManager.loadPosts();
                Swal.fire('Deleted!', 'Post has been deleted.', 'success').then(() => {
                  BlogManager.loadPosts();
                });
              }
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          })
          .catch(err => Swal.fire('Error', 'Failed to delete post.', 'error'));
      }
    });
  }

  /**
   * Delete an image asset
   */
  static deleteImage(id) {
    if (!id) {
      Swal.fire('Error', 'Image ID is missing.', 'error');
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
              // IMMEDIATELY TRIGGER INSTANT RELOAD WHEN STATUS IS OK
              BlogManager.loadPosts();
              Swal.fire('Deleted!', 'Image has been removed.', 'success').then(() => {
                BlogManager.loadPosts();
              });
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          })
          .catch(err => console.error("Delete image error:", err));
      }
    });
  }

  /**
   * Submit a new comment
   */
  static submitComment(form) {
    const submitBtn = form.querySelector('.add-comment-btn');
    const postId = (submitBtn && submitBtn.getAttribute('data-post-id')) ? submitBtn.getAttribute('data-post-id') : BlogManager.getActivePostId();
    const textarea = form.querySelector('textarea[name="comment"]');
    const text = textarea ? textarea.value.trim() : '';

    if (!postId) {
      Swal.fire('Error', 'Target post ID missing.', 'error');
      return;
    }
    if (!text) {
      Swal.fire('Error', 'Comment cannot be empty.', 'error');
      return;
    }

    const formData = new FormData();
    formData.append('post_id', postId);
    formData.append('comment', text);

    fetch('ajax_add_comment.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'OK') {
          if (textarea) textarea.value = '';
          // IMMEDIATELY TRIGGER INSTANT RELOAD WHEN STATUS IS OK
          BlogManager.loadPosts(postId);
          Swal.fire('Success', 'Comment added!', 'success').then(() => {
            BlogManager.loadPosts(postId);
          });
        } else {
          Swal.fire('Error', data.message || 'Failed to add comment', 'error');
        }
      })
      .catch(err => console.error("Comment submission error:", err));
  }

  /**
   * Edit a comment
   */
  static editComment(commentId, oldText) {
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
              // IMMEDIATELY TRIGGER INSTANT RELOAD WHEN STATUS IS OK
              BlogManager.loadPosts();
              Swal.fire('Updated!', 'Comment updated!', 'success').then(() => {
                BlogManager.loadPosts();
              });
            } else if (data.status === 'NOCHANGE') {
              Swal.fire('Notice', 'No changes were detected.', 'info');
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          })
          .catch(err => console.error("Edit comment error:", err));
      }
    });
  }

  /**
   * Delete a comment
   */
  static deleteComment(commentId) {
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
              // IMMEDIATELY TRIGGER INSTANT RELOAD WHEN STATUS IS OK
              BlogManager.loadPosts();
              Swal.fire('Deleted!', 'Comment has been deleted.', 'success').then(() => {
                BlogManager.loadPosts();
              });
            } else {
              Swal.fire('Error', data.message, 'error');
            }
          })
          .catch(err => console.error("Delete comment error:", err));
      }
    });
  }

  /**
   * Bind event listeners for delegation and form submit handlers
   */
  static initEvents() {
    if (window._blogManagerEventsBound) return;
    window._blogManagerEventsBound = true;

    document.body.addEventListener('click', function(e) {
      const editCommentBtn = e.target.closest('.edit-comment-btn');
      if (editCommentBtn) {
        e.preventDefault();
        BlogManager.editComment(editCommentBtn.dataset.commentId, editCommentBtn.dataset.commentText);
        return;
      }

      const deleteCommentBtn = e.target.closest('.delete-comment-btn');
      if (deleteCommentBtn) {
        e.preventDefault();
        BlogManager.deleteComment(deleteCommentBtn.dataset.commentId);
        return;
      }

      const deletePostBtn = e.target.closest('.delete-post-btn');
      if (deletePostBtn) {
        e.preventDefault();
        BlogManager.deletePost(deletePostBtn.dataset.postId);
        return;
      }

      const editPostBtn = e.target.closest('.edit-btn');
      if (editPostBtn) {
        e.preventDefault();
        const id = editPostBtn.dataset.id;
        let titleText = editPostBtn.dataset.title;
        let contentHtml = editPostBtn.dataset.content;

        if (!titleText) {
          titleText = document.querySelector('.blog-title h2, .blog-title h4')?.textContent.trim() || '';
        }
        if (!contentHtml) {
          const contentContainer = document.querySelector('.blog-content');
          if (contentContainer) {
            const clone = contentContainer.cloneNode(true);
            const controls = clone.querySelector('.blog-control');
            if (controls) controls.remove();
            contentHtml = clone.innerHTML.trim();
          }
        }
        if (id) BlogManager.editPost(id, titleText, contentHtml);
        return;
      }

      const deleteImageBtn = e.target.closest('.delete-btn');
      if (deleteImageBtn) {
        e.preventDefault();
        const imgId = deleteImageBtn.dataset.imageId || deleteImageBtn.getAttribute('data-image-id');
        BlogManager.deleteImage(imgId);
        return;
      }

      if (e.target.closest('#btnAddPost')) {
        e.preventDefault();
        BlogManager.addPostModal();
        return;
      }
    });

    document.addEventListener('submit', (e) => {
      const form = e.target.closest('.add-comment-form');
      if (form) {
        e.preventDefault();
        BlogManager.submitComment(form);
        return;
      }

      const searchForm = e.target.closest('#search_form');
      if (searchForm) {
        e.preventDefault();
        const q = searchForm.q ? searchForm.q.value : '';
        fetch('ajax_search_post.php?q=' + encodeURIComponent(q))
          .then(res => res.json())
          .then(data => {
            const resultsDiv = document.getElementById('searchResults');
            if (!resultsDiv) return;
            resultsDiv.innerHTML = '<h4>SEARCH RESULTS</h4>';
            if (data.status === 'OK' && data.results && data.results.length > 0) {
              let ul = document.createElement('ul');
              data.results.forEach(r => {
                let li = document.createElement('li');
                li.style.cssText = 'margin:10px auto;color:#bbb';
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
              resultsDiv.innerHTML += '<p>No results found.</p>';
            }
          });
      }
    });
  }
}

// Auto-initialize event listeners
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => BlogManager.initEvents());
} else {
  BlogManager.initEvents();
}

// Global function proxies for backward compatibility / inline event calls
function getActivePostId() { return BlogManager.getActivePostId(); }
function loadPost(postId) { return BlogManager.loadPosts(postId); }
function loadPosts(postId) { return BlogManager.loadPosts(postId); }
function addPostModal() { return BlogManager.addPostModal(); }
function editPost(id, title, content) { return BlogManager.editPost(id, title, content); }
function deletePost(id) { return BlogManager.deletePost(id); }
function deleteImage(id) { return BlogManager.deleteImage(id); }
function editComment(commentId, oldText) { return BlogManager.editComment(commentId, oldText); }
function deleteComment(commentId) { return BlogManager.deleteComment(commentId); }
