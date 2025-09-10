<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

// Создаем список возможных режимов отображения для использования в выпадающем списке
$arViewModeList = array(
    'LIST' => GetMessage('CPT_BCSL_VIEW_MODE_LIST'),
    'LINE' => GetMessage('CPT_BCSL_VIEW_MODE_LINE'),
    'TEXT' => GetMessage('CPT_BCSL_VIEW_MODE_TEXT'),
    'TILE' => GetMessage('CPT_BCSL_VIEW_MODE_TILE')
);

$arTemplateParameters = array(

    // Параметр 'VIEW_MODE' - выбор режима отображения разделов
    'VIEW_MODE' => array(
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('CPT_BCSL_VIEW_MODE'),
        'TYPE' => 'LIST',
        'VALUES' => $arViewModeList,
        'MULTIPLE' => 'N',
        'DEFAULT' => 'LINE',
        'REFRESH' => 'Y'
    ),

    // Параметр 'SHOW_PARENT_NAME' - показывать ли название родительского раздела
    'SHOW_PARENT_NAME' => array(
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('CPT_BCSL_SHOW_PARENT_NAME'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'Y'
    ),
);

// Проверяем, существует ли массив текущих значений и какое значение имеет параметр 'VIEW_MODE'. $arCurrentValues - это массив, который Битрикс автоматически передает в этот файл, он содержит текущие значения всех параметров
if (isset($arCurrentValues['VIEW_MODE']) && 'TILE' == $arCurrentValues['VIEW_MODE']) {

    // Если режим просмотра выбран как "TILE" (Плитка), то мы добавляем ЕЩЕ ОДИН параметр в настройки
    $arTemplateParameters['HIDE_SECTION_NAME'] = array(
        'PARENT' => 'VISUAL',
        'NAME' => GetMessage('CPT_BCSL_HIDE_SECTION_NAME'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N'
    );
}
