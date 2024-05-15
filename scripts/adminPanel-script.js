
// skryje vsetky panely
function hideAll() {
    panelPridajFakultu.style.display = "none";
    panelPridajVS.style.display = "none";
    panelUpravVS.style.display = "none";
    panelUpravFakultu.style.display = "none";
    panelZmazFakultu.style.display = "none";
    panelZmazVS.style.display = "none";
    panelPridajStudProg.style.display = "none";
    panelUpravStudProg.style.display = "none";
    panelZmazSP.style.display = "none";
    panelKomentare.style.display = "none";
    panelPridajClanok.style.display = "none";
    panelUpravClanok.style.display = "none";
    panelZmazClanok.style.display = "none";
    panelZmenitMeno.style.display = "none";
    panelZmenitHeslo.style.display = "none";
}

// counter znakov napisanych do input type text
function count(el, div, max) {
    let counter = document.getElementById(div);
    let len = document.getElementById(el).value.length;

    counter.innerText = len + '/' + max;
}

// po odoslani formulara sa formular vycisti od zadanych inputov
function clearForm() {
    document.getElementById("form1").reset();
    document.getElementById("form2").reset();
    document.getElementById("form3").reset();
    document.getElementById("form4").reset();
    document.getElementById("form5").reset();
    document.getElementById("form6").reset();
    document.getElementById("form7").reset();
    document.getElementById("form8").reset();
    document.getElementById("form9").reset()
    document.getElementById("form11").reset()
    document.getElementById("form12").reset()
}


// zobrazi v info-paneli informacie ku prislusnej VS, ktory pouzivatel vybral cez select
let vysokaSkola;
let fakulta, editorPanel;

function showVSInfo(skola) {
    let infoPanel;
    //document.getElementById("FakultaInfo1").innerHTML = "";
    document.getElementById("FakultaInfo2").innerHTML = "";

    switch (skola.name) {
        case "vsModifySelect":
            infoPanel = "VSinfo1";
            break;
        case "vsDeleteSelect":
            infoPanel = "VSinfo2";
            break;
    }

    vysokaSkola = skola.value;

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {

        const data = JSON.parse(xhttp.responseText);

        document.getElementById('nazovUpravVS').value = data.nazov;
        document.getElementById('mestoUprav').value = data.mesto;
        setOptionSelect('typSkolyUprav', data.typ_skoly);
        document.getElementById('vsLogo').textContent  = data.logo;
    }
    xhttp.open("GET", "vs/getVSInfo.php?id=" + vysokaSkola, true);
    xhttp.send();
}

// kontroluje zmenu VS v selecte
// prislusny select pre fakulty naplni spravnymi hodnotami (fakultami pre vybranu VS)
function changeFakultu(skola) {

    showVSInfo(skola);

    let fakultaSelect, fakultaSelectFilled;

    switch (skola.name) {
        case "vsModifySelectVSFak":
            fakultaSelect = "ModifySelectFakulta";
            fakultaSelectFilled = "FakultaSelect";
            break;
        case "vsDeleteFakSelectVS":
            fakultaSelect = "DeletSelectFakulta";
            fakultaSelectFilled = "FakultaSelectDelete";
            break;
        case "vsAddStudyProgSelectVS":
            fakultaSelect = "FSelectAddStudyProg";
            fakultaSelectFilled = "FakultaSelectAddStudyProg";
            break;
        case "vsModifyStudyProgSelectVS":
            fakultaSelect = "FSelectModifyStudyProg";
            fakultaSelectFilled = "FakultaSelectModifyStudyProg";
            break;
        case "vsDeleteSPSelectVS":
            fakultaSelect = "DeleteSPSelectFakulta";
            fakultaSelectFilled = "FakultaSelectDeleteSP";
            break;
    }

    if (vysokaSkola === "NULL") {
        document.getElementById(fakultaSelect).style.display = "none";
        return;
    }

    const xhttp2 = new XMLHttpRequest();
    xhttp2.onload = function() {
        document.getElementById(fakultaSelectFilled).innerHTML = this.responseText;
    }
    xhttp2.open("GET", "fakulta/getFakulty.php?id=" + vysokaSkola + "&select=" + fakultaSelect, true);
    xhttp2.send();
}


