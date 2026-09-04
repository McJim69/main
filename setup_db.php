<?php
require_once("connect.php");

$queries = [
    "CREATE TABLE IF NOT EXISTS projects (
      pid int(11) NOT NULL AUTO_INCREMENT,
      pname varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
      description varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
      plink varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
      pimgUrl varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
      PRIMARY KEY (pid)
    )",
    
    "CREATE TABLE IF NOT EXISTS projects_details (
      did int(11) NOT NULL AUTO_INCREMENT,
      pid int(11) NOT NULL,
      long_desc   text COLLATE utf8mb4_unicode_ci NOT NULL,
      how_itworks text COLLATE utf8mb4_unicode_ci NOT NULL,
      management  text COLLATE utf8mb4_unicode_ci NOT NULL, 
      mgt_public  text COLLATE utf8mb4_unicode_ci NOT NULL, 
      mgt_admin   text COLLATE utf8mb4_unicode_ci NOT NULL, 
      features    text COLLATE utf8mb4_unicode_ci NOT NULL, 
      tech_used   text COLLATE utf8mb4_unicode_ci NOT NULL, 
      PRIMARY KEY (did),
      FOREIGN KEY (pid) REFERENCES projects (pid) ON DELETE CASCADE
    )",

    "CREATE TABLE IF NOT EXISTS projects_images (
      sid int(11) NOT NULL AUTO_INCREMENT,
      pid int(11) NOT NULL,
      imgUrl varchar(255) DEFAULT NULL,
      PRIMARY KEY (sid),
      FOREIGN KEY (pid) REFERENCES projects (pid) ON DELETE CASCADE
    )"
];

foreach ($queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Successfully executed query.\n";
    } else {
        echo "Error executing query: " . mysqli_error($conn) . "\n";
    }
}

echo "Database setup complete.\n";
?>
