<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>

<!-- POST_FORM_ACTION_URI — специальная константа Битрикса. Она автоматически содержит URL текущей страницы (с учётом параметров). То есть форма будет отправляться на ту же страницу, где расположен компонент -->
<form action="<?= POST_FORM_ACTION_URI ?>" class="form-horizontal form-style-dashed">
    <h1><?= Loc::getMessage("MFT_HEADER") ?></h1>

    <!-- Если есть ошибки после отправки, они выводятся сверху формы, чтобы пользователь их увидел -->
    <?php
    if (!empty($arResult["ERROR_MESSAGE"])) {
        foreach ($arResult["ERROR_MESSAGE"] as $v) {
            ShowError($v);
        }
    }

    // Если ошибок нет, то показывается подтверждение пользователю сверху формы
    if (!empty($arResult["OK_MESSAGE"])) {
        ?>
        <div class="mf-ok-text"><?= $arResult["OK_MESSAGE"] ?></div><?php
    }
    ?>

    <!-- Эта функция выводит скрытое поле: <input type="hidden" name="sessid" value="..." />. Оно содержит уникальный токен сессии. Компонент проверяет его при отправке, чтобы защититься от CSRF-атак (подделки запросов) -->
    <?= bitrix_sessid_post() ?>

    <div class="row">
        <div class="col-lg-8 col-md-8">
            <div class="form-group">

                <!-- Проверка нужна, чтобы:
                а) посмотреть, пустой ли массив обязательных полей. Если ничего не задано, то считается, что поле NAME, EMAIL, MESSAGE обязательны по умолчанию.
                б) проверить, есть ли строка "NAME", "EMAIL", "MESSAGE" в массиве. То есть — указали ли явно, что поле NAME является обязательным -->
                <label for="input-6"
                       class="col-sm-4 col-xs-12 control-label <?php
                       if (empty($arParams["REQUIRED_FIELDS"]) || in_array(
                               "NAME",
                               $arParams["REQUIRED_FIELDS"]
                           )): ?>required<?php
                       endif ?>">
                    <?= Loc::getMessage("MFT_NAME") ?>
                </label>

                <div class="col-sm-8">
                    <input id="input-6" type="text" class="form-control" name="user_name"
                           value="<?= $arResult["AUTHOR_NAME"] ?>"
                           placeholder="<?= Loc::getMessage("MFT_NAME_PLACEHOLDER") ?>"
                        <?php
                        if (empty($arParams["REQUIRED_FIELDS"]) || in_array(
                                "NAME",
                                $arParams["REQUIRED_FIELDS"]
                            )): ?> required<?php
                        endif ?>>
                </div>
            </div>
            <div class="form-group">
                <label for="input-9"
                       class="col-sm-4 col-xs-12 control-label <?php
                       if (empty($arParams["REQUIRED_FIELDS"]) || in_array(
                               "EMAIL",
                               $arParams["REQUIRED_FIELDS"]
                           )): ?>required<?php
                       endif ?> value="<?= $arResult["AUTHOR_EMAIL"] ?>"">
                <?= Loc::getMessage("MFT_EMAIL") ?>
                </label>
                <div class="col-sm-8">
                    <input id="input-9" type="email" class="form-control" name="user_email"
                           value="<?= $arResult["AUTHOR_EMAIL"] ?>"
                           placeholder="<?= Loc::getMessage("MFT_EMAIL_PLACEHOLDER") ?>"
                        <?php
                        if (empty($arParams["REQUIRED_FIELDS"]) || in_array(
                                "EMAIL",
                                $arParams["REQUIRED_FIELDS"]
                            )): ?> required<?php
                        endif ?>>
                </div>
            </div>

            <div class="form-group">
                <label for="input-10"
                       class="col-sm-4 col-xs-12 control-label <?php
                       if (empty($arParams["REQUIRED_FIELDS"]) || in_array(
                               "MESSAGE",
                               $arParams["REQUIRED_FIELDS"]
                           )): ?>required<?php
                       endif ?>">
                    <?= Loc::getMessage("MFT_MESSAGE") ?>
                </label>
                <div class="col-sm-8">
                    <textarea class="form-control" rows="7" name="MESSAGE" id="input-10"
                        <?php
                        if (empty($arParams["REQUIRED_FIELDS"]) || in_array(
                                "MESSAGE",
                                $arParams["REQUIRED_FIELDS"]
                            )): ?> required<?php
                        endif ?>><?= $arResult["MESSAGE"] ?></textarea>
                </div>
            </div>

            <!-- Если параметр капчи включён, то выводим блок вёрстки с капчей -->
            <?php
            if ($arParams["USE_CAPTCHA"] == "Y"): ?>
                <div class="form-group">
                    <label for="input-5" class="col-sm-4 col-xs-12 control-label required">
                        <?= Loc::getMessage("MFT_CAPTCHA") ?>
                    </label>

                    <div class="col-sm-8 col-xs-12">
                        <div class="input-group-captcha">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="image">

                                        <!-- $arResult["capCode"] — это уникальный идентификатор капчи, который генерируется компонентом формы. Он вставляется:
                                        а) в скрытое поле (captcha_sid) — чтобы при отправке формы сервер знал, какую капчу проверять.
                                        б) в URL картинки (captcha.php?captcha_sid=...) — чтобы отрисовать правильное изображение с символами -->
                                        <input type="hidden" name="captcha_sid" value="<?= $arResult["capCode"] ?>">
                                        <img class="img-responsive"
                                             src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["capCode"] ?>"
                                             width="180" height="40" alt="CAPTCHA"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control" name="captcha_word" type="text"
                                           placeholder="<?= Loc::getMessage("MFT_CAPTCHA_PLACEHOLDER") ?>"
                                           maxlength="50" value=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endif; ?>
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4">
                    <button class="btn btn-primary" type="submit">
                        <?= Loc::getMessage("MFT_SUBMIT") ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- PARAMS_HASH — это хэш параметров формы. Он нужен для защиты от повторной или поддельной отправки (CSRF). При обработке формы Битрикс сверяет этот хэш с тем, что ожидал компонент. Если не совпало — запрос игнорируется -->
    <input type="hidden" name="PARAMS_HASH" value="<?= $arResult["PARAMS_HASH"] ?>">
    <input type="hidden" name="submit" value="<?= GetMessage("MFT_SUBMIT") ?>">
</form>
