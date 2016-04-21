<!-- Blog Entries Column -->
  <div class="col-md-8">
    <h1 class="page-header">
        Larry's custom CMS
        <small>template</small>
    </h1>
   
<!-- First Blog Post -->
  <?php 
    // Query the db for posts
    $query = "SELECT * FROM posts";
    $select_all_from_posts = mysqli_query($connection, $query);
  ?>   
  
  <?php while ($row = mysqli_fetch_assoc($select_all_from_posts)): ?>
    <?php 
      // Just grab the values.
      $post_id = $row['post_id'];
      $post_title = $row['post_title']; 
      $post_author = $row['post_author']; 
      $post_date = $row['post_date']; 
      $post_image = $row['post_image']; 
      $post_content = $row['post_content'];
    ?>
    <h2><a href="index.php?post_id=<?php print $post_id; ?>"><?php print $post_title; ?></a></h2>
    <p class="lead">
      by <a href="#"><?php print $post_author; ?></a>
    </p>    
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php print $post_date; ?></p>
    <hr>
    <img class="img-responsive" style="background: url('<?php print $post_image; ?>'); background-repeat: no-repeat; background-size: 100%;" src="" alt="">
    <hr>
    <?php $renderable_content = code_format_teaser($post_content);?>
    <p class="wrap-text"><?php print $renderable_content; ?></p>
    <a class="btn btn-primary" href="index.php?post_id=<?php print $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
  <?php endwhile; ?>
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
