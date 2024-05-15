<?php
    require_once 'dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    function dispSP($studijneProgramy) {
        while ($sp = $studijneProgramy->fetch_array(MYSQLI_ASSOC)) {

            $sp_id = $sp['id'];
            $nazovSP = $sp['nazov'];
            $vs = $sp['vs'];
            $fakulta = $sp['fakulta'];

            echo <<<EOP
                            <a href='./studijnyProgram.php?sp=$sp_id&name=$nazovSP' class='clear-link'>
                            <div class="panel panel-default">
                                <div class="panel-body py-2 px-5">
                                        <div style="color: #efefef; font-weight: bolder">$vs</div>
                                        <div style="color: #c5a915; font-weight: bolder">$fakulta</div>

                                        <hr class="hr" />
                                        <div style="color: #4a9a95; font-weight: bolder">$nazovSP</div>
                                        
                                </div>
                            </div>
                            </a>
                            <br>
            EOP;
        }
    }
    function sanitizeData($data, $conn) : string {
        $Data = trim($data);
        $Data = strip_tags($Data);
        $Data = $conn->real_escape_string($Data);
        $Data = stripslashes($Data);
        return $Data;
    }



    $sql = "SELECT sp.id, sp.fakulta_ID, sp.nazov, vs.nazov as 'vs', f.nazov as 'fakulta' 
            FROM studijny_program sp 
            INNER JOIN fakulta f ON f.id=sp.fakulta_ID 
            INNER JOIN vysoka_skola vs on f.vysoka_skola_ID = vs.id
            WHERE ";

    $where = '';

    if (isset($_POST) && !empty($_POST)) {

        if (isset($_POST['vs']) && $_POST['vs'] != 'all' && $_POST['vs'] != '') {
            if ($where != '') $where .= ' AND';
            $where .= ' vs.id=' . sanitizeData($_POST['vs'], $conn);
        }

        if (isset($_POST['mesto']) && $_POST['mesto'] != 'all' && $_POST['mesto'] != '') {
            if ($where != '') $where .= ' AND';
            $where .= " vs.mesto='" . sanitizeData($_POST['mesto'], $conn) . "'";
        }

        if (isset($_POST['typ']) && $_POST['typ'] != 'all' && $_POST['typ'] != '') {
            if ($where != '') $where .= ' AND';
            $where .= " vs.typ_skoly='" . sanitizeData($_POST['typ'], $conn) . "'";
        }

        if (isset($_POST['jazyk']) && $_POST['jazyk'] != 'all' && $_POST['jazyk'] != '') {
            if ($where != '') $where .= ' AND';
            $where .= " sp.vyucovaci_jazyk='" . sanitizeData($_POST['jazyk'], $conn) . "'";
        }

        if (isset($_POST['prijimacky']) && $_POST['prijimacky'] != 'all' && $_POST['prijimacky'] != '') {
            if ($where != '') $where .= ' AND';
            $where .= " sp.prijimacie_skusky='" . sanitizeData($_POST['prijimacky'], $conn) . "'";
        }

        if (isset($_POST['externe']) && $_POST['externe'] != 'all' && $_POST['externe'] != '') {
            if ($where != '') $where .= ' AND';
            $where .= " sp.ponuka_externeho_studia='" . sanitizeData($_POST['externe'], $conn) . "'";
        }

        $finalSql = $sql . $where;
        $stmt = $conn->prepare($finalSql);
        $stmt->execute();
        $studijneProgramy = $stmt->get_result();

        dispSP($studijneProgramy);
        $where = '';

    } else if (isset($_POST)) {
        $sql = "SELECT sp.id, sp.fakulta_ID, sp.nazov, vs.nazov as 'vs', f.nazov as 'fakulta' 
                FROM studijny_program sp 
                INNER JOIN fakulta f ON f.id=sp.fakulta_ID 
                INNER JOIN vysoka_skola vs on f.vysoka_skola_ID = vs.id;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $studijneProgramy = $stmt->get_result();

        dispSP($studijneProgramy);
    }
