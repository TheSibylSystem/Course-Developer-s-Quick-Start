<?php

use Bitrix\Main;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Web\Uri;

// Регистрируем обработчик события OnEndBufferContent модуля main. Это позволяет коду запускаться в конце формирования страницы, перед выводом контента
$eventManager = Main\EventManager::getInstance();
$eventManager->addEventHandlerCompatible("main", "OnEndBufferContent", array("PagesViewed", "Collection"));

class PagesViewed
{
    /**
     * Обработчик события OnEndBufferContent.
     * Метод статический, так как регистрируется как ["PagesViewed", "Collection"].
     * Параметр $content передаётся по ссылке
     *
     * @param string &$content - содержимое буфера (не используется в коде, но требуется для события)
     * @return void
     * @throws Main\LoaderException
     */
    public static function Collection(&$content)
    {
        global $APPLICATION, $USER;

        $iblockId = 4; // ID инфоблока "Посещённые страницы"
        $i = 0; // Счётчик для очистки старых записей (оставляем только 3 последние)

        // Получаем URI текущего запроса и извлекаем путь (path) без параметров
        $urlString = Application::getInstance()->getContext()->getRequest()->getRequestUri();
        $url = new Uri($urlString);
        $path = $url->getPath();

        if (!Loader::includeModule("iblock")) {
            return;
        }

        // Определяем идентификатор посетителя: ID авторизованного пользователя или ID сессии для гостя
        $visitorId = $USER->IsAuthorized() ? $USER->GetID() : session_id();

        // Фильтр для проверки дубликатов: ищем элементы в инфоблоке с тем же пользователем и URL
        $arFilter = array(
            "IBLOCK_ID" => $iblockId,
            "PROPERTY_USER" => $visitorId, // Свойство USER (число)
            "PROPERTY_URL" => $path       // Свойство URL (строка)
        );

        // Проверяем наличие дубликата: запрашиваем один элемент по фильтру (nTopCount=1)
        $exists = CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            array('nTopCount' => 1), // Ограничение на 1 запись
            array('ID') // Выбираем только ID для проверки существования
        );

        // Если дубликат не найден (GetNext() вернул false) — создаём новый элемент
        if (!$exists->GetNext()) {
            $el = new CIBlockElement(); // Объект для работы с элементами инфоблока

            // Массив данных для создания элемента
            $arLoadProductArray = array(
                // MODIFIED_BY: ID пользователя, если авторизован, иначе 1 (системный пользователь)
                "MODIFIED_BY" => $USER->IsAuthorized() ? $USER->GetID() : 1,
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID" => $iblockId,
                "PROPERTY_VALUES" => array(
                    "URL" => $path,
                    "USER" => $visitorId
                ),
                "NAME" => $APPLICATION->GetTitle() ?: $path
                // Имя элемента: заголовок страницы или путь, если заголовок пустой
            );
            $el->Add($arLoadProductArray); // Добавляем элемент в инфоблок

            // Очистка старых записей: оставляем только 3 последние для этого посетителя
            $arSelect = array("ID"); // Выбираем только ID элементов
            $res = CIBlockElement::GetList(
                array('created' => 'desc'), // Сортировка по дате создания descending (новые сверху)
                array(
                    "IBLOCK_ID" => $iblockId,
                    "PROPERTY_USER" => $visitorId
                ),
                false,
                false,
                $arSelect
            );

            // Проходим по результатам и удаляем элементы старше 3-х последних
            while ($ar_fields = $res->GetNext()) {
                $i++;
                if ($i > 3) {
                    CIBlockElement::Delete($ar_fields['ID']); // Удаляем лишние элементы
                }
            }
        }
    }
}
