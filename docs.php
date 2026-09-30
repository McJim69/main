<?php
require("connect.php");
require("header.php");
require("menunav.php");

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
$isAdmin = (isset($_SESSION['access']) && $_SESSION['access'] === 'Admin');
?>

<script>setActive("docs");</script>

<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
<style>
  #viewContent { font-size: 15px; }
  #viewContent .ql-editor { padding: 0; }
  #viewContent h1, #viewContent h2, #viewContent h3 { color: #fff; margin-top: 20px; }
  #viewContent ul, #viewContent ol { padding-left: 20px; }
  #viewContent blockquote { border-left: 4px solid #5e5e5e; padding-left: 12px; color: #aaa; }
  #viewContent pre { background: #1a1a2e; border-radius: 6px; padding: 12px; color: #e0e0e0; }
  #viewContent a { color: #6ec6ff; }
  
  #categoryList .list-group-item {
      background-color: var(--bg-card, #1a1a2e);
      color: #e0e0e0;
      border-color: #2b2b40;
  }
  #categoryList .list-group-item:hover {
      background-color: #2a2a4e;
      color: #fff;
  }
  #categoryList .list-group-item.active {
      background-color: #007bff;
      color: #fff;
      border-color: #007bff;
  }
  .admin-btns { font-size: 12px; cursor: pointer; color: #aaa; margin-left: 10px; }
  .admin-btns:hover { color: #fff; }
</style>

<div class="page-heading header-text">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Knowledge Base</h1>
        <span>Find guides, documentation, and FAQs</span>
      </div>
    </div>
  </div>
</div>

<div class="services">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h4 style="color:#fff;">Categories</h4>
        <div class="list-group mb-3" id="categoryList">
            <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
        <?php if ($isAdmin): ?>
        <button class="btn btn-sm btn-primary w-100" onclick="showAddCategoryModal()"><i class="fa fa-plus"></i> Add Category</button>
        <?php endif; ?>
      </div>
      <div class="col-md-9">
        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="wikiSearchInput" class="form-control bg-dark text-white border-secondary" placeholder="Search articles..." oninput="filterArticles(this.value)">
                <div class="input-group-append">
                    <span class="input-group-text bg-dark border-secondary text-muted"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 id="articleListTitle" style="color:#fff; margin:0;">All Articles</h4>
            <?php if ($isAdmin): ?>
            <button class="btn btn-sm btn-success" id="addArticleBtn" onclick="showAddArticleModal()"><i class="fa fa-plus"></i> Add Article</button>
            <?php endif; ?>
        </div>
        
        <div id="articleList" class="row">
            <div class="col-12 text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
        
        <!-- Single Article View -->
        <div id="singleArticleView" style="display:none;">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <button class="btn btn-sm btn-secondary" onclick="showArticleList()"><i class="fa fa-arrow-left"></i> Back</button>
                <?php if ($isAdmin): ?>
                <div>
                    <button class="btn btn-sm btn-info" id="editArticleBtn" onclick="showEditArticleModal()"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-sm btn-danger" id="deleteArticleBtn" onclick="deleteArticle()"><i class="fa fa-trash"></i> Delete</button>
                </div>
                <?php endif; ?>
            </div>
            <h2 id="viewTitle" style="color:#fff;"></h2>
            <p class="text-muted" style="margin-bottom: 20px;"><i class="fa fa-folder-open"></i> <span id="viewCategory"></span> &nbsp; <i class="fa fa-clock-o"></i> <span id="viewDate"></span></p>
            <div id="viewContent" class="ql-editor" style="color:var(--text-main); line-height: 1.8; padding: 0;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>
<script>
const isAdmin = <?php echo $isAdmin ? 'true' : 'false'; ?>;
let allArticles = [];
let allCategories = [];
let currentCategoryId = 0;
let currentArticle = null;

$(document).ready(function() {
    loadCategories();
    loadArticles(0);
});

function loadCategories() {
    $.get("ajax_docs.php?action=fetch_categories", function(response) {
        if(response.status === 'success') {
            allCategories = response.data;
            let html = `<a href="javascript:void(0)" class="list-group-item list-group-item-action ${currentCategoryId == 0 ? 'active' : ''}" onclick="loadArticles(0, this)">All Categories</a>`;
            response.data.forEach(cat => {
                let adminHtml = isAdmin ? `<span class="float-right"><i class="fa fa-edit admin-btns" onclick="showEditCategoryModal(${cat.id}, '${cat.title.replace(/'/g, "\\'")}', '${(cat.description||'').replace(/'/g, "\\'")}', event)"></i> <i class="fa fa-trash admin-btns" onclick="deleteCategory(${cat.id}, event)"></i></span>` : '';
                html += `<a href="javascript:void(0)" class="list-group-item list-group-item-action ${currentCategoryId == cat.id ? 'active' : ''}" onclick="loadArticles(${cat.id}, this)">${cat.title} ${adminHtml}</a>`;
            });
            $("#categoryList").html(html);
        }
    });
}

function loadArticles(categoryId, element) {
    currentCategoryId = categoryId;
    if(element) {
        $("#categoryList .list-group-item").removeClass("active");
        $(element).addClass("active");
        // Remove admin buttons from text for title
        let clone = $(element).clone();
        clone.find('span').remove();
        $("#articleListTitle").text(clone.text().trim());
    } else {
        if(categoryId == 0) {
            $("#categoryList .list-group-item").removeClass("active");
            $("#categoryList .list-group-item:first").addClass("active");
            $("#articleListTitle").text("All Articles");
        }
    }
    
    $("#singleArticleView").hide();
    $("#articleListTitle").show();
    if(isAdmin) $("#addArticleBtn").show();
    $("#wikiSearchInput").val('');
    $("#articleList").show().html('<div class="col-12 text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    
    $.get("ajax_docs.php?action=fetch_articles&category_id=" + categoryId, function(response) {
        if(response.status === 'success') {
            allArticles = response.data;
            renderArticleCards(allArticles);
        }
    }, 'json');
}

function renderArticleCards(articles) {
    let html = '';
    if(articles.length === 0) {
        html = '<div class="col-12"><div class="alert alert-secondary">No articles found.</div></div>';
    } else {
        articles.forEach(art => {
            html += `
            <div class="col-md-6 mb-4">
                <div class="service-item" style="padding: 20px; background: var(--bg-card); border-radius: 10px; cursor:pointer; transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform=''" onclick="viewArticle('${art.slug}')">
                    <h4 style="margin-top:0; color:#fff;">${art.title}</h4>
                    <p class="text-muted" style="font-size:12px; margin-bottom: 10px;"><i class="fa fa-clock-o"></i> ${art.updated_at || art.created_at}</p>
                    <span class="btn btn-sm btn-primary filled-button">Read Article</span>
                </div>
            </div>`;
        });
    }
    $("#articleList").html(html);
}

function filterArticles(query) {
    query = query.toLowerCase().trim();
    if (query.length === 0) {
        renderArticleCards(allArticles);
        return;
    }
    let filtered = allArticles.filter(art => art.title.toLowerCase().includes(query));
    renderArticleCards(filtered);
}

function viewArticle(slug) {
    $("#articleList, #articleListTitle").hide();
    if(isAdmin) $("#addArticleBtn").hide();
    $("#singleArticleView").show();
    $("#viewContent").html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
    $("#viewTitle, #viewCategory, #viewDate").empty();
    
    $.get("ajax_docs.php?action=fetch_article&slug=" + slug, function(response) {
        if(response.status === 'success') {
            currentArticle = response.data;
            $("#viewTitle").text(currentArticle.title);
            $("#viewCategory").text(currentArticle.category_title);
            $("#viewDate").text(currentArticle.updated_at);
            $("#viewContent").html(currentArticle.content);
        } else {
            $("#viewContent").html('<div class="alert alert-danger">Error loading article.</div>');
        }
    });
}

function showArticleList() {
    currentArticle = null;
    $("#singleArticleView").hide();
    $("#articleListTitle").show();
    if(isAdmin) $("#addArticleBtn").show();
    $("#articleList").show();
}

/* =========================================
   ADMIN ACTIONS
========================================= */

function showAddCategoryModal() {
    Swal.fire({
        title: 'Add Category',
        html: `
            <input id="catTitle" class="swal2-input" placeholder="Category Title">
            <input id="catDesc" class="swal2-input" placeholder="Description">
        `,
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
            return {
                title: document.getElementById('catTitle').value,
                description: document.getElementById('catDesc').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("ajax_docs.php", { action: 'create_category', title: result.value.title, description: result.value.description }, function(res) {
                if(res.status == 'success') {
                    Swal.fire('Success', res.message, 'success');
                    loadCategories();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}

function showEditCategoryModal(id, title, description, event) {
    event.stopPropagation();
    Swal.fire({
        title: 'Edit Category',
        html: `
            <input id="catTitle" class="swal2-input" value="${title}" placeholder="Category Title">
            <input id="catDesc" class="swal2-input" value="${description}" placeholder="Description">
        `,
        focusConfirm: false,
        showCancelButton: true,
        preConfirm: () => {
            return {
                title: document.getElementById('catTitle').value,
                description: document.getElementById('catDesc').value
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("ajax_docs.php", { action: 'update_category', id: id, title: result.value.title, description: result.value.description }, function(res) {
                if(res.status == 'success') {
                    Swal.fire('Success', res.message, 'success');
                    loadCategories();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}

function deleteCategory(id, event) {
    event.stopPropagation();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("ajax_docs.php", { action: 'delete_category', id: id }, function(res) {
                if(res.status == 'success') {
                    Swal.fire('Deleted!', res.message, 'success');
                    if(currentCategoryId == id) loadArticles(0);
                    loadCategories();
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}

function showAddArticleModal() {
    let catOptions = allCategories.map(c => `<option value="${c.id}" ${c.id == currentCategoryId ? 'selected' : ''}>${c.title}</option>`).join('');
    
    Swal.fire({
        title: 'Add Article',
        html: `
            <select id="artCategory" class="swal2-input" style="height:auto; padding: 10px;">
                <option value="0">Select Category...</option>
                ${catOptions}
            </select>
            <input id="artTitle" class="swal2-input" placeholder="Article Title">
            <div id="artEditor" style="height: 200px; margin-top: 20px; background: #fff; color: #000; text-align: left;"></div>
        `,
        width: 800,
        didOpen: () => {
            window.artQuill = new Quill('#artEditor', {
                theme: 'snow'
            });
        },
        showCancelButton: true,
        preConfirm: () => {
            return {
                category_id: document.getElementById('artCategory').value,
                title: document.getElementById('artTitle').value,
                content: window.artQuill.root.innerHTML
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("ajax_docs.php", { 
                action: 'create_article', 
                category_id: result.value.category_id, 
                title: result.value.title, 
                content: result.value.content 
            }, function(res) {
                if(res.status == 'success') {
                    Swal.fire('Success', res.message, 'success');
                    loadArticles(currentCategoryId);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}

function showEditArticleModal() {
    if(!currentArticle) return;
    
    let catOptions = allCategories.map(c => `<option value="${c.id}" ${c.id == currentArticle.category_id ? 'selected' : ''}>${c.title}</option>`).join('');
    
    Swal.fire({
        title: 'Edit Article',
        html: `
            <select id="artCategory" class="swal2-input" style="height:auto; padding: 10px;">
                ${catOptions}
            </select>
            <input id="artTitle" class="swal2-input" value="${currentArticle.title.replace(/"/g, '&quot;')}" placeholder="Article Title">
            <div id="artEditor" style="height: 200px; margin-top: 20px; background: #fff; color: #000; text-align: left;"></div>
        `,
        width: 800,
        didOpen: () => {
            window.artQuill = new Quill('#artEditor', {
                theme: 'snow'
            });
            window.artQuill.root.innerHTML = currentArticle.content;
        },
        showCancelButton: true,
        preConfirm: () => {
            return {
                id: currentArticle.id,
                category_id: document.getElementById('artCategory').value,
                title: document.getElementById('artTitle').value,
                content: window.artQuill.root.innerHTML
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("ajax_docs.php", { 
                action: 'update_article', 
                id: result.value.id,
                category_id: result.value.category_id, 
                title: result.value.title, 
                content: result.value.content 
            }, function(res) {
                if(res.status == 'success') {
                    Swal.fire('Success', res.message, 'success');
                    viewArticle(currentArticle.slug); // Refresh view
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}

function deleteArticle() {
    if(!currentArticle) return;
    
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("ajax_docs.php", { action: 'delete_article', id: currentArticle.id }, function(res) {
                if(res.status == 'success') {
                    Swal.fire('Deleted!', res.message, 'success');
                    showArticleList();
                    loadArticles(currentCategoryId);
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}
</script>
