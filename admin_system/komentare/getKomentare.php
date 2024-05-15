<?php
    include_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['spId'])) {

        $sp_id = $_POST['spId'];
        if ($sp_id == "NULL") return;

        $sql = "SELECT *
            FROM recenzie 
            WHERE recenzie.studijny_program_ID=?
            ORDER BY datum_pridania_recenzie DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $sp_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo <<<EOP
            <table id="commentsTable" class="table table-striped table-light table-hover table-sm">
                    
                        <thead class="table-dark">
                             <tr><th>Id recenzie</th><th>Pridané od</th><th>Pridané dňa</th><th>Vymazať</th></tr>
                        </thead>
                        <tbody>
EOP;

        while ($comment = $result->fetch_array(MYSQLI_ASSOC)) {

            $commId = $comment['id'];
            $commAutor = $comment['autor'];
            $commentDatum = $comment['datum_pridania_recenzie'];

            echo "<tr>";
            echo "<td>" . $commId . "</td>";
            echo "<td>" . $commAutor . "</td>";
            echo "<td>" . $commentDatum . "</td>";
            echo "<td>
                    <form action='./komentare/deleteKomentar.php' method='post'>
                        <input type='hidden' name='delRecenziaId' value='" . $commId . "'>
                        <button type='submit' class='btn btn-outline-danger'>
                        <i class='bi bi-trash-fill'></i>
                        </button>
                    </form>";
        }

        echo <<<EOP
                    </tbody>
                </table>
               EOP;
    }