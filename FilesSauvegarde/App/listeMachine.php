<?php
session_start();
if(isset($_SESSION["id"] )) {
    require('../Metier/Machine.php');
    require('../Service/MachineService.php');
    $MachineS = new MachineService();
    $machines = $MachineS->findall();
}else{
    header('location: login.php');
}
?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style>
    body{
        background-color: #f4f7f6;
        margin-top:20px;
    }
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
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 10%);
    }

    a:hover {
        text-decoration:none;
    }
</style>
<div id="main-content" class="file_manager">
    <div class="container">
        <div class="row clearfix">

            <?php foreach ($machines as $item){ ?>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <div class="card">
                    <div class="file">


                            <div >
                              <a href="uploadfile.php?id=<?php echo $item[0] ?>">  <button type="button" onclick="window.location.href('machine.php');" class="btn btn-icon btn-success">
                                    <i class="fa fa-plus-square"></i>
                                </button></a>
                                <button type="button" class="btn btn-icon btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <div class="icon">
                                <img src="upload/chaise-plastique-de-restaurant1.jpg" height="200px" width="100%">
                            </div>
                            <div class="file-name">
                                <p class="m-b-5 text-muted"><?php echo $item[2] ?></p>
                                <small>Ref : <?php echo $item[2] ?> <span class="date text-muted">Nov 02, 2017</span></small>
                            </div>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

    </div>
</div>
