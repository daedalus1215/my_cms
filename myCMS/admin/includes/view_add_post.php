<?php listen_for_post_addition(); ?>
<?php listen_for_post_generation(); ?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">  
    </div>
    <div class="form-group">
        <select id="post_category_id" name="post_category_id">
            <?php select_category_options(); ?>
        </select>
    </div>        
    <div class="form-group">    
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author"> 
    </div>        
    <div class="form-group">    
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status"> 
    </div> 
    <div class="form-group">    
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags"> 
    </div> 
    <div class="form-group">    
        <label for="post_image">Post Image</label>
        <!-- MAX_FILE_SIZE must precede the file input field -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" name="post_image">
    </div>
     <div class="form-group">   
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_post" value="Publish Post">                                
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="generate_post" value="Generate Post">
    </div>
</form>





