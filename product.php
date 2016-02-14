<?php
    require_once 'req/sql_details.php';
    require_once 'req/create_head.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $product_name = $product_description = $product_color = $product_size = $product_material = $product_price = '';
    $image_sources = array();
    $number_of_images = 0;

    if (isset($_GET['product_id']))
    {
        $product_id = clean_string($connection, $_GET['product_id']);
        $query = "SELECT * FROM products WHERE product_id='$product_id'";
        $result = $connection->query($query);

        if (!$result) die($connection->error);
        elseif ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $product_name = $row['name'];
            $product_description = $row['description'];
            $product_color = $row['color'];
            $product_size = $row['size'];
            $product_material = $row['material'];
            $product_price = $row['price'];
        }

        else header('Location: /sommarmobler/fyranollfyra.php');

        $query = "SELECT * FROM product_images WHERE product_id='$product_id'";
        $result = $connection->query($query);
        if (!$result) die($connection->error);
        $rows = $result->num_rows;

        for ($j = 0; $j < $rows ; ++$j)
        {
            $result->data_seek($j);
            $row = $result->fetch_array(MYSQLI_ASSOC);

            array_push($image_sources, "/sommarmobler/" . $row['image_path']);
        }
        $number_of_images = count($image_sources);
    }
    else header('Location: /sommarmobler/fyranollfyra.php');
?>

<!DOCTYPE html>
<html lang='sv'>
<?php create_head($product_name); ?>
<body>
<div class='container-fluid'>
<div class='row'>
<div class='col-lg-3 col-md-2 col-sm-1'>
</div>
<div class='col-lg-6 col-md-8 col-sm-10'>

    <?php require_once 'req/menu.php'; ?>
    <div class='container-fluid'>
    <div class='row'>
    <div class='col-sm-8'>
        <div class="container-fluid text-center no-padding">
        <div id="myCarousel2" class="carousel slide text-center" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php
                    for ($index = 0; $index < $number_of_images; $index++)
                    {
                        if ($index == 0) echo "<li data-target='#myCarousel2' data-slide-to='0' class='active'></li>";
                        else echo "<li data-target='#myCarousel2' data-slide-to='$index'></li>";
                    }
                ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php
                for ($index = 0; $index < $number_of_images; $index++)
                {
                    if ($index == 0) echo "<div class='item active'>";
                    else echo "<div class='item'>";
                    echo "<img class='img-responsive center-block' src='$image_sources[$index]'>";
                    echo "</div>";
                }
                ?>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel2" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel2" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>
        </div>
        </div>


        <div class='container-fluid hide-xs'>
            <?php
                $number_of_rows = ceil($number_of_images/4);
                $index = 0;
                for ($j = 0; $j < $number_of_rows; $j++)
                {
                    echo "<div class='row'>";
                    for ($i = 0; $i < 4; $i++)
                    {
                        echo "<div class='col-xs-3 no-padding'>";
                        if ($index < $number_of_images)
                        {
                            echo "<img class='img-responsive center-block img-thumbnail' src='$image_sources[$index]' data-target='#myCarousel2' data-slide-to='$index'>";
                        }

                        echo "</div>";
                        $index++;
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </div>
    <div class='col-sm-4'>
    <div class='well well-sm m-t-10 center-text-xs'><h2 class='no-margin'><?php echo $product_name; ?></h2></div>
        <div class='well'>
            <strong>Beskrivning: </strong><p><?php echo $product_description; ?></p>
            <p><strong>Färg: </strong><?php echo $product_color; ?></p>
            <p><strong>Material: </strong><?php echo $product_material; ?></p>
            <p><strong>Storlek: </strong><?php echo $product_size; ?></p>
        </div>
        <div class='well well-sm center-text-xs'>
        <h2 class='no-margin'><?php echo $product_price; ?>,-</h2>
        </div>

    </div>
    </div>
    </div>

</div>
<div class='col-lg-3 col-md-2 col-sm-1'>
</div>

</div>
</div>
</body>
</html>

<?php $connection->close(); ?>