// zobrazi v info-paneli informacie ku prislusnej fakulte, ktoru pouzivatel vybral cez select
function showFakultaInfo(fakultaSelect) {

    let selectName = fakultaSelect.name;
    let infoPanel, SPSelect, SPSelectFilled;

    switch (selectName) {
        case "ModifySelectFakulta":
            infoPanel = "FakultaInfo1"
            break;
        case "DeletSelectFakulta":
            infoPanel = "FakultaInfo2"
            break;
        case "FSelectModifyStudyProg":
            infoPanel = null;
            SPSelect = "SPSelectModifySPnazovSP";
            SPSelectFilled = "modifySPSelectSP";
            editorPanel = "modifyStudyProgEditor";
            break;
        case "DeleteSPSelectFakulta":
            infoPanel = null;
            SPSelect = "SPSelectDeleteSPnazovSP";
            SPSelectFilled = "deleteSPSelectSP";
            editorPanel = null;
            break;
        default:
            infoPanel = null;
            break;
    }

    fakulta = fakultaSelect.value;

    if (fakulta === "NULL") {
        document.getElementById(infoPanel).innerHTML = "";
        return;
    }

    if (infoPanel) {

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            const data = JSON.parse(xhttp.responseText);
            document.getElementById('nazovUpravFakultu').value = data.nazov;
            document.getElementById('fkaLogo').textContent  = data.logo;
        }
        xhttp.open("GET", "fakulta/getFakultaInfo.php?id=" + fakulta + "&select=" + fakultaSelect, true);
        xhttp.send();
    }


    if (selectName === "FSelectModifyStudyProg" || selectName === "DeleteSPSelectFakulta") {

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById(SPSelectFilled).innerHTML = this.responseText;
        }
        xhttp.open("GET", "studijnyProgram/getStudProgs.php?vsId=" + vysokaSkola + "&fId=" + fakulta + "&select=" + SPSelect , true);
        xhttp.send();
    }
}

// zobrazi v text-editore prislusny clanok, podla vybraneho studijneho programu
function changeEditorContext(studyprog) {
    let spId = studyprog.value;

    if (spId !== "NULL") {

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {

            const data = JSON.parse(xhttp.responseText);

            console.log(data)
            document.getElementById('novyNazovModifyvSP').value = data.nazov;
            setOptionSelect('modifySPprijimacky', data.skusky);
            setOptionSelect('modifySPexterne', data.externe);
            setOptionSelect('modifySPjazyk', data.jazyk);
            CKEDITOR.instances[editorPanel].setData(data.clanok);
        }
        xhttp.open("GET", "studijnyProgram/getSPInfo.php?sp=" + spId , true);
        xhttp.send();
    }
    else {
        CKEDITOR.instances[editorPanel].setData("");
    }
}

function showClanokContent(clanok) {

    let clanokId = clanok.value;

    document.getElementById("modClanokId").setAttribute("value", clanokId);

    if (clanokId !== "NULL") {

        $("#modNadpisClanku").load("clanky/getClanok.php", {
            clId: clanokId
        }, function(responseText) {
            $("#modNadpisClanku").val(responseText);
        });

        const xhttp6 = new XMLHttpRequest();
        xhttp6.onload = function() {

            CKEDITOR.instances["modClanokEditor"].setData(this.responseText);
        }
        xhttp6.open("GET", "clanky/getClanok.php?id=" + clanokId , true);
        xhttp6.send();
    }
    else {
        CKEDITOR.instances[editorPanel].setData("");
    }
}

function changeKomentare(select) {
    let spId = select.value;

    $("#komentareDiv").load("komentare/getKomentare.php", {
        spId : spId,
    });
}

function setOptionSelect(select, option) {
    const selectEl = document.getElementById(select);
    const optionTextToMatch = option;
    for (let i = 0; i < selectEl.options.length; i++) {
        const option = selectEl.options[i];
        if (option.text === optionTextToMatch) {
            option.selected = true;
            break;
        }
    }
}
