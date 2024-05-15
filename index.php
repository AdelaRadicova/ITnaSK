<?php
    require_once 'include_files/navigation.php';
    include 'include_files/footer.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    function disp_subtitle($text, $margin) {
        echo <<<EOP
            <h4 class='shadow-box $margin'>
            <span class='logo-slash'>[</span>
            <span class='subtitle'>$text</span>
            <span class='logo-slash'>]</span>
            </h4>
        EOP;
    }

    function disp_thumbnails($conn, $mesto) {
        $root_url = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $root_url .= "s";
        }
        $root_url .= "://".$_SERVER['HTTP_HOST'];
        $root_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);

        $sql = "SELECT * FROM vysoka_skola WHERE mesto=?;";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $mesto);
        $stmt->execute();
        $vs_thumbnails = $stmt->get_result();

        while ($vs = $vs_thumbnails->fetch_array(MYSQLI_ASSOC)) {

            $vs_id = $vs['id'];
            $vysoka_skola = $vs['nazov'];
            $img = $vs['logo_img_src'];

            $path = $root_url . "upload_pictures/thumbnails/vs/" . $img;
            $redirect = $root_url . "fakulty/" . $vs_id;

            echo <<<EOP
            <div class='card-group'>
                <div class="card bg-light border-light">
                    <div class="row h-100">
                        <div class="col-5 h-100 d-flex align-items-stretch" style="padding: 0!important; background: white!important; justify-content: center!important;">
                            <img src="$path" alt="logo" class="img-fluid">
                        </div>
                    
                        <div class="col-7 p-auto" style="padding-left: 0!important;">
                            <div class="card-body h-100 d-flex flex-wrap justify-content-center align-items-center">
                                <div></div>
                                <h5 class="card-title d-flex align-items-center" style="text-align: center!important;">$vysoka_skola</h5>
                                <a href='$redirect' class="btn btn-secondary card-btn" 
                                style="background: #2f6562; color: #efefef">
                                Na výšku!
                                </a>
                             </div>
                        </div> 
                    </div>
                </div>
            </div>

            EOP;
        }
    }
?>

<body>

    <div class="body">

        <?php
            disp_subtitle("Chceš študovať IT v Bratislave?", "");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Bratislava");
            ?>
        </div>


        <?php
            disp_subtitle("... v Žiline?", "subtitle-margin");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Žilina");
            ?>
        </div>


        <?php
            disp_subtitle(" ... v Košiciach?", "subtitle-margin");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Košice");
            ?>
        </div>


        <?php
            disp_subtitle(" ... alebo v Trnave?", "subtitle-margin");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Trnava");
            ?>
        </div>


        <?php
            disp_subtitle(" ... čo takto v Nitre?", "subtitle-margin");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Nitra");
            ?>
        </div>


        <?php
            disp_subtitle(" ... skúsiť to môžeš aj v Banskej Bystrici", "subtitle-margin");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Banská Bystrica");
            ?>
        </div>


        <?php
            disp_subtitle(" ... a dokonca aj v Komárne!", "subtitle-margin");
        ?>
        <div class="thumbnail-section">
            <?php
                disp_thumbnails($conn, "Komárno");
            ?>
        </div>
    </div>

    <?php dispFooter(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="/scripts/script.js"></script>
</body>
</html>