<!-- Blog Entries Column -->
  <div class="col-md-8">
    <h1 class="page-header">
        Larry's custom CMS
        <small>template</small>
    </h1>
      <?php 
        $cat_id = htmlspecialchars($_GET['cat_id']);
        // Grab the category title
        $cat_title = get_category_title($cat_id);
      
      ?>
   <h2><a href="#"><?php print strtoupper($cat_title); ?></a></h2>
    <?php 
   
        $query = "SELECT p.*, c.* FROM categories AS c "
                . "LEFT JOIN posts AS p ON c.cat_id = p.post_category_id "
                . "WHERE c.cat_id = {$cat_id}";

        $result_category_query = mysqli_query($connection, $query);
    ?>
    <?php while ($row = mysqli_fetch_assoc($result_category_query)): ?>
    <?php
        // Declare the array and stuff its elements.
        $post = array();    
        $post['post_content'] = $row['post_content'];
        $post['post_date'] = $row['post_date'];
        $post['post_id'] = $row['post_id'];
        $post['post_image'] = $row['post_image'];
        $post['post_status'] = $row['post_status'];
        $post['post_tags'] = $row['post_tags'];
        $post['post_title'] = $row['post_title'];
        $post['post_author'] = $row['post_author'];
    ?>

  <h2><a href="index.php?post_id=<?php print $post['post_id']; ?>"><?php print $post['post_title']; ?></a></h2>
    <p class="lead">
      by <a href="#"><?php print $post['post_author']; ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php print $post['post_date']; ?></p>
    <hr>
    <img class="img-responsive" style="background: url('<?php print $post['post_image']; ?>'); background-repeat: no-repeat; background-size: 100%;" src="" alt="">
    <hr>
    <?php $renderable_content = code_format_teaser($post['post_content']);?>
    <p class="wrap-text"><?php print $renderable_content; ?></p>
  <hr>
  <?php endwhile; ?>
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
