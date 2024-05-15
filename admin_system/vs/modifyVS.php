<?php
    require_once '../../include_files/dbs.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitUpravitVS'])) {

        $vysoka_skola = $_POST['vsModifySelect'];
        $novy_nazov = $_POST['nazovUpravVS'];
        $nove_mesto = $_POST['mestoUprav'];
        $novyTypVS = $_POST['typSkolyUprav'];
        $nove_logoVS = $_POST['logoVSUprav'];

        if ($vysoka_skola == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }
        if ($novyTypVS == "NULL") { $novyTypVS = "Neuvedené"; }

        $sql = "UPDATE vysoka_skola SET nazov=?, mesto=?, typ_skoly=? WHERE id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $novy_nazov,$nove_mesto, $novyTypVS, $vysoka_skola);
        $stmt->execute();

        if (strlen($nove_logoVS) != 0) {

            $sql = "UPDATE vysoka_skola SET logo_img_src=? WHERE id=?;";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $nove_logoVS,$idVS);
            $stmt->execute();
        }

/*
        $sql="SELECT id, typ_skoly FROM vysoka_skola where nazov=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $vysoka_skola);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {

            $idVS = $row['id'];
            $staryTypVS = $row['typ_skoly'];

            if (strlen($novy_nazov) != 0) {

                $sql = "UPDATE vysoka_skola SET nazov=? WHERE id=?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $novy_nazov,$idVS);
                $stmt->execute();
            }

            if (strlen($nove_mesto) != 0) {

                $sql = "UPDATE vysoka_skola SET mesto=? WHERE id=?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $nove_mesto,$idVS);
                $stmt->execute();
            }

            if ((strcmp($novyTypVS, $staryTypVS) != 0 ) && strcmp($novyTypVS, "NULL")) {

                $sql = "UPDATE vysoka_skola SET typ_skoly=? WHERE id=?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $novyTypVS,$idVS);
                $stmt->execute();
            }

            if (strlen($nove_logoVS) != 0) {

                $sql = "UPDATE vysoka_skola SET logo_img_src=? WHERE id=?;";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $nove_logoVS,$idVS);
                $stmt->execute();
            }
        }*/
        header("location: ../adminPanel.php?upload=success");
    }

