<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

// Переменная, которая содержит значение корня сайта
$bIsMainPage = $APPLICATION->GetCurPage(false) == SITE_DIR;

?>

<!DOCTYPE html>
<!--[if lt IE 8]>
<html class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]>
<html class="no-js"><![endif]-->
<head>
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Вывод заголовка браузера  -->
    <title><?php
        $APPLICATION->ShowTitle(); ?></title>

    <!-- Вывод метатегов  -->
    <?php
    $APPLICATION->ShowHead(); ?>

    <!-- Подключение CSS и иконки-->
    <?php
    Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/common-styles.css"); ?>
    <link rel="icon" href="<?= SITE_TEMPLATE_PATH ?>/ico/favicon_bx.png">

    <!-- Здесь подключаем скрипты через GetAdditionalFileURL, так как идёт проверка на версию браузера -->
    <!--[if lt IE 9]>
    <script src="<?php
    CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH . "/js/vendor/modernizr-html5shiv-respond.min.js") ?>"></script>
    <![endif]-->

    <!--[if gte IE 9]><!-->
    <script src="<?php
    CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH . "/js/vendor/modernizr.min.js") ?>"></script>
    <!--<![endif]-->

    <?php
    // Подключение скриптов
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.min.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/bootstrap/collapse.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/bootstrap/tooltip.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/plugins.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.touchSwipe.js");
    Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.ba-throttle-debounce.min.js");
    ?>
</head>
<body>
<!--[if lt IE 8]>
<p class="chromeframe">Вы используете <strong>устаревший </strong> браузер. Пожалуйста <a
    href="http://browsehappy.com/">
    обновите свой браузер</a> или <a href="http://www.google.com/chromeframe/?redirect=true">установите Google Chrome
    Frame</a> чтобы улучшить взаимодействие с сайтом.</p>
<![endif]-->

<!-- Вывод административной панели -->
<?php
$APPLICATION->ShowPanel(); ?>

