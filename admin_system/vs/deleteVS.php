<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitVymazatVS'])) {

        $vysoka_skola = $_POST['vsDeleteSelect'];

        if (strcmp($vysoka_skola, 'NULL') == 0) {
            header("location: ../adminPanel.php?delete=fail");
            exit();
        }

        $sql="DELETE FROM vysoka_skola WHERE id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $vysoka_skola);
        $stmt->execute();
        header("location: ../adminPanel.php?delete=success");
    }