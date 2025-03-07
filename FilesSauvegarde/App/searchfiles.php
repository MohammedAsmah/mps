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
        header('location: searchfiles.php?id=' . $_GET["id"] . '&idarticle=' . $idarticle);

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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<style>
    body {
        padding-top:20px;
        background:#eee;
    }
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

<div class="container bootstrap snippets bootdey">
    <div class="row">
        <div >
            <div class="panel panel-primary">
                <div class="panel-heading" align="center">
                    <h3 class="panel-title">
                        <span class="glyphicon glyphicon-bookmark"></span> Bonjour Mr : <?php echo $_SESSION["nomComplet"] ?></h3>
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div align="center">
                            <a href="addmachine.php" class="btn btn-success btn-lg" role="button"><span class="glyphicon  glyphicon-plus"></span> <br/>Machine</a>
                            <a href="addarticle.php" class="btn btn-success btn-lg" role="button"><span class="glyphicon glyphicon-paperclip"></span> <br/>Article</a>
                            <a href="index.php" class="btn btn-info btn-lg" role="button"><span class="glyphicon glyphicon-list"></span> <br/>Liste</a>
                            <a href="logout.php" class="btn btn-danger btn-lg" role="button"><span class="glyphicon glyphicon-log-out"></span> <br/>Log out</a>

                        </div>
                        <br>
                        <hr>
                        <div class="col-lg-12  col-sm-12" align="center">
                            <div class="card" >
                                <div class="file">
                                    <div align="center" >
                                        <img src="<?php echo $machine[3]?>" width="200px" height="200px">
                                    </div>
                                </div>
                                <div class="card"  >
                                    <div class="file" >
                                        <div align="center" >
                                            <label>la machine est : <?php echo $machine[2]?></label>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        <div class="container" align="center">
                            <div class="panel panel-default">
                                <div class="panel-heading"><strong> Upload fichiers </strong> <small></small></div>
                                <div class="panel-body">
                                    <h4>Veuillez selectionner l'article svp :</h4>
                                    <form action="searchfiles.php?id=<?php echo $_GET["id"] ?>" method="post" enctype="multipart/form-data" >
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <select class="form-group" name="select">
                                                    <?php foreach ($listarticle as $item){?>
                                                    <option <?php if(isset($_GET["idarticle"])){ if($_GET["idarticle"]==$item[0]){?>selected<?php } }?> value="<?php echo $item[0]?>"><?php echo $item[1]?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <br><br>

                                            <input type="submit" value="search" class="btn btn-sm btn-primary">
                                    </form>
                                   <?php if(isset($_GET["idarticle"])){?><a href="uploadfiles.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo $_GET["idarticle"] ?>"> <input type="button" value="add" class="btn btn-sm btn-success"></a><?php } ?>
                                    <div class="js-upload-finished">
                                        <HR> <HR> <HR>
                                        <div class="list-group">
                                            <?php if($produit != null){
                                                foreach ($produit as $item){
                                                    if($item != null){
                                                        $img = explode('/',$item["Chemin"]);
                                                        if($item["Chemin"] != null){
                                                            ?><a href="<?php echo $item["Chemin"] ?>" target="_blank" class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">disponible</span><?php echo $img[1]  ?> &nbsp;<label style="color: red"> date : <?php echo $item["date"]?></label> </a>
                                                            <?php
                                                        }else{
                                                            ?><a href="#"class="list-group-item list-group-item-success"><span class="badge alert-success pull-right">lien indisponible</span><em> Cycle : <?php echo $item["cycle"]?> &nbsp;Poids : <?php echo $item["poids"]?> </em><label style="color: red">&nbsp; date : <?php echo $item["date"]?></label></a> <?php
                                                        }
                                                    }
                                                    ?>
                                                <?php }
                                            }else{
                                                ?>    <a href="#" class="list-group-item list-group-item-danger"><span class="badge alert-danger pull-right"></span>liste vide !!</a>
                                                <?php
                                            }?>
                                        </div>
                                    </div>
                                    <HR> <HR> <HR>
                                    <?php if(!isset($_GET["idarticle"])){?>
                                    <div class="paginatoin-area">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <ul class="pagination-box">
                                                    <nav>
                                                        <ul class="pagination">
                                                            <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                                                <a href="searchfiles.php?id=<?php echo $_GET["id"] ?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                                                            </li>
                                                            <?php for($page = 1; $page <= $pages; $page++): ?>
                                                                <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                                                    <a href="searchfiles.php?id=<?php echo $_GET["id"] ?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                                                </li>
                                                            <?php endfor ?>
                                                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                                                <a href="searchfiles.php?id=<?php echo $_GET["id"] ?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php  } else{
                                        ?>

                                        <div class="paginatoin-area">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <ul class="pagination-box">
                                                        <nav>
                                                            <ul class="pagination">
                                                                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                                                                    <a href="searchfiles.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo  $_GET["idarticle"]?>&page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                                                                </li>
                                                                <?php for($page = 1; $page <= $pages; $page++): ?>
                                                                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                                                        <a href="searchfiles.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo  $_GET["idarticle"]?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                                                                    </li>
                                                                <?php endfor ?>
                                                                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                                                                    <a href="searchfiles.php?id=<?php echo $_GET["id"] ?>&idarticle=<?php echo  $_GET["idarticle"]?>&page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>