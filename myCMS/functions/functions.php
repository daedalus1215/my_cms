<?php
/**
 * HELPER FUNCTIONS FOR every query
 * @param $query_result: this is the query result of a mysqli query. We are 
 * Making sure that the query went through with no issue.
 */
function confirm_query($query_result) {
    global $connection;
    if (!$query_result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

/**
 * This is a utility function to format code examples I throw as a post, in a way that is readable and reasonable.
 * @param type $string_code - $post_content that is coming in.
 * @return type - return the changed $string_code, or altered $string_code - depending on if the post had a opening <CODE>.
 */
function code_format_teaser($string_code) {
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

    return $string_code;
}

/**
 * Retrieve the Category Title
 * @global DB_Object $connection
 * @param Integer $cat_id: the category id.
 * @return String The category title.
 */
function get_category_title($cat_id) {
    global $connection;
    
    $query = "SELECT cat_title FROM categories "
                . "WHERE cat_id = '{$cat_id}'";
    
    $result_categories = mysqli_query($connection, $query);
    confirm_query($result_categories);
    
    while($row = mysqli_fetch_assoc($result_categories)){
        $cat_title = $row['cat_title'];
    }
    return $cat_title;
}



/**
 * 
 * 
 * @param Integer $cat_id: Is the ID of a category that we are checking.
 */
function validate_category_id($cat_id) {
    global $connection;
    $query = "SELECT c.cat_id "
            . "FROM category AS c "
            . "WHERE c.cat_id = '{$cat_id}'";
            
    $result_query = mysqli_query($connection, $query);
    
    confirm_query($result_query);
}


/**
 * Display all of the posts of a particular category.
 * 
 * @global $connection $connection
 * @param Integer $cat_id is the category id we want to display all posts for.
 */
function display_all_posts_of_category($cat_id) {
    global $connection;
    // DISPLAY CATEGORIES
    // Query db for all of the categories.
    $query = "SELECT p.* "
            . "FROM posts as p"
            . "JOIN categories AS c"
            . "ON p.post_category_id = c.cat_id "
            . "WHERE c.cat_id = {$cat_id}";
    $select_posts_query = mysqli_query($connection, $query);
    confirm_query($select_posts_query);
    
    while ($rows = mysqli_fetch_assoc($select_posts_query)) {
        $post_id = $rows['post_id'];
        $post_author = $rows['post_author'];
        $post_title = $rows['post_title'];
        $post_category_id = $rows['post_category_id'];
        $post_status = $rows['post_status'];
        $post_image = $rows['post_image'];
        $post_tags = $rows['post_tags'];
        $post_comment_count = $rows['post_comment_count'];
        $post_date = $rows['post_date'];
        
        (isset($rows['cat_title'])) ? $cat_title = $rows['cat_title'] : $cat_title = "";
        
        echo "<tr>";
            echo "<td><a href='admin_posts.php?source=view_edit_posts&edit={$post_id}'>Edit</a></td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$post_title}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td>{$post_status}</td>";
            echo "<td><img src='../{$post_image}' alt='' width='100px' /></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td>{$post_comment_count}</td>";
            echo "<td>{$post_date}</td>";
        echo "</tr>";
    }
}


function display_all_comments_for_post() {
  global $connection;
  if (!isset($_POST['post_id'])) {
      return;
  }
  $post_id = htmlspecialchars($_POST['post_id']);
  
  $query = "SELECT c.* FROM comments AS c "
          . "JOIN posts AS p ON c.comment_post_id = p.post_id "
          . "WHERE p.post_id = {$post_id}";

  $result_query_comments = mysqli_query($connection, $query);
  confirm_query($result_query_comments);
  
  while ($rows = mysqli_fetch_assoc($result_query_comments)) {
    echo '<div class="image"></div>';
        $comment['comment_id']      = $rows['comment_id'];
        $comment['comment_post_id'] = $rows['comment_post_id'];
        $comment['comment_author']  = $rows['comment_author'];
        $comment['comment_email']   = $rows['comment_email'];
        $comment['comment_content'] = $rows['comment_content'];
        $comment['comment_status']  = $rows['comment_status'];
        $comment['comment_date']    = $rows['comment_date'];
        
        display_comment($comment); 
  }  
}

/**
 * Displays the comment in the appronpriate manner.
 * @param Array $comment
 */
function display_comment($comment) {
    echo "<div class='comment-text-wrapper'>";
        echo "<p>";
            echo "<span class='comment-author'>{$comment['comment_author']}</span>";
            echo "<span class='comment-date'>{$comment['comment_date']}</span>";
        echo "</p>";
        echo "<p class='comment-content'>";
            echo "<span class='comment-content'>{$comment['comment_content']}</span>";
        echo "</p>";
    echo "</div>";
}


function listen_for_comment_addition() {
    if (!isset($_POST['add_comment'])) {
        return;
    }
    
    $comment = array();
    $comment['comment_content'] = $_POST['comment_content'];
    $comment['post_id']         = $_POST['post_id'];
    $comment['comment_author']  = isset($_POST['comment_author']) ? htmlspecialchars($_POST['comment_author']) : "anonymous";
    $comment['comment_date']    = date('m-d-y');
    $comment['comment_email']   = isset($_POST['comment_email']) ? htmlspecialchars($_POST['comment_email']) : "anonymous_email";
    $comment['comment_status']  = 0; // by default, comment needs to be approved.
    save_comment($comment);
    header("Location:index.php?post_id={$comment['post_id']}");
    unset($_POST);
}
/**
 * 
 * @param Array $comment
 */
function save_comment($comment) {
    global $connection;
    
    $query_save_comment = "INSERT INTO comments "
            . "(comment_post_id, comment_email, comment_content, comment_status, comment_date, comment_author) "
            . "VALUES('{$comment['post_id']}','{$comment['comment_email']}', '{$comment['comment_content']}', '{$comment['comment_status']}', now(), '{$comment['comment_author']}')";
    $result_query_saved = mysqli_query($connection, $query_save_comment);
    confirm_query($result_query_saved);
    
}

// THIS SI WHERE I AM LEAVING OFF _ make sure that comment_form.php is passing in the "bring this" make sure we receive it and go from here. 

  // comment_post_id      bring this
  // comment_author       auto fill this
  // comment_email        auto fill tis
  // comment_content      bring this 
  // comment_status       auto set this to 0 
  // comment_date         auto set this

