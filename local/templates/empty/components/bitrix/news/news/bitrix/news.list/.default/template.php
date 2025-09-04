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

// Bitrix включает «frame mode» для корректной работы композитного кеширования / динамических зон. Позволяет системе обновлять только часть страницы, не ломая кеш
$this->setFrameMode(true);
?>

<?php
if ($arResult["ITEMS"]): ?>
<div class="live-list-detail">
    <div class="row">

        <!--  Пробегаем все элементы. $cell — индекс (0,1,2...), $arItem — массив с данными элемента (NAME, PREVIEW_TEXT, PREVIEW_PICTURE, DETAIL_PAGE_URL, DISPLAY_ACTIVE_FROM и т.д.). -->
        <?php
        foreach ($arResult["ITEMS"] as $cell => $arItem): ?>

        <!-- Эти вызовы подготавливают ссылки редактирования/удаления для админки; позже GetEditAreaId() возвращает id контейнера, к которому привяжутся кнопки редактирования в визуальном режиме -->
        <?php
        $this->AddEditAction(
            $arItem['ID'],
            $arItem['EDIT_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT")
        );
        $this->AddDeleteAction(
            $arItem['ID'],
            $arItem['DELETE_LINK'],
            CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
            array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))
        );
        ?>

        <!-- GetEditAreaId обеспечивает уникальный id, который Bitrix использует для показа иконок редактирования прямо в шаблоне -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="live-list-item" id="live-<?= $cell ?>">
                <?php
                if (is_array($arItem["PREVIEW_PICTURE"])): ?>
                <div class="live-item-body image">
                    <a class="live-item-img" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                             alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                             title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                    </a>
                    <?php
                    else: ?>
                    <div class="live-item-body">
                        <?php
                        endif;
                        ?>

                        <div class="live-item-body-over">
                            <?php
                            if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                                <div class="live-item-description">
                                    <div class="description">
                                        <?php
                                        echo $arItem["PREVIEW_TEXT"]; ?>
                                    </div>
                                </div>
                            <?php
                            endif; ?>
                            <div class="live-item-label">
                                <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                                    <?php
                                    echo $arItem["NAME"] ?>
                                </a>
                            </div>
                            <?php
                            if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]): ?>
                                <span class="live-item-data">
                                            <?php
                                            echo $arItem["DISPLAY_ACTIVE_FROM"] ?>
                                        </span>
                            <?php
                            endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>

    <!-- Если включён параметр показа нижней навигации, печатаем HTML пагинации, который подготовил компонент ($arResult["NAV_STRING"]) -->
    <?php
    if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?>
    <?php
    endif; ?>
    <?php
    endif; ?>
