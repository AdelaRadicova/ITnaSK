<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Favicon-->
    <link rel="icon" type="image/x-icon" href="../img_style/favicon_io/favicon.ico">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!--Style-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300&display=swap" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- My style -->
    <link rel="stylesheet" href="../styles/adminPanel-style.css">

    <title>Študuj IT na SK!</title>
</head>
<?php
    require_once '../include_files/dbs.php';
    require_once 'dispFunctions.php';

    session_start();
    if (!isset($_SESSION['admin'])) {
        header("location: ../admin-login");
        exit();
    }

    if (isset($_POST['buttOdhlasit'])) {
        session_destroy();
        header("location: ../admin-login");
        exit();
    }

    $conn = connectDbs();

    if ($conn -> connect_errno) {
        echo "Failed to connect to MySQL: " . $conn -> connect_error;
        exit();
    }
?>


<body>
    <!-- Side-menu navbar inspirovany: https://www.youtube.com/watch?v=x977EY47d-M -->
    <nav class="navbar navbar-expand d-flex flex-column alighn-item-start justify-content-between" id="sidebar">

        <div class="w-100 m-4">

            <a href="#" class="navbar-brand text-light">
                <div class="display-5 font-weight-bold"> IT na SK </div>
            </a>
            <hr class="my-1 mx-3"/>

            <ul class="navbar-nav d-flex flex-column mt-4 w-100">
                <li class="nav-item w-100">
                    <button type="button" id="buttDomov" class="nav-but w-100 text-light p-2 mb-4">
                        <i class="bi bi-house"></i> Domovská stránka
                    </button>
                </li>

                <li class="nav-item dropdown w-100">
                    <button type="button" class="nav-but dropdown-toggle text-light w-100 p-2" id="navbarDropdown1" data-bs-toggle='dropdown'
                            aria-expanded="false"><i class="bi bi-plus-square-dotted"></i> Pridať</button>
                    <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown1">
                        <li>
                            <button type="button" id="buttPridatVS" class="sub-but w-100 text-light p-2">
                                Vysoká škola
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttPridatFakultu" class="sub-but w-100 text-light p-2">
                                Fakulta
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttPridatStudProg" class="sub-but w-100 text-light p-2">
                                Študijný program
                            </button>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <button type="button" id="buttPridatClanok" class="sub-but w-100 text-light p-2">
                                Článok
                            </button>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown w-100">
                    <button type="button" class="nav-but dropdown-toggle text-light w-100 p-2" id="navbarDropdown2" data-bs-toggle='dropdown'
                            aria-expanded="false"><i class="bi bi-pencil-square"></i> Upraviť</button>
                    <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown2">
                        <li>
                            <button type="button" id="buttUpravVS" class="sub-but w-100 text-light p-2">
                                Vysoká škola
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttUpravFakultu" class="sub-but w-100 text-light p-2">
                                Fakulta
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttUpravStudProg" class="sub-but w-100 text-light p-2">
                                Študijný program
                            </button>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <button type="button" id="buttUpravClanok" class="sub-but w-100 text-light p-2">
                                Článok
                            </button>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown w-100">
                    <button type="button" class="nav-but dropdown-toggle text-light w-100 p-2" id="navbarDropdown3" data-bs-toggle='dropdown'
                            aria-expanded="false"><i class="bi bi-eraser"></i> Zmazať</button>
                    <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown3">
                        <li>
                            <button type="button" id="buttZmazatVS" class="sub-but w-100 text-light p-2">
                                Vysoká škola
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttZmazatFakultu" class="sub-but w-100 text-light p-2">
                                Fakulta
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttZmazatStudProg" class="sub-but w-100 text-light p-2">
                                Študijný program
                            </button>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <button type="button" id="buttZmazatClanok" class="sub-but w-100 text-light p-2">
                                Článok
                            </button>
                        </li>
                    </ul>
                </li>

                <li class="nav-item w-100">
                    <button type="button" id="buttKomentare" class="nav-but w-100 text-light p-2 mb-4">
                        <i class="bi bi-chat-square-text"></i> Komentáre
                    </button>
                </li>

                <li class="nav-item dropdown w-100">
                    <button type="button" class="nav-but dropdown-toggle text-light w-100 p-2" id="navbarDropdown4" data-bs-toggle='dropdown'
                            aria-expanded="false"><i class="bi bi-gear"></i> Nastavenia</button>
                    <ul class="dropdown-menu w-100" aria-labelledby="navbarDropdown4">
                        <li>
                            <button type="button" id="buttZmenMeno" class="sub-but w-100 text-light p-2">
                                Zmeniť meno
                            </button>
                        </li>
                        <li>
                            <button type="button" id="buttZmenHeslo" class="sub-but w-100 text-light p-2">
                                Zmeniť heslo
                            </button>
                        </li>
                    </ul>
                </li>
            </div>

            <div class="w-100">
                <ul class="navbar-nav d-flex flex-column mt-4 w-100">
                    <li class="nav-item w-100">
                        <form method="POST" class="alighn-end">
                            <button type="submit" class="nav-but w-100 text-light p-2" name="buttOdhlasit" id="buttOdhlasit">
                                <i class="bi bi-box-arrow-left"></i> Odhlásiť sa
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </ul>
    </nav>


    <!-- Forms -->
    <section class="p-4 my-container">
        <!-- Toggle butt for mob version -->
        <button class="btn my-4" id="menu-btn">
            Menu
        </button>

        <h1 id="mode">Domovská stránka</h1>

