<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

?>

<div class="sticky-push"></div>
</div>

<footer>
    <div class="sticky-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <address>
                        <?php
                        $APPLICATION->IncludeFile(
                            SITE_DIR . "include/address.php",
                            array(),
                            array("MODE" => "html")
                        ); ?>
                    </address>
                </div>

                <div class="col-md-4 col-md-push-4">
                    <div class="copyright">
                        Данный шаблон предоставлен компанией<br/>© <a href="http://www.intervolga.ru">ИНТЕРВОЛГА</a> для
                        Академии 1С-Битрикс
                    </div>
                </div>

                <div class="col-md-4 col-md-pull-4 hidden-print">
                    <?php
                    $APPLICATION->IncludeFile(
                        SITE_DIR . "include/social-links.php",
                        array(),
                        array("MODE" => "text")
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/bootstrap/collapse.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/bootstrap/tooltip.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.touchSwipe.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/plugins.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.ba-throttle-debounce.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/main.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/cookesHelp.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/bootstrap-switch.min.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.carouFredSel-packed.js");
?>

</body>
</html>
