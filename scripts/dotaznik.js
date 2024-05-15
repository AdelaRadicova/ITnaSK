
/* dotaznik - modal */

function resetDotaznik() {
    document.getElementById("dotaznikForm").reset();
    document.getElementById("formAlert").innerHTML = " ";
}

/* prevents modal from closing ked sa klikne mimo neho */
$(document).ready(function () {
    $('#dotaznik').modal({
        backdrop: 'static',
        keyboard: false
    })
});

const dotaznik = document.getElementById("dotaznikForm");

dotaznik.addEventListener('submit', (event) => {
    event.preventDefault();

    let articleID = $("#article").val();
    let autor = $("#autor").val();
    let otazka_1 = $("#otazka1").val();
    let otazka_2 = $("#otazka2").val();
    let otazka_3 = $("#otazka3").val();
    let otazka_4 = $("#otazka4").val();
    let otazka_5 = $("#otazka5").val();
    let otazka_6 = $("#otazka6").val();
    let otazka_7 = $("#otazka7").val();
    let otazka_8 = $("#otazka8").val();
    let otazka_9 = $("#otazka9").val();
    let otazka_10 = $("#otazka10").val();
    let otazka_11 = $("#otazka11").val();
    let submitButt = $("#submitRecenziu").val();

    if (!checkInputs(otazka_1, otazka_2, otazka_3, otazka_4, otazka_5, otazka_6,
        otazka_7, otazka_8, otazka_9, otazka_10, otazka_11)) return;


    $("#formAlert").load("../include_files/validateForm.php", {
        article : articleID,
        autor : autor,
        otazka1 : otazka_1,
        otazka2 : otazka_2,
        otazka3 : otazka_3,
        otazka4 : otazka_4,
        otazka5 : otazka_5,
        otazka6 : otazka_6,
        otazka7 : otazka_7,
        otazka8 : otazka_8,
        otazka9 : otazka_9,
        otazka10 : otazka_10,
        otazka11 : otazka_11,
        submitButt : submitButt
    });

    setTimeout(refreshComments, 500, articleID);
});

function checkInputs(otazka_1, otazka_2, otazka_3, otazka_4, otazka_5,otazka_6, otazka_7, otazka_8, otazka_9, otazka_10) {

    if (otazka_1 === '' || otazka_2 === '' || otazka_3 === '' || otazka_4 === '' || otazka_5 === ''
        || otazka_6 === '' || otazka_7 === '' || otazka_8 === '' || otazka_9 === '' || otazka_10 === ''
    ) {
        document.getElementById("formAlert").innerHTML = "*Vyplň, prosím, všetky vyznačené polia";
        return false;
    }
    return true;
}

function refreshComments(id) {

    $(".comment-section-body").load("../include_files/commentSectionHandler.php", {
        article : id,
        limit : 5
    });
}

const loadMoreComm = document.getElementById("loadMoreComm");
let limitComm = 5;
loadMoreComm.addEventListener('submit', (event) => {
    event.preventDefault();

    limitComm =  limitComm + 3;
    let articleId = $("#articleId").val();

    $(".comment-section-body").load("../include_files/commentSectionHandler.php", {
        article : articleId,
        limit : limitComm
    });
});


const sortDownForm = document.getElementById("sortDownForm");
const sortUpForm = document.getElementById("sortUpForm");
sortDownForm.addEventListener('submit', (event) => {
    event.preventDefault();

    let articleId = $("#articleIdSortDown").val();

    $(".comment-section-body").load("../include_files/commentSectionHandler.php", {
        article : articleId,
        sortType : "down",
        limit : limitComm
    });
});

sortUpForm.addEventListener('submit', (event) => {
    event.preventDefault();

    let articleId = $("#articleIdSortUp").val();

    $(".comment-section-body").load("../include_files/commentSectionHandler.php", {
        article : articleId,
        sortType : "up",
        limit : limitComm
    });
});

let lastOpenedComm;
let lasOpenedCommButt;
function showCommentBody(commID) {

    let divId = "commBody" + commID;
    let div = document.getElementById(divId);
    let divButtId = "commButt" + commID;
    let divButt = document.getElementById(divButtId);

    /*kliknutim zavrie comment body, ak je otvorene*/
    if (div.style.display === "block") {
        div.style.display = "none";
        divButt.innerHTML = "... čítať viac";
    }
    else {
        /*kliknutim zavrie comment body predchadzajuceho otvoreneho komentara*/
        if (lastOpenedComm != null) {
            lastOpenedComm.style.display = "none";
            lasOpenedCommButt.innerHTML = "... čítať viac";
        }
        $("#" + divId).load("../include_files/commentSectionHandler.php", {
            commID : commID,
        });
        /*zobrazi comment body zakliknuteho komentara*/
        div.style.display = "block"
        divButt.innerHTML = "... zobraziť menej";
        lastOpenedComm = div;
        lasOpenedCommButt = divButt;
    }

}