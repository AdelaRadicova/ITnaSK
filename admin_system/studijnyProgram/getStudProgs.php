<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    $vs = $_GET['vsId'];
    $fakulta = $_GET['fId'];
    $select = $_GET['select'];

    $sql="SELECT sp.nazov, sp.id
          FROM studijny_program sp 
          INNER JOIN fakulta f ON sp.fakulta_ID=f.id 
          WHERE sp.fakulta_ID=? AND f.vysoka_skola_ID=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $fakulta, $vs);
    $stmt->execute();
    $result = $stmt->get_result();

    echo <<<EOP
                <label for=$select>Študijný program: </label>
                <select name=$select id=$select required='required'
                                    onchange='changeEditorContext(this)'>
                <option value='NULL' selected disabled>...</option>
            EOP;

    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $name = $row['nazov'];
        $id = $row['id'];

        echo "<option value=$id>$name</option>";
    }
    echo "</select>";
