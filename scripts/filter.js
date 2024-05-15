let VS, Mesto, Typ, Jazyk, Prijimacky, Externe;

document.getElementById("filterVS").onchange = function filterVS() {
    VS = this.value;
    filter();
}

document.getElementById("filterMesto").onchange = function filterMesto() {
    Mesto = this.value;
    filter();
}

document.getElementById("filterTypVS").onchange = function filterTypVS() {
    Typ = this.value;
    filter();
}

document.getElementById("filterJazyk").onchange = function filterJazyk() {
    Jazyk = this.value;
    filter();
}

function filterSkusky(f) {
    if (f.checked) {
        if (f.value === 'Áno') {
            Prijimacky = 'Áno';
        }
        else {
            Prijimacky = 'Nie';
        }
        filter();
    }
}

function filterExterne(f) {
    if (f.checked) {
        Externe = f.value;
        filter();
    }
}

function filter() {
    $("#spList").load("./include_files/filter.php", {
        vs : VS,
        mesto : Mesto,
        typ : Typ,
        jazyk : Jazyk,
        prijimacky : Prijimacky,
        externe : Externe
    });
}

function resetFilter() {
    document.getElementById("filterForm").reset();
    VS = null;
    Mesto = null;
    Typ = null;
    Jazyk = null;
    Prijimacky = null;
    Externe = null;
    $("#spList").load("./include_files/filter.php", { });
}

const filterButt = document.getElementById("showFilterButt");

function checkWidth() {
    if (window.innerWidth < 780) {
        filterButt.disabled = false;
    } else {
        filterButt.disabled = true;
    }
}

window.addEventListener("resize", checkWidth);

// check on load
checkWidth();


filterButt.addEventListener("click", () => {
    filterButt.classList.toggle("filter-active");
    document.getElementById("filter").classList.toggle("filterDisplay");
})

