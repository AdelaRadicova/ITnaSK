<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['delRecenziaId'])) {

        $rec_id = $_POST['delRecenziaId'];

        $sql="DELETE rec FROM recenzie rec WHERE rec.id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $rec_id);
        $stmt->execute();
        $result = $stmt->get_result();

        header("location: ../adminPanel.php?delete=success");
    }