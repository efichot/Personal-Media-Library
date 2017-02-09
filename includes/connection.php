<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=database;port:3306", "root", "root");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    echo "An error occurs: " . $e->getMessage();
    exit;
}

?>
