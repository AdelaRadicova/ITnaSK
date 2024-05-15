<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if (isset($_GET['id'])) {

        $id = $_GET['id'];

        $sql="SELECT clanok FROM clanok WHERE clanok.id=?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $clanok = $result->fetch_array(MYSQLI_ASSOC);

        echo $clanok['clanok'];
    }
    else if (isset($_POST['clId'])) {

        $id = $_POST['clId'];

        $sql="SELECT nadpis FROM clanok WHERE clanok.id=?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $clanok = $result->fetch_array(MYSQLI_ASSOC);

        echo $clanok['nadpis'];
    }