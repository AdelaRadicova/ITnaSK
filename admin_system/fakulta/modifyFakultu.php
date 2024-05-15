<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitUpravitFak'])) {

        $vysoka_skola = $_POST['vsModifySelectVSFak'];
        $fakulta = $_POST['ModifySelectFakulta'];
        $novy_nazov = $_POST['nazovUpravFakultu'];
        $nove_logo_Fak = $_POST['logoFakUprav'];

        if ($vysoka_skola == "NULL" || $fakulta == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }

        $sql = "UPDATE fakulta SET nazov=? WHERE fakulta.id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $novy_nazov, $fakulta);
        $stmt->execute();

        if (strlen($nove_logo_Fak) != 0) {

            $sql = "UPDATE fakulta SET logo_img_src=? WHERE fakulta.id=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $nove_logo_Fak, $fakulta);
            $stmt->execute();
        }

        header("location: ../adminPanel.php?upload=success");
    }