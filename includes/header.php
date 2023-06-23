<?php

use model\UsersTypes;

function creerDossierUtilisateur($nomUtilisateur)
{
    $cheminDossier = "includes/assets/images/profiles/" . $nomUtilisateur;

    if (!file_exists($cheminDossier)) {
        // Créer le dossier avec les permissions appropriées (par exemple, 0777 pour des permissions complètes)
        mkdir($cheminDossier, 0777, true);
    }
}

creerDossierUtilisateur($_SESSION['user_id']);


$isLaragon = "";
if ($_SERVER['HTTP_HOST'] == "localhost") {
    $isLaragon = "/chaliceMVC";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chalice</title>
    <link href="<?php echo $isLaragon ?>/includes/assets/css/images.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="<?php echo $isLaragon ?>/includes/assets/js/functions.js"></script>
    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">

    <!-- Common -->
    <link href="includes/assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="includes/assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="includes/assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="includes/assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="includes/assets/css/lib/helper.css" rel="stylesheet">
    <link href="includes/assets/css/style.css" rel="stylesheet">
    <link href="includes/assets/css/lib/jsgrid/jsgrid-theme.min.css" rel="stylesheet"/>
    <link href="includes/assets/css/lib/jsgrid/jsgrid.min.css" type="text/css" rel="stylesheet"/>


</head>
<body>


<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <div class="logo"><a href="main.php"><img src="includes/assets/images/logo.png" width="50px" height="50px"
                                                      alt=""/>
                    <span>Chalice Admin</span></a>
            </div>
            <ul>

                <?php
                if ($_SESSION['type_id'] == UsersTypes::TYPE_ADMIN) { ?>
                    <li><a class="sidebar-sub-toggle"><i class="ti-user"></i> Users <span
                                    class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>

                            <li><a href="?view=user">Liste Users</a></li>
                            <li><a href="?view=user&action=add">Add User</a></li>
                            <li><a href="?view=profile">Profile</a></li>

                        </ul>
                    </li>
                <?php } ?>
                <li><a class="sidebar-sub-toggle"><i class="ti-files"></i> News <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="?view=news">Liste News</a></li>
                        <li><a href="?view=news&action=add">Add News</a></li>
                    </ul>
                </li>
                <?php
                if ($_SESSION['type_id'] == UsersTypes::TYPE_ADMIN) { ?>
                    <li><a class="sidebar-sub-toggle"><i class="ti-target"></i> Types <span
                                    class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="?view=type">Liste Types</a></li>
                            <li><a href="?view=type&action=add">Add Type</a></li>

                        </ul>
                    </li>
                <?php } ?>

                <li><a class="sidebar-sub-toggle"><i class="ti-image"></i> Images <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                    <ul>
                        <li><a href="?view=image">Liste Images</a></li>
                        <li><a href="?view=image&action=add">Add Image</a></li>
                    </ul>
                </li>

                <li><a href="?action=logout"><i class="ti-close"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-left">
                    <div class="hamburger sidebar-toggle">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </div>
                </div>
                <div class="float-right">
                    <div class="dropdown dib">
                        <div class="header-icon" data-toggle="dropdown">
                            <i class="ti-bell"></i>
                            <div class="drop-down dropdown-menu dropdown-menu-right">
                                <div class="dropdown-content-heading">
                                    <span class="text-left">Recent Notifications</span>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="includes/logout.php">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/3.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Mr. John</div>
                                                    <div class="notification-text">6 members joined today</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/3.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Mariam</div>
                                                    <div class="notification-text">likes a photo of you</div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/3.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Tasnim</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you
                                                        ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/3.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Mr. John</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you
                                                        ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="text-center">
                                            <a href="#" class="more-link">See All</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown dib">
                        <div class="header-icon" data-toggle="dropdown">
                            <i class="ti-email"></i>
                            <div class="drop-down dropdown-menu dropdown-menu-right">
                                <div class="dropdown-content-heading">
                                    <span class="text-left">2 New Messages</span>
                                    <a href="email.html">
                                        <i class="ti-pencil-alt pull-right"></i>
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/1.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Michael Qin</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you
                                                        ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/2.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Mr. John</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you
                                                        ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/3.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Michael Qin</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you
                                                        ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img class="pull-left m-r-10 avatar-img"
                                                     src="includes/assets/images/avatar/2.jpg" alt=""/>
                                                <div class="notification-content">
                                                    <small class="notification-timestamp pull-right">02:34 PM</small>
                                                    <div class="notification-heading">Mr. John</div>
                                                    <div class="notification-text">Hi Teddy, Just wanted to let you
                                                        ...
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="text-center">
                                            <a href="#" class="more-link">See All</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown dib">
                        <div class="header-icon" data-toggle="dropdown">
                                <span class="user-avatar"><?php echo $_SESSION['login']; ?>
                                    <i class="ti-angle-down f-s-10"></i>
                                </span>
                            <div class="drop-down dropdown-profile dropdown-menu dropdown-menu-right">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="profiles.php">
                                                <i class="ti-user"></i>
                                                <span>Profile</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ti-email"></i>
                                                <span>Inbox</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ti-settings"></i>
                                                <span>Setting</span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ti-lock"></i>
                                                <span>Lock Screen</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="includes/logout.php">
                                                <i class="ti-power-off"></i>
                                                <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>Hello, <span>Welcome Here</span></h1>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div id="main-content">
                        <div class="row">
                            <div class="col-lg-12">
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>











