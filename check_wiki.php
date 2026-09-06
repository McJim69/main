<?php
require 'connect.php';

// Create a category
$conn->query("INSERT INTO mcjim_wiki_categories (title) VALUES ('Test Cat')");
$catId = $conn->insert_id;

// Create an article in it
$conn->query("INSERT INTO mcjim_wiki_articles (category_id, title, slug, content, created_by, created_at) VALUES ($catId, 'Test Art', 'test-art', 'content', 1, NOW())");

// Attempt to delete category
if (!$conn->query("DELETE FROM mcjim_wiki_categories WHERE id = $catId")) {
    echo "Delete failed: " . $conn->error;
} else {
    echo "Delete succeeded!";
}

// Clean up
$conn->query("DELETE FROM mcjim_wiki_articles WHERE category_id = $catId");
?>
