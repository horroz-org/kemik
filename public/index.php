<?php
require_once dirname(__DIR__, 1) . "/src/init.php";
use \Core\TemplateManager as TM;
use \Uygulama\Uzman as Uzman;
?>
<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $SITE_BASLIK; ?></title>
        <link rel="stylesheet" href="assets/css/topbar.css">
        <link rel="stylesheet" href="assets/css/genel.css">
    </head>
    <body>
        <div class="index-layout">
            <!-- topbar -->
            <?php TM::print("topbar", ["baslik" => $SITE_BASLIK, "logo" => $SITE_LOGO, "sagbutonlar" => $SITE_TOPBAR_SAGBUTON]) ?>

            <div class="anakutu">
                <div class="anasayfa-baslik"><?php echo $SITE_ANASAYFA_YAZILAR_METIN; ?></div>
                <div class="yazi-liste">
                    <?php echo Uzman::yaziListeHTML() ?>
                </div>
            </div>
        </div>

        <!-- footer -->
        <?php TM::print("footer", ["metin" => $SITE_FOOTER]) ?>
    </body>
</html>