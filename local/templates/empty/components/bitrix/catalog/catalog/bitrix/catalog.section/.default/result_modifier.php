<?php

foreach ($arResult["ITEMS"] as $cell => $arElement) {
    if ($arElement["PREVIEW_PICTURE"]["ID"]) {
        $file = CFile::ResizeImageGet(
            $arElement["PREVIEW_PICTURE"]["ID"],
            array(
                'width' => $arParams['CATALOG_WIDTH'],
                'height' => $arParams['CATALOG_HEIGHT']
            ),
            BX_RESIZE_IMAGE_EXACT,
            //константа, определяющая тип масштабирования (изображение будет точно подогнано под указанные размеры с обрезкой лишнего)
            true // Флаг кеширования. true - создать файл на диске и вернуть на него ссылку, false - вернуть бинарные данные
        );

        // Мы перезаписываем данные в исходном массиве $arResult["ITEMS"] для текущего элемента ($cell)
        $arResult["ITEMS"][$cell]["PREVIEW_PICTURE"]['WIDTH'] = $file['width'];
        $arResult["ITEMS"][$cell]["PREVIEW_PICTURE"]['HEIGHT'] = $file['height'];
        $arResult["ITEMS"][$cell]["PREVIEW_PICTURE"]['SRC'] = $file['src'];
    }
}
