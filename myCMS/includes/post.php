<!-- Blog Entries Column -->
  <div class="col-md-8">
    <h1 class="page-header">
        Larry's custom CMS
        <small>template</small>
    </h1>
   
  <?php 
    // Make sure we handle a additional comment to this post.
    listen_for_comment_addition();
    $post_id = htmlspecialchars($_GET['post_id']);
    
    // Query the db for posts
    $query_post = "SELECT posts.*, categories.cat_title "
            . "FROM categories "
            . "LEFT JOIN posts "
            . "ON posts.post_category_id = categories.cat_id "
            . "WHERE posts.post_id = '{$post_id}'"; 
    
    $select_post = mysqli_query($connection, $query_post);
    confirm_query($select_post);
  ?>   
  
  <?php while ($row = mysqli_fetch_assoc($select_post)): ?>
    <?php 
    // Just grab the values.
      $post_title = $row['post_title']; 
      $post_author = $row['post_author']; 
      $post_date = $row['post_date']; 
      $post_image = $row['post_image']; 
      $post_content = $row['post_content'];
      $post_cat_id = $row['post_category_id'];
      $post_cat_name = $row['cat_title'];
    ?>
    <h2><a href="#"><?php print $post_title; ?></a></h2>
    <p class="lead">
      by <a href="#"><?php print $post_author; ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php print $post_date; ?></p>
    <hr>
    <img class="img-responsive" style="background: url('<?php print $post_image; ?>'); background-repeat: no-repeat;" src="" alt="">
    <hr>
    <?php $renderable_content = code_format($post_content);?>
    <p class="wrap-text"><?php print $post_content; ?></p>
    <hr>
    <?php include "comment_form.php"; ?>    
  <?php endwhile; ?>
   <hr>
    <div class="comments-wrapper">
        <?php display_all_comments_for_post(); ?>
    </div>
  <hr>
  <!-- Pager -->
  <ul class="pager">
    <li class="previous">
        <a href="#">&larr; Older</a>
    </li>
    <li class="next">
        <a href="#">Newer &rarr;</a>
    </li>
  </ul>
</div>

<!-- Yarn ball for mysql image came from http://thenewcode.com -->
