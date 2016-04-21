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
 * User has made a clear intention to add an additional post. admin_post.php > view_add_post.php
 * @global $connection $connection
 */
function listen_for_post_addition() {
    global $connection;
    if (isset($_POST['add_post'])) {        
        
        $post_title         = $_POST['post_title'];
        $post_category_id   = $_POST['post_category_id'];
        $post_author        = $_POST['post_author'];
        $post_staus         = $_POST['post_status'];
        
        $post_image         = $_FILES['post_image']['tmp_name'];
        $to                 = "../images/".basename($_FILES['post_image']['name']);
        
        $post_content       = $_POST['post_content'];
        $post_tags          = $_POST['post_tags'];
        $post_date          = date('m-d-y');
        $post_comment_count = 4;
        
        
        
        
        
        
        // Upload the file.
       $d = move_uploaded_file($post_image, $to);
       $post_image = "images/$post_image";
        $query_insert_new_post = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) "
                . "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}')";
        
       
        $query_result = mysqli_query($connection, $query_insert_new_post);
        
        confirm_query($query_result);
            
        header("Location: admin_index.php?source=view_all_posts");
        unset($_POST);
    }
}

/**
 * User has made a clear intention to generate an additional post. admin_post.php > view_add_post.php
 * @global $connection $connection
 */
function listen_for_post_generation() {
    global $connection;
    if (isset($_POST['generate_post'])) {        
        $post_title         = "Lorem Ipsum";
        $post_category_id   = 17;
        $post_author        = "larry";
        $post_status        = 1;
        
        $post_image         = "images/mysql-not.jpg";
        $post_image_temp    = "C:/xampp/tmp"; // temporary location, basically we are storing the file in a tmp location on the server.
        
        $post_content       = 'Contrary to popular belief, Lorem I';
        $post_tags          = "generated";
        $post_date          = date('m-d-y');
        $post_comment_count = 0;
        
             
        $query_insert_new_post = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) "
                . "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_comment_count}','{$post_status}')";
        
        
        $query_result = mysqli_query($connection, $query_insert_new_post);
        
        confirm_query($query_result);
        header("Location:admin_index.php?source=view_posts");
        unset($_POST);
    }
}

/**
 * HELPER FUNCTIONS FOR admin_categories.php
 */

/*
 * Listens for a user's request to add a category. 
 * When the user clicks the add button, we add the entry, if it is not empty and not a blank string.
 */
function listen_for_categorical_additions() {
    global $connection;
    
    // User has expressed interest in ADDING a CATEGORY.
    if (isset($_POST['add_category'])) {
        // Grab the new category.
        $cat_title = htmlspecialchars($_POST['cat_title']);
        
        // flush the post category title - so we don't keep it if the screen is refreshed.
        unset($_POST);
        
        // If it has an empty string or empty.
        if (!$cat_title == "" || !empty($cat_title)) {
            // Insert the new category value.
            $query = "INSERT INTO categories(cat_title)";
            $query .= "VALUE('{$cat_title}')";
            
            // Create our query.
            $create_category_query = mysqli_query($connection, $query);
            confirm_query($create_category_query);
        }
    }
}

/**
 * Listens for a user to request an intention to edit a category. When the user has sent out the request
 * we then query the db, with the specific categorical id, then generate a dynamic form, where they can
 * edit the categorical name, and submit the changes. 
 * Called before listen_for_categorical_edits_completed() is called.
 */
function listen_for_categorical_edits() {
    global $connection;
    // User has expressed interest in EDITING a CATEGORY.
    if (isset($_GET['edit'])) {
        $edit_category_choice = htmlspecialchars($_GET['edit']);
        
        // Flush the global get 'edit' entry
        unset($_GET);
        
        $query = "SELECT * FROM categories WHERE cat_id = '{$edit_category_choice}'";
        $select_editable_category = mysqli_query($connection, $query);
        $editable_query = mysqli_fetch_assoc($select_editable_category);
      
        confirm_query($editable_query);
        
        // The title is
        $cat_title = $editable_query['cat_title'];
        
        echo "   <form action='admin_categories.php' method='get'>";
        echo "       <div class='form-group'>";
        echo "           <label for='cat-title'>Edit Category</label>";
        echo "           <input type='text' class='form-control' name='cat_title' value='{$cat_title}'>";
        echo "           <input type='hidden'  name='cat_id' value='{$edit_category_choice}'>";
        echo "       </div>";
        echo "       <div class='form-group'>";
        echo "           <input type='submit' class='btn btn-primary' name='edit_submit' value='Edit Category'>";     
        echo "       </div>";
        echo "   </form>";
    }
}

/**
 * Query the database for all categories and display them in a table's row and 
 * cells. This does call a global connection object.
 * @global $connection
 */
