<?php
    require_once 'header.html';
    require_once 'dbs.php';

    $root_url = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $root_url .= "s";
    }
    $root_url .= "://".$_SERVER['HTTP_HOST'];
    $root_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
?>

<body>
<!-- Navbar -->
<div class="container-fluid" id="nav">
    <nav class="navbar navbar-custom navbar-expand-xl navbar-dark fixed-top">
        <div class="navbar-header">
            <?php

            $url = $root_url;
            echo "<a href=$url class='navbar-brand logo'>";

            $url = $root_url . "img_style/pc.png";
            echo "<img src=$url width='40' height='40' alt='pc-screen-image' class='align-top pc-image-collapse'>";
            ?>

                <span class="logo-pack">
                        <span>
                            <?php
                            echo "<img src=$url width='50' height='50' alt='pc-screen-image' class='align-top pc-image'>";
                            ?>
                            </span>
                        <span class="logo-name">
                            <span class="logo-slash sl1">/*</span>
                            <span class="ttl">Študuj IT na Slovensku!</span>
                            <span class="logo-slash sl2"> */</span>
                        </span>
                    </span>
                </a>
        </div>


        <div class="collapse navbar-collapse" id="toggleMobileMenu">
            <ul class="navbar-nav ms-auto navbar-list-collapsed">
                <li class="navbar-list-item-collapsed">

                    <?php
                    $url = $root_url . "clanky";
                    echo " <a class='nav-link menu-item' href=$url title='Tu sa dočítaš o odboroch'>  Články  </a>";
                    ?>

                </li>
                <li class="navbar-list-item-collapsed">
                    <?php
                    $url = $root_url . "studijne-programy";
                    echo " <a class='nav-link menu-item' href=$url title='Zoznam študijných programov'>  Študijné programy  </a>";
                    ?>

                </li>
                <li class="navbar-list-item-collapsed">
                <?php
                $url = $root_url . "o-nas";
                echo " <a class='nav-link menu-item' href=$url title='Info o stránke'>  O nás  </a>";
                ?>

                </li>
                <li class="navbar-list-item-collapsed">
                    <div id="searchDiv" class="input-group d-flex justify-content-center">

                        <?php
                        $url = $root_url . "search.php";
                        echo " <form action=$url method='POST' class='search'> ";
                        ?>
                            <div class="form-outline">
                                <input type="text" id="searchBar" class="rounded form-control" name="searchBar" placeholder="Hľadaj..."/>
                            </div>
                            <button type="submit" id="searchButt" title="Hľadať" name="searchButt" class="btn btn-primary searchButt">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>


        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#toggleMobileMenu"
            aria-controls="toggleMobileMenu"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

    </nav>
</div>


<!-- Mobile-version title of the page -->
<div class="homepage-content">

    <div class="mob-header">
        <div class="logo-name-mob">
            <h1 class="mob-l">
                <span class="logo-slash sl1 d-flex justify-content-start">/*</span>
                <span class="ttl">Študuj IT na Slovensku!</span>
                <span class="logo-slash sl2 d-flex justify-content-end">*/</span>
            </h1>
        </div>
    </div>
</div>