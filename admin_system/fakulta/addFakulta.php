<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitPridatFak'])) {

        $idVS = $_POST['vsSelect'];
        $fakulta = $_POST['nazovFak'];
        $logoF = $_POST['logoF'];

        /*neda sa pridat 2x rovnaka fakulta pre tu istu vs*/
        $sql="SELECT f.id
                FROM fakulta f
                INNER JOIN vysoka_skola vs 
                ON f.vysoka_skola_ID = vs.id
                WHERE f.nazov=? AND f.vysoka_skola_ID=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $fakulta, $idVS);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            header("location: ../adminPanel.php?upload=FakultaPreDanuVSuzExistuje");
            exit();
        }

        if (strlen($logoF) == 0) $logoF = "default.svg";

        if ($idVS == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }
        else {
            $sql = "INSERT INTO fakulta (vysoka_skola_ID, nazov, logo_img_src) VALUES (?, ?, ?);";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $idVS, $fakulta, $logoF);
            $stmt->execute();

            header("location: ../adminPanel.php?upload=success");
            exit();
        }
    }

