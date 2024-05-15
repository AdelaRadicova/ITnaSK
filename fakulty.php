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

    $vs_id = $_GET['vs'];

    $sql = "SELECT nazov FROM vysoka_skola WHERE id=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vs_id);
    $stmt->execute();
    $result= $stmt->get_result();
    $vs = $result->fetch_array(MYSQLI_ASSOC);

    if ($vs == null || empty($vs)) {
        header("Location: $err");
        exit();
    }

    $vs_nazov = $vs['nazov'];
?>

<body>
<div class='body'>

<?php

    echo <<<EOP
            <a href="../" class="go-back-butt" style="width: fit-content; display: inline!important;">
                <i class="bi bi-arrow-left-circle-fill"></i>
            </a>
EOP;


    echo <<<EOP
            <h4 class='shadow-box' style="display: inline-block!important">
            <span class='logo-slash'>[</span>
            <span class='subtitle'>$vs_nazov :: fakulty</span>
            <span class='logo-slash'>]</span>
            </h4>
EOP;

    echo "<div class='fak-thumbnail' style='gap: 0!important;'>";

    $sql = "SELECT fakulta.nazov, fakulta.logo_img_src, fakulta.id 
            FROM fakulta 
            INNER JOIN vysoka_skola ON vysoka_skola.id=fakulta.vysoka_skola_ID 
            WHERE vysoka_skola_ID=?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vs_id);
    $stmt->execute();
    $fakulty = $stmt->get_result();


    while ($fakulta = $fakulty->fetch_array(MYSQLI_ASSOC)) {

        $fakulta_id = $fakulta['id'];
        $img = $fakulta['logo_img_src'];
        $nazovFakulty = $fakulta['nazov'];

        $path = $root_url . "upload_pictures/thumbnails/fakulty/" . $img;

        echo <<<EOP
            <a href='../studijne-programy-fakulty/$fakulta_id' class='clear-link setLink'>
                <section class='thumbnail-box thumbnail-box-fak'>
                    <img class=img-thumbnail src=$path alt='logo'>
                    <div class='center thumbnail-header'> $nazovFakulty </div>
                </section>
            </a>
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
