<?php
session_start();
if(isset($_SESSION["id"] )) {
    require('../Metier/Machine.php');
    require('../Service/MachineService.php');
    $MachineS = new MachineService();
    $machine = $MachineS->findbyid($_GET["id"]);
    $listarticle = $MachineS->findallarticle();
    if (isset($_GET["idarticle"])) {
        $nbrproduit = $MachineS->findcountfilesarticle($_GET["id"], $_GET["idarticle"]);
        //$produit = $global_service->findallproduit();
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int)strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        $nbrproduit = (int)$MachineS->findcountfilesarticle($_GET["id"], $_GET["idarticle"]);
        $parPage = 5;
        $pages = ceil($nbrproduit / $parPage);
        $premier = ($currentPage * $parPage) - $parPage;

        $produit1 = $listarticle;
        $produit = $MachineS->findallarticlepagination($premier, $parPage, $_GET['id'], $_GET["idarticle"]);

    } else {
        $listeMachine = $MachineS->findallclause($_GET["id"]);
        $nbrproduit = $MachineS->findcountfiles($_GET["id"]);
        //$produit = $global_service->findallproduit();
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int)strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        $nbrproduit = (int)$MachineS->findcountfiles($_GET["id"]);
        $parPage = 15;
        $pages = ceil($nbrproduit / $parPage);
        $premier = ($currentPage * $parPage) - $parPage;

        $produit1 = $listeMachine;
        $produit = $MachineS->findallmachinepagination($premier, $parPage, $_GET['id']);
    }
    if (isset($_GET["id"])) {


    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $idarticle = $_POST["select"];
        header('location: searchforfile.php?id=' . $_GET["id"] . '&idarticle=' . $idarticle);

        /*
        $nbrproduit = $MachineS->findcountfilesarticle($_GET["id"],$_POST["select"]);
        //$produit = $global_service->findallproduit();
        if(isset($_GET['page']) && !empty($_GET['page'])){
            $currentPage = (int) strip_tags($_GET['page']);
        }else{
            $currentPage = 1;
        }
        $nbrproduit =  (int)  $MachineS->findcountfilesarticle($_GET["id"],$_POST["select"]);
        $parPage = 2;
        $pages = ceil($nbrproduit / $parPage);
        $premier = ($currentPage * $parPage) - $parPage;

        $produit1 = $listeMachine;
        $produit = $MachineS->findallarticlepagination($premier,$parPage,$_GET['id'],$_POST["select"]);
        var_dump($produit);
        */
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

    <title>SB Admin 2 - Blank</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                   aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Articles</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Action :</h6>
                        <a class="collapse-item" href="addarticle.php">Ajouter Article</a>
                        <a class="collapse-item" href="listearticle.php">Liste Article</a>
                        <a class="collapse-item" href="editmachine.php" hidden>Update article</a>

                    </div>
                </div>
            </li>


            <!-- Divider -->
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

                <!-- Topbar -->
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

                    <div class="row gutters-sm">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="<?php echo $machine[3]?>" alt="Admin" class="rounded-circle" width="150">
                                        <div class="mt-3">
                                            <h4><label style="color: black">la machine est : <?php echo $machine[2]?></label></h4>
                                            <h4>Veuillez selectionner l'article svp :</h4>
                                            <form action="searchforfile.php?id=<?php echo $_GET["id"] ?>" method="post" enctype="multipart/form-data" >
                                                <div class="mx-auto"  >
                                                    <div class="form-group">
                                                        <select class="form-group" name="select" >
                                                            <?php foreach ($listarticle as $item){?>
                                                                <option <?php if(isset($_GET["idarticle"])){ if($_GET["idarticle"]==$item[0]){?>selected<?php } }?> value="<?php echo $item[0]?>"><?php echo $item[1]?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <input type="submit" value="search" class="btn btn-sm btn-primary">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-body" align="center">
                                    <?php if(isset($_GET["idarticle"])){?><a href="uploadfiles.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo $_GET["idarticle"] ?>"> <input type="button" value="Ajouter Fichier" class="btn btn-sm btn-success"></a><?php } ?>
                                    <hr>
                                    <div class="js-upload-finished">
                                        <div class="list-group">
                                            <table class="table">

                                                <?php if($produit != null){
                                                foreach ($produit as $item){
                                                    if($item != null) {
                                                        $img = explode('/', $item["Chemin"]);
                                                        if ($item["Chemin"] != null) {
                                                            ?>
                                                            <tr>
                                                                <td scope="col"><?php echo $img[1] ?></td>
                                                                <td scope="col"><label style="color: red">

                                                                        <b>Article
                                                                            : <?php $art = $MachineS->findarticlebyid($item["idarticle"]);
                                                                            echo $art[1];
                                                                            ?>
                                                                </td>
                                                                <td  style="color: red">
                                                                    <b> date
                                                                        : <?php echo $item["date"] ?></b>
                                                                </td>
                                                                <td scope="col"><a href="<?php echo $item["Chemin"] ?>" target="_blank">Download</a>&nbsp;<a
                                                                            href="deletefile.php?ids=<?php echo $item["id"] ?>&&id=<?php  echo $_GET['id']?>&&idarticle=<?php echo $art[0]?>&&chemin=<?php echo $item['Chemin']?>">Suppression</a></td>

                                                            </tr>


                                                            <?php
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td scope="col"><em> Cycle
                                                                        : <?php echo $item["cycle"] ?> Poids
                                                                        : <?php echo $item["poids"] ?>
                                                                        &nbsp;</em><label
                                                                            style="color: red">&nbsp; </label>
                                                                </td>
                                                                <td scope="col"><label style="color: red">

                                                                        <b>Article
                                                                            : <?php  $art = $MachineS->findarticlebyid($item["idarticle"]);
                                                                            echo $art[1];
                                                                            ?>
                                                                </td>
                                                                <td  style="color: red">
                                                                    <b> date
                                                                        : <?php echo $item["date"] ?></b>
                                                                </td>
                                                                <td scope="col"><a href="">Download</a>&nbsp;<a
                                                                            href="deletefile.php?ids=<?php echo $item["id"] ?>&&id=<?php echo $_GET['id']?>&&idarticle=<?php echo $_GET['idarticle']?>">Suppression</a></td>
                                                            </tr>

                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </table>

                                            <?php
                                            }else{
                                                ?>    <a href="#" class="list-group-item list-group-item-danger"><span class="badge alert-danger pull-right"></span>liste vide !!</a>
                                                <?php
                                            }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                    <HR> <HR> <HR>
                    <?php if(!isset($_GET["idarticle"])){  if($produit != null){?>
                        <div class="paginatoin-area" align="center">
                            <div class="row">
                                <div class="col-md-12">
                                </div>
                                <div class="col-md-12">
                                    <ul class="pagination-box">
                                        <nav>
                                            <ul class="pagination">
                                                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                                    <a href="searchforfile.php?id=<?php echo $_GET["id"] ?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                                                </li>
                                                <?php for($page = 1; $page <= $pages; $page++): ?>
                                                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                                        <a href="searchforfile.php?id=<?php echo $_GET["id"] ?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                                    </li>
                                                <?php endfor ?>
                                                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                                    <a href="searchforfile.php?id=<?php echo $_GET["id"] ?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php }  } else{  if($produit != null){
                        ?>
                        <div class="paginatoin-area">
                            <div class="row">
                                <div class="col-md-12">
                                </div>
                                <div class="col-md-12">
                                    <ul class="pagination-box">
                                        <nav>
                                            <ul class="pagination">
                                                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                                    <a href="searchforfile.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo  $_GET["idarticle"]?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                                                </li>
                                                <?php for($page = 1; $page <= $pages; $page++): ?>
                                                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                                        <a href="searchforfile.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo  $_GET["idarticle"]?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                                    </li>
                                                <?php endfor ?>
                                                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                                    <a href="searchforfile.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo  $_GET["idarticle"]?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php }
                    }?>
                </div>
            </div>
        </div>
                <!-- /.container-fluid -->
                </div>
            </div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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