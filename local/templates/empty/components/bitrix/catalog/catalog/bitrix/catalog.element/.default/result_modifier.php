<?php

// Выбираем активные элементы из того же инфоблока и того же раздела, что и наш товар
$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "ACTIVE_DATE" => "Y",
    "SECTION_GLOBAL_ACTIVE" => "Y",
    "SECTION_ID" => $arParams["SECTION_ID"],
    "SECTION_CODE" => $arParams["SECTION_CODE"]
);

// Используем те же настройки сортировки, что и для торговых предложений
$arOrder = array(
    $arParams["OFFERS_SORT_FIELD"] => $arParams["OFFERS_SORT_ORDER"],
    $arParams["OFFERS_SORT_FIELD2"] => $arParams["OFFERS_SORT_ORDER2"],
);

// Здесь используется следующая настройка: мы запрашиваем по 1 элементу, начиная с ID текущего товара. Это нужно, чтобы в результате получить всего один элемент — следующий за текущим
$arNavStartParams = array(
    "nElementID" => $arResult["ID"],
    "nPageSize" => 1
);

// Флаг, который поможет нам найти предыдущий элемент
$end = false;

$DBRes = CIBlockElement::GetList($arOrder, $arFilter, false, $arNavStartParams);

// В цикле проходим по выборке, которая содержит всего один элемент (следующий),но логика построена так, чтобы при необходимости можно было получить и предыдущий
while ($res = $DBRes->GetNext()) {
    if ($res["ID"] == $arResult["ID"]) {
        // Если нашли текущий элемент, ставим флаг, что все последующие элементы — "следующие"
        $end = true;
    } elseif ($end) {
        // Если флаг установлен и это не текущий элемент — значит, это "следующий" товар
        $arResult["CATALOG_RING"]["NEXT"] = $res;
    } else {
        // Если флаг НЕ установлен и это не текущий элемент — значит, это "предыдущий" товар
        $arResult["CATALOG_RING"]["PREV"] = $res;
    }
}
