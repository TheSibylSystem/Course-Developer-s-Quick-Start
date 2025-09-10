<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>
<form action="" method="get" class="form-horizontal">
    <div class="form-group">
        <div class="col-md-12">
            <div class="input-group">

                <!-- Поле ввода поискового запроса -->
                <input type="text" name="q" value="<?= $arResult["REQUEST"]["QUERY"] ?>" " size=" 40"
                class="form-control" />

                <!-- Скрытое поле для типа сортировки -->
                <input type="hidden" name="how" value="<?php
                echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>"/>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">Искать</button>
                </span>
            </div>
        </div>
    </div>

</form>

<?php
if (isset($arResult["REQUEST"]["ORIGINAL_QUERY"])):
    ?>
    <div class="search-language-guess">

        <!-- Показываем сообщение о автокоррекции запроса -->
        <?php
        echo GetMessage(
            "CT_BSP_KEYBOARD_WARNING",
            array("#query#" => '<a href="' . $arResult["ORIGINAL_QUERY_URL"] . '">' . $arResult["REQUEST"]["ORIGINAL_QUERY"] . '</a>')
        ) ?>
    </div><br/><?php
endif; ?>

<!-- Случай 1: Поисковый запрос не был выполнен -->
<?php
if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false): ?>

    <!-- Случай 2: Произошла ошибка при поиске -->
<?php
elseif ($arResult["ERROR_CODE"] != 0): ?>
    <p><?= GetMessage("SEARCH_ERROR") ?></p>
    <?php
    ShowError($arResult["ERROR_TEXT"]); ?>
    <p><?= GetMessage("SEARCH_CORRECT_AND_CONTINUE") ?></p>
    <br/><br/>
    <p><?= GetMessage("SEARCH_SINTAX") ?><br/><b><?= GetMessage("SEARCH_LOGIC") ?></b></p>
    <table border="0" cellpadding="5">
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_OPERATOR") ?></td>
            <td valign="top"><?= GetMessage("SEARCH_SYNONIM") ?></td>
            <td><?= GetMessage("SEARCH_DESCRIPTION") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_AND") ?></td>
            <td valign="top">and, &amp;, +</td>
            <td><?= GetMessage("SEARCH_AND_ALT") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_OR") ?></td>
            <td valign="top">or, |</td>
            <td><?= GetMessage("SEARCH_OR_ALT") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top"><?= GetMessage("SEARCH_NOT") ?></td>
            <td valign="top">not, ~</td>
            <td><?= GetMessage("SEARCH_NOT_ALT") ?></td>
        </tr>
        <tr>
            <td align="center" valign="top">( )</td>
            <td valign="top">&nbsp;</td>
            <td><?= GetMessage("SEARCH_BRACKETS_ALT") ?></td>
        </tr>
    </table>

    <!-- Случай 3: Найдены результаты -->
<?php
elseif (count($arResult["SEARCH"]) > 0): ?>
    <p>

        <!-- Переключатель сортировки: по релевантности или по дате -->
        <?php
        if ($arResult["REQUEST"]["HOW"] == "d"): ?>
            <a href="<?= $arResult["URL"] ?>&amp;how=r<?php
            echo $arResult["REQUEST"]["FROM"] ? '&amp;from=' . $arResult["REQUEST"]["FROM"] : '' ?><?php
            echo $arResult["REQUEST"]["TO"] ? '&amp;to=' . $arResult["REQUEST"]["TO"] : '' ?>"><?= GetMessage(
                    "SEARCH_SORT_BY_RANK"
                ) ?>
            </a>&nbsp;|&nbsp;
            <b>
                <?= GetMessage("SEARCH_SORTED_BY_DATE") ?>
            </b>
        <?php
        else: ?>
            <b>
                <?= GetMessage("SEARCH_SORTED_BY_RANK") ?>
            </b>&nbsp;|&nbsp;
            <a
                href="<?= $arResult["URL"] ?>&amp;how=d<?php
                echo $arResult["REQUEST"]["FROM"] ? '&amp;from=' . $arResult["REQUEST"]["FROM"] : '' ?><?php
                echo $arResult["REQUEST"]["TO"] ? '&amp;to=' . $arResult["REQUEST"]["TO"] : '' ?>"><?= GetMessage(
                    "SEARCH_SORT_BY_DATE"
                ) ?>
            </a>
        <?php
        endif; ?>
    </p>
    <hr/>

    <!-- Цикл по результатам поиска -->
    <?php
    foreach ($arResult["SEARCH"] as $arItem): ?>
        <h4>
            <a href="<?php
            echo $arItem["URL"] ?>">
                <?php
                echo $arItem["TITLE_FORMATED"] ?>
            </a>
        </h4>

        <p>
            <?php
            echo $arItem["BODY_FORMATED"] ?>
        </p>
        <small>Изменен: <?= $arItem["DATE_CHANGE"] ?></small>
        <br/>

        <!-- Отображение breadcrumbs для результата -->
        <?php
        if ($arItem["CHAIN_PATH"]): ?>
            <ul class="breadcrumb small">
                <?= $arItem["CHAIN_PATH"] ?>
            </ul>
        <?php
        endif;
        ?>
        <hr/>

        <!-- Постраничная навигация -->
    <?php
    endforeach; ?>
    <?php
    if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>

    <!-- Случай 4: Ничего не найдено -->
<?php
else: ?>
    <?php
    ShowNote(GetMessage("SEARCH_NOTHING_TO_FOUND")); ?>
<?php
endif; ?>
