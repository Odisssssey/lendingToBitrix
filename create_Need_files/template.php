<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); } use Bitrix\Main\Localization\Loc; Loc::loadMessages(__FILE__); $this->setFrameMode(true); ?><? if ($arResult["AJAX_CALL"]) : $APPLICATION->RestartBuffer(); endif;<? if ($arResult["AJAX_CALL"]) : $APPLICATION->RestartBuffer(); endif; ?>
<form class="popup-cost__form" name="popup-cost" action="<?= POST_FORM_ACTION_URI ?>" method="post" id="iblock_add_request_call">
<p class="popup-cost-calc__title">Расчет стоимости восстановления аккумулятора
</p>
<div class="popup-cost-calc__inputs-wrapper">
<div class="popup-cost-calc__inputs-inner">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field__title popup-cost-calc__input-caption">Представьтесь, пожалуйста
</div>
<label class="text-field__label" for="popup-cost-calc-name">Представьтесь, пожалуйста
</label>
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-name" >
</div>
</div>
<div class="popup-cost-calc__inputs-inner">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field__title popup-cost-calc__input-caption">Электронный адрес
</div>
<label class="text-field__label" for="popup-cost-calc-mail">Электронный адрес
</label>
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-mail" >
</div>
</div>
</div>
</form>