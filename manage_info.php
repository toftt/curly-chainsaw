<?php
    require_once 'req/sql_details.php';
    require_once 'req/create_head.php';
    require_once 'req/check_login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $name_value = $material_value = $size_value = $color_value = $category_value = $description_value = $price_value = $product_id_input = '';

    if (isset($_POST['mode']))
    {
        if ($_POST['mode'] == 'add_product' || $_POST['mode'] == 'edit_product')
        {
            $tmp_name = clean_string($connection, $_POST['name']);
            $tmp_material = clean_string($connection, $_POST['material']);
            $tmp_size = clean_string($connection, $_POST['size']);
            $tmp_color = clean_string($connection, $_POST['color']);
            $tmp_category = clean_string($connection, $_POST['category']);
            $tmp_description = clean_string($connection, $_POST['description']);
            $tmp_price = clean_string($connection, $_POST['price']);

            if ($_POST['mode'] == 'add_product')
            {
            $a_query = "INSERT INTO products(name, material, size, color, category_id, description, price)
                        VALUES ('$tmp_name', '$tmp_material', '$tmp_size', '$tmp_color', '$tmp_category',
                                '$tmp_description', '$tmp_price')";
            $a_result = $connection->query($a_query);
            if (!$a_result) die($connection->error);
            else
                {
                    upload_image($connection, "upload_image", $connection->insert_id);
                    header ('Location: admin_panel.php');
                }
            }

            elseif ($_POST['mode'] == 'edit_product')
            {
                $tmp_product_id = clean_string($connection, $_POST['product_id']);
                $query = "UPDATE products SET name='$tmp_name', material='$tmp_material', size='$tmp_size', color='$tmp_color', category_id='$tmp_category',
                         description='$tmp_description', price='$tmp_price' WHERE product_id='$tmp_product_id'";
                $result = $connection->query($query);
                if (!$result) die($connection->error);
                else
                {
                    header('Location: admin_panel.php');
                }

            }
        }

        elseif ($_POST['mode'] == 'delete_product')
        {
            $tmp_product_id = clean_string($connection, $_POST['product_id']);
            $query = "DELETE FROM products WHERE product_id='$tmp_product_id'";
            $result = $connection->query($query);
            if (!$result) die($connection->error);
            else
            {
                header ('Location: admin_panel.php');
            }
        }
    }

    if ($_GET['mode'] == 'add')
    {
        $panel_type = 'primary';
        $panel_text = 'Lägg till en produkt';
        $form_mode = 'add_product';
        $r_or_d = 'required';
        $button = '<button type="submit" class="btn btn-primary">Lägg till</button>';
    }
    elseif ($_GET['mode'] == 'edit')
    {
        $panel_type='warning';
        $panel_text = 'Ändra en produkt';
        $form_mode = 'edit_product';
        $r_or_d = 'required';
        $button = '<button type="submit" class="btn btn-warning">Ändra</button>';
    }
    elseif ($_GET['mode'] == 'delete')
    {
        $panel_type='danger';
        $panel_text = 'Ta bort en produkt';
        $form_mode = 'delete_product';
        $r_or_d = 'disabled';
        $button = '<button type="submit" class="btn btn-danger">Ta bort</button>';
    }


    if ($_GET['mode'] == 'delete' || $_GET['mode'] == 'edit')
    {
        $product_id = $_GET['product_id'];
        $query = "SELECT * FROM products WHERE product_id='$product_id'";
        $result = $connection->query($query);
        if (!$result) die($connection->error);

        elseif($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $name_value = $row['name'];
            $material_value = $row['material'];
            $size_value = $row['size'];
            $color_value = $row['color'];
            $category_value = $row['category_id'];
            $description_value = $row['description'];
            $price_value = $row['price'];
        }

        $product_id_input = "<input type='hidden' value='$product_id' name='product_id'>";
    }

    $c_query = "SELECT * FROM categories ORDER BY name";
    $c_result = $connection->query($c_query);
    if (!$c_result) die($connection->error);
    $c_rows = $c_result->num_rows;
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

