<?php
require("connect.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}

if ($_SESSION["access"] !== "Admin") {
    echo "<script>alert('Access Denied'); window.location.href='index.php';</script>";
    exit;
}

require("header.php");
require("menunav.php");
?>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Manage Knowledge Base</h1>
        <span>Admin area for Wiki Categories and Articles</span>
      </div>
    </div>
  </div>
</div>

<!-- Quill Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

<div class="services" style="padding-top: 50px;">
  <div class="container">
    
    <div class="row">
      <div class="col-md-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 style="color:#fff; margin:0;">Categories</h4>
            <button class="btn btn-sm btn-primary filled-button" onclick="showCategoryForm()">+ New Category</button>
        </div>
        <div class="list-group" id="adminCategoryList">
            <div class="text-center py-3"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>
      
      <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 id="adminArticleTitle" style="color:#fff; margin:0;">All Articles</h4>
            <button class="btn btn-sm btn-primary filled-button" onclick="showArticleForm()">+ New Article</button>
        </div>
        
        <div id="adminArticleList">
             <div class="text-center py-3"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>

    </div>

  </div>
</div>

<!-- Modal for Category -->
<div class="modal fade" id="categoryModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" style="background:var(--bg-card); border: 1px solid var(--border-glass);">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#fff;" id="catModalTitle">New Category</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm">
            <input type="hidden" name="action" id="catAction" value="create_category">
            <input type="hidden" name="id" id="catId">
            <div class="mb-3">
                <label style="color:#ccc;">Title</label>
                <input type="text" class="form-control text-white bg-dark border-secondary" name="title" id="catTitle" required placeholder="e.g. Getting Started">
            </div>
            <div class="mb-3">
                <label style="color:#ccc;">Description</label>
                <textarea class="form-control text-white bg-dark border-secondary" name="description" id="catDesc" rows="3" placeholder="Short description of this category..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary filled-button w-100">Save Category</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Article -->
<div class="modal fade" id="articleModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" style="background:var(--bg-card); border: 1px solid var(--border-glass);">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#fff;" id="artModalTitle">New Article</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="articleForm">
            <input type="hidden" name="action" id="artAction" value="create_article">
            <input type="hidden" name="id" id="artId">
            <input type="hidden" name="content" id="artContent">
            <div class="row mb-3">
                <div class="col-md-5">
                    <label style="color:#ccc;">Category</label>
                    <select class="form-control text-white bg-dark border-secondary" name="category_id" id="artCategory" required></select>
                </div>
                <div class="col-md-7">
                    <label style="color:#ccc;">Title</label>
                    <input type="text" class="form-control text-white bg-dark border-secondary" name="title" id="artTitle" required placeholder="Article title...">
                </div>
            </div>
            <div class="mb-3">
                <label style="color:#ccc;">Content</label>
                <div id="quillEditor" style="background:#fff; min-height: 300px; border-radius: 4px;"></div>
            </div>
            <button type="submit" class="btn btn-primary filled-button w-100">Save Article</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>
<script>
let categoriesData = [];
let quill;

$(document).ready(function() {
    // Initialize Quill editor
    quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Write your article content here...',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        }
    });

    loadAdminCategories();
    loadAdminArticles();

    $("#categoryForm").submit(function(e) {
        e.preventDefault();
        $.post("ajax_docs.php", $(this).serialize(), function(res) {
            if(res.status == 'success') {
                $("#categoryModal").modal('hide');
                loadAdminCategories();
                loadAdminArticles();
            } else {
                alert(res.message);
            }
        }, 'json').fail(function() {
            alert('Request failed. Please try again.');
        });
    });

    $("#articleForm").submit(function(e) {
        e.preventDefault();
        // Push Quill content into the hidden field
        $("#artContent").val(quill.root.innerHTML);
        $.post("ajax_docs.php", $(this).serialize(), function(res) {
            if(res.status == 'success') {
                $("#articleModal").modal('hide');
                loadAdminArticles();
            } else {
                alert(res.message);
            }
        }, 'json').fail(function() {
            alert('Request failed. Please try again.');
        });
    });
});

