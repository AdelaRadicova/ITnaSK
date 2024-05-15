<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitVymazatFakultu'])) {

        $vysoka_skola = $_POST['vsDeleteFakSelectVS'];
        $fakulta = $_POST['DeletSelectFakulta'];

        if ($vysoka_skola == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }
        if ($fakulta == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }
/*
        $sql="DELETE f 
              FROM fakulta f 
              INNER JOIN vysoka_skola vs 
              ON f.vysoka_skola_ID=vs.id 
              where vs.nazov=? AND f.nazov=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $vysoka_skola, $fakulta);
        $stmt->execute();
        header("location: ../adminPanel.php?delete=success");
*/
        $sql="DELETE f FROM fakulta f WHERE f.id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fakulta);
        $stmt->execute();
        header("location: ../adminPanel.php?delete=success");
    }