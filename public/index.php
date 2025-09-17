<?php
require_once dirname(__DIR__, 1) . "/src/init.php";
use \Core\TemplateManager as TM;
?>
<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kemik</title>
        <link rel="stylesheet" href="/assets/css/topbar.css">
        <link rel="stylesheet" href="/assets/css/genel.css">
    </head>
    <body>
        <div class="index-layout">
            <!-- topbar -->
            <?php TM::print("topbar") ?>

            <div class="anakutu ortala-yatay">
                <div class="yazi-liste">
                    <div class="yazi-blok"><a href="/oku.php?i=11111" class="yazi-link"></a>&nbsp;<div class="yazi-tarih">2025-01-01 00:00</div></div>
                </div>
            </div>
        </div>
    </body>
</html>