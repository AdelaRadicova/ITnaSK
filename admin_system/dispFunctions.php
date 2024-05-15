<?php
    function listallVS($conn,  $selectId, $onchange) {
        //$sql="SELECT nazov FROM vysoka_skola;";
        $sql="SELECT id, nazov FROM vysoka_skola;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<select name=$selectId id=$selectId required='required' onchange=$onchange(this)>";
        echo "<option value='NULL' selected>...</option>";
        while ($row = mysqli_fetch_assoc($result)) {

            $id = $row['id'];
            $name = $row['nazov'];
            echo "<option value=$id>$name</option>";
        }
        echo "</select>";
    }

    function listallSP($conn,  $selectId, $onchange) {

        $sql="SELECT vs.nazov as 'vs', f.nazov as 'fak', sp.nazov as 'sp', sp.id as 'spId' 
                  FROM vysoka_skola vs
                  JOIN fakulta f on vs.id = f.vysoka_skola_ID
                  JOIN studijny_program sp on f.id = sp.fakulta_ID;";


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<select name=$selectId id=$selectId onchange=$onchange(this)>";
        echo "<option value='NULL' selected>...</option>";
        while ($row = mysqli_fetch_assoc($result)) {

            $vs = $row['vs'];
            $f = $row['fak'];
            $sp = $row['sp'];
            $spId = $row['spId'];

            echo "<option value=$spId>$vs -- $f -- $sp</option>";
        }
        echo "</select>";
    }

    function listAllClanky($conn,  $selectId, $onchange) {
        $sql = "SELECT id, nadpis FROM clanok;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<select name=$selectId id=$selectId onchange=$onchange(this)>";
        echo "<option value='NULL' selected>...</option>";

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

            $id = $row['id'];
            $nadpis = $row['nadpis'];

            echo "<option value=$id> $nadpis </option>";
        }
        echo "</select>";
    }

    function dispAllClanky($conn) {
        $sql = "SELECT id, nadpis, datum_aktualizacie_clanku FROM clanok;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        echo <<<EOP
                <table id="clankyTable" class="table table-striped table-light table-hover table-sm">
                        
                            <thead class="table-dark">
                                 <tr><th>Nadpis</th><th>Pridané dňa</th><th>Vymazať</th></tr>
                            </thead>
                            <tbody>
            EOP;

        while ($clanok = $result->fetch_array(MYSQLI_ASSOC)) {

            $nadpis = $clanok['nadpis'];
            $datum = $clanok['datum_aktualizacie_clanku'];
            $id = $clanok['id'];

            echo "<tr>";
            echo "<td>" . $nadpis . "</td>";
            echo "<td>" . $datum . "</td>";
            echo "<td>
                        <form action='./clanky/deleteClanok.php' method='post'>
                            <input type='hidden' name='delClanokId' value='" . $id . "'>
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
