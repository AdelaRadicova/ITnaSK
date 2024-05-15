<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitUpravitClanok'])) {

        if (empty($_POST['modClanokId']) || $_POST['modClanokId'] == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }

        $nadpis = $_POST['modNadpisClanku'];
        $clanok = $_POST['modClanokEditor'];
        $id = $_POST['modClanokId'];
        $datumUpravy = date("j.n.Y");

        $sql = "UPDATE clanok SET nadpis=?, clanok=?, datum_aktualizacie_clanku=? WHERE id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nadpis,$clanok, $datumUpravy,$id);
        $success = $stmt->execute();

        header("location: ../adminPanel.php?upload=success");
    }