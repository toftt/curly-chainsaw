<?php
    require_once 'req/sql_details.php';
    require_once 'req/create_head.php';
    require_once 'req/check_login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $query = "SELECT * FROM products ORDER BY name";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
    $rows = $result->num_rows;
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
            <div class='col-sm-3 m-t-20'>
                <a href="manage_info.php?mode=add" class="btn btn-primary btn-block">Lägg till produkt</a>
            </div>
            <div class='col-sm-3 m-t-20'>
                <button id="col2-btn" type="button" class="btn btn-warning btn-block" data-toggle="collapse" data-target="#col2">Ändra produkt</button>
                <div id='col2' class='collapse text-left'>
                    <div class='list-group'>
                    <a href='#' class='list-group-item'>
                    <input id='search_input2' class='border-none w-100 no-outline' type='text'>
                    </a>
                    <?php
                        for ($j = 0; $j < $rows ; ++$j)
                        {
                            $result->data_seek($j);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $tmp_name = $row['name'];
                            $tmp_product_id = $row['product_id'];
                            echo "<a href='manage_info.php?product_id=$tmp_product_id&mode=edit' class='list-group-item'>$tmp_name</a>";
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class='col-sm-3 m-t-20'>
                <button id="col3-btn" type="button" class="btn btn-danger btn-block" data-toggle="collapse" data-target="#col3">Ta bort produkt</button>
                <div id='col3' class='collapse text-left'>
                    <div class='list-group'>
                    <a href='#' class='list-group-item'>
                    <input id='search_input3' class='border-none w-100 no-outline' type='text'>
                    </a>
                    <?php
                        for ($j = 0; $j < $rows ; ++$j)
                        {
                            $result->data_seek($j);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $tmp_name = $row['name'];
                            $tmp_product_id = $row['product_id'];
                            echo "<a href='manage_info.php?product_id=$tmp_product_id&mode=delete' class='list-group-item'>$tmp_name</a>";
                        }
                    ?>
                    </div>
                </div>
            </div>
            <div class='col-sm-3 m-t-20'>
                <a href="manage_info.php?mode=change_ot" class="btn btn-info btn-block">Ändra öppettider</a>
            </div>
        </div>
    </div>

<!---->
</div>
<div class='col-lg-3 col-md-2'>
</div>
</div>
</div>

<script>
$(document).ready(function(){
    $("#col2-btn").click(function(){
        $("#col3").collapse('hide');
    });
    $("#col3-btn").click(function(){
        $("#col2").collapse('hide');
    });
    $("#col2").on("shown.bs.collapse", function(){
        $("#search_input2").focus();
    });
        $("#col3").on("shown.bs.collapse", function(){
        $("#search_input3").focus();
    });

    $("#search_input2").keyup(function(){
        listSearch(col2_items, $(this));
    });

    $("#search_input3").keyup(function(){
        listSearch(col3_items, $(this));
    });

    var col2_items = $("#col2 > .list-group > a");
    var col3_items = $("#col3 > .list-group > a");
});

function listSearch(items, input) {
    var patt = new RegExp($(input).val(), "i");
    $(items).each(function(index){
        if (index == 0) return true;
        if (patt.test($(this).text()))
        {
            $(this).show();
        }
        else
        {
            $(this).hide();
        }
    });
}

</script>
</body>
</html>

<?php $connection->close(); ?>