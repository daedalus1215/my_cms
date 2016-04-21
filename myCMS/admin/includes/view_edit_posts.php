<?php 
    listen_for_post_edit_complete();
    listen_for_post_edit(); 
?>
<table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Action</th>
                      <th>Author</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Status</th>
                      <th>Image</th>
                      <th>Tags</th>
                      <th>Comments</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php display_all_posts('edit'); ?>
                  </tbody>
                </table>
