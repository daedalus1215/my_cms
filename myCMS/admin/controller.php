<?php 
    $debug_stop = ""; 

    if (isset($_GET['source'])) {
        include "pages/admin_posts.php";
    }
    else if (isset($_GET['admin_categories'])) {
        include "pages/admin_categories.php";
    }
    else if (isset($_GET['admin_comments'])) {
        include "pages/admin_comments.php";
    }
    include "includes/admin_sidebar.php";
?> 
    <hr>