<!-- PRIDAT -->

        <!-- Pridat VS -->
        <div class="panel" id="panelPridatVS">
            <form action="vs/addVS.php" method="POST" class="panel-content" id="form1">
                <span class="warn"><span style="text-decoration: underline; font-weight: bolder">Upozornenie:</span>
                    Názov vysokej školy musí byť unikátny!</span>
                <div class="panel-element">
                    <label for="nazovVS">Vysoká škola: </label>
                    <input type="text" id="nazovVS" name="nazovVS" maxlength="128" required placeholder="..."
                           oninput="count('nazovVS', 'nazovVSX', 128)">
                    <div class="" id="nazovVSX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="mesto">Mesto: </label>
                    <input type="text" id="mesto" name="mesto" maxlength="128" required placeholder="..."
                           oninput="count('mesto', 'mestoX', 128)">
                    <div class="" id="mestoX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="typSkoly">Typ školy: </label>
                    <select id="typSkoly" name="typSkoly">
                        <option value='NULL' selected>...</option>
                        <option value="Štátna">Štátna</option>
                        <option value="Súkromná">Súkromná</option>
                        <option value="Verejná">Verejná</option>
                        <option value="Neuvedené">Neuvedené</option>
                    </select>
                </div>
                <div class="panel-element" style="margin-top: 3em">
                    <label for="logoVS">Logo: </label>
                    <input type="file" id="logoVS" name="logoVS">
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitPridatVS" id="submitPridatVS" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-upload"></i> Pridať
                    </button>
                </div>
            </form>
        </div>

        <!-- Pridat FAKULTU -->
        <div class="panel" id="panelPridatFakultu">
            <form action="fakulta/addFakulta.php" method="POST" class="panel-content" id="form2">
                <div class="panel-element">
                    <label for="vsSelect">Vysoká škola: </label>
                    <?php
                        listallVS($conn, "vsSelect", NULL);
                    ?>
                </div>
                <div class="panel-element">
                    <label for="nazov">Fakulta: </label>
                    <input type="text" id="nazovFak" name="nazovFak" maxlength="128" placeholder="..."
                           required oninput="count('nazovFak', 'nazovFakX', 128)">
                    <div class="" id="nazovFakX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="logo">Logo: </label>
                    <input type="file" id="logoF" name="logoF">
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitPridatFak" id="submitPridatFak" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-upload"></i> Pridať
                    </button>
                </div>
            </form>
        </div>

        <!-- Pridat STUD.PROG. -->
        <div class="panel" id="panelPridatStudProg">
            <form action="studijnyProgram/addStudyProg.php" method="POST" class="panel-content" id="form3">
                <div class="panel-element">
                    <label for="vsAddStudyProgSelectVS">Vysoká škola: </label>
                    <?php
                        listallVS($conn, "vsAddStudyProgSelectVS", "changeFakultu");
                    ?>
                </div>
                <div class="panel-element" id="FakultaSelectAddStudyProg">
                    <label for='FSelectAddStudyProg'>Fakulta: </label>
                </div>
                <div class="panel-element">
                    <label for="addSPnazovSP">Študijný program: </label>
                    <input type="text" id="addSPnazovSP" name="addSPnazovSP" maxlength="128" required placeholder="..."
                           oninput="count('addSPnazovSP', 'addSPnazovSPX', 128)">
                    <div class="" id="addSPnazovSPX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="addSPprijimacky">Prijímacie skúšky: </label>
                    <select id="addSPprijimacky" name="addSPprijimacky">
                        <option value='' selected>...</option>
                        <option value="Áno">Áno</option>
                        <option value="Nie">Nie</option>
                        <option value="Neuvedené">Neuvedené</option>
                    </select>
                </div>
                <div class="panel-element">
                    <label for="addSPexterne">Ponuka externého štúdia: </label>
                    <select id="addSPexterne" name="addSPexterne">
                        <option value='' selected>...</option>
                        <option value="Áno">Áno</option>
                        <option value="Nie">Nie</option>
                        <option value="Neuvedené">Neuvedené</option>
                    </select>
                </div>
                <div class="panel-element">
                    <label for="addSPjazyk">Vyučovací jazyk: </label>
                    <select id="addSPjazyk" name="addSPjazyk">
                        <option value='' selected>...</option>
                        <option value="Slovenský">Slovesnký</option>
                        <option value="Anglický">Anglický</option>
                        <option value="Maďarský">Maďarský</option>
                        <option value="Iný">Iný</option>
                    </select>
                </div>
                <div class="panel-element">
                    <label for="addSPclanok" style="margin-bottom: 1.3em">Popis: </label>
                    <br><textarea required name="addStudyProgEditor"></textarea>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitPridatStudProg" id="submitPridatStudProg" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-upload"></i> Pridať
                    </button>
                </div>
            </form>
        </div>

        <!-- Pridat CLANOK -->
        <div class="panel" id="panelPridatClanok">
            <form action="clanky/addClanok.php" method="POST" class="panel-content" id="form11">

                <div class="panel-element">
                    <label for="addNadpisClanku">Nadpis: </label>
                    <input type="text" id="addNadpisClanku" name="addNadpisClanku" maxlength="200" required placeholder="..."
                           oninput="count('addNadpisClanku', 'addNadpisClankuX', 200)">
                    <div class="" id="addNadpisClankuX" style="text-align: right">0/200</div>
                </div>
                <div class="panel-element">
                    <label for="addClanok" style="margin-bottom: 1.3em">Článok: </label>
                    <br><textarea required name="addClanokEditor"></textarea>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitPridatClanok" id="submitPridatClanok" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-upload"></i> Pridať
                    </button>
                </div>
            </form>
        </div>



