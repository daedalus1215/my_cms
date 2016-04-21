<?php 
    $query = "SELECT * FROM categories";
    $select_all_categories_sidebar_query = mysqli_query($connection, $query);
    $category_title = array();
    while ($row = mysqli_fetch_assoc($select_all_categories_sidebar_query)) {
        $category_title[$row['cat_id']] = $row['cat_title'];
    }
?>

<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="index.php" method="post">
          <div class="input-group">
            <input type="text" name="search" id="search" class="form-control" value="<?php if (isset($_POST['search'])) { print $_POST['search']; } ?>">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
          </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                <?php foreach ($category_title as $cat_id => $cat_title): ?>
                    <li><a href="index.php?cat_id=<?php print $cat_id; ?>"><?php print $cat_title; ?></a></li>
                <?php endforeach; ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>
</div>