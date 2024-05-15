<?php
    require_once '../include_files/dbs.php';

    session_start();
    if (!isset($_SESSION['admin'])) {
        header("location: admin-login");
        exit();
    }

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST) && isset($_GET) && $_GET['m'] == "updateAdminName") {

        $sql = "UPDATE admin_login SET admin_meno=? WHERE admin_meno=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $_POST['userName'], $_SESSION['admin']);
        $stmt->execute();
        $_SESSION['admin'] = $_POST['userName'];
        header("location: ./adminPanel.php?setNewName=success");
        exit();
    }
    
    if (isset($_POST) && isset($_GET) && $_GET['m'] == "updateAdminPassw") {
        $sql = "UPDATE admin_login SET admin_heslo=? WHERE admin_meno=?;";
        $stmt = $conn->prepare($sql);
        $noveHeslo = password_hash($_POST['userPassw'], PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $noveHeslo, $_SESSION['admin']);
        $stmt->execute();
        $_SESSION['adminPassw'] = $_POST['userPassw'];
        header("location: ./adminPanel.php?setNewPassw=success");
        exit();
    }