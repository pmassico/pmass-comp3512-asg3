<header>
        <div class="topHeaderRow">
            <div class="container">
                <div class="pull-right">
                    <ul class="list-inline">
                        <?php 
                        if (isset($_COOKIE['login'])) {?>
                            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        <?php } else { ?>
                            <li><a href="login.php"><span class="glyphicon glyphicon-log-out"></span> Login</a></li>
                        <?php } ?>
                        <li><a href="user-profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                        <li><a href="favourites.php"><span class="glyphicon glyphicon-star"></span> Favorites</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end topHeaderRow -->


        <nav class="navbar navbar-default ">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">Share Your Travels</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="aboutus.php">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Browse <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="browse-Countries.php">countries</a></li>
                                <li><a href="browse-Images.php">images</a></li>
                                <li><a href="browse-Users.php?">users</a></li>
                                <li><a href="browse-Posts.php?page=1">posts</a></li>
                            </ul>
                        </li>
                    </ul>


                    <form id="header-search" action="browse-Images.php" method="get" class="navbar-form navbar-right disappear" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="search">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <!-- /.navbar-collapse -->


            </div>
            <!-- /.container-fluid -->
        </nav>
    </header>