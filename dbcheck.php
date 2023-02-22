<?php

require_once 'DB.php';

$db = new DB();

$rows = $db->getQuery("SELECT * FROM book_reviews");

    foreach($rows as $review) {
        echo "Review: " . $review["review"] . " - Created By: " . $review["created_by"] . " - Created Date: " . $review["created_date"] . "<br>";
    }
?>