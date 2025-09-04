<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** @var array $arParams - Параметры компонента */
/** @var array $arResult - Результаты работы компонента, основные данные для отображения */
/** @global CMain $APPLICATION - Объект приложения */
/** @global CUser $USER - Объект текущего пользователя */
/** @global CDatabase $DB - Объект базы данных */
/** @var CBitrixComponentTemplate $this - Объект шаблона компонента */
/** @var string $templateName - Имя шаблона */
/** @var string $templateFile - Путь к файлу шаблона */
/** @var string $templateFolder - Папка шаблона */
/** @var string $componentPath - Путь к компоненту */
/** @var CBitrixComponent $component - Объект компонента */

$this->setFrameMode(true);

// Проверяем, нужно ли вообще отображать пагинацию
// Если настройка NavShowAlways выключена и выполняется одно из условий:
// 1. Нет записей для отображения (NavRecordCount == 0)
// 2. Страница всего одна И при этом запрещен показ всех записей на одной странице
if (!$arResult["NavShowAlways"]) {
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) {
        return; // Завершаем выполнение шаблона, пагинация не отображается
    }
}

// Подготавливаем строку параметров для URL:
// $strNavQueryString - параметры для добавления к существующим (с & в конце)
// $strNavQueryStringFull - полная строка параметров с ведущим ?
$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
?>

