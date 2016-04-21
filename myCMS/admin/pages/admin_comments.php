<?php 
    listen_for_comment_action();
?>  

<div id="wrapper">
      <!-- All admin pages need to set this value, so the sidebar knows which one to select, based off of where the user is currently. -->
        <?php $current_location = "admin_posts_view"; ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Comments
                            </li>
                        </ol>
                    </div>
                </div> <!-- /.row -->

<table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Edit</th>
                      <th>Author</th>
                      <th>Comment</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>In Response to</th>
                      <th>Date</th>
                      <th>Unapprove</th>
                      <th>Approve</th>
                      <th>delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php display_all_comments(); ?>
                  </tbody>
                </table>
                
            </div> <!-- /.container-fluid -->
        </div> <!-- /#page-wrapper -->
    </div> <!-- /#wrapper -->
  