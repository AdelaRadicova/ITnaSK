<?php
    require_once 'include_files/navigation.php';
    include 'include_files/footer.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    $root_url = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $root_url .= "s";
    }
    $root_url .= "://".$_SERVER['HTTP_HOST'];
    $root_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $err = $root_url . "404";

    $fakulta_id = $_GET['f'];


    $sql = "SELECT vs.id, vs.nazov, f.nazov as 'fakulta' 
            FROM vysoka_skola vs INNER JOIN fakulta f ON vs.id=f.vysoka_skola_ID 
            WHERE f.id=?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fakulta_id);
    $stmt->execute();
    $fakultyVS = $stmt->get_result();
    $fak = $fakultyVS->fetch_array(MYSQLI_ASSOC);

    if ($fak == null || empty($fak)) {
        header("Location: $err");
        exit();
    }

    $vs_id = $fak['id'];
    $vysoka_skola = $fak['nazov'];
    $fakulta_nazov = $fak['fakulta'];
?>

<body>
<div class='body' style="min-height: 100vh!important;">

    <?php
        /* sipka naspat */
        echo <<<EOP
            <a href="../fakulty/$vs_id" class="go-back-butt">
                <i class="bi bi-arrow-left-circle-fill"></i>
            </a>
        EOP;

        echo <<<EOP
                <h4 class='shadow-box' style="display: inline-block!important">
                <span class='logo-slash'>[</span>
                <span class='subtitle'>$fakulta_nazov :: študijné programy</span>
                <span class='logo-slash'>]</span>
                </h4>  
            EOP;

        $sql = "SELECT sp.id, sp.fakulta_ID, sp.nazov FROM studijny_program sp
                INNER JOIN fakulta ON sp.fakulta_ID = fakulta.id 
                INNER JOIN vysoka_skola ON vysoka_skola.id=fakulta.vysoka_skola_ID 
                WHERE sp.fakulta_ID=?;";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $fakulta_id);
        $stmt->execute();
        $studijneProgramy = $stmt->get_result();

        echo "<div class='w-md-100 w-50' style='margin: 0 6em'>";

        while ($sp = $studijneProgramy->fetch_array(MYSQLI_ASSOC)) {

            $sp_id = $sp['id'];
            $nazovSP = $sp['nazov'];

            echo <<<EOP
                <a href='../studijny-program/$sp_id' class='clear-link'>
                <div class="panel panel-default">
                    <div id="sp-box" class="panel-body py-2 px-5 sp-panel">$nazovSP</div>
                </div>
                </a>
                <br>
            EOP;
        }
        echo "</div>";
    ?>
</div>

<?php dispFooter(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="/scripts/script.js"></script>

</body>
</html>