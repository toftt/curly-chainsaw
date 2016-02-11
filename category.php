<?php
    require_once 'req/sql_details.php';
    require_once 'req/create_head.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $number_of_products = 0;
    $products = array();


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

        <?php
            if (isset($_GET['category_id']))
            {
                $category_id = clean_string($connection, $_GET['category_id']);
                $query = "SELECT * FROM products WHERE category_id='$category_id'";
                $result = $connection->query($query);
                if (!$result) die($connection->error);
                $rows = $result->num_rows;
                $number_of_rows = ceil($rows/4);
                $k= 0;

                for ($j = 0; $j < $number_of_rows ; ++$j)
                {
                    echo "<div class='row'>";

                    for ($i = 0; $i < 4; ++$i)
                    {
                        $result->data_seek($j);
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        $tmp_product_id = $row['product_id'];
                        $image_query = "SELECT * FROM product_images WHERE product_id='$tmp_product_id' LIMIT 1";
                        $image_result = $connection->query($image_query);
                        if (!$image_result) die($connection->error);

                        if ($image_result->num_rows)
                        {
                            $image_row = $image_result->fetch_array(MYSQLI_ASSOC);
                            $image_src = $image_row['image_path'];
                        }

                        echo "<div class='col-sm-3'>";
                        echo "<div class='panel panel-default'>";
                        if ($k < $rows)
                        {
                            $tmp_name = $row['name'];
                            echo "<img class='img-responsive center-block img-thumbnail' src='$image_src'>";
                            echo "<div class='panel-body'>$tmp_name</div></div>";
                        }
                        else
                            {
                                echo "<img class='img-responsive center-block img-thumbnail'>";
                                echo "<div class='panel-body'></div></div>";
                            }

                        echo "</div>";
                        $k++;
                    }

                    echo "</div>";
                }
            }

        ?>
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