<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;

/**
 * Компонент pagesViewedNew — показывает просмотренные пользователем страницы
 */
class pagesViewedNew extends CBitrixComponent
{
    /**
     * Проверка подключённых модулей
     * Если модуль iblock не подключён — выбрасываем LoaderException
     * @throws LoaderException
     * @throws LoaderException
     */
    protected function checkModules()
    {
        if (!Loader::IncludeModule("iblock")) {
            throw new LoaderException(Loc::getMessage("IBLOCK_MODULE_NOT_INSTALLED"));
        }
    }

    /**
     * Сбор списка страниц, просмотренных текущим пользователем
     */
    protected function ListPages()
    {
        global $USER;

        $arFilter = array(
            "IBLOCK_ID" => $this->arParams["IBLOCKS"],
            "PROPERTY_USER" => $USER->IsAuthorized() ? $USER->GetID() : session_id()
        );

        $arOrder = array(
            "created" => "desc"
        );

        $arSelect = array(
            "NAME",
            "PROPERTY_URL"
        );

        // Формируем объект c элементами инфоблока
        $rsItems = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

        $arResult = [];
        $arResult["ITEMS"] = [];

        // C помощью GetNext() извлекаем элементы из объекта (каждый элемент это ассоциативный массив с ключами TITLE и URL) и вставляем их в конец массива $arResult["ITEMS"]
        while ($arItem = $rsItems->GetNext()) {
            $arResult["ITEMS"][] = array(
                'TITLE' => $arItem["NAME"],
                'URL' => $arItem["PROPERTY_URL_VALUE"]
            );
        }

        return $arResult;
    }

    /**
     * Точка входа компонента: подготовка данных и подключение шаблона
     * @throws LoaderException
     */
    public function executeComponent()
    {
        // Подключаем файл языковых сообщений
        $this->includeComponentLang('class.php');

        // Проверяем, что все необходимые модули подключены
        $this->checkModules();

        // Собираем данные — результат работы нашего метода ListPages
        $this->arResult = $this->ListPages();

        // Подключаем шаблон компонента — он использует $arResult
        $this->IncludeComponentTemplate();
    }
}