function loadAdminCategories() {
    $.get("ajax_docs.php?action=fetch_categories", function(response) {
        if(response.status === 'success') {
            categoriesData = response.data;
            let html = '';
            let optHtml = '<option value="">-- Select Category --</option>';
            if (response.data.length === 0) {
                html = '<div class="text-center py-3 text-muted">No categories yet.</div>';
            }
            response.data.forEach(cat => {
                html += `
                <div class="list-group-item d-flex justify-content-between align-items-center" style="background:var(--bg-card); color:#fff; border-color:var(--border-glass);">
                    <div>
                        <strong>${cat.title}</strong>
                        ${cat.description ? `<br><small class="text-muted">${cat.description}</small>` : ''}
                    </div>
                    <div>
                        <button class="btn btn-sm btn-outline-light mr-1" onclick="editCategory(${cat.id}, '${cat.title.replace(/'/g, "\\'")}', '${(cat.description||'').replace(/'/g, "\\'")}')"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteCategory(${cat.id})"><i class="fa fa-trash"></i></button>
                    </div>
                </div>`;
                optHtml += `<option value="${cat.id}">${cat.title}</option>`;
            });
            $("#adminCategoryList").html(html);
            $("#artCategory").html(optHtml);
        }
    }, 'json');
}

function loadAdminArticles(categoryId) {
    categoryId = categoryId || 0;
    $.get("ajax_docs.php?action=fetch_articles&category_id=" + categoryId, function(response) {
        if(response.status === 'success') {
            if (response.data.length === 0) {
                $("#adminArticleList").html('<div class="alert alert-secondary">No articles found.</div>');
                return;
            }
            let html = '<table class="table table-dark table-striped"><thead><tr><th>Title</th><th>Category</th><th>Updated</th><th>Action</th></tr></thead><tbody>';
            response.data.forEach(art => {
                let catName = categoriesData.find(c => c.id == art.category_id);
                let catLabel = catName ? catName.title : '—';
                html += `
                <tr>
                    <td>${art.title}</td>
                    <td><span class="badge badge-secondary">${catLabel}</span></td>
                    <td style="font-size:12px;">${art.updated_at || art.created_at}</td>
                    <td>
                        <button class="btn btn-sm btn-info mr-1" onclick="editArticle('${art.slug}')"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteArticle(${art.id})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            $("#adminArticleList").html(html);
        }
    }, 'json');
}

function showCategoryForm() {
    $("#categoryForm")[0].reset();
    $("#catAction").val("create_category");
    $("#catId").val("");
    $("#catModalTitle").text("New Category");
    $("#categoryModal").modal('show');
}

function editCategory(id, title, description) {
    $("#catAction").val("update_category");
    $("#catId").val(id);
    $("#catTitle").val(title);
    $("#catDesc").val(description);
    $("#catModalTitle").text("Edit Category");
    $("#categoryModal").modal('show');
}

function deleteCategory(id) {
    if(confirm("Are you sure you want to delete this category? Articles must be moved first.")) {
        $.post("ajax_docs.php", {action: 'delete_category', id: id}, function(res) {
            if(res.status == 'success') loadAdminCategories();
            else alert(res.message);
        }, 'json');
    }
}

function showArticleForm() {
    $("#articleForm")[0].reset();
    quill.setContents([]);
    $("#artAction").val("create_article");
    $("#artId").val("");
    $("#artModalTitle").text("New Article");
    $("#articleModal").modal('show');
}

function editArticle(slug) {
    $.get("ajax_docs.php?action=fetch_article&slug=" + slug, function(res) {
        if(res.status == 'success') {
            $("#artAction").val("update_article");
            $("#artId").val(res.data.id);
            $("#artCategory").val(res.data.category_id);
            $("#artTitle").val(res.data.title);
            quill.root.innerHTML = res.data.content || '';
            $("#artModalTitle").text("Edit Article");
            $("#articleModal").modal('show');
        }
    }, 'json');
}

function deleteArticle(id) {
    if(confirm("Are you sure you want to delete this article?")) {
        $.post("ajax_docs.php", {action: 'delete_article', id: id}, function(res) {
            if(res.status == 'success') loadAdminArticles();
            else alert(res.message);
        }, 'json');
    }
}
</script>
