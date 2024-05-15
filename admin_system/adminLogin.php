<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Favicon-->
    <link rel="icon" type="image/x-icon" href="../img_style/favicon_io/favicon.ico">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!--Style-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- My style -->
    <link rel="stylesheet" href="./styles/adminLogin-style.css">

    <title>Študuj IT na SK!</title>
</head>

<?php
    require_once '../include_files/dbs.php';

$conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }
?>

<body>
<form method="POST" class="login-panel">

    <h5>PRIHLÁSENIE DO SYSTÉMU<BR>IT na SK</h5>

    <div class="login-box">
        <div>
            <span class="icon"><i class="bi bi-person-fill"></i></span>
            <input type="text" style="margin-bottom: 2em;" placeholder="Meno" name="adminName">
        </div>

        <div>
            <span class="icon"><i class="bi bi-lock-fill"></i></span>
            <input type="password" style="margin-bottom: 4em;" placeholder="Heslo" name="adminPswd">
        </div>

        <button type="submit" id="subButt" name="buttPrihlasit">Prihlásiť sa</button>
    </div>
</form>
</body>
</html>

<?php
    if(isset($_POST['buttPrihlasit'])) {
        $sql = "SELECT * FROM admin_login a WHERE admin_meno=?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_POST['adminName']);
        $stmt->execute();
        $result = $stmt->get_result();
        $queryResult = $result->num_rows;
        $row = $result->fetch_array(MYSQLI_ASSOC);

        if ($queryResult == 0) {
            echo "<script>alert('Zadal si nesprávne prihlasovacie meno!')</script>";
        }
        else {
            $heslo = $row['admin_heslo'];
            if (password_verify($_POST['adminPswd'], $heslo)) {
                session_start();
                $_SESSION['admin'] = $_POST['adminName'];
                $_SESSION['adminPassw'] = $_POST['adminPswd'];
                header("location: admin_system/adminPanel.php");
                exit();
            }
            else {
                echo "<script>alert('Zadal si nesprávne heslo!')</script>";
            }
        }
    }

?>