<div class='container-fluid m-y-100'>
    <div class="panel panel-<?php echo $panel_type; ?>">
        <div class="panel-heading"><?php echo $panel_text; ?></div>
    </div>
    <form role="form" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $form_mode; ?>" name="mode">
        <?php echo $product_id_input; ?>
        <div class="form-group">
            <label>Namn:</label>
            <input type="text" class="form-control" name="name" <?php echo $r_or_d . " value='$name_value'"; ?>>
        </div>
        <div class="form-group">
            <label>Material:</label>
            <input type="text" class="form-control" name="material" <?php echo $r_or_d . " value='$material_value'"; ?>>
        </div>
        <div class="form-group">
            <label>Storlek:</label>
            <input type="text" class="form-control" name="size" <?php echo $r_or_d . " value='$size_value'"; ?>>
        </div>
        <div class="form-group">
            <label>Färg:</label>
            <input type="text" class="form-control" name="color" <?php echo $r_or_d . " value='$color_value'"; ?>>
        </div>
        <div class="form-group">
            <label>Kategori:</label>
            <select class="form-control" name="category" <?php echo $r_or_d; ?>>
                <?php
                    for ($j = 0; $j < $c_rows ; ++$j)
                    {
                        $c_result->data_seek($j);
                        $row = $c_result->fetch_array(MYSQLI_ASSOC);
                        $tmp_name = $row['name'];
                        $tmp_category_id = $row['category_id'];
                        if ($tmp_category_id == $category_value) echo "<option selected='selected' value='$tmp_category_id'>$tmp_name</option>";
                        else echo "<option value='$tmp_category_id'>$tmp_name</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Beskrivning:</label>
            <textarea class="form-control" rows="5" name="description" <?php echo $r_or_d; ?>><?php echo $description_value; ?></textarea>
        </div>
        <div class="form-group">
            <label>Pris:</label>
            <input type="text" class="form-control" name="price" <?php echo $r_or_d . " value='$price_value'"; ?>>
        </div>
        <div class="form-group">
            <label>Bild:</label>
            <input type="file" class="form-control" name="upload_image" id="upload_image">
        </div>

        <?php
            if (isset($_GET['product_id']))
            {
                $product_id = $_GET['product_id'];
                $query = "SELECT * FROM product_images WHERE product_id='$product_id'";
                $result = $connection->query($query);
                if (!$result) die($connection->error);
                $rows = $result->num_rows;
                $number_of_rows = ceil($rows/4);
                $index = 0;

                for ($j = 0; $j < $number_of_rows; $j++)
                {
                    echo "<div class='row'>";

                    for ($i = 0; $i < 4; ++$i)
                    {
                        echo "<div class='col-xs-3'>";
                        if ($index < $rows)
                        {
                            $result->data_seek($index);
                            $row = $result->fetch_array(MYSQLI_ASSOC);

                            $image_src = '/sommarmobler/' . $row['image_path'];
                            echo "<img class='img-responsive center-block img-thumbnail' src='$image_src'>";
                        }
                        $index++;
                        echo "</div>";
                    }
                    echo "</div>";
                }

            }
        ?>


        <?php echo $button; ?>
    </form>
</div>
<!---->
</div>
<div class='col-lg-3 col-md-2'>
</div>
</div>
</div>
</body>
</html>
<?php
    function upload_image($connection, $image_name, $product_id)
    {
        $target_dir = 'images/';
        $uploadOK = 1;
        $target_file = $target_dir . basename($_FILES[$image_name]['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES[$image_name]['tmp_name']);
        $check !== false ? $uploadOK = 1 : $uploadOK = 0;

        $target_file = hash('ripemd128', $_FILES[$image_name]['tmp_name']) . "." . $imageFileType;
        $target_path = $target_dir . $target_file;

        if (file_exists($target_path))
        {
            $uploadOK = 0;
            $fail_msg = 'Bilden finns redan.';
        }

        if ($_FILES[$image_name]['size'] > 10000000)
        {
            $uploadOK = 0;
            $fail_msg = 'Bilden är för stor.';
        }

        if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg')
        {
            $uploadOK = 0;
            $fail_msg = 'Bilden är i fel format (jpg, eller png krävs).';
        }

        if ($uploadOK == 0)
        {

        }
        else
        {

            if(move_uploaded_file($_FILES[$image_name]['tmp_name'], $target_path))
            {
                $fail_msg = 'Bild uppladdad.';

                $query = "INSERT INTO product_images(product_id, image_path)
                          VALUES ('$product_id', '$target_path')";
                $result = $connection->query($query);
                if (!$result) die($connection->error);
            }
            else
            {
                $fail_msg = 'Någonting gick fel.';
            }
        }
    }
?>
<?php $connection->close(); ?>