<?php
    require_once '../../include_files/dbs.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitPridatVS'])) {
        $vysoka_skola = $_POST['nazovVS'];
        $mestoVS = $_POST['mesto'];
        $typVS = $_POST['typSkoly'];
        $logoVS = $_POST['logoVS'];

        /*neda sa pridat 2x rovnaka vs*/
        $sql="SELECT id FROM vysoka_skola where nazov=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $vysoka_skola);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            header("location: ../adminPanel.php?upload=VSuzExistuje");
            exit();
        }

        if (strlen($logoVS) == 0) { $logoVS = "default.svg"; }

        if ($typVS == "NULL") { $typVS = "Neuvedené"; }

        $sql = "INSERT INTO vysoka_skola (nazov, mesto, typ_skoly, logo_img_src) VALUES (?, ?, ?, ?);";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $vysoka_skola, $mestoVS, $typVS, $logoVS);
        $stmt->execute();

        header("location: ../adminPanel.php?upload=success");
    }

