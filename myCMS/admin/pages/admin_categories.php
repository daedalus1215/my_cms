    <div id="wrapper">
      <!-- All admin pages need to set this value, so the sidebar knows which one to select, based off of where the user is currently. -->
       <?php 
       $current_location = "admin_categories"; 
       ?>
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
                                <i class="fa fa-file"></i> Categories
                            </li>
                        </ol>
                    </div>
                </div> <!-- /.row -->
                <div class="row">
                    <div class="col-xs-6">
                    <?php listen_for_categorical_additions(); ?>                        
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input type="text" class="form-control" name="cat_title">                                
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="add_category" value="Add Category">                                
                            </div>
                        </form>

                    <?php listen_for_categorical_edits(); ?>
                    <?php listen_for_categorical_edits_completed(); ?>
                                                      
                    </div>
                    <div class="col-xs-6">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php display_all_categories(); ?>
                                <?php listen_for_categorical_deletes(); ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- /.container-fluid -->
        </div> <!-- /#page-wrapper -->
    </div> <!-- /#wrapper -->
