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

<!-- Проверка на то, что элементы инфоблока существуют -->
<?php
if ($arResult["ITEMS"]): ?>
    <div class="slider-responsive">
        <div class="slider-responsive-panel">
            <input data-toggle="radio-switch" type="checkbox">
            <span>Наши лучшие предложения Вам</span>
        </div>
        <div class="toggle-height">
            <div class="slider-responsive-controls">
                <a class="hidden-xs" href="#prev"></a>
                <a class="hidden-xs" href="#next"></a>
            </div>
            <div class="slider-responsive-inner">

                <!-- Вывод элементов инфоблока циклом -->
                <?php
                foreach ($arResult["ITEMS"] as $arItem): ?>
                    <div class="slider-responsive-inner-item active">

                        <!-- Вывод изображения для анонса -->
                        <div class="slider-responsive-inner-item-img"
                             style="background-image: url('<?= $arItem['PREVIEW_PICTURE']['SRC'] ?>')">
                            <div class="slider-responsive-inner-item-img-title">

                                <!-- Вывод названия элемента инфоблока -->
                                <div class="h2"><?= $arItem['NAME'] ?></div>

                                <!-- Проверка на то, что у элемента заполнен текст для анонса (если заполнен, выводим его) -->
                                <?php
                                if ($arItem['PREVIEW_TEXT']): ?>
                                    <div><?= $arItem['PREVIEW_TEXT'] ?></div>
                                <?php
                                endif; ?>

                                <!-- Проверка на то, что у элемента заполнено значение свойство URL (если заполнено, выводим его) -->
                                <?php
                                if ($arItem['PROPERTIES']['url']['VALUE']): ?>
                                    <a href="<?= $arItem['PROPERTIES']['url']['VALUE'] ?>" class="link">Подробнее...</a>
                                <?php
                                endif; ?>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach; ?>
            </div>
        </div>
    </div>
<?php
endif; ?>
