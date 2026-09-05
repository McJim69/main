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

<div class="services" style="padding-top: 50px;">
  <div class="container">
    
    <div class="row">
      <div class="col-md-4">
        <h4>Categories</h4>
        <button class="btn btn-sm btn-primary mb-3" onclick="showCategoryForm()">+ New Category</button>
        <div class="list-group" id="adminCategoryList">
            <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>
      
      <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 id="adminArticleTitle">All Articles</h4>
            <button class="btn btn-sm btn-primary" onclick="showArticleForm()">+ New Article</button>
        </div>
        
        <div id="adminArticleList">
             <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
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
        <h5 class="modal-title" style="color:#fff;">Manage Category</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm">
            <input type="hidden" name="action" id="catAction" value="create_category">
            <input type="hidden" name="id" id="catId">
            <div class="mb-3">
                <label>Title</label>
                <input type="text" class="form-control" name="title" id="catTitle" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea class="form-control" name="description" id="catDesc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary filled-button w-100">Save Category</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Article -->
<div class="modal fade" id="articleModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="background:var(--bg-card); border: 1px solid var(--border-glass);">
      <div class="modal-header">
        <h5 class="modal-title" style="color:#fff;">Manage Article</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="articleForm">
            <input type="hidden" name="action" id="artAction" value="create_article">
            <input type="hidden" name="id" id="artId">
            <div class="mb-3">
                <label>Category</label>
                <select class="form-control" name="category_id" id="artCategory" required></select>
            </div>
            <div class="mb-3">
                <label>Title</label>
                <input type="text" class="form-control" name="title" id="artTitle" required>
            </div>
            <div class="mb-3">
                <label>Content (HTML supported)</label>
                <textarea class="form-control" name="content" id="artContent" rows="15" required></textarea>
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

$(document).ready(function() {
    loadAdminCategories();
    loadAdminArticles();

    $("#categoryForm").submit(function(e) {
        e.preventDefault();
        $.post("ajax_docs.php", $(this).serialize(), function(res) {
            if(res.status == 'success') {
                $("#categoryModal").modal('hide');
                loadAdminCategories();
            } else {
                alert(res.message);
            }
        });
    });

    $("#articleForm").submit(function(e) {
        e.preventDefault();
        $.post("ajax_docs.php", $(this).serialize(), function(res) {
            if(res.status == 'success') {
                $("#articleModal").modal('hide');
                loadAdminArticles();
            } else {
                alert(res.message);
            }
        });
    });
});

function loadAdminCategories() {
    $.get("ajax_docs.php?action=fetch_categories", function(response) {
        if(response.status === 'success') {
            categoriesData = response.data;
            let html = '';
            let optHtml = '<option value="">-- Select Category --</option>';
            response.data.forEach(cat => {
                html += `
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>${cat.title}</span>
                    <button class="btn btn-sm btn-danger" onclick="deleteCategory(${cat.id})"><i class="fa fa-trash"></i></button>
                </div>`;
                optHtml += `<option value="${cat.id}">${cat.title}</option>`;
            });
            $("#adminCategoryList").html(html);
            $("#artCategory").html(optHtml);
        }
    });
}

function loadAdminArticles() {
    $.get("ajax_docs.php?action=fetch_articles", function(response) {
        if(response.status === 'success') {
            let html = '<table class="table table-dark table-striped"><thead><tr><th>Title</th><th>Updated</th><th>Action</th></tr></thead><tbody>';
            response.data.forEach(art => {
                html += `
                <tr>
                    <td>${art.title}</td>
                    <td>${art.updated_at}</td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="editArticle('${art.slug}')"><i class="fa fa-pencil"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteArticle(${art.id})"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>`;
            });
            html += '</tbody></table>';
            $("#adminArticleList").html(html);
        }
    });
}

function showCategoryForm() {
    $("#categoryForm")[0].reset();
    $("#catAction").val("create_category");
    $("#categoryModal").modal('show');
}

function deleteCategory(id) {
    if(confirm("Are you sure you want to delete this category?")) {
        $.post("ajax_docs.php", {action: 'delete_category', id: id}, function(res) {
            if(res.status == 'success') loadAdminCategories();
            else alert(res.message);
        });
    }
}

function showArticleForm() {
    $("#articleForm")[0].reset();
    $("#artAction").val("create_article");
    $("#articleModal").modal('show');
}

function editArticle(slug) {
    $.get("ajax_docs.php?action=fetch_article&slug=" + slug, function(res) {
        if(res.status == 'success') {
            $("#artAction").val("update_article");
            $("#artId").val(res.data.id);
            $("#artCategory").val(res.data.category_id);
            $("#artTitle").val(res.data.title);
            $("#artContent").val(res.data.content);
            $("#articleModal").modal('show');
        }
    });
}

function deleteArticle(id) {
    if(confirm("Are you sure you want to delete this article?")) {
        $.post("ajax_docs.php", {action: 'delete_article', id: id}, function(res) {
            if(res.status == 'success') loadAdminArticles();
            else alert(res.message);
        });
    }
}
</script>

