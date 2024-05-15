<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['delClanokId'])) {

        $clanokId = $_POST['delClanokId'];

        $sql="DELETE cl FROM clanok cl WHERE cl.id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $clanokId);
        $stmt->execute();
        $result = $stmt->get_result();

        header("location: ../adminPanel.php?delete=success");
    }