function display_all_categories() {
    global $connection;
    // DISPLAY CATEGORIES
    // Query db for all of the categories.
    $query = "SELECT * FROM categories";
    $select_all_categories_query = mysqli_query($connection, $query);
    confirm_query($select_all_categories_query);
    
    while ($rows = mysqli_fetch_assoc($select_all_categories_query)) {
        
        $cat_id = $rows['cat_id'];
        $cat_title = $rows['cat_title'];

        echo "<tr>";
            echo "<td>$cat_id</td>";  
            echo "<td><input  type=\"text\" value='{$cat_title}' class=\"no-style readonly\" readonly></input></td>";
            echo "<td><a href='admin_categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "<td><a href='admin_categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}

/**
 * Listens for a request to delete a category and handles it appropriately.
 * It's essentially called when a user has expressed intent to delete a category.
 * @global type $connection
 */
function listen_for_categorical_deletes() {
    global $connection;
    
    // User has expressed interest in DELETING a CATEGORY.
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        // GET - category id the user intends to delete.
        $cat_id = $_GET['delete'];
        unset($_GET);
        // Make the delete query.
        $delete_category_query = "DELETE FROM categories WHERE cat_id = {$cat_id} ";
        $delete_query = mysqli_query($connection, $delete_category_query);
        confirm_query($delete_query);
        header("Location: admin_categories.php");
    }
}

/**
 * Listen's for the user to complete the editing, and updates the db accordingly.
 * It is called when a user has submitted their changes.
 * Called after listen_for_categorical_edits() is called.
 */
function listen_for_categorical_edits_completed() {
    global $connection;
    // User has expressed interest in SUBMITTING EDITS on a CATEGORY.
    if (isset($_GET['edit_submit'])) {
        $cat_id = htmlspecialchars($_GET['cat_id']);
        $cat_title = htmlspecialchars($_GET['cat_title']);
        
        // Flush the post.
        unset($_GET);
        
        $alter_category = "UPDATE categories SET cat_title='{$cat_title}' ";
        $alter_category .= "WHERE cat_id = '{$cat_id}'";
        $alter_category_result = mysqli_query($connection, $alter_category);
        confirm_query($alter_category_result);
       
        header("Location: admin_categories.php");
    }
}


/**
 * HELPER FUNCTIONS FOR admin_posts.php
 */
/**
 * Used to display all of the posts for admin_posts.php's include files - refer to 
 * what the parameter is to know which include files.
 * @global $connection $connection
 * @param type $edit_or_view: Are we from view_all_posts.php or view_edit_posts.php.
 * We either was trying to edit or view (with the option to delete). It will be either
 * 'view' or 'edit'
 */
function display_all_posts($edit_or_view) {
    global $connection;
    // DISPLAY CATEGORIES
    // Query db for all of the categories.
    $query = "SELECT posts.*, categories.cat_title "
            . "FROM posts "
            . "LEFT JOIN categories "
            . "ON posts.post_category_id = categories.cat_id";
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
        switch($edit_or_view) {
            case 'view':
                echo "<td><a href='admin_index.php?source=view_all_posts&delete={$post_id}'>Delete</a></td>";
                break;
            case 'edit':
                echo "<td><a href='admin_index.php?source=view_edit_posts&edit={$post_id}'>Edit</a></td>";
                break;
        }
            
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
/**
 * HELPER FUNCTIONS for admin_posts.php > view_all_posts.php.
 */
/**
 * Listen's for the user's intention to delete a post. From admin_posts.php > view_all_posts.php.
 * @global type $connection: connection object for mysql queries.
 */
function listen_for_post_deletion() {
    global $connection;
    if(isset($_GET['delete'])) {
        $post_id = htmlspecialchars($_GET['delete']);
        
        $query_delete_post = "DELETE FROM posts WHERE post_id = '{$post_id}'";
        
        $result_delete_post = mysqli_query($connection, $query_delete_post);
        
        confirm_query($result_delete_post);  
        
        unset($_POST);
    }
}

/**
 * HELPER FUNCTIONS FOR admin_posts.php > view_edit_posts.php
 */
/**
 * Listen for the user's intent to edit a post. Then generate the dynamic form.
 * @global $connection $connection
 */
function listen_for_post_edit() {
    global $connection;
    if (isset($_GET['edit'])) {
        $post_id = htmlspecialchars($_GET['edit']);
        unset($_GET['edit']);
        
        $query_post = "SELECT * FROM posts WHERE post_id = '{$post_id}'";
        $result_post_query = mysqli_query($connection, $query_post);
        confirm_query($result_post_query);
        
        $row = mysqli_fetch_assoc($result_post_query);
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
?>                                                                          
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title;?>">  
    </div>
    <div class="form-group">
        <select name="post_category_id" id="post_category_id">
            <?php select_category_options(); ?>
        </select>
    </div>        
    <div class="form-group">    
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author;?>"> 
    </div>        
    <div class="form-group">    
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php echo $post_status;?>"> 
    </div> 
    <div class="form-group">    
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags;?>"> 
    </div> 
    <div class="form-group">    
        <img width="100px" src="../images/<?php echo $post_image; ?>" alt="the image">
        <input type="file" name="post_image">
    </div>
     <div class="form-group">   
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="post_content" cols="30" rows="10"><?php echo $post_content; ?>
        </textarea>
    </div>
    <input type="hidden" name="post_id" value="<?php echo $post_id;?>">
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_post" value="Edit Post">                                
    </div>
</form>
<?php 
    } 
}
/**
 * Display the categories as a option in a select input. listen_for_post_edit()'s 
 * form helper function.
 * @global $connection $connection
 */
function select_category_options() {
    global $connection;
    $query = "SELECT * FROM categories";
    $query_categories = mysqli_query($connection, $query);
    confirm_query($query_categories);

    while ($row = mysqli_fetch_assoc($query_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<option value='{$cat_id}'>{$cat_title}</option>";
    }
}

/**
 * User has expressed intent of editing a post and has completed the editing process.
 * @global $connection $connection
 */
function listen_for_post_edit_complete() {
    global $connection;
    
    if (isset($_POST['edit_post'])) {
        $post_content     = htmlspecialchars($_POST['post_content']);
        $post_id          = htmlspecialchars($_POST['post_id']);
        $post_author      = htmlspecialchars($_POST['post_author']);
        $post_title       = htmlspecialchars($_POST['post_title']);
        $post_category_id = htmlspecialchars($_POST['post_category_id']);
        $post_status      = htmlspecialchars($_POST['post_status']);
        $post_image       = htmlspecialchars($_FILES['post_image']['name']);
        $post_image_temp  = htmlspecialchars($_FILES['post_image']['tmp_name']);
        $post_tags        = htmlspecialchars($_POST['post_tags']);
        unset($_POST);
        move_uploaded_file($post_image_temp, '../images/' . $post_image);
        
        $query_edit_post = "UPDATE posts "
                . "SET post_author = '{$post_author}', "
                . "post_title = '{$post_title}', "
                . "post_category_id = {$post_category_id}, "
                . "post_status = {$post_status}, "
                . "post_tags = '{$post_tags}', "
                . "post_image = 'images/{$post_image}', "
                . "post_content = '$post_content' "
                . "WHERE post_id = {$post_id}";
                
        $result_edit_post = mysqli_query($connection, $query_edit_post);
        confirm_query($result_edit_post);
    }
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


function display_all_comments() {
     global $connection;
    // DISPLAY COMMENTS
    // Query db for all of the comments.
    $query = "SELECT com.* "
            . "FROM comments as com";
    
    $select_comments_query = mysqli_query($connection, $query);
    confirm_query($select_comments_query);
    $comment = array();
    
    while ($rows = mysqli_fetch_assoc($select_comments_query)) {
        $comment = array();
        $comment['comment_id']      = $rows['comment_id'];
        $comment['comment_post_id'] = $rows['comment_post_id'];
        $comment['comment_author']  = $rows['comment_author'];
        $comment['comment_email']   = $rows['comment_email'];
        $comment['comment_content'] = $rows['comment_content'];
        $comment['comment_status']  = $rows['comment_status'];
        $comment['comment_date']    = $rows['comment_date'];

        echo "<tr>";
            echo "<td>{$comment['comment_author']}</td>";
            echo "<td>{$comment['comment_content']}</td>";
            echo "<td>{$comment['comment_email']}</td>";
            echo "<td>{$comment['comment_status']}</td>";
            echo "<td>Some Title</td>";
            echo "<td>{$comment['comment_date']}</td>";
            echo "<td><a href=\"admin_index.php?admin_comments={$comment['comment_id']}&delete\">Delete</a></td>";

            echo "<td><a href=\"admin_index.php?admin_comments={$comment['comment_id']}&unapprove\">Unapprove</a></td>";
            echo "<td><a href=\"admin_index.php?admin_comments={$comment['comment_id']}&approve\">Approve</a></td>";
            
            echo "<td><a href=\"admin_index.php.php?admin_comments={$comment['comment_id']}&edit\">Edit</a></td>";
        echo "</tr>";
    }
}


function listen_for_comment_action() {
    global $connection;
    $debug_stop = '';
    if ($cat_id = isset($_GET['approve'])) {
        listen_for_comment_approve($cat_id);
    }
    else if ($cat_id = isset($_GET['delete'])) {
        listen_for_comment_delete($cat_id);
    }
    else if ($cat_id = isset($_GET['edit'])) {
        listen_for_comment_edit($cat_id);
    }
}


function listen_for_comment_approve($cat_id) {
    PRINT "APPROVAL";
}
function listen_for_comment_edit($cat_id) {
    print "EDIT";
}
function listen_for_comment_delete($cat_id) {
    print "DELETE";
}


