<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitPridatClanok'])) {

        $nadpis = $_POST['addNadpisClanku'];
        $datumUpravy = date("j.n.Y");
        $clanok = $_POST['addClanokEditor'];

        if (empty($nadpis) || empty($clanok)) {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }

        $sql = "INSERT INTO clanok (nadpis, datum_aktualizacie_clanku, clanok) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $nadpis, $datumUpravy, $clanok);
        $success = $stmt->execute();

        header("location: ../adminPanel.php?upload=success");
    }