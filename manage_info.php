<?php
    require_once 'req/sql_details.php';
    require_once 'req/create_head.php';
    require_once 'req/check_login.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

    if (isset($_POST['mode']))
    {
        if ($_POST['mode'] == 'add_product')
        {
            $tmp_name = clean_string($connection, $_POST['name']);
            $tmp_material = clean_string($connection, $_POST['material']);
            $tmp_size = clean_string($connection, $_POST['size']);
            $tmp_color = clean_string($connection, $_POST['color']);
            $tmp_category = clean_string($connection, $_POST['category']);
            $tmp_description = clean_string($connection, $_POST['description']);
            $tmp_price = clean_string($connection, $_POST['price']);

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

<div class='container-fluid m-t-100'>
    <div class="panel panel-primary">
        <div class="panel-heading">Fyll i informationen nedan</div>
    </div>
    <form role="form" method="post" enctype="multipart/form-data">
        <input type="hidden" value="add_product" name="mode">
        <div class="form-group">
            <label>Namn:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label>Material:</label>
            <input type="text" class="form-control" name="material" required>
        </div>
        <div class="form-group">
            <label>Storlek:</label>
            <input type="text" class="form-control" name="size" required>
        </div>
        <div class="form-group">
            <label>Färg:</label>
            <input type="text" class="form-control" name="color" required>
        </div>
        <div class="form-group">
            <label>Kategori:</label>
            <select class="form-control" name="category" required>
                <?php
                    for ($j = 0; $j < $c_rows ; ++$j)
                    {
                        $c_result->data_seek($j);
                        $row = $c_result->fetch_array(MYSQLI_ASSOC);
                        $tmp_name = $row['name'];
                        $tmp_category_id = $row['category_id'];
                        echo "<option value='$tmp_category_id'>$tmp_name</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Beskrivning:</label>
            <textarea class="form-control" rows="5" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label>Pris:</label>
            <input type="text" class="form-control" name="price" required>
        </div>
        <div class="form-group">
            <label>Bild:</label>
            <input type="file" class="form-control" name="upload_image" id="upload_image" required>
        </div>
        <button type="submit" class="btn btn-primary">Lägg till</button>
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