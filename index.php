<?php
require_once dirname(__DIR__, 1) . "/src/init.php";
use \Core\TemplateManager as TM;
?>
<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kurtabi</title>
        <link rel="stylesheet" href="/assets/css/stylesheet.css">
        <script src="/assets/js/index.js"></script>
        <script src="/assets/js/auth.js"></script>
        <script src="/assets/js/api.js"></script>
        <script src="/assets/js/utils.js"></script>
    </head>
    <body>
        <div class="index-layout">
            <!-- topbar -->
            <?php TM::print("topbar") ?>

            <div class="anakutu">
                <div class="ickutu ortalayandiv">
                    <div id="ana-kisim-wrapper">
                        <div id="oda-kur-buton" class="buton font-kalin">Oda Kur</div>
                    </div>
                </div>
                <div class="ickutu ortalayandiv">
                    <div id="ana-kisim-wrapper">
                        <input type="text" id="oda-kod-input" placeholder="....." maxlength="3" autocomplete="off">
                        <div id="katil-buton" class="buton kapali-buton font-kalin">Katıl</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>