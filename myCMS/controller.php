<!-- Viewing posts for a particular search. -->
    <?php if (isset($_POST['search'])): ?>
        <?php include "includes/search-content.php"; ?>
    <!-- Viewing a specific post, because we have a post_id -->
    <?php elseif (isset($_GET['post_id'])): ?>
        <?php include "includes/post.php"; ?>
    <!-- Viewing a specific category, because we have a cat_id -->
    <?php elseif (isset($_GET['cat_id'])): ?>
        <?php include "includes/category.php"; ?>
    <!-- Viewing the home page. -->
    <?php else: ?>
        <?php include "includes/content.php"; ?>
    <?php endif; ?>
    <?php include "includes/sidebar.php"; ?>
    <hr>
