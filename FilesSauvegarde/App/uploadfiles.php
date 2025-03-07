<?php
session_start();
if(isset($_SESSION["id"] )) {
    require('../Metier/Machine.php');
    require('../Service/MachineService.php');
    $MachineS = new MachineService();
    $machine = $MachineS->findbyid($_GET["id"]);

    if (isset($_GET["id"])) {
        $listeMachine = $MachineS->findallclause($_GET["id"]);
        $nbrproduit = $MachineS->findcountfiles($_GET["id"]);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $date = $_POST["date"];
        $cycle = $_POST["cycle"];
        $poids = $_POST["poids"];
        $filecount = count($_FILES['files']['name']);
        if ($filecount != null) {
            $img = "";
            for ($i = 0; $i <= $filecount; $i++) {
                if (isset($_FILES['files']['name'][$i])) {
                    $upload_image = $_FILES["files"]["name"][$i];
                    if ($upload_image != null) {
                        $folder = "upload/";
                        move_uploaded_file($_FILES["files"]["tmp_name"][$i], "$folder" . $_FILES["files"]["name"][$i]);
                        $image = $folder . $upload_image;
                        $img = $img . $image;
                    }
                }
            }
            if ($MachineS->checkfile($img) && $img != null) {
                ?>
                <script>alert('File name exist deja !!!')</script><?php
            } else {

                if ($MachineS->add1($_GET["id"], $img, $_GET["idarticle"], $date, $cycle, $poids)) {
                    header('location: searchforfile.php?id=' . $_GET["id"] . '&idarticle=' . $_GET["idarticle"]);
                }
            }
        }
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
    <title>Upload files</title>

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

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><label>Article : <em><?php echo $_GET["idarticle"] ?>  _  <?php $article = $MachineS->findarticlebyid($_GET["idarticle"]);
                                        echo  $article[1] ;?></em></label></h1>
                                    </div>
                                    <div>

                                    </div>

                                    <form class="user" action="uploadfiles.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo $_GET["idarticle"]?>" method="post" enctype="multipart/form-data">
                                        <div class="form-inline">
                                            <br><br>
                                            <div class="form-inline">
                                                <div class="form-group">
                                                    <input type="file" name="files[]" id="js-upload-files" >
                                                </div>
                                                <br><br>
                                                <input type="date" name="date"  value="<?php print(date("Y-m-d"))?>" placeholder="Veuillez saisir la date" class="form-group">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" name="cycle" placeholder="Veuillez saisir le Cycle" class="form-group">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="text" name="poids" placeholder="Veuillez saisir le Poids" class="form-group">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                            </div>
                                            <br>

                                        <input type="submit"  name="action" value="upload" type="submit" class="btn btn-primary btn-user btn-block" >
                                    </form>
                                    <hr>

                                    <div class="text-center">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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