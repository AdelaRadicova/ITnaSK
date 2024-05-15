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

    $sp_id = $_GET['sp'];

    $sql = "SELECT f.id, f.nazov, sp.nazov as 'sp'
            FROM fakulta f
            INNER JOIN studijny_program sp ON sp.fakulta_ID=f.id 
            WHERE sp.id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sp_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $fakulta = $result->fetch_array(MYSQLI_ASSOC);

    if ($fakulta == null || empty($fakulta)) {
        header("Location: $err");
        exit();
    }

    $fakulta_id = $fakulta['id'];
    $nazovFakulty = $fakulta['nazov'];
    $sp_nazov = $fakulta['sp'];

    $sql = "SELECT *, vs.nazov as 'vs'
            FROM studijny_program sp
            INNER JOIN fakulta ON sp.fakulta_ID = fakulta.id 
            INNER JOIN vysoka_skola vs ON vs.id=fakulta.vysoka_skola_ID 
            WHERE sp.id=?;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sp_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $studijnyProgram = $result->fetch_array(MYSQLI_ASSOC);

    $editedWhen = $studijnyProgram['datum_aktualizacie_clanku'];
    $vyska = $studijnyProgram['vs'];


    echo <<<EOP
            <body>
            <div class="body">
                <small class='d-flex justify-content-end mb-3' style="font-style: italic; margin-right: 2em"> Naposledy aktualizované: $editedWhen </small>
                
                <div class="sp-header">
                    <h4 class='shadow-box mb-1' style="margin:0!important; min-width: 100%!important; padding: 0 1em">
                        <div class="d-flex align-items-start flex-column">
                        <div class="subheader-sp" style="font-weight: bolder; margin-top: 1em!important;"> $vyska </div>
                        <div class="subheader-sp" style="color: #c5a915; font-weight: bolder">$nazovFakulty</div>
                        <div class='subheader-sp w-100 d-flex justify-content-between' style="color: #4a9a95; font-weight: bolder"> $sp_nazov 
                        
                        <span class="d-flex justify-content-center align-items-end">
                        <button id="scroll-to-message" title="Recenzie" class="p-0"><i class="bi bi-chat-square-text-fill"></i></button>
                        </span>
                        
                        </div>
                        </div>
                    </h4>      
                </div>
                
                    
EOP;
?>


<div id="sp-clanok" class='spText'>

    <?php
        $clanok = $studijnyProgram['clanok'];

        echo $clanok;
    ?>
</div>


<div class="m-0 p-3" id="comment-section">

    <h3 class="comment-sect-title my-3 px-2" id="comm-sect-header"> Čo na študijný program povedali iní... </h3>

    <h6 class="comment-sect-title mb-3 px-2"> Študoval/-a si na tomto odbore?
        Zanechaj tu aj ty svoj názor pre ostatných... </h6>

    <button type="button" id="leaveComment" class="px-2" data-bs-toggle="modal" data-bs-target="#dotaznik">
        Chcem zanechať názor!
    </button>


    <!-- sortovacie buttony -->
    <div class="px-2 mt-5">
        <?php
            echo <<<EOP
            <div id="sortButts"> 
                <form id="sortDownForm" style="display: inline">
                <input type='hidden' id='articleIdSortDown' value=$sp_id>
                <button type='submit' title="Zoradiť od najnovšieho" id='sortDown'><i class="bi bi-sort-numeric-down"></i></button>
                </form>
                
                <form id="sortUpForm" style="display: inline">
                <input type='hidden' id='articleIdSortUp' value=$sp_id>
                <button type='submit' title="Zoradiť od najstaršieho" id='sortUp'><i class="bi bi-sort-numeric-up"></i></i></button>
                </form>
            </div>
EOP;
        ?>
    </div>


    <!-- dotaznik -->
    <?php
    echo <<<EOP
        <div class="modal fade bd-example-modal-lg" id="dotaznik" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">
                                Ďakujeme, že si nájdeš chvíľku na vyplnenie tohto dotazníka :)
                            </h5>
                            <button type="button" id="closeModal" class="close" data-bs-dismiss="modal" aria-label="Close" aria-hidden="true">
                                <i class="bi bi-x-square-fill"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="dotaznikForm" action="include_files/validateForm.php" method="post">
                                <input type="hidden" id="article" value=$sp_id>
                                <div class="form-group">
                                    <label for="autor" class="dotaznik-label">Uveď, prosím, svoje meno. (nepovinné)</label>
                                    <input type="text" class="form-control dotaznik-text" id="autor" placeholder=" ... ">
                                </div>
EOP;
                                dispOtazky($conn);

        echo <<<EOP
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <div id="formAlert" class="mr-auto text-danger font-weight-bold"></div>
                                    <div>
                                        <button type="button" class="btn btn-secondary" 
                                        onclick="resetDotaznik()" data-bs-dismiss="modal">Zavrieť</button>
                                        <button type="button" class="btn btn-danger" 
                                        onclick="resetDotaznik()">Zmazať</button>
                                        <button type='submit' id='submitRecenziu' class="btn">Odoslať</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
EOP;
        ?>

    <!-- sekcia pre komentare -->
    <div id="commDiv" class="comment-section-body px-2 pt-4 pb-2">
        <?php displayComments($sp_id, 5); ?>
    </div>


    <!-- load more button -->
    <?php dispLoadMoreCommButt($sp_id); ?>
</div>

    <!-- alert -->
    <div id="snackbar"></div>
</div>

<?php dispFooter(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="/scripts/script.js"></script>
<script src="/scripts/dotaznik.js"></script>
<!--
<script>
    let scriptPath = "";
    let scriptPathDotaznik = "";
    if (window.location.origin === "http://localhost") {
        scriptPath = window.location.origin + '/ITnaSK/scripts/script.js';
        scriptPathDotaznik = window.location.origin + '/ITnaSK/scripts/dotaznik.js';
    } else {
        scriptPath = window.location.origin + '/scripts/script.js';
        scriptPathDotaznik = window.location.origin + '/scripts/dotaznik.js';
    }

    let scriptElement = document.createElement('script');
    scriptElement.src = scriptPath;
    document.head.appendChild(scriptElement);

    let scriptElement2 = document.createElement('script');
    scriptElement2.src = scriptPathDotaznik;
    document.head.appendChild(scriptElement2);
</script>-->

</body>
</html>