<!-- UPRAVIT -->
        <!-- Upravit VS -->
        <div class="panel" id="panelUpravitVS">
            <form action="vs/modifyVS.php" method="POST" class="panel-content" id="form4">
                <span class="warn"><span style="text-decoration: underline; font-weight: bolder">Upozornenie:</span>
                    Názov vysokej školy musí byť unikátny!</span>
                <div class="panel-element">
                    <label for="vsModifySelect">Vysoká škola: </label>
                    <?php
                        listallVS($conn, "vsModifySelect", "showVSInfo");
                    ?>
                </div>
                <div class="panel-element" style="margin-top: 3em">
                    <label for="nazovUpravVS">Názov: </label>
                    <input type="text" id="nazovUpravVS" name="nazovUpravVS" maxlength="128" placeholder="..."
                           oninput="count('nazovUpravVS', 'nazovUpravVSX', 128)">
                    <div class="" id="nazovUpravVSX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="mestoUprav">Mesto: </label>
                    <input type="text" id="mestoUprav" name="mestoUprav" maxlength="128" placeholder="..."
                           oninput="count('mestoUprav', 'mestoUpravX', 128)">
                    <div class="" id="mestoUpravX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="typSkolyUprav">Typ školy: </label>
                    <select id="typSkolyUprav" name="typSkolyUprav">
                        <option value='NULL' selected>...</option>
                        <option value="Štátna">Štátna</option>
                        <option value="Súkromná">Súkromná</option>
                        <option value="Verejná">Verejná</option>
                        <option value="Neuvedené">Neuvedené</option>
                    </select>
                </div>
                <div class="panel-element" style="margin-top: 3em">
                    <label for="logoVSUprav">Logo: </label>
                    <input type="file" id="logoVSUprav" name="logoVSUprav">
                </div>
                <div class="panel-element" id="VSinfo1">
                    <table class='VSInfoTable'>
                        <tr>
                            <th> Logo </th>
                            <td id="vsLogo"> </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitUpravitVS" id="submitUpravitVS" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-pencil-square"></i> Upraviť
                    </button>
                </div>
            </form>
        </div>


        <!-- Upravit FAKULTU -->
        <div class="panel" id="panelUpravitFakultu">
            <form action="fakulta/modifyFakultu.php" method="POST" class="panel-content" id="form5">
                <div class="panel-element">
                    <label for="vsModifySelectVSFak">Vysoká škola: </label>
                    <?php
                        listallVS($conn, "vsModifySelectVSFak", "changeFakultu");
                    ?>
                </div>
                <div class="panel-element" id="FakultaSelect">
                    <label for='ModifySelectFakulta'>Fakulta: </label>
                </div>
                <div class="panel-element">
                    <label for="nazovUpravFakultu">Názov: </label>
                    <input type="text" id="nazovUpravFakultu" name="nazovUpravFakultu" maxlength="128" placeholder="..."
                           oninput="count('nazovUpravFakultu', 'nazovUpravFakultuX', 128)">
                    <div class="" id="nazovUpravFakultuX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="logoFakUprav">Nové logo: </label>
                    <input type="file" id="logoFakUprav" name="logoFakUprav">
                </div>
                <div class="panel-element" id="FakultaInfo1">
                    <table class='FInfoTable'>
                        <tr>
                            <th> Logo </th>
                            <td id="fkaLogo"> </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitUpravitFak" id="submitUpravitFak" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-pencil-square"></i> Upraviť
                    </button>
                </div>
            </form>
        </div>


        <!-- Upravit STUDIJNY PROGRAM -->
        <div class="panel" id="panelUpravitStudProg">
            <form action="studijnyProgram/modifyStudyProg.php" method="POST" class="panel-content" id="form6">
                <div class="panel-element">
                    <label for="vsModifyStudyProgSelectVS">Vysoká škola: </label>
                    <?php
                        listallVS($conn, "vsModifyStudyProgSelectVS", "changeFakultu");
                    ?>
                </div>
                <div class="panel-element" id="FakultaSelectModifyStudyProg">
                    <label for='FSelectModifyStudyProg'>Fakulta: </label>
                </div>
                <div class="panel-element" id="modifySPSelectSP">
                    <label for="SPSelectModifySPnazovSP">Študijný program: </label>
                </div>
                <div class="panel-element">
                    <label for="novyNazovModifyvSP">Názov: </label>
                    <input type="text" id="novyNazovModifyvSP" name="novyNazovModifyvSP" maxlength="128" placeholder="..."
                           oninput="count('novyNazovModifyvSP', 'novyNazovModifyvSPX', 128)">
                    <div class="" id="novyNazovModifyvSPX" style="text-align: right">0/128</div>
                </div>
                <div class="panel-element">
                    <label for="modifySPprijimacky">Prijímacie skúšky: </label>
                    <select id="modifySPprijimacky" name="modifySPprijimacky">
                        <option value='NULL' selected disabled>...</option>
                        <option value="Áno">Áno</option>
                        <option value="Nie">Nie</option>
                        <option value="Neuvedené">Neuvedené</option>
                    </select>
                </div>
                <div class="panel-element">
                    <label for="modifySPexterne">Ponuka externého štúdia: </label>
                    <select id="modifySPexterne" name="modifySPexterne">
                        <option value='NULL' selected disabled>...</option>
                        <option value="Áno">Áno</option>
                        <option value="Nie">Nie</option>
                        <option value="Neuvedené">Neuvedené</option>
                    </select>
                </div>
                <div class="panel-element">
                    <label for="modifySPjazyk">Vyučovací jazyk: </label>
                    <select id="modifySPjazyk" name="modifySPjazyk">
                        <option value='NULL' selected disabled>...</option>
                        <option value="Slovenský">Slovenský</option>
                        <option value="Anglický">Anglický</option>
                        <option value="Maďarský">Maďarský</option>
                        <option value="Iný">Iný</option>
                    </select>
                </div>
                <div class="panel-element">
                    <label for="modifySPclanok" style="margin-bottom: 1.3em">Popis: </label>
                    <br>
                    <textarea name="modifyStudyProgEditor"></textarea>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitUpravitStudProg" id="submitUpravitStudProg" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-upload"></i> Upraviť
                    </button>
                </div>
                </div>
            </form>
        </div>


        <!-- Upravit CLANOK -->
        <div class="panel" id="panelUpravitClanok">
            <form action="clanky/modifyClanok.php" method="POST" class="panel-content" id="form12">
                <input type="hidden" name="modClanokId" id="modClanokId">
                <div class="panel-element">
                    <label for="clanokModSelect">Článok: </label>
                    <?php
                    listAllClanky($conn, "clanokModSelect", "showClanokContent");
                    ?>
                </div>
                <div class="panel-element">
                    <label for="modNadpisClanku">Nadpis: </label>
                    <input type="text" id="modNadpisClanku" name="modNadpisClanku" maxlength="200" placeholder="..."
                           oninput="count('modNadpisClanku', 'modNadpisClankuX', 200)">
                    <div class="" id="modNadpisClankuX" style="text-align: right">0/200</div>
                </div>
                <div class="panel-element">
                    <label for="modClanok" style="margin-bottom: 1.3em">Článok: </label>
                    <br><textarea required name="modClanokEditor"></textarea>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitUpravitClanok" id="submitUpravitClanok" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-upload"></i> Upraviť
                    </button>
                </div>
            </form>
        </div>


