<?php
    require_once '../../include_files/dbs.php';
    header('Content-Type: application/json');

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    $sql = "SELECT nazov, mesto, typ_skoly, logo_img_src FROM vysoka_skola WHERE id=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($staryNazov, $stareMesto, $staryTypSkoly, $stareLogo);
    $stmt->fetch();

    $data = [
        'nazov' => $staryNazov,
        'mesto' => $stareMesto,
        'typ_skoly' => $staryTypSkoly,
        'logo' => $stareLogo
    ];

    echo json_encode($data);
