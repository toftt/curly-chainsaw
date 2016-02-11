<?php
    require_once 'req/create_head.php';
?>

<!DOCTYPE html>
<html lang='sv'>
<?php create_head('Möbler') ?>
<body>
<div class='container-fluid'>
<div class='row'>
<div class='col-lg-3 col-md-2'>
</div>
<div class='col-lg-6 col-md-8'>
<!---->
<?php require_once 'req/menu.php'; ?>

    <div class='container-fluid'>
        <div class='row'>
            <div class='col-xs-12 no-padding'>
                <div class='well'>
                    <h2 class='no-margin'>Loungegrupper</h2>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-3'>
                <img class='img-responsive center-block img-thumbnail' src='one.jpg'>
                <div class="panel panel-default">
                    <div class="panel-body">Queen</div>
                </div>
            </div>
            <div class='col-sm-3'>
                <img class='img-responsive center-block img-thumbnail' src='two.jpg'>
                <div class="panel panel-default">
                    <div class="panel-body">Boston</div>
                </div>
            </div>
            <div class='col-sm-3'>
                <img class='img-responsive center-block img-thumbnail' src='three.jpg'>
                <div class="panel panel-default">
                    <div class="panel-body">Paris a Mozks</div>
                </div>
            </div>
            <div class='col-sm-3'>
                <img class='img-responsive center-block img-thumbnail' src='four.jpg'>
                <div class="panel panel-default">
                    <div class="panel-body">Virudella</div>
                </div>
            </div>
        </div>
        </div>

    </div>
<!---->
</div>
<div class='col-lg-3 col-md-2'>
</div>
</div>
</div>
</body>
</html>