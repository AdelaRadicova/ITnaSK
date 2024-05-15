<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitVymazatSP'])) {

        $vysoka_skola = $_POST['vsDeleteSPSelectVS'];
        $fakulta = $_POST['DeleteSPSelectFakulta'];
        $study_prog = $_POST['SPSelectDeleteSPnazovSP'];

        if ($vysoka_skola == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }
        if ($fakulta == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }
        if ($study_prog == "NULL") {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }

        $sql="DELETE sp FROM studijny_program sp WHERE sp.id=?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $study_prog);
        $stmt->execute();

        header("location: ../adminPanel.php?delete=success");
}