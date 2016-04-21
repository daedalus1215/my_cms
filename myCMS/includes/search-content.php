<?php 
    if (isset($_POST['search'])) {
        $search = htmlspecialchars($_POST['search']);
        $query = "SELECT * FROM posts WHERE post_content LIKE '%$search%' ";
        $select_all_posts_with_search = mysqli_query($connection, $query);
        if (!$select_all_posts_with_search) { die("QUERY FAILED: " . mysqli_error($connection)); }
        $result_titles = array();
        while ($row = mysqli_fetch_assoc($select_all_posts_with_search)) {
            $result_titles[$row['post_title']] = 
                    array("content" => $row['post_content'], 
                          "image"   => $row['post_image'], 
                          "author"  => $row['post_author'],
                          "date"    => $row['post_date']
                    );
        }
    }
?>
 

 <!-- Blog Entries Column -->
  <div class="col-md-8">
    <h1 class="page-header">
        Search Results for: <span class="search-header"><?php print $search?></span>
        <small></small>
    </h1>
   <?php foreach ($result_titles as $result_title => $result_bundle): ?>
<!-- First Blog Post -->
    <h2><a href="#"><?php print $result_title; ?></a></h2>
    <p class="lead">
      by <a href="#"><?php print $result_bundle['author']; ?></a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php print $result_bundle['date']; ?></p>
    <hr>
    <img class="img-responsive" style="background: url(<?php print $result_bundle['image']; ?>) center;" src="" alt="">
    <hr>
    <?php $renderable_content = code_format($result_bundle['content']); ?>
    <p><?php if (isset($renderable_content)) { print $renderable_content; } ?></p>
    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
    <?php endforeach; ?>
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

<?php
/**
 * This is a utility function to format code examples I throw as a post, in a way that is readable and reasonable.
 * @param type $string_code - $post_content that is coming in.
 * @return type - return the changed $string_code, or altered $string_code - depending on if the post had a opening <CODE>.
 */
function code_format($string_code) {
    // Code string or regular string.
    $code = false;
    // Opening content should have <code> at top if that's what the nature of it is.
    $code = (str_word_count($string_code, 0, "<CODE>") > 0) ? true : false;
    // if this is actually a segment of code for notes (like I usually have in my notes).
    if ($code) {
        $string_code = str_replace(";", "&#59;<br/>", $string_code); // Lets Identify semi-colon, add a br and append it back to the line
        $string_code = str_replace("{", "&#123;<br/>", $string_code); // Identify open french bracket and repeat ^^
        $string_code = str_replace("}", "&#125;<br/>", $string_code); // ID close french bracket and repeat ^^
        $string_code = str_replace(".", "&#46;<br/>", $string_code);$string_code = str_replace(";", "<br/>", $string_code); // ID periods and repeat ^^
    }
    // Truncate after 200 characters. For Snippet effect.
    $string_code = substr($string_code, 0, 200);
    // While truncating, did we remove </code>? If so.. we need to re-attach it.
    if ($code) {
        $occurance = strpos($string_code, "</code>");
        if ($occurance <= 0) {
            $string_code = $string_code . "</code>"; // slap it on the end.
        } 
    }
    return $string_code;
}
?>