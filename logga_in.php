<?php
    require_once 'req/sql_details.php';
    $connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    $enter_pw = '';


    if (isset($_POST['usr']) && isset($_POST['pwd']))
    {
        $un_temp = clean_string($connection, $_POST['usr']);
        $pw_temp = clean_string($connection, $_POST['pwd']);

        $query = "SELECT * FROM users WHERE username='$un_temp'";
        $result = $connection->query($query);
        if (!$result) die($connection->error);
        elseif ($result->num_rows)
        {
            $row = $result->fetch_array(MYSQLI_ASSOC);

            $salt1 = "^´fdg";
            $salt2 = "k9p.<";
            $token = hash('ripemd128', "$salt1$pw_temp$salt2");

            if ($token == $row['password'])
            {
                session_start();
                $_SESSION['username'] = $un_temp;
                $_SESSION['check'] = hash('ripemd128',
                $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);



                header('Location: admin_panel.php');
            }
            else $enter_pw = "Felaktigt lösenord eller användarnamn.";
        } else $enter_pw = "Felaktigt lösenord eller användarnamn.";
    }
?>

<!DOCTYPE html>
<html lang='sv'>
<head>
    <title>Sommarmöbler Alnö</title>
    <meta charset='UTF-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel='stylesheet' type='text/css' href='css/layout.css'>

</head>
<body>
<div class='container-fluid'>
<div class='row'>
<div class='col-lg-3 col-md-2'>
</div>
<div class='col-lg-6 col-md-8'>

<div class='container-fluid m-t-100'>
    <form role="form" method="post">
        <div class="form-group">
            <label for="usr">Användarnamn:</label>
            <input type="text" class="form-control" name="usr">
        </div>
        <div class="form-group">
            <label for="pwd">Lösenord:</label>
            <input type="password" class="form-control" name="pwd">
        </div>
        <button type="submit" class="btn btn-default">Logga in</button>
    </form>
    <?php echo $enter_pw; ?>
</div>

</div>
<div class='col-lg-3 col-md-2'>
</div>
</div>
</div>
</body>
</html>