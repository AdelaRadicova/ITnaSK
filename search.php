<?php
    require_once 'include_files/navigation.php';
    include 'include_files/footer.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    function sanitizeData($data, $conn) : string {
        $Data = trim($data);
        $Data = strip_tags($Data);
        $Data = $conn->real_escape_string($Data);
        $Data = stripslashes($Data);
        return $Data;
    }
?>

<body>
<div class="body">

<?php
    if (isset($_POST['searchButt'])) {

        $search = sanitizeData($_POST['searchBar'], $conn);

        $sql = "SELECT sp.nazov, sp.id, vs.nazov as 'vs', f.nazov as 'fakulta'
                FROM vysoka_skola vs 
                JOIN fakulta f on vs.id = f.vysoka_skola_ID
                JOIN studijny_program sp on f.id = sp.fakulta_ID
                WHERE vs.nazov LIKE '%$search%' 
                OR vs.mesto LIKE '%$search%'
                OR vs.typ_skoly LIKE '%$search%'
                OR f.nazov LIKE '%$search%'
                OR sp.nazov LIKE '%$search%'
                OR sp.vyucovaci_jazyk LIKE '%$search%'
                OR sp.clanok LIKE '%$search%';";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result1 = $stmt->get_result();
        $queryResult1 = $result1->num_rows;


        $sql = "SELECT cl.id, cl.nadpis
                FROM clanok cl
                WHERE cl.nadpis LIKE '%$search%' 
                OR cl.clanok LIKE '%$search%';";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $queryResult2 = $result2->num_rows;


        echo "<h3 class='mb-3'>Výsledky vyhľadávania pre ". '"'. $search .'"' .  "...</h3>";
        if ($queryResult1+$queryResult2 == 0) {
            echo "<h6>Ľutujeme, pre zadaný výraz ". '"'. $search .'"' . " sa nenašla žiadna zhoda.</h6>";
        }
        else {
            $nOfResults = $queryResult1+$queryResult2;
            echo "<h6>Nájdených: ". $nOfResults . "</h6>";

            echo "<div class='mt-4'>";

            while ($zhoda = $result1->fetch_array(MYSQLI_ASSOC)) {
                $sp_id = $zhoda['id'];
                $title = $zhoda['nazov'];
                $vs =  $zhoda['vs'];
                $fakulta = $zhoda['fakulta'];

                echo <<<EOP
                            <a href='./studijny-program/$sp_id' class='clear-link'>
                            <div class="panel panel-default">
                                <div class="panel-body py-2 px-5">
                                        <div style="color: #efefef; font-weight: bolder">$vs</div>
                                        <div style="color: #c5a915; font-weight: bolder">$fakulta</div>

                                        <hr class="hr" />
                                        <div style="color: #4a9a95; font-weight: bolder">$title</div>
                                        
                                </div>
                            </div>
                            </a>
                            <br>
                        EOP;
            }

            while ($zhoda = $result2->fetch_array(MYSQLI_ASSOC)) {
                $cl_id = $zhoda['id'];
                $title = $zhoda['nadpis'];

                echo <<<EOP
                    <a href='./clanok/$cl_id' class='clear-link'>
                    <div class="panel panel-default">
                        <div class="panel-body">$title</div>
                    </div>
                    </a>
                    <br>
                EOP;
            }
            echo "</div>";
        }
    }
?>
</div>

<?php dispFooter(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="./scripts/script.js"></script>

</body>
<html