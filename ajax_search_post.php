<?php
require_once("connect.php");

header('Content-Type: application/json');

if(isset($_GET['q'])) {
  $q = "%".trim($_GET['q'])."%";

  $sql = "SELECT bp.id, bp.title, bp.created_at, u.fullname
          FROM blog_posts bp
          JOIN users u ON bp.user_uno = u.uno
          WHERE bp.title LIKE ? OR bp.content LIKE ?
          ORDER BY bp.created_at DESC LIMIT 10";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $q, $q);
  $stmt->execute();
  $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

  echo json_encode(['status'=>'OK','results'=>$results]);
} else {
  echo json_encode(['status'=>'ERROR','message'=>'Missing query']);
}
?>