<!-- ZMAZAT -->

        <!-- Zmazat VS -->
        <div class="panel" id="panelZmazatVS">
            <form action="vs/deleteVS.php" method="POST" class="panel-content" id="form7">
                <span class="warn" style="margin-bottom: 3.5em"><span style="text-decoration: underline; font-weight: bolder">Upozornenie:</span>
                     &nbsp;Po odstránení vysokej školy, sa spolu s ňou vymažú <br>aj prislúchajúce fakulty a študijné odbory!</span>
                <div class="panel-element">
                    <label for="vsDeleteSelect">Vysoká škola: </label>
                    <?php
                        listallVS($conn, "vsDeleteSelect", "showVSInfo");
                    ?>
                </div>
                <div class="panel-element" id="VSinfo2"></div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" class="deleteButt" name="submitVymazatVS" id="submitVymazatVS" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-trash3-fill"></i> <span style="font-weight: bolder">Vymazať</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Zmazat FAKULTU -->
        <div class="panel" id="panelZmazatFakultu">
            <form action="fakulta/deleteFakultu.php" method="POST" class="panel-content" id="form8">
                <span class="warn" style="margin-bottom: 3.5em"><span style="text-decoration: underline; font-weight: bolder">Upozornenie:</span>
                     &nbsp;Po odstránení fakulty, sa spolu s ňou vymažú <br>aj prislúchajúce študijné odbory!</span>
                <div class="panel-element">
                    <label for="vsDeleteFakSelectVS">Vysoká škola: </label>
                    <?php
                    listallVS($conn, "vsDeleteFakSelectVS", "changeFakultu");
                    ?>
                </div>
                <div class="panel-element" id="FakultaSelectDelete">
                    <label for='DeleteSelectFakulta'>Fakulta: </label>
                </div>
                <div class="panel-element" id="FakultaInfo2"></div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" class="deleteButt" name="submitVymazatFakultu" id="submitVymazatFakultu" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-trash3-fill"></i> <span style="font-weight: bolder">Vymazať</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Zmazat STUDIJNY PROGRAM -->
        <div class="panel" id="panelZmazatStudyProg">
            <form action="studijnyProgram/deleteSP.php" method="POST" class="panel-content" id="form9">
                <div class="panel-element">
                    <label for="vsDeleteSPSelectVS">Vysoká škola: </label>
                    <?php
                    listallVS($conn, "vsDeleteSPSelectVS", "changeFakultu");
                    ?>
                </div>
                <div class="panel-element" id="FakultaSelectDeleteSP">
                    <label for='DeleteSPSelectFakulta'>Fakulta: </label>
                </div>
                <div class="panel-element" id="deleteSPSelectSP">
                    <label for="SPSelectDeleteSPnazovSP">Študijný program: </label>
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" class="deleteButt" name="submitVymazatSP" id="submitVymazatSP" onclick="setTimeout('clearForm()', 1500)">
                        <i class="bi bi-trash3-fill"></i> <span style="font-weight: bolder">Vymazať</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Zmazat CLANOK -->
        <div class="panel" id="panelZmazatClanok">
            <div id="clankyDiv" class="container">
                <?php
                dispAllClanky($conn);
                ?>
            </div>
        </div>

        <!-- Zmazat KOMENTAR -->
        <div class="panel" id="panelKomentare">
            <div id="komentareSelectSP" class="panel-element">
                <label for="komentareSelectSP" class="mb-2" style="display: block">Študijný program: </label>
                <?php
                listallSP($conn, "komentareSelectSP", "changeKomentare");
                ?>
            </div>

            <div id="komentareDiv" class="container">
            </div>
        </div>


        <!-- ZMENA MENA -->
        <div class="panel" id="panelZmenitMeno">
            <form action="/admin_system/userHandler.php?m=updateAdminName" method="POST" class="panel-content" id="formModName">
                <div class="panel-element">
                    <label for="userName">Meno: </label>
                    <input type="text" id="userName" name="userName" style="background: #3f8984" value="<?php echo $_SESSION['admin'] ?>">
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitZmenitMeno" id="submitZmenitMeno">
                        <i class="bi bi-pencil-square"></i> Zmeniť
                    </button>
                </div>
            </form>
        </div>


        <!-- ZMENA HESLA -->
        <div class="panel" id="panelZmenitHeslo">
            <form action="/admin_system/userHandler.php?m=updateAdminPassw" method="POST" class="panel-content" id="formModPassw">
                <div class="panel-element">
                    <label for="userPassw">Heslo: </label>
                    <input type="text" id="userPassw" name="userPassw" style="background: #3f8984" value="<?php echo $_SESSION['adminPassw'] ?>">
                </div>
                <div class="panel-element" style="text-align: right">
                    <button type="submit" name="submitZmenitHeslo" id="submitZmenitHeslo">
                        <i class="bi bi-pencil-square"></i> Zmeniť
                    </button>
                </div>
            </form>
        </div>

    </section>

    <script src="../ckeditor/ckeditor.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="../scripts/declarations-script.js"></script>
    <script src="../scripts/listeners-script.js"></script>
    <script src="../scripts/adminPanel-script.js"></script>
    <script src="../scripts/ckeditor-script.js"></script>
</body>
</html>
