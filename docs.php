<?php
require("connect.php");
require("header.php");
require("menunav.php");

if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
?>

<script>setActive("docs");</script>

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
        <h4>Categories</h4>
        <div class="list-group" id="categoryList">
            <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
      </div>
      <div class="col-md-9">
        <h4 id="articleListTitle">All Articles</h4>
        <div id="articleList" class="row">
            <div class="col-12 text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
        </div>
        
        <!-- Single Article View -->
        <div id="singleArticleView" style="display:none;">
            <button class="btn btn-sm btn-secondary mb-3" onclick="showArticleList()"><i class="fa fa-arrow-left"></i> Back</button>
            <h2 id="viewTitle" style="color:#fff;"></h2>
            <p class="text-muted" style="margin-bottom: 20px;"><i class="fa fa-folder-open"></i> <span id="viewCategory"></span> &nbsp; <i class="fa fa-clock-o"></i> <span id="viewDate"></span></p>
            <div id="viewContent" style="color:var(--text-main); line-height: 1.8;"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("footer.php"); ?>
<script>
let allArticles = [];

$(document).ready(function() {
    loadCategories();
    loadArticles(0);
});

function loadCategories() {
    $.get("ajax_docs.php?action=fetch_categories", function(response) {
        if(response.status === 'success') {
            let html = `<a href="javascript:void(0)" class="list-group-item list-group-item-action active" onclick="loadArticles(0, this)">All Categories</a>`;
            response.data.forEach(cat => {
                html += `<a href="javascript:void(0)" class="list-group-item list-group-item-action" onclick="loadArticles(${cat.id}, this)">${cat.title}</a>`;
            });
            $("#categoryList").html(html);
        }
    });
}

function loadArticles(categoryId, element) {
    if(element) {
        $("#categoryList .list-group-item").removeClass("active");
        $(element).addClass("active");
        $("#articleListTitle").text($(element).text());
    } else {
        $("#articleListTitle").text("All Articles");
    }
    
    $("#singleArticleView").hide();
    $("#articleListTitle").show();
    $("#articleList").show().html('<div class="col-12 text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
    
    $.get("ajax_docs.php?action=fetch_articles&category_id=" + categoryId, function(response) {
        if(response.status === 'success') {
            let html = '';
            if(response.data.length === 0) {
                html = '<div class="col-12"><div class="alert alert-info">No articles found in this category.</div></div>';
            } else {
                response.data.forEach(art => {
                    html += `
                    <div class="col-md-6 mb-4">
                        <div class="service-item" style="padding: 20px; background: var(--bg-card); border-radius: 10px; cursor:pointer;" onclick="viewArticle('${art.slug}')">
                            <h4 style="margin-top:0;">${art.title}</h4>
                            <p>Updated: ${art.updated_at}</p>
                            <span class="btn btn-sm btn-primary filled-button mt-2">Read More</span>
                        </div>
                    </div>`;
                });
            }
            $("#articleList").html(html);
        }
    });
}

function viewArticle(slug) {
    $("#articleList, #articleListTitle").hide();
    $("#singleArticleView").show();
    $("#viewContent").html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
    $("#viewTitle, #viewCategory, #viewDate").empty();
    
    $.get("ajax_docs.php?action=fetch_article&slug=" + slug, function(response) {
        if(response.status === 'success') {
            let art = response.data;
            $("#viewTitle").text(art.title);
            $("#viewCategory").text(art.category_title);
            $("#viewDate").text(art.updated_at);
            $("#viewContent").html(art.content);
        } else {
            $("#viewContent").html('<div class="alert alert-danger">Error loading article.</div>');
        }
    });
}

function showArticleList() {
    $("#singleArticleView").hide();
    $("#articleList, #articleListTitle").show();
}
</script>

