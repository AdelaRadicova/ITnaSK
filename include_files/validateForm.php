<?php
    require_once 'dbs.php';

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    if (isset($_POST['submitButt'])) {

        $articleID = $_POST['article'];
        $autor = trim(filter_var($_POST['autor'], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_FLAG_ENCODE_LOW));

        $pocetOtazok = 0;
        $dotaznikOdpovede = array();
        $otazkyID = array();


        $sql = "SELECT COUNT(*) as 'pocet' FROM otazky_pre_dotaznik";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $pocetOtazok = $row["pocet"];
        }


        $sql = "SELECT id FROM otazky_pre_dotaznik";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($otId = $result->fetch_array(MYSQLI_ASSOC)) {
            $otazkyID[] = $otId["id"];
        }


        $sql = "SELECT id FROM studijny_program WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $articleID);
        $stmt->execute();
        $articles = $stmt->get_result();


        /* kontrola ci su data validne */
        for ($i=1; $i <= $pocetOtazok; $i++) {
            $o = "otazka".$i;

            if ($articles->num_rows === 0) {
                    echo "<span>Hups, daný študijný program už neexistuje.</span>";
                    return;
                }
            else if (empty($_POST[$o]) || (trim($_POST[$o]) == '') ) {
                if ($i < $pocetOtazok) {
                    echo "<span>*Vyplň, prosím, všetky vyznačené polia</span>";
                    return;
                }
            }
            $dotaznikOdpovede[$i-1] = trim(filter_var($_POST[$o], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES|FILTER_FLAG_ENCODE_LOW));
        }


        /* pridam novu recenziu */
        $sql = "INSERT INTO recenzie (studijny_program_ID, autor) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        if ($autor == '') $autor = 'Anonym';
        $stmt->bind_param('is', $articleID, $autor);
        $success = $stmt->execute();
        $recenzia_id =  $conn->insert_id;


        /* priradim k nej dotaznik/odpovede */
        for ($i=0; $i < $pocetOtazok; $i++) {

            $sql = "INSERT INTO dotaznik (otazka_ID, recenzia_ID, odpoved) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('iis', $otazkyID[$i], $recenzia_id, $dotaznikOdpovede[$i]);
            $success = $stmt->execute();
        }


        /* zobrazim alert pre usera */
        echo <<<EOP
            <script>
                $('#dotaznik').modal('hide')
                const x = document.getElementById("snackbar");
                x.innerHTML = "Tvoja recenzia bola pridaná, ďakujeme.";   
                x.className = "show";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);     
            </script>
    
    EOP;
    }

