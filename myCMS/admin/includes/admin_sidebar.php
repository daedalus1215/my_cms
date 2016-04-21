            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="admin_index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li class="<?php ($current_location === 'admin_posts_view') ? print 'active': ''; ?>">
                        <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="posts_dropdown" class="collapse">
                            <li class="<?php ($current_location === 'admin_posts_view') ? print 'active': ''; ?>">
                                <a href="admin_index.php?source=view_post " class="<?php ($current_location === 'admin_posts_view') ? print 'active': ''; ?>">View Posts</a>
                            </li>
                            <li>
                                <a href="admin_index.php?source=add_post">Add Post</a>
                            </li>
                            <li>
                                <a href="admin_index.php?source=view_edit_posts">Edit Posts</a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php ($current_location === 'admin_categories') ? print 'active': '' ?>">
                        <a href="admin_index.php?admin_categories"><i class="fa fa-fw fa-wrench"></i> Categories</a>
                    </li>
                    <li class="<?php ($current_location === 'admin_comments') ? print 'active': '' ?>">
                        <a href="admin_index.php?admin_comments"><i class="fa fa-fw fa-file"></i> Comments</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo_dropdown" class="collapse">
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                            <li>
                                <a href="#">Dropdown Item</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="bootstrap-grid.html"><i class="fa fa-fw fa-dashboard"></i> Profile</a>
                    </li>
                </ul>
            </div> <!-- /.navbar-collapse -->

