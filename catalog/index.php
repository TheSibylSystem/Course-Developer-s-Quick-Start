<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Каталог товаров");
?>

<!-- Вызов комплексного компонента "Каталог" -->
<?$APPLICATION->IncludeComponent(
    "bitrix:catalog",
    "catalog",
    Array(
        "ACTION_VARIABLE" => "action", // Имя переменной для действий (добавить в корзину, сравнить и т.п.)
        "ADD_ELEMENT_CHAIN" => "Y", // Добавлять название элемента в цепочку навигации
        "ADD_PICT_PROP" => "-", // Свойство товара с дополнительными картинками
        "ADD_PROPERTIES_TO_BASKET" => "N", // Передавать ли свойства товара в корзину
        "ADD_SECTIONS_CHAIN" => "Y", // Добавлять раздел в цепочку навигации
        "AJAX_MODE" => "N", // Включить AJAX-режим работы
        "AJAX_OPTION_ADDITIONAL" => "", // Дополнительный идентификатор для AJAX
        "AJAX_OPTION_HISTORY" => "N", // Разрешить управление навигацией браузера (история) в AJAX
        "AJAX_OPTION_JUMP" => "N", // Скроллить к началу компонента после AJAX-загрузки
        "AJAX_OPTION_STYLE" => "Y", // Подгружать стили при AJAX-запросах
        "BASKET_URL" => "/personal/basket.php", // Страница корзины
        "CACHE_FILTER" => "N", // Кешировать ли при установленном фильтре
        "CACHE_GROUPS" => "Y", // Учитывать права доступа при кешировании
        "CACHE_TIME" => "36000000", // Время кеширования (секунды)
        "CACHE_TYPE" => "A", // Тип кеширования
        "CATALOG_HEIGHT" => "288", // Высота изображений каталога (кастомный параметр шаблона)
        "CATALOG_WIDTH" => "288", // Ширина изображений каталога (кастомный параметр шаблона)
        "COMPATIBLE_MODE" => "N", // Совместимость с устаревшими режимами компонента
        "COMPONENT_TEMPLATE" => "catalog",
        "DETAIL_ADD_DETAIL_TO_SLIDER" => "N", // Добавлять ли детальное фото в слайдер картинок
        "DETAIL_BACKGROUND_IMAGE" => "-", // Свойство с картинкой для фона на детальной странице
        "DETAIL_BRAND_USE" => "N", // Использовать бренды
        "DETAIL_BROWSER_TITLE" => "-", // Источник для <title> на детальной странице
        "DETAIL_CHECK_SECTION_ID_VARIABLE" => "N", // Проверять SECTION_ID в URL
        "DETAIL_DETAIL_PICTURE_MODE" => "IMG", // Режим показа детальной картинки (IMG, POPUP, MAGNIFIER)
        "DETAIL_DISPLAY_NAME" => "N", // Показывать название элемента
        "DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "E", // Показ анонса: E — только если есть детальное описание
        "DETAIL_META_DESCRIPTION" => "-", // Источник для meta-description
        "DETAIL_META_KEYWORDS" => "-", // Источник для meta-keywords
        "DETAIL_PROPERTY_CODE" => array("","img",""), // Свойства, выводимые на детальной странице
        "DETAIL_SET_CANONICAL_URL" => "N", // Устанавливать канонический URL
        "DETAIL_STRICT_SECTION_CHECK" => "N", // Показывать элемент только в своём разделе
        "DETAIL_USE_COMMENTS" => "N", // Включить комментарии
        "DETAIL_USE_VOTE_RATING" => "N", // Включить голосование/рейтинг
        "DISABLE_INIT_JS_IN_COMPONENT" => "Y", // Не подключать init.js внутри компонента
        "DISPLAY_BOTTOM_PAGER" => "Y", // Показывать постраничную навигацию снизу
        "DISPLAY_TOP_PAGER" => "N", // Показывать постраничную навигацию сверху
        "ELEMENT_SORT_FIELD" => "sort", // Первое поле сортировки элементов
        "ELEMENT_SORT_FIELD2" => "id", // Второе поле сортировки элементов
        "ELEMENT_SORT_ORDER" => "asc", // Направление первой сортировки
        "ELEMENT_SORT_ORDER2" => "desc", // Направление второй сортировки
        "FILE_404" => "", // Пользовательский файл для ошибки 404
        "FILTER_VIEW_MODE" => "VERTICAL", // Вид фильтра: VERTICAL или HORIZONTAL
        "IBLOCK_ID" => "3", // ID инфоблока каталога
        "IBLOCK_TYPE" => "catalog", // Тип инфоблока
        "INCLUDE_SUBSECTIONS" => "Y", // Показывать элементы из подразделов
        "LABEL_PROP" => "-", // Свойство-метка (например, «Хит», «Новинка»)
        "LINE_ELEMENT_COUNT" => "", // Количество элементов в строке (для списка)
        "LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#", // URL для связанных элементов
        "LINK_IBLOCK_ID" => "", // ID связанного инфоблока
        "LINK_IBLOCK_TYPE" => "", // Тип связанного инфоблока
        "LINK_PROPERTY_SID" => "", // Код свойства для связи
        "LIST_BROWSER_TITLE" => "-", // Источник для <title> в списке
        "LIST_META_DESCRIPTION" => "-", // Источник для meta-description в списке
        "LIST_META_KEYWORDS" => "-", // Источник для meta-keywords в списке
        "LIST_PROPERTY_CODE" => array("",""), // Свойства, выводимые в списке раздела
        "MESSAGE_404" => "", // Сообщение для страницы 404
        "MESS_BTN_ADD_TO_BASKET" => "В корзину", // Текст кнопки «В корзину»
        "MESS_BTN_BUY" => "Купить", // Текст кнопки «Купить»
        "MESS_BTN_COMPARE" => "Сравнение", // Текст кнопки «Сравнить»
        "MESS_BTN_DETAIL" => "Подробнее", // Текст кнопки «Подробнее»
        "MESS_NOT_AVAILABLE" => "Нет в наличии", // Текст, если товара нет
        "PAGER_BASE_LINK_ENABLE" => "N", // Включить базовую ссылку для постранички
        "PAGER_DESC_NUMBERING" => "N", // Использовать обратную нумерацию
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000", // Время кеша для обратной нумерации
        "PAGER_SHOW_ALL" => "Y", // Показывать ссылку «Все»
        "PAGER_SHOW_ALWAYS" => "N", // Всегда показывать постраничку
        "PAGER_TEMPLATE" => ".default", // Шаблон постраничной навигации
        "PAGER_TITLE" => "Товары", // Заголовок для постранички
        "PAGE_ELEMENT_COUNT" => "6", // Количество элементов на странице
        "PARTIAL_PRODUCT_PROPERTIES" => "N", // Поддерживать частично заполненные свойства в корзине
        "PRICE_CODE" => array(), // Типы цен для отображения
        "PRICE_VAT_INCLUDE" => "Y", // Включать НДС в цену
        "PRICE_VAT_SHOW_VALUE" => "N", // Показывать размер НДС отдельно
        "PRODUCT_ID_VARIABLE" => "id", // Имя переменной для ID товара
        "PRODUCT_PROPERTIES" => "", // Какие свойства товара передавать в корзину
        "PRODUCT_PROPS_VARIABLE" => "prop", // Имя переменной для свойств товара
        "PRODUCT_QUANTITY_VARIABLE" => "", // Имя переменной для количества товара
        "SECTIONS_SHOW_PARENT_NAME" => "Y", // Показывать название раздела
        "SECTIONS_VIEW_MODE" => "LINE", // Вид списка разделов: LINE, LIST, TEXT, TILE
        "SECTION_BACKGROUND_IMAGE" => "-", // Свойство с фоновым изображением раздела
        "SECTION_COUNT_ELEMENTS" => "N", // Показывать количество элементов в разделе
        "SECTION_ID_VARIABLE" => "SECTION_ID", // Имя переменной для ID раздела
        "SECTION_TOP_DEPTH" => "1", // Глубина показа разделов
        "SEF_FOLDER" => "/catalog/", // Базовая папка ЧПУ
        "SEF_MODE" => "Y", // Включить ЧПУ (человекопонятные URL)
        "SEF_URL_TEMPLATES" => array( // Шаблоны ЧПУ URL
            "sections" => "", // Общий список разделов
            "section" => "#SECTION_CODE#/", // URL раздела
            "element" => "#SECTION_CODE#/#ELEMENT_CODE#/", // URL элемента
            "compare" => "", // URL сравнения
            "smart_filter" => "", // URL умного фильтра
        ),
        "SET_LAST_MODIFIED" => "Y", // Устанавливать заголовок Last-Modified
        "SET_STATUS_404" => "Y", // Устанавливать статус 404, если элемент не найден
        "SET_TITLE" => "Y", // Устанавливать заголовок страницы
        "SHOW_404" => "Y", // Показывать страницу 404
        "SHOW_DEACTIVATED" => "N", // Показывать деактивированные товары
        "SHOW_PRICE_COUNT" => "1", // Количество цен для отображения (если диапазоны)
        "SHOW_SKU_DESCRIPTION" => "N", // Показывать описание SKU
        "SHOW_TOP_ELEMENTS" => "N", // Показывать топ-элементы
        "SIDEBAR_DETAIL_SHOW" => "N", // Показывать сайдбар на детальной
        "SIDEBAR_PATH" => "", // Путь к файлу сайдбара
        "SIDEBAR_SECTION_SHOW" => "N", // Показывать сайдбар в разделе
        "TEMPLATE_THEME" => "blue", // Цветовая тема шаблона
        "TOP_ELEMENT_COUNT" => "9", // Количество элементов в TOP-блоке
        "TOP_ELEMENT_SORT_FIELD" => "sort", // Поле сортировки для TOP-блока
        "TOP_ELEMENT_SORT_FIELD2" => "id", // Второе поле сортировки TOP-блока
        "TOP_ELEMENT_SORT_ORDER" => "asc", // Направление сортировки TOP-блока
        "TOP_ELEMENT_SORT_ORDER2" => "desc", // Второе направление сортировки TOP-блока
        "TOP_LINE_ELEMENT_COUNT" => "3", // Количество элементов в строке TOP-блока
        "TOP_PROPERTY_CODE" => "", // Свойства для TOP-блока
        "USER_CONSENT" => "N", // Использовать согласие пользователя
        "USER_CONSENT_ID" => "0", // ID соглашения
        "USER_CONSENT_IS_CHECKED" => "Y", // Флаг «галочка проставлена»
        "USER_CONSENT_IS_LOADED" => "N", // Подгружать ли текст соглашения
        "USE_COMPARE" => "N", // Включить сравнение товаров
        "USE_ELEMENT_COUNTER" => "Y", // Учитывать просмотры элемента
        "USE_FILTER" => "N", // Использовать фильтр
        "USE_MAIN_ELEMENT_SECTION" => "Y", // Привязывать элемент к основному разделу
        "USE_PRICE_COUNT" => "N", // Использовать вывод цен с диапазонами
        "USE_PRODUCT_QUANTITY" => "N", // Использовать выбор количества товара
        "USE_STORE" => "N" // Использовать складской учёт
    )
);?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>