<?php
    require_once 'req/sql_details.php';
    require_once 'req/create_head.php';
    require_once 'req/check_login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
?>

<!DOCTYPE html>
<html lang='sv'>
<?php create_head('Admin-panel') ?>
<body>
<div class='container-fluid m-t-100'>
<div class='row'>
<div class='col-lg-3 col-md-2'>
</div>
<div class='col-lg-6 col-md-8'>
<!---->
<?php require_once 'req/menu.php'; ?>

    <div class='container-fluid'>
        <div class='row text-center'>
            <div class='col-sm-3'>
                <button type="button" class="btn btn-primary">Lägg till produkt</button>
            </div>
            <div class='col-sm-3'>
                <button type="button" class="btn btn-warning">Ändra produktinformation</button>
            </div>
            <div class='col-sm-3'>
                <button type="button" class="btn btn-danger">Ta bort produkt</button>
            </div>
            <div class='col-sm-3'>
                <button type="button" class="btn btn-info">Ändra öppettider</button>
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

<?php $connection->close(); ?>