<!-- Начало разметки пагинации - Bootstrap-совместимая структура -->
<div class="text-center">
    <ul class="pagination">
        <?php

        // БЛОК ДЛЯ ОБРАТНОЙ НАВИГАЦИИ (нумерация страниц по убыванию)
        // Часто используется в блогах, форумах - последняя страница = первая по хронологии
        if ($arResult["bDescPageNumbering"] === true):?>

            <?php
            // КНОПКИ "В КОНЕЦ" (⏪) И "НАЗАД" (⬅) ДЛЯ ОБРАТНОЙ НАВИГАЦИИ
            // Проверяем, есть ли страницы перед текущей
            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
                <?php

                // Если включено сохранение номера страницы в URL
                if ($arResult["bSavePage"]):?>

                    <!-- Ссылка на самую последнюю страницу (первую по порядку) -->
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                        ?>=<?= $arResult["NavPageCount"] ?>"><i class="fa fa-angle-double-left"></i></a>
                    </li>

                    <!-- Ссылка на следующую страницу (более новую) -->
                    <li>
                        <a rel="prev"
                           href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                           ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><i class="fa fa-angle-left"></i></a>
                    </li>
                <?php

                // Если НЕ включено сохранение номера страницы в URL
                else:?>

                    <!-- Для первой страницы (последней по порядку) параметр PAGEN не используется -->
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                        ?>"><i class="fa fa-angle-double-left"></i></a>
                    </li>
                    <?php

                    // Проверяем, является ли следующая страница первой (последней по порядку)
                    if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)):?>

                        <!-- Если да, то ссылка без параметра PAGEN -->
                        <li>
                            <a rel="prev" href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                            ?>"><i class="fa fa-angle-left"></i></a>
                        </li>
                    <?php
                    else:?>

                        <!-- Если нет, то стандартная ссылка с параметром PAGEN -->
                        <li>
                            <a rel="prev"
                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                               ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><i class="fa fa-angle-left"></i></a>
                        </li>
                    <?php
                    endif ?>
                <?php
                endif ?>
            <?php

            // ЕСЛИ ПЕРЕД ТЕКУЩЕЙ СТРАНИЦЕЙ НЕТ СТРАНИЦ - ОТКЛЮЧАЕМ КНОПКИ
            else:?>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                    ?>"><i class="fa fa-angle-double-left"></i></a>
                </li>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                    ?>"><a href="#"><i class="fa fa-angle-left"></i></a>
                </li>
            <?php
            endif ?>

            <?php
            // ЦИКЛ ОТОБРАЖЕНИЯ НОМЕРОВ СТРАНИЦ ДЛЯ ОБРАТНОЙ НАВИГАЦИИ
            // Номера идут в обратном порядке: от большего к меньшему
            while ($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
                <?php

                // Рассчитываем отображаемый номер страницы (для обратной навигации)
                $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1; ?>

                <?php

                // ЕСЛИ ЭТО ТЕКУЩАЯ СТРАНИЦА - ВЫДЕЛЯЕМ ЕЁ
                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <li class="active">
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                        ?>"><?= $NavRecordGroupPrint ?></a>
                    </li>
                <?php

                // ЕСЛИ ЭТО ПЕРВАЯ СТРАНИЦА (ПОСЛЕДНЯЯ ПО ПОРЯДКУ) И ВЫКЛЮЧЕНО СОХРАНЕНИЕ СТРАНИЦЫ
                elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                        ?>=<?= ($arResult["NavPageNomer"]) ?>"><?= $NavRecordGroupPrint ?></a>
                    </li>
                <?php

                // ВСЕ ОСТАЛЬНЫЕ СТРАНИЦЫ
                else:?>
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                        ?>=<?= $arResult["nStartPage"] ?>"><?= $NavRecordGroupPrint ?></a>
                    </li>
                <?php
                endif ?>

                <?php
                // Уменьшаем счетчик для движения по страницам в обратном порядке
                $arResult["nStartPage"]-- ?>
            <?php
            endwhile ?>

            <?php

            // КНОПКИ "ВПЕРЕД" (➡) И "В НАЧАЛО" (⏩) ДЛЯ ОБРАТНОЙ НАВИГАЦИИ
            // Проверяем, есть ли страницы после текущей (более старые)
            if ($arResult["NavPageNomer"] > 1):?>

                <!-- Ссылка на предыдущую страницу (более старую) -->
                <li>
                    <a rel="next"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                       ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><i class="fa fa-angle-right"></i></a>
                </li>

                <!-- Ссылка на самую первую страницу (последнюю по порядку) -->
                <li>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                    ?>=1"><i class="fa fa-angle-double-right"></i></a>
                </li>
            <?php

            // ЕСЛИ ПОСЛЕ ТЕКУЩЕЙ СТРАНИЦЫ НЕТ СТРАНИЦ - ОТКЛЮЧАЕМ КНОПКИ
            else:?>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                    ?>=1"><?= GetMessage("PAGINATION_NEXT") ?></a>
                </li>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                    ?>=1"><?= GetMessage("PAGINATION_END") ?></a>
                </li>

            <?php
            endif ?>

        <?php

        // БЛОК ДЛЯ ПРЯМОЙ НАВИГАЦИИ (нумерация страниц по возрастанию)
        // Стандартный вариант: 1, 2, 3, 4...
        else:?>

            <?php
            // КНОПКИ "В НАЧАЛО" (⏪) И "НАЗАД" (⬅) ДЛЯ ПРЯМОЙ НАВИГАЦИИ
            // Проверяем, есть ли страницы перед текущей
            if ($arResult["NavPageNomer"] > 1):?>

                <?php

                // Если включено сохранение номера страницы в URL
                if ($arResult["bSavePage"]):?>

                    <!-- Ссылка на первую страницу -->
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                        ?>=1"><i class="fa fa-angle-double-left"></i></a>
                    </li>

                    <!-- Ссылка на предыдущую страницу -->
                    <li>
                        <a rel="prev"
                           href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                           ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><i class="fa fa-angle-left"></i></a>
                    </li>
                <?php

                // Если НЕ включено сохранение номера страницы в URL
                else:?>

                    <!-- Для первой страницы параметр PAGEN не используется -->
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                        ?>"><i class="fa fa-angle-double-left"></i></a>
                    </li>
                    <?php

                    // Проверяем, является ли предыдущая страница первой
                    if ($arResult["NavPageNomer"] > 2):?>

                        <!-- Если нет, то стандартная ссылка с параметром PAGEN -->
                        <li>
                            <a rel="prev"
                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                               ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"><i class="fa fa-angle-left"></i></a>
                        </li>
                    <?php
                    else:?>

                        <!-- Если да, то ссылка без параметра PAGEN -->
                        <li>
                            <a rel="prev"
                               href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                               ?>"><i class="fa fa-angle-left"></i></a>
                        </li>
                    <?php
                    endif ?>
                <?php
                endif ?>

            <?php

            // ЕСЛИ ПЕРЕД ТЕКУЩЕЙ СТРАНИЦЕЙ НЕТ СТРАНИЦ - ОТКЛЮЧАЕМ КНОПКИ
            else:?>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                    ?>"><i class="fa fa-angle-double-left"></i></a>
                </li>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull
                    ?>"><i class="fa fa-angle-left"></i></a>
                </li>
            <?php
            endif ?>

            <?php

            // ЦИКЛ ОТОБРАЖЕНИЯ НОМЕРОВ СТРАНИЦ ДЛЯ ПРЯМОЙ НАВИГАЦИИ
            // Номера идут в прямом порядке: от меньшего к большему
            while ($arResult["nStartPage"] <= $arResult["nEndPage"]):?>

                <?php

                // ЕСЛИ ЭТО ТЕКУЩАЯ СТРАНИЦА - ВЫДЕЛЯЕМ ЕЁ
                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <li class="active">
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                        ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
                    </li>
                <?php

                // ЕСЛИ ЭТО ПЕРВАЯ СТРАНИЦА И ВЫКЛЮЧЕНО СОХРАНЕНИЕ СТРАНИЦЫ
                elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>

                    <!-- Для первой страницы параметр PAGEN не используется -->
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"><?= $arResult["nStartPage"] ?></a>
                    </li>
                <?php

                // ВСЕ ОСТАЛЬНЫЕ СТРАНИЦЫ
                else:?>
                    <li>
                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                        ?>=<?= $arResult["nStartPage"] ?>"><?= $arResult["nStartPage"] ?></a>
                    </li>
                <?php
                endif ?>
                <?php

                // Увеличиваем счетчик для движения по страницам в прямом порядке
                $arResult["nStartPage"]++ ?>
            <?php
            endwhile ?>

            <?php

            // КНОПКИ "ВПЕРЕД" (➡) И "В КОНЕЦ" (⏩) ДЛЯ ПРЯМОЙ НАВИГАЦИИ
            // Проверяем, есть ли страницы после текущей
            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>

                <!-- Ссылка на следующую страницу -->
                <li>
                    <a rel="next"
                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                       ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"><i class="fa fa-angle-right"></i></a>
                </li>

                <!-- Ссылка на последнюю страницу -->
                <li>
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                    ?>=<?= $arResult["NavPageCount"] ?>"><i class="fa fa-angle-double-right"></i></a>
                </li>
            <?php

            // ЕСЛИ ПОСЛЕ ТЕКУЩЕЙ СТРАНИЦЫ НЕТ СТРАНИЦ - ОТКЛЮЧАЕМ КНОПКИ
            else:?>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                    ?>=<?= $arResult["NavPageCount"] ?>"><i class="fa fa-angle-right"></i></a>
                </li>
                <li class="disabled">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"]
                    ?>=<?= $arResult["NavPageCount"] ?>"><i class="fa fa-angle-double-right"></i></a>
                </li>
            <?php
            endif ?>

        <?php
        endif ?>

        <?php

        // КНОПКА "ПОКАЗАТЬ ВСЕ" / "ПОКАЗАТЬ ПО СТРАНИЦАМ"
        if ($arResult["bShowAll"]):?>
            <?php

            // Проверяем, активен ли сейчас режим показа всех элементов
            if ($arResult["NavShowAll"]):?>

                <!-- Если да, показываем кнопку для возврата к постраничному выводу -->
                <li class="btn-all">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult["NavNum"]
                    ?>=0"><?= GetMessage("nav_paged") ?></a>
                </li>
            <?php
            else:?>

                <!-- Если нет, показываем кнопку для показа всех элементов на одной странице -->
                <li class="btn-all">
                    <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>SHOWALL_<?= $arResult["NavNum"]
                    ?>=1"><?= GetMessage("nav_all") ?></a>
                </li>
            <?php
            endif ?>
        <?php
        endif ?>
    </ul>
</div>
