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
$this->setFrameMode(true);
?>

<div class="row">
    <div class="col-xs-12 col-md-9">

        <!-- $arResult["NAV_RESULT"] — признак того, что детальный текст разбит по страницам (внутри текста могли быть разделители) — тогда:
        а) при DISPLAY_TOP_PAGER выводится верхняя навигация (NAV_STRING),
        б) затем NAV_TEXT — содержимое текущей страницы,
        в) при DISPLAY_BOTTOM_PAGER — нижняя навигация.
        г) иначе: если есть непустой DETAIL_TEXT — выводим его. Если нет детального — показываем PREVIEW_TEXT -->
        <?php
        if ($arResult["NAV_RESULT"]): ?>
            <?php
            if ($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><br/>
            <?php
            endif; ?>
            <?php
            echo $arResult["NAV_TEXT"]; ?>
            <?php
            if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><br/><?= $arResult["NAV_STRING"] ?>
            <?php
            endif; ?>
        <?php
        elseif (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
            <?php
            echo $arResult["DETAIL_TEXT"]; ?>
        <?php
        else: ?>
            <?php
            echo $arResult["PREVIEW_TEXT"]; ?>
        <?php
        endif ?>
    </div>

    <?php
    if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
        <div class="col-xs-12 col-md-3">
            <div class="project-participants">
                <h6>Дата новости:</h6>
                <span><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></span>
            </div>
        </div>
    <?php
    endif; ?>
</div>
