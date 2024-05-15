<?php
    require_once '../../include_files/dbs.php';
    header('Content-Type: application/json');

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    $studijnyProgram = $_GET['sp'];

    $sql="SELECT * FROM studijny_program sp WHERE sp.id=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $studijnyProgram);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);

    $data = [
        'nazov' => $row['nazov'],
        'skusky' => $row['prijimacie_skusky'],
        'externe' => $row['ponuka_externeho_studia'],
        'jazyk' => $row['vyucovaci_jazyk'],
        'clanok' =>$row['clanok']
    ];

    echo json_encode($data);