<div class="sticky-wrap">
    <header>
        <div class="header-main">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <?php
                        if ($bIsMainPage): ?>
                        <span class="logo">
						<?php
                        else: ?>
						<a class="logo" href="/">
						<?php
                        endif; ?>
							<div class="image">Одежда</div>
							<div id="slogan-rand" class="slogan">
								<noscript>Лучшая одежда</noscript>
							</div>
						<?php
                        if ($bIsMainPage): ?>
						</span>
                    <?php
                    else: ?>
                        </a>
                    <?php
                    endif; ?>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="row">
                            <div class="col-lg-7 col-xs-12 hidden-xs">
                                <ul class="btn-list-inline">
                                    <?php
                                    $APPLICATION->IncludeFile(
                                        SITE_DIR . "include/slogan.php",
                                        array(),
                                        array("MODE" => "text")
                                    ); ?>
                                </ul>
                            </div>
                            <div class="col-lg-5 col-xs-12 hidden-print">
                                <div class="input-group-search">
                                    <input type="text" class="form-control" placeholder="Поиск...">
                                    <button class="btn btn-link" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <ul class="phone-list">
                            <li><?php
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/phone1.php",
                                    array(),
                                    array("MODE" => "html")
                                ); ?></li>
                            <li><?php
                                $APPLICATION->IncludeFile(
                                    SITE_DIR . "include/phone2.php",
                                    array(),
                                    array("MODE" => "html")
                                ); ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Подключение компонента меню -->
    <?php
    $APPLICATION->IncludeComponent(
        "bitrix:menu",
        "menu",
        array(
            "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
            "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
            "DELAY" => "N",    // Откладывать выполнение шаблона меню
            "MAX_LEVEL" => "1",    // Уровень вложенности меню
            "MENU_CACHE_GET_VARS" => "",    // Значимые переменные запроса
            "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
            "MENU_CACHE_TYPE" => "N",    // Тип кеширования
            "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
            "ROOT_MENU_TYPE" => "top",    // Тип меню для первого уровня
            "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
            "COMPONENT_TEMPLATE" => ".default"
        ),
        false
    ); ?>

    <!-- Если находимся на главной странице, то часть её контента будет отображаться в шапке сайта -->
    <?php
    if ($bIsMainPage): ?>

        <!-- Вызов системного компонента списка новостей с шаблоном index для реализации слайдера на главной странице -->
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "index",
            array(
                "ACTIVE_DATE_FORMAT" => "d.m.Y", // Формат отображения даты (день.месяц.год)
                "ADD_SECTIONS_CHAIN" => "N",     // Добавлять раздел в цепочку навигации (хлебные крошки)
                "AJAX_MODE" => "N",              // Включить режим AJAX
                "AJAX_OPTION_ADDITIONAL" => "",  // Дополнительный идентификатор AJAX
                "AJAX_OPTION_HISTORY" => "N",    // Управлять историей браузера в AJAX
                "AJAX_OPTION_JUMP" => "N",       // Прокручивать страницу к компоненту после AJAX
                "AJAX_OPTION_STYLE" => "Y",      // Подгружать CSS стили в AJAX
                "CACHE_FILTER" => "N",           // Кешировать результаты при фильтрации
                "CACHE_GROUPS" => "Y",           // Учитывать права доступа пользователей при кешировании
                "CACHE_TIME" => "36000000",      // Время кеширования (в секундах)
                "CACHE_TYPE" => "A",             // Тип кеша
                "CHECK_DATES" => "N",            // Показывать только активные элементы по дате
                "COMPONENT_TEMPLATE" => ".default", // Название шаблона компонента
                "DETAIL_URL" => "",              // Ссылка на детальную страницу
                "DISPLAY_BOTTOM_PAGER" => "N",   // Отображать постраничную навигацию снизу
                "DISPLAY_DATE" => "N",           // Показывать дату элемента
                "DISPLAY_NAME" => "Y",           // Показывать название элемента
                "DISPLAY_PICTURE" => "Y",        // Показывать изображение элемента
                "DISPLAY_PREVIEW_TEXT" => "Y",   // Показывать текст анонса
                "DISPLAY_TOP_PAGER" => "N",      // Отображать постраничную навигацию сверху
                "FIELD_CODE" => array(           // Поля инфоблока, которые выбираются
                    0 => "NAME",                 // название
                    1 => "PREVIEW_TEXT",         // текст анонса
                    2 => "PREVIEW_PICTURE",      // картинка анонса
                    3 => "",
                ),
                "FILTER_NAME" => "",             // Имя переменной фильтра
                "HIDE_LINK_WHEN_NO_DETAIL" => "N", // Убирать ссылку, если нет детальной страницы
                "IBLOCK_ID" => "1",              // ID инфоблока для выборки
                "IBLOCK_TYPE" => "index",        // Тип инфоблока
                "INCLUDE_IBLOCK_INTO_CHAIN" => "N", // Добавлять инфоблок в цепочку навигации
                "INCLUDE_SUBSECTIONS" => "N",    // Показывать элементы из подразделов
                "MESSAGE_404" => "",             // Сообщение для 404 ошибки (не задано)
                "NEWS_COUNT" => "50",            // Количество элементов на странице
                "PAGER_BASE_LINK_ENABLE" => "N", // Использовать базовую ссылку для навигации
                "PAGER_DESC_NUMBERING" => "N",   // Обратная нумерация страниц
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000", // Время кеша для обратной навигации
                "PAGER_SHOW_ALL" => "N",         // Показывать ссылку "Все"
                "PAGER_SHOW_ALWAYS" => "N",      // Всегда показывать постраничную навигацию
                "PAGER_TEMPLATE" => ".default",  // Шаблон постраничной навигации
                "PAGER_TITLE" => "Новости",      // Заголовок постраничной навигации
                "PARENT_SECTION" => "",          // ID раздела для выборки
                "PARENT_SECTION_CODE" => "",     // Символьный код раздела
                "PREVIEW_TRUNCATE_LEN" => "",    // Ограничение длины текста анонса
                "PROPERTY_CODE" => array(        // Свойства инфоблока, которые выбираются
                    0 => "url",                  // свойство "url"
                    1 => "",
                ),
                "SET_BROWSER_TITLE" => "N",      // Устанавливать заголовок браузера
                "SET_LAST_MODIFIED" => "N",      // Устанавливать дату последнего изменения заголовка страницы
                "SET_META_DESCRIPTION" => "N",   // Устанавливать meta-описание страницы
                "SET_META_KEYWORDS" => "N",      // Устанавливать meta-ключевые слова страницы
                "SET_STATUS_404" => "N",         // Устанавливать статус 404, если элементов нет
                "SET_TITLE" => "N",              // Устанавливать заголовок страницы
                "SHOW_404" => "N",               // Показывать страницу 404, если нет элементов
                "SORT_BY1" => "SORT",            // Поле первой сортировки
                "SORT_BY2" => "TIMESTAMP_X",     // Поле второй сортировки
                "SORT_ORDER1" => "ASC",          // Направление первой сортировки
                "SORT_ORDER2" => "DESC",         // Направление второй сортировки
                "STRICT_SECTION_CHECK" => "N"    // Проверять принадлежность разделу строго
            )
        );
        ?>

        <div class="activities-description-wrap">
            <div class="activities-description">
                <div class="container">
                    <div class="activities-inner">
                        <h3>Последние посещенные вами страницы</h3>
                        <ul>
                            <li><a href="#">Мы стали использовать новую ткань</a></li>
                            <li><a href="#">Главная страница</a></li>
                            <li><a href="#">Контакты</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mbl">
            <div class="row">
                <div class="col-md-12">
                    <div class="live-main">
                        <h5><a href="#">Новости</a></h5>
                        <div class="live-pagination">
                            <a class="prev" href="#prev"><i class="fa fa-angle-left"></i></a>
                            <a class="next" href="#next"><i class="fa fa-angle-right"></i></a>
                        </div>
                        <div class="live-list-wrap">
                            <div class="live-list">
                                <div class="live-list-item" id="live-1">
                                    <div class="live-item-body image">
                                        <a class="live-item-img" href=""><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/img/live-list/img-1.jpg" alt=""/></a>
                                        <div class="live-item-body-over">
                                            <div class="live-item-description">
                                                <div class="description">Изобретение относится к области получения и
                                                    применения...
                                                </div>
                                            </div>
                                            <div class="live-item-label">
                                                <i class="fa fa fa-twitter"></i>
                                                <a href="#">Новое веяние в одежде - получено прочное водостойкое
                                                    соединение</a>
                                            </div>
                                            <span class="live-item-data">25 Декабря 2015</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="live-list-item" id="live-2">
                                    <div class="live-item-body image">
                                        <a class="live-item-img" href=""><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/img/live-list/img-2.jpg" alt=""/></a>
                                        <div class="live-item-body-over">
                                            <div class="live-item-description">
                                                <div class="description">В следующем году состоится выставка одежды...
                                                </div>
                                            </div>
                                            <div class="live-item-label">
                                                <i class="fa fa fa-vk"></i>
                                                <a href="#">Международная выставка одежды Salon De Fashion</a>
                                            </div>
                                            <span class="live-item-data">22 Октября 2015</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="live-list-item" id="live-3">
                                    <div class="live-item-body">
                                        <div class="live-item-body-over">
                                            <div class="live-item-description">
                                                <div class="description">Для пошива нашей одежды мы стали использовать
                                                    новую
                                                    инновационную ткань
                                                </div>
                                            </div>
                                            <div class="live-item-label">
                                                <a href="#">Мы стали использовать новую ткань</a>
                                            </div>
                                            <span class="live-item-data">2 Июня 2015</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="live-list-item" id="live-4">
                                    <div class="live-item-body">
                                        <div class="live-item-body-over">
                                            <div class="live-item-description">
                                                <div class="description">Мы расширяем свой размерный ряд. Теперь наша
                                                    одежда будет
                                                    доступна большему количеству людей
                                                </div>
                                            </div>
                                            <div class="live-item-label">
                                                <a href="#">Размерный ряд</a>
                                            </div>
                                            <span class="live-item-data">30 Апреля 2015</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="live-list-item" id="live-5">
                                    <div class="live-item-body image">
                                        <a class="live-item-img" href=""><img
                                                src="<?= SITE_TEMPLATE_PATH ?>/img/live-list/img-3.jpg" alt=""/></a>
                                        <div class="live-item-body-over">
                                            <div class="live-item-description">
                                                <div class="description">С 20 по 23 февраля состоится...</div>
                                            </div>
                                            <div class="live-item-label">
                                                <i class="fa fa fa-twitter"></i>
                                                <a href="#">Форум производителей одежды в России</a>
                                            </div>
                                            <span class="live-item-data">22 Апреля 2014</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endif; ?>

    <!-- Если страница не найдена, то будет отрабатывать блок вёрстки для 404 страницы + подключается файл 404.php. Эта константа устанавливается до инициализации ядра битрикса, что позволяет нам в шапке шаблона проверить её наличие и соответствующим образом изменить шаблон -->
    <?php
    if ("ERROR_404" == 'Y'): ?>
    <div class="page-not-found">
        <?php
        else: ?>
            <div class="container">

                <!-- Хлебные крошки отображаются на всех страницах, кроме главной -->
                <?php
                if (!$bIsMainPage): ?>

                    <!-- Подключение компонента навигационной цепочки -->
                    <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:breadcrumb",
                        "breadcrumb",
                        array(
                            "PATH" => "",
                            // Путь, для которого будет построена навигационная цепочка (по умолчанию, текущий путь)
                            "SITE_ID" => "s1",
                            // Cайт (устанавливается в случае многосайтовой версии, когда DOCUMENT_ROOT у сайтов разный)
                            "START_FROM" => "0",
                            // Номер пункта, начиная с которого будет построена навигационная цепочка
                        ),
                        false
                    ); ?>
                <?php
                endif; ?>

                <!-- Выводим заголовок у страниц (false стоит, так как у нас нет свойства для заголовка или его значение пустое)  -->
                <h1><?php
                    $APPLICATION->ShowTitle(false); ?></h1>
            </div>
        <?php
        endif; ?>
        <div class="container">
