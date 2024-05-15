<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitPridatStudProg'])) {

        $vysoka_skola = $_POST['vsAddStudyProgSelectVS'];
        $fakulta = $_POST['FSelectAddStudyProg'];
        $study_prog = $_POST['addSPnazovSP'];

        $prijimacky = $_POST['addSPprijimacky'];
        $externeStudium = $_POST['addSPexterne'];
        $vyucJazyk = $_POST['addSPjazyk'];

        $clanok = $_POST['addStudyProgEditor'];
        $datumUpravy = date("j.n.Y");

        if ($vysoka_skola == "NULL" || $fakulta == "NULL" || $study_prog == null) {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }

        /*neda sa pridat 2x rovnaky sp pre tu istu fakultu*/
        $sql="SELECT sp.id
              FROM studijny_program sp
              INNER JOIN fakulta f
              ON sp.fakulta_ID=f.id
              WHERE sp.nazov=? AND sp.fakulta_ID=? AND f.vysoka_skola_ID=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $study_prog,$fakulta, $vysoka_skola);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            header("location: ../adminPanel.php?upload=SPpreDanuFakultuUzExistuje");
            exit();
        }

        $sql = "INSERT INTO studijny_program (fakulta_ID, nazov, prijimacie_skusky, ponuka_externeho_studia, vyucovaci_jazyk, datum_aktualizacie_clanku, clanok) VALUES (?,?,?,?,?,?,?);";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $fakulta, $study_prog, $prijimacky, $externeStudium, $vyucJazyk, $datumUpravy, $clanok);
        $stmt->execute();
        header("location: ../adminPanel.php?upload=success");
    }

