<?php
    require_once 'include_files/navigation.php';
    include 'include_files/footer.php';
    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }

    echo "<body>";
    echo "<div class='body'>";

    echo <<<EOP
                <h4 class='shadow-box' style="display: inline-block!important">
                <span class='logo-slash'>[</span>
                <span class='subtitle'> Všetky študijné programy </span>
                <span class='logo-slash'>]</span>
                </h4>  
    EOP;

    function listallVS($conn) {
        $sql="SELECT nazov, id FROM vysoka_skola;";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $vsetkyVS = $stmt->get_result();

        echo "<select name='filterVS' id='filterVS' 
                            class='form-select form-select-sm w-100' aria-label='.form-select-sm example'>";
        echo "<option selected disabled value='all'>...</option>";
        while ($row = $vsetkyVS->fetch_array(MYSQLI_ASSOC)) {

            $n = $row['nazov'];
            $i = $row['id'];
            echo "<option value='$i'> $n </option>";
        }
        echo "</select>";
    }
?>


<div class="homepage-content mt-0">

    <div id="cont-f" class="container-fluid py-0 px-2">
        <div class="row flex-column-reverse flex-md-row flex-col">

            <!-- filter -->
            <div class="col-md-4 order-2 order-md-2 p-0 stretch">

                <div class="panel panel-default mb-5 mt-1 stretch">
                    <div class="panel-heading px-2" style="background-color: #404250">
                        <button id="showFilterButt" type="button" class="btn">
                            <i class="bi bi-filter" style="color: white"></i>
                        </button>
                    </div>
                    <div id="filter" class="panel-body clear-panel">
                        <form id="filterForm">
                            <div class="filter-group">
                                <label class="filterLabel">Vysoká škola: </label>
                                <?php
                                listallVS($conn);
                                ?>
                            </div>
                            <div class="filter-group">
                                <label class="filterLabel">Mesto: </label>
                                <select id="filterMesto" name="filterMesto" class="form-select form-select-sm w-100" aria-label=".form-select-sm example">
                                    <option selected disabled value="all"> ...</option>
                                    <option value="Bratislava">Bratislava</option>
                                    <option value="Trnava">Trnava</option>
                                    <option value="Žilina">Žilina</option>
                                    <option value="Košice">Košice</option>
                                    <option value="Nitra">Nitra</option>
                                    <option value="Banská Bystrica">Banská Bystrica</option>
                                    <option value="Komárno">Komárno</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filterLabel">Typ vysokej školy: </label>
                                <select id="filterTypVS" name="filterTypVS"
                                        class="form-select form-select-sm w-100" aria-label=".form-select-sm example">
                                    <option selected disabled value="all"> ...</option>
                                    <option value="Štátna">Štátna</option>
                                    <option value="Súkromná">Súkromná</option>
                                    <option value="Verejná">Verejná</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filterLabel">Vyučovací jazyk: </label>
                                <select id="filterJazyk" name="filterJazyk"
                                        class="form-select form-select-sm w-100" aria-label=".form-select-sm example">
                                    <option selected disabled value="all"> ...</option>
                                    <option value="Slovenský">Slovenský</option>
                                    <option value="Anglický">Anglický</option>
                                    <option value="Maďarský">Maďarský</option>
                                    <option value="Iný">Iný</option>
                                </select>
                            </div>
                            <div class="filter-group" id="filterSkusky">
                                <label class="filterLabel">Prijímacie skúšky: </label><br>
                                <label class="radio-inline filterRadioButt">
                                    <input type="radio" name="prSkusky" id="filterSkuskyA" value="Áno" onclick="filterSkusky(this)">
                                    Áno
                                </label>
                                <label class="radio-inline filterRadioButt">
                                    <input type="radio" name="prSkusky" id="filterSkuskyN" value="Nie" onclick="filterSkusky(this)">
                                    Nie
                                </label>
                            </div>
                            <div class="filter-group">
                                <label class="filterLabel">Externé štúdium: </label><br>
                                <label class="radio-inline filterRadioButt">
                                    <input type="radio" name="externe" id="filterExterneA" value="Áno" onclick="filterExterne(this)">
                                    Áno
                                </label>
                            </div>
                            <button type="button" class="filterButt resetButt" onclick="resetFilter()">Reset</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- studijne programy - list -->
            <div class="col-md-8 order-1 order-md-1 p-0 stretch">

                <div id="spList" class='container-fluid spList-w-md-100 d-flex justify-content-left flex-column mt-1'>

                    <?php

                    $sql = "SELECT sp.id, sp.fakulta_ID, sp.nazov, vysoka_skola.nazov as 'vs', fakulta.nazov as 'fakulta' 
                            FROM studijny_program sp
                            INNER JOIN fakulta ON sp.fakulta_ID = fakulta.id 
                            INNER JOIN vysoka_skola ON vysoka_skola.id=fakulta.vysoka_skola_ID ;";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $studijneProgramy = $stmt->get_result();

                    while ($sp = $studijneProgramy->fetch_array(MYSQLI_ASSOC)) {

                        $sp_id = $sp['id'];
                        $nazovSP = $sp['nazov'];
                        $vs = $sp['vs'];
                        $fakulta = $sp['fakulta'];

                        echo <<<EOP
                            <a href='./studijny-program/$sp_id' class='clear-link mb-4'>
                            <div class="panel panel-default">
                                <div class="panel-body py-2 px-5">
                                        <div style="color: #efefef; font-weight: bolder">$vs</div>
                                        <div style="color: #c5a915; font-weight: bolder">$fakulta</div>

                                        <hr class="hr" />
                                        <div style="color: #4a9a95; font-weight: bolder">$nazovSP</div>
                                        
                                </div>
                            </div>
                            </a>
                        EOP;
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php dispFooter(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="/scripts/script.js"></script>
<script src="/scripts/filter.js"></script>
</body>
</html>