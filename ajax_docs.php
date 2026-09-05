<?php
require_once("connect.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$isAdmin = ($_SESSION["access"] === "Admin");
$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = $_SESSION['id'] ?? 0;

if ($action == '') {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
    exit;
}

// Fetch categories
if ($action == 'fetch_categories') {
    $query = "SELECT * FROM mcjim_wiki_categories ORDER BY title ASC";
    $result = mysqli_query($conn, $query);
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $categories]);
    exit;
}

// Fetch articles (can be filtered by category_id)
if ($action == 'fetch_articles') {
    $categoryId = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
    
    if ($categoryId > 0) {
        $query = "SELECT id, category_id, title, slug, created_at, updated_at FROM mcjim_wiki_articles WHERE category_id = ? ORDER BY title ASC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $categoryId);
    } else {
        $query = "SELECT id, category_id, title, slug, created_at, updated_at FROM mcjim_wiki_articles ORDER BY title ASC";
        $stmt = $conn->prepare($query);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $articles = [];
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $articles]);
    exit;
}

// Fetch a single article by slug
if ($action == 'fetch_article') {
    $slug = isset($_GET['slug']) ? $_GET['slug'] : '';
    if (empty($slug)) {
        echo json_encode(['status' => 'error', 'message' => 'Slug is required']);
        exit;
    }
    $query = "SELECT a.*, c.title as category_title FROM mcjim_wiki_articles a LEFT JOIN mcjim_wiki_categories c ON a.category_id = c.id WHERE a.slug = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Article not found']);
    }
    exit;
}

// Admin only actions
if (!$isAdmin) {
    echo json_encode(['status' => 'error', 'message' => 'Access denied. Admins only.']);
    exit;
}

function generateSlug($title, $conn) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $originalSlug = $slug;
    $count = 1;
    while (true) {
        $stmt = $conn->prepare("SELECT id FROM mcjim_wiki_articles WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            break;
        }
        $slug = $originalSlug . '-' . $count;
        $count++;
    }
    return $slug;
}

// Create Category
if ($action == 'create_category') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    if (empty($title)) {
        echo json_encode(['status' => 'error', 'message' => 'Title is required']);
        exit;
    }
    $stmt = $conn->prepare("INSERT INTO mcjim_wiki_categories (title, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $description);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create category']);
    }
    exit;
}

// Delete Category
if ($action == 'delete_category') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    // Check if articles exist in this category
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM mcjim_wiki_articles WHERE category_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if ($res['cnt'] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Cannot delete category because it contains articles.']);
        exit;
    }
    
    $stmt = $conn->prepare("DELETE FROM mcjim_wiki_categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Category deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete category']);
    }
    exit;
}

// Create Article
if ($action == 'create_article') {
    $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    
    if (empty($title) || empty($content) || $categoryId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }
    
    // Get user id (if not available in session, we look it up by username)
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $uRes = $stmt->get_result()->fetch_assoc();
    $userId = $uRes ? $uRes['id'] : 0;
    
    $slug = generateSlug($title, $conn);
    $now = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare("INSERT INTO mcjim_wiki_articles (category_id, title, slug, content, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssiss", $categoryId, $title, $slug, $content, $userId, $now, $now);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Article published successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to publish article']);
    }
    exit;
}

// Update Article
if ($action == 'update_article') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $categoryId = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    
    if ($id <= 0 || empty($title) || empty($content) || $categoryId <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }
    
    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE mcjim_wiki_articles SET category_id = ?, title = ?, content = ?, updated_at = ? WHERE id = ?");
    $stmt->bind_param("isssi", $categoryId, $title, $content, $now, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Article updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update article']);
    }
    exit;
}

// Delete Article
if ($action == 'delete_article') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    $stmt = $conn->prepare("DELETE FROM mcjim_wiki_articles WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Article deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete article']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
