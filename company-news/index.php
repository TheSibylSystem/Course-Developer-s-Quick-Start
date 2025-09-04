<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Новости компании");
?>

<!-- Вызов комплексного компонента "Новости"  -->
<?php
$APPLICATION->IncludeComponent(
    "bitrix:news", // Системное имя компонента
    "news", // Шаблон компонента (news - кастомный шаблон)
    array(
        "IBLOCK_TYPE" => "news", // Тип инфоблока
        "IBLOCK_ID" => "2", // ID инфоблока с новостями
        "NEWS_COUNT" => "8", // Количество новостей на странице
        "SEF_MODE" => "Y", // Включить ЧПУ (человеко-понятные URL)
        "SEF_FOLDER" => "/company-news/", // Папка ЧПУ для новостей
        "CHECK_DATES" => "Y", // Показывать только активные по дате
        "CACHE_TYPE" => "A", // Тип кэширования (Auto - управляется в админке)
        "CACHE_TIME" => "36000000", // Время кэширования в секундах (~416 дней)
        "CACHE_GROUPS" => "Y", // Учитывать права доступа при кэшировании
        "CACHE_FILTER" => "N", // Кэшировать при использовании фильтра
        "AJAX_MODE" => "N", // Отключить AJAX режим
        "AJAX_OPTION_JUMP" => "N", // Не прокручивать к компоненту после AJAX
        "AJAX_OPTION_STYLE" => "Y", // Подгружать стили при AJAX
        "AJAX_OPTION_HISTORY" => "N", // Не использовать AJAX для навигации
        "AJAX_OPTION_ADDITIONAL" => "", // Дополнительный идентификатор AJAX
        "SET_TITLE" => "Y", // Устанавливать заголовок страницы
        "SET_LAST_MODIFIED" => "Y", // Устанавливать время последнего изменения
        "SET_STATUS_404" => "Y", // Устанавливать 404 статус если не найдено
        "SHOW_404" => "Y", // Показывать страницу 404 если не найдено
        "MESSAGE_404" => "", // Сообщение для страницы 404 (по умолчанию)
        "FILE_404" => "", // Файл для страницы 404 (по умолчанию)
        "ADD_ELEMENT_CHAIN" => "Y", // Добавлять название элемента в цепочку навигации
        "ADD_SECTIONS_CHAIN" => "N", // Не добавлять разделы в цепочку навигации
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N", // Не включать инфоблок в цепочку навигации
        "SET_CANONICAL_URL" => "N", // Не устанавливать canonical URL
        "BROWSER_TITLE" => "-", // Заголовок браузера (по умолчанию)
        "META_DESCRIPTION" => "-", // Meta description (по умолчанию)
        "META_KEYWORDS" => "-", // Meta keywords (по умолчанию)
        "DISPLAY_DATE" => "Y", // Показывать дату
        "DISPLAY_NAME" => "N", // Не показывать название (уже есть по умолчанию)
        "DISPLAY_PICTURE" => "Y", // Показывать изображение
        "DISPLAY_PREVIEW_TEXT" => "Y", // Показывать текст анонса
        "ACTIVE_DATE_FORMAT" => "j F Y", // Формат даты для списка (день месяц год)
        "PREVIEW_TRUNCATE_LEN" => "", // Не обрезать текст анонса
        "HIDE_LINK_WHEN_NO_DETAIL" => "N", // Не скрывать ссылку если нет детальной страницы
        "FIELD_CODE" => array( // Поля для отображения в списке
            "NAME",
            "PREVIEW_TEXT",
            "PREVIEW_PICTURE",
            "DATE_ACTIVE_FROM"
        ),
        "PROPERTY_CODE" => array( // Свойства для отображения в списке
            ""
        ),
        "DETAIL_ACTIVE_DATE_FORMAT" => "j F Y", // Формат даты для детальной страницы
        "DETAIL_FIELD_CODE" => array( // Поля для детальной страницы
            "DETAIL_TEXT"
        ),
        "DETAIL_PROPERTY_CODE" => array( // Свойства для детальной страницы
            ""
        ),
        "SORT_BY1" => "ACTIVE_FROM", // Первое поле сортировки - дата начала активности
        "SORT_ORDER1" => "DESC", // По убыванию (новые сверху)
        "SORT_BY2" => "SORT", // Второе поле сортировки - поле сортировки
        "SORT_ORDER2" => "ASC", // По возрастанию
        "DISPLAY_TOP_PAGER" => "N", // Не показывать пагинацию сверху
        "DISPLAY_BOTTOM_PAGER" => "Y", // Показывать пагинацию снизу
        "PAGER_TITLE" => "Новости", // Заголовок пагинации
        "PAGER_SHOW_ALWAYS" => "N", // Не показывать если все помещается на одну страницу
        "PAGER_TEMPLATE" => ".default", // Шаблон пагинации
        "PAGER_DESC_NUMBERING" => "N", // Обычная нумерация (не обратная)
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000", // Время кэша для обратной навигации
        "PAGER_SHOW_ALL" => "N", // Не показывать ссылку "Все"
        "PAGER_BASE_LINK_ENABLE" => "N", // Не использовать базовые ссылки для пагинации
        "DETAIL_DISPLAY_TOP_PAGER" => "N",  // Не показывать пагинацию сверху в детальной
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "N", // Не показывать пагинацию снизу в детальной
        "DETAIL_PAGER_TITLE" => "Страница", // Заголовок пагинации в детальной
        "DETAIL_PAGER_SHOW_ALL" => "N", // Не показывать "Все" в детальной
        "USE_PERMISSIONS" => "N", // Не использовать проверку прав доступа
        "USE_SEARCH" => "N", // Отключить поиск
        "USE_FILTER" => "N", // Отключить фильтр
        "USE_RSS" => "N", // Отключить RSS
        "USE_RATING" => "N", // Отключить рейтинги
        "USE_CATEGORIES" => "N", // Отключить категории
        "USE_SHARE" => "N", // Отключить кнопки поделиться
        "SEF_URL_TEMPLATES" => array(
            "news" => "", // Главная страница новостей
            "section" => "", // Страница раздела (не используется)
            "detail" => "#ELEMENT_ID#/", // Шаблон URL детальной страницы
        )
    ),
    false // Не показывать исключения компонента
);
?>

<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
