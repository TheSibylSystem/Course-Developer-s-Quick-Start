<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/** Подсказки для IDE (не влияют на выполнение)
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @global CDatabase $DB
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);
?>

    <div class="row">

        <?php
        // Проверяем, задано ли свойство 'img' (может быть одиночным ID или массивом)
        if (!empty($arResult['PROPERTIES']['img']['VALUE'])) {
            $fileImg = [];

            // Если свойство multiple — VALUE будет массивом
            if (is_array($arResult['PROPERTIES']['img']['VALUE'])) {
                foreach ($arResult['PROPERTIES']['img']['VALUE'] as $key => $fileId) {
                    // Получаем информацию о файле. Если нужен только путь, можно использовать CFile::GetPath($fileId)
                    $fileInfo = CFile::GetFileArray($fileId);
                    if ($fileInfo) {
                        $fileImg[] = [
                            'SRC' => $fileInfo['SRC'],
                            'DESCRIPTION' => $arResult['PROPERTIES']['img']['DESCRIPTION'][$key] ?? ''
                        ];
                    }
                }
            } else {
                // Одиночный файл (VALUE — ID)
                $fileInfo = CFile::GetFileArray($arResult['PROPERTIES']['img']['VALUE']);
                if ($fileInfo) {
                    $fileImg[] = [
                        'SRC' => $fileInfo['SRC'],
                        'DESCRIPTION' => $arResult['PROPERTIES']['img']['DESCRIPTION'] ?? ''
                    ];
                }
            }

            // Если получили массив картинок — выводим слайдер/галерею
            if (!empty($fileImg)): ?>
                <div class="portfolio-works-slider">
                    <div class="slider-inner">
                        <?php
                        foreach ($fileImg as $img):
                            $imgSrc = htmlspecialcharsbx($img['SRC']);
                            $imgAlt = $img['DESCRIPTION'] !== '' ? $img['DESCRIPTION'] : ($arResult['NAME'] ?? '');
                            ?>
                            <div class="item-wrap">
                                <a data-blueimp="portfolio-works" class="item" href="<?= $imgSrc ?>">
                                    <img src="<?= $imgSrc ?>"
                                         alt="<?= htmlspecialcharsbx($imgAlt) ?>"
                                         loading="lazy"
                                         decoding="async"/>
                                </a>
                            </div>
                        <?php
                        endforeach; ?>
                    </div>

                    <div class="slider-nav slider-next intervolga-chevron-right"></div>
                    <div class="slider-nav slider-prev intervolga-chevron-left"></div>
                </div>

                <div id="live-galery" class="blueimp-gallery blueimp-gallery-controls" style="display: none;">
                    <div class="slides" style="padding: 10px 0;"></div>
                    <a class="prev"></a>
                    <a class="next"></a>
                    <a class="close"></a>
                </div>
            <?php
            endif;
        }
        ?>

        <div class="col-xs-12 col-md-12">
            <?php
            echo $arResult['DETAIL_TEXT'];
            ?>
        </div>
    </div>

<?php
// Проверяем, есть ли соседние элементы (подготовлено в result_modifier.php)
if (!empty($arResult["CATALOG_RING"]["PREV"]) || !empty($arResult["CATALOG_RING"]["NEXT"])): ?>
    <ul class="pager">
        <?php
        if (!empty($arResult["CATALOG_RING"]["PREV"])):
            $prev = $arResult["CATALOG_RING"]["PREV"];
            ?>
            <li class="previous">
                <a href="<?= htmlspecialcharsbx($prev["DETAIL_PAGE_URL"]) ?>">
                    <div class="title">Предыдущий товар</div>
                    <?= htmlspecialcharsbx($prev["NAME"]) ?>
                </a>
            </li>
        <?php
        endif; ?>

        <?php
        if (!empty($arResult["CATALOG_RING"]["NEXT"])):
            $next = $arResult["CATALOG_RING"]["NEXT"];
            ?>
            <li class="next">
                <a href="<?= htmlspecialcharsbx($next["DETAIL_PAGE_URL"]) ?>">
                    <div class="title">Следующий товар</div>
                    <?= htmlspecialcharsbx($next["NAME"]) ?>
                </a>
            </li>
        <?php
        endif; ?>
    </ul>
<?php
endif; ?>
