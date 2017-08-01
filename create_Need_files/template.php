<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); } use Bitrix\Main\Localization\Loc; Loc::loadMessages(__FILE__); $this->setFrameMode(true); ?><? if ($arResult["AJAX_CALL"]) : $APPLICATION->RestartBuffer(); endif;<? if ($arResult["AJAX_CALL"]) : $APPLICATION->RestartBuffer(); endif; ?>
<form class="popup-cost__form" name="popup-cost" action="<?= POST_FORM_ACTION_URI ?>" method="post" id="iblock_add_request_call">
<p class="popup-cost-calc__title">Расчет стоимости восстановления аккумулятора
</p>
<div class="popup-cost-calc__inputs-wrapper">
<div class="popup-cost-calc__button-wrap">
<button class="button popup-cost-calc__button js-popup-cost-calc-submit">Отправить заявку
</button>
</div>
</div>
</form>