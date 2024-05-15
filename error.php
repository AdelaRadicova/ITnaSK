<?php
require_once 'include_files/navigation.php';
include 'include_files/footer.php';
?>

<body style="min-height: 100vh!important;">
    <div class="body" style="min-height: 100vh!important;">

<?php
echo <<<EOP
<div class="container d-flex justify-content-center vh-100 align-items-center">
    <p class="bg-danger text-white fw-bolder fs-1 w-50 h-auto d-flex flex-column justify-content-center text-center" style="padding: 2em">
        <span class="font-monospace text-decoration-underline">404</span>
        <span class="fs-4 fw-normal"><br>Hľadaná stránka neexistuje!</span>
    </p>
</div>
</div> 
EOP;

dispFooter();
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script src="/scripts/script.js"></script>

</body>
</html>