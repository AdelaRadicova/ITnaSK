<?php
    require_once './include_files/navigation.php';
    include 'include_files/footer.php';
    $conn = connectDbs();

    if ($conn->connect_errno) {
        echo "Failed to connect to MySQL: " . $conn->connect_error;
        exit();
    }
?>

<body>
    <div class='body'>
        <div id="oNas">
            <p>
                Ahoj, si študentom strednej školy a rozhoduješ sa kam ďalej na výšku? Zaujal ťa smer IT?
                Tak si tu správne. Na tejto stránke nájdeš rýchly prehľad všetkých študijných odborov zameraných na IT,
                ktoré ponúkajú naše vysoké školy. Ak si naopak už absolvent/študent daného odboru, čítaj ďalej.
            </p>
            <p>
                Stránka bola vytvorená v rámci bakalárskeho projektu a okrem toho má poslúžiť záujemcom o študium
                IT na Slovensku, aby si vedeli rýchlo spraviť základný prehľad o študijných odboroch.
                Študijných odborov s IT zameraním je veruže na výber nemálo a ako bývalá maturantka, ktorá mala
                pred sebou svojho času rovnaké rozhodovanie, ako možno práve teraz ty, som sa rozhodla to budúcim
                generáciám možno trošku uľahčiť.
            </p>
            <p>
                Každému študijnému programu je venovaný osobitný článok, kde sa o ňom niečo málo dočítaš a ak ťa zaujme,
                ďalej nájdeš odkaz na jeho oficiálnu stránku, kde sa dozvieš viac.
            </p>
            <p>
                Viem, že rozhodovať sa len na základe nejakých "pekných rečí" o študijnom programe nestačí a určite chceš
                vedieť aj názory na odbor od študentov/absolventov, ktorý ho študovali, preto je pod
                každým článkom so študijným odborom sekcia na zanechávanie recenzií.
                Ak si teda už absolvent, alebo študent daného odboru a našiel by si si chvíľočku čas na zanechanie
                svojho názoru, verím, že by to pomohlo mnohým.
            </p>
            <p style="margin-top: 2.5em">
                Veľa štastia s výberom :)
            </p>
        </div>
    </div>

    <?php dispFooter(); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="./scripts/script.js"></script>
</body>
</html>