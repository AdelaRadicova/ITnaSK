// zobrazi/skryje menu pri mobilnej verzii
menu_btn.addEventListener("click", () => {
    sidebar.classList.toggle("active-nav");
    container.classList.toggle("active-cont");
})


// vrati pouzovatela na domovsku stranku
domov.addEventListener("click", () => {
    nadpis.innerHTML = "Domovská stránka";
    hideAll();
})


// zobrazi panel pre pridanie novej VS
pridatVSButt.addEventListener("click", () => {
    nadpis.innerHTML = "Pridať vysokú školu";
    hideAll();
    panelPridajVS.style.display = "flex";
})

// zobrazi panel pre pridanie novej fakulty
pridatFakButt.addEventListener("click", () => {
    nadpis.innerHTML = "Pridať fakultu";
    hideAll();
    panelPridajFakultu.style.display = "flex";
})

// zobrazi panel pre pridanie studijneho programu
pridatStudProgButt.addEventListener("click", () => {
    nadpis.innerHTML = "Pridať študijný program";
    hideAll();
    panelPridajStudProg.style.display = "flex";
})

// zobrazi panel pre pridanie clanku
pridatClanokButt.addEventListener("click", () => {
    nadpis.innerHTML = "Pridať článok";
    hideAll();
    panelPridajClanok.style.display = "flex";
})

// zobrazi panel pre upravu VS
upravitVSButt.addEventListener("click", () => {
    nadpis.innerHTML = "Upraviť vysokú školu";
    hideAll();
    panelUpravVS.style.display = "flex";

})

// zobrazi panel pre upravu fakulty
upravitFakultuButt.addEventListener("click", () => {
    nadpis.innerHTML = "Upraviť fakultu";
    hideAll();
    panelUpravFakultu.style.display = "flex";

})

// zobrazi panel pre upravu studijneho programu
upravitStudProgButt.addEventListener("click", () => {
    nadpis.innerHTML = "Upraviť študijný program";
    hideAll();
    panelUpravStudProg.style.display = "flex";

})

// zobrazi panel pre upravu clanku
upravitClanokButt.addEventListener("click", () => {
    nadpis.innerHTML = "Upraviť článok";
    hideAll();
    panelUpravClanok.style.display = "flex";

})

// zobrazi panel pre odstranenie VS
zmazatVSButt.addEventListener("click", () => {
    nadpis.innerHTML = "Odstrániť vysokú školu";
    hideAll();
    panelZmazVS.style.display = "flex";

})

// zobrazi panel pre odstranenie fakulty
zmazatFakultuButt.addEventListener("click", () => {
    nadpis.innerHTML = "Odstrániť fakultu";
    hideAll();
    panelZmazFakultu.style.display = "flex";
})

// zobrazi panel pre odstranenie studijneho programu
zmazatSPButt.addEventListener("click", () => {
    nadpis.innerHTML = "Odstrániť študijný program";
    hideAll();
    panelZmazSP.style.display = "flex";
})

// zobrazi panel pre odstranenie clanku
zmazatClanokButt.addEventListener("click", () => {
    nadpis.innerHTML = "Odstrániť článok";
    hideAll();
    panelZmazClanok.style.display = "block";
})

// zobrazi panel s komentarmi
kommentButt.addEventListener("click", () => {
    nadpis.innerHTML = "Odstrániť komentár";
    hideAll();
    panelKomentare.style.display = "block";
})

//zobrazi panel pre zmenu mena
zmenitMenoButt.addEventListener("click", () => {
    nadpis.innerHTML = "Zmeniť meno";
    hideAll();
    panelZmenitMeno.style.display = "flex";
})

//zobrazi panel pre zmenu hesla
zmenitHesloButt.addEventListener("click", () => {
    nadpis.innerHTML = "Zmeniť heslo";
    hideAll();
    panelZmenitHeslo.style.display = "flex";
})