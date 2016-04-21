<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Start Bootstrap</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php // Query db for all of the categories.
                  $query = "SELECT * FROM categories";
                  $select_all_categories_query = mysqli_query($connection, $query);
                  confirm_query($select_all_categories_query);
                ?>
                <?php while ($rows = mysqli_fetch_assoc($select_all_categories_query)): ?>
                  <li><a href="index.php?cat_id=<?php print $rows['cat_id']; ?>"><?php print $rows['cat_title']; ?></a></li>
                <?php endwhile; ?>      
                <!-- Admin button -->
                <li>
                  <a href="admin/admin_index.php">Admin</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>