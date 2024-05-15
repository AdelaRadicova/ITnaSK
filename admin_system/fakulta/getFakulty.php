<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    $select = $_GET['select'];

    $sql = "SELECT fakulta.nazov, fakulta.id FROM fakulta WHERE fakulta.vysoka_skola_ID=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    echo <<<EOP
                    <label for=$select>Fakulta: </label>
                    <select name=$select id=$select required='required' 
                                        onchange='showFakultaInfo(this)'>
                    <option value='NULL' selected='selected'>...</option>
                EOP;

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $name = $row['nazov'];
        $id = $row['id'];
        echo "<option value=$id>$name</option>";
    }
    echo "</select>";
