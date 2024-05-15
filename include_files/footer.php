<?php

function dispFooter() : void {

    $root_url = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $root_url .= "s";
    }
    $root_url .= "://".$_SERVER['HTTP_HOST'];
    $root_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    $url = $root_url . "o-nas";
    $admin = $root_url . "admin-login";
    /*https://itnask.online/admin-login*/

    echo <<<EOP

    <footer class="d-flex justify-content-between">
        <div style="display: flex">
            <div>
                <p class="foot">
                    Kontakt
                </p>
                <p class="me">
                    Adela Radičová <br>
                    xradicova@stuba.sk
                </p>
            </div>
            
            <p class="onas"><a href=$url>O nás</a></p>
            
            <p class="admin"><a href="$admin">Admin</a></p>
            
        </div>
        <div style="display: flex; justify-content: flex-end!important; text-align: end!important;">
            <p class="foot-logo">
                Študuj aj ty IT na Slovensku!
            </p>
        </div>
    </footer>
    
    <button id="scroll-top" class="d-flex justify-content-end shift-up" title="Presunúť sa nahor">
        <i class="bi bi-arrow-up-circle-fill"></i>
    </button>

EOP;
}

