<?php
    require_once 'include_files/navigation.php';
    require_once 'include_files/commentSectionHandler.php';
    include 'include_files/footer.php';
    date_default_timezone_set('Europe/Bratislava');

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

    $clanokId = $_GET['clanok'];

    $sql = "SELECT * FROM clanok WHERE clanok.id=?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clanokId);
    $stmt->execute();
    $result = $stmt->get_result();

    $clanok = $result->fetch_array(MYSQLI_ASSOC);

    if ($clanok == null || empty($clanok)) {
        header("Location: $err");
        exit();
    }

    $clanokNadpis = $clanok['nadpis'];
    $clanokObsah = $clanok['clanok'];
    $editedWhen = $clanok['datum_aktualizacie_clanku'];

    echo <<<EOP
            <body>
            <div class="body">
            
                 <small class='d-flex justify-content-end mb-1' style="font-style: italic"> Naposledy aktualizované: $editedWhen </small>
            
                <a href="../clanky" class="go-back-butt" style="width: fit-content; display: inline!important;">
                    <i class="bi bi-arrow-left-circle-fill"></i>
                </a>

                 <h4 class='shadow-box mb-1' style="display: inline-block!important">
                <span class='logo-slash'>[</span>
                <span class='subtitle'> $clanokNadpis </span>
                <span class='logo-slash'>]</span>
                </h4>      
    
                <div class='spText'>
                    $clanokObsah
                </div>
            </div>
            
EOP;

    dispFooter();
?>
                        
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="/scripts/script.js"></script>

</body>
</html>


