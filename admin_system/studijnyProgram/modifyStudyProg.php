<?php
    require_once '../../include_files/dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitUpravitStudProg'])) {

        $vysoka_skola = $_POST['vsModifyStudyProgSelectVS'];
        $fakulta = $_POST['FSelectModifyStudyProg'];
        $study_prog = $_POST['SPSelectModifySPnazovSP'];
        $novy_nazov = $_POST['novyNazovModifyvSP'];

        $prijimacky = $_POST['modifySPprijimacky'];
        $externeStudium = $_POST['modifySPexterne'];
        $vyucJazyk = $_POST['modifySPjazyk'];

        $clanok = $_POST['modifyStudyProgEditor'];
        $datumUpravy = date("j.n.Y");

        if ($vysoka_skola == null || $fakulta == null || $study_prog == null) {
            header("location: ../adminPanel.php?upload=fail");
            exit();
        }

        $sql = "UPDATE studijny_program SET nazov=?, prijimacie_skusky=?, ponuka_externeho_studia=?, vyucovaci_jazyk=?, clanok=?, datum_aktualizacie_clanku=? 
                WHERE studijny_program.id=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi",  $novy_nazov, $prijimacky, $externeStudium, $vyucJazyk, $clanok, $datumUpravy, $study_prog);
        $stmt->execute();

        header("location: ../adminPanel.php?upload=success");
    }