<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

// Инициализация массива для хранения элементов цепочки
$arChainBody = [];

// Перебор каждого элемента в массиве $arCHAIN
foreach ($arCHAIN as $item) {
    // Пропускаем элементы, у которых длина ссылки меньше длины корневой директории сайта. Это исключает корневые или системные элементы из цепочки
    if (strlen($item["LINK"]) < strlen(SITE_DIR)) {
        continue;
    }

    // Если у элемента есть ссылка
    if ($item["LINK"] <> "") {
        // Создаем элемент списка с ссылкой
        $arChainBody[] = '<li><a href="' . $item["LINK"] . '">' . htmlspecialcharsex($item["TITLE"]) . '</a></li>';
    } else {
        // Создаем элемент списка без ссылки (текущая страница)
        $arChainBody[] = '<li>' . htmlspecialcharsex($item["TITLE"]) . '</li>';
    }
}

// Объединяем все элементы массива в одну строку и возвращаем результат
return implode('', $arChainBody);
