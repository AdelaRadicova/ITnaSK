<?php
    require_once 'include_files/navigation.php';
    include 'include_files/footer.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }
?>

<body>

<div class="body" style="min-height: 100vh!important;">
    <?php

    echo <<<EOP
                <h4 class='shadow-box'>
                <span class='logo-slash'>[</span>
                <span class='subtitle'> Tu nájdeš články, ktoré sú zamerané na porovnanie študijných programov </span>
                <span class='logo-slash'>]</span>
                </h4>  
    EOP;

    $sql = "SELECT * FROM clanok";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $clanky = $stmt->get_result();

    echo "<div class='w-md-100 w-75' style='margin: 0 6em'>";

    while ($clanok = $clanky->fetch_array(MYSQLI_ASSOC)) {

        $clanok_id = $clanok['id'];
        $nadpis = $clanok['nadpis'];

        echo <<<EOP
                <a href='./clanok/$clanok_id' class='clear-link'>
                <div class="panel panel-default">
                    <div id="sp-box" class="panel-body py-2 px-5 sp-panel">$nadpis</div>
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
