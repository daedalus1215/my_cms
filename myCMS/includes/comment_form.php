<div class="form-wrapper">
  <form class="form-inline" action="index.php?post_id=<?php echo $post_id; ?>" method="POST">
  <input type="hidden" name="post_id" value="<?php echo $post_id; ?>"></input>       
  <div class="form-group">
    <label class="sr-only">Email</label>
    <p class="form-control-static"><span class="comment-title">Leave a Comment</span></p>
  </div><br/>
  <div class="form-group">
      <textarea name="comment_content" id="comment" cols="100" rows="3"></textarea><br/>
  </div>
  <button type="submit" class="btn btn-primary comment-btn" name="add_comment">Submit</button>
</form>
    </div>