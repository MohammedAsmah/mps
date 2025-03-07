<?php
session_start();
if(isset($_SESSION["id"] )) {
    require('../Metier/Machine.php');
    require('../Service/MachineService.php');
    $MachineS = new MachineService();
    if(!isset($_GET["like"]) || $_GET["like"] == null) {
        $machines = $MachineS->findallarticle();
        $nbrproduit = $MachineS->findcountarticle();
        //$produit = $global_service->findallproduit();
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int)strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        $nbrproduit = (int)$MachineS->findcountarticle();
        $parPage = 32;
        $pages = ceil($nbrproduit / $parPage);
        $premier = ($currentPage * $parPage) - $parPage;

        $produit1 = $machines;
        $produit = $MachineS->findallarticlepagination1($premier, $parPage);
    }else{
        $produit = $MachineS->findbyidwherenomlikearticle(strtolower('%'.$_GET["like"].'%'));
    }
}else{
    header('location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="mps.jpg" type="image/png">
    <title>Liste Articles</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .panel-body .btn:not(.btn-block) { width:120px;margin-bottom:10px; }
    .file_manager .file a:hover .hover,
    .file_manager .file .file-name small{
        display: block
    }
    .file_manager .file {
        padding: 0 !important
    }

    .file_manager .file .icon{
        text-align: center
    }


    .file_manager .file {
        position: relative;
        border-radius: .55rem;
        overflow: hidden
    }

    .file_manager .file .image,
    .file_manager .file .icon {
        max-height: 180px;
        overflow: hidden;
        background-size: cover;
        background-position: top
    }

    .file_manager .file .hover {
        position: absolute;
        right: 10px;
        top: 10px;
        display: none;
        transition: all 0.2s ease-in-out
    }

    .file_manager .file a:hover .hover {
        transition: all 0.2s ease-in-out
    }

    .file_manager .file .icon {
        padding: 15px 10px;
        display: table;
        width: 100%
    }

    .file_manager .file .icon i {
        display: table-cell;
        font-size: 30px;
        vertical-align: middle;
        color: #777;
        line-height: 100px
    }

    .file_manager .file .file-name {
        padding: 10px;
        border-top: 1px solid #f7f7f7
    }

    .file_manager .file .file-name small .date {
        float: right
    }

    .folder {
        padding: 20px;
        display: block;
        color: #777
    }

    @media only screen and (max-width: 992px) {
        .file_manager .nav-tabs {
            padding-left: 0;
            padding-right: 0
        }
        .file_manager .nav-tabs .nav-item {
            display: inline-block
        }
    }

    .card {
        background: #fff;
        transition: .5s;
        border: 0;
        margin-bottom: 30px;
        border-radius: .55rem;
        position: relative;
        width: 100%;

    }

    a:hover {
        text-decoration:none;
    }
</style>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Mps<sup>Plastique</sup></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="index.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Home</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#headingone"
               aria-expanded="true" aria-controls="headingone">
                <i class="fas fa-fw fa-cog"></i>
                <span>Machine</span>
            </a>
            <div id="headingone" class="collapse" aria-labelledby="headingone" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Action :</h6>
                    <a class="collapse-item" href="addmachine.php">Ajouter Machine</a>
                    <a class="collapse-item" href="index.php">Liste Machine</a>
                    <a class="collapse-item" href="editmachine.php" hidden>Update Machine</a>

                </div>
            </div>
        </li>
        <li class="nav-item active">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Articles</span>
            </a>
            <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Action :</h6>
                    <a class="collapse-item" href="addarticle.php">Ajouter Article</a>
                    <a class="collapse-item" href="listearticle.php">Liste Article</a>
                    <a class="collapse-item" href="editmachine.php" hidden>Update article</a>

                </div>
            </div>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["nomComplet"] ?></span>
                            <img class="img-profile rounded-circle"
                                 src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">

                            <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800" align="center">Liste des articles </h1>
                <div id="main-content" class="file_manager" >
                    <div align="center">
                        <form ACTION="listearticle.php" method="GET">
                            <input type="text" name="like" id="txtpname"   width="30%">
                            <input type="submit" class=".btn-circle" style="background-color: blue" value="Search">
                        </form>
                        <br>
                        <hr>
                    </div>
                    <div class="container">
                        <div class="row clearfix">

                            <?php foreach ($produit as $item){ ?>
                                <div class="col-lg-3 col-md-5 col-sm-12">
                                    <div class="card"  style="background-color: lightgrey">
                                        <div class="file">


                                            <div  align="center" >
                                                <a href="editarticle.php?ida=<?php echo $item["id"] ?>">   <button type="button" class="btn btn-icon btn-info">
                                                        <i class="fas fa-edit"></i>
                                                    </button></a>
                                                <a href="deletearticle.php?id=<?php echo $item["id"] ?>">   <button type="button" class="btn btn-icon btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button></a>

                                            </div>
                                            <div class="icon">
                                                <img src="<?php echo $item["image"] ?>" height="200px" width="100%">
                                            </div>
                                            <div class="file-name" align="center">
                                                <p class="m-b-5 text-muted">Nom : <b><?php echo $item["nom"] ?></b></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>

            </div>
            <div class="paginatoin-area">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <ul class="pagination-box">
                            <nav>
                                <?php if(!isset($_GET["like"]) || $_GET["like"] == null){ ?>
                                <ul class="pagination">
                                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                        <?php if($currentPage - 1 != 0 ){ ?>
                                            <a href="listearticle.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                                        <?php } ?>
                                    </li>

                                    <?php
                                    if($currentPage > 6 ){ ?>
                                        <li class="page-item">
                                            <a href="listearticle.php?page=<?= $currentPage - 3 ?>" class="page-link" class="page-link">..</a>
                                        </li>
                                        <?php
                                    }

                                    for ($page = $currentPage - 3; $page <= $currentPage + 3 ; $page++): ?>
                                        <?php

                                        if($page > 0 && $page <= $pages) {
                                            ?>

                                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                                <a href="listearticle.php?page=<?= $page ?>"
                                                   class="page-link"><?= $page ?></a>
                                            </li>

                                        <?php } ?>
                                    <?php endfor;  ?>
                                    <?php
                                    if($currentPage <= $pages - 4){ ?>
                                        <li class="page-item">
                                            <a  href="listearticle.php?page=<?= $currentPage + 3 ?>" class="page-link" class="page-link">..</a>
                                        </li>
                                    <?php } ?>
                                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                        <a href="listearticle.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                                    </li>
                                </ul>
                                <?php } ?>
                            </nav>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; MPS *H* </span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">voulez vous vraiment vous déconnecter ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Si oui cliquez sur "Oui"</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <a class="btn btn-primary" href="logout.php">Oui</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

</body>

</html>