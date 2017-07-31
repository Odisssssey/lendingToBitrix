<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) { die(); } use Bitrix\Main\Localization\Loc; Loc::loadMessages(__FILE__); $this->setFrameMode(true); ?>
<form class="popup-cost__form" name="popup-cost" action="<?= POST_FORM_ACTION_URI ?>" method="post">
<form class="popup-cost__form" name="popup-cost">
<p class="popup-cost-calc__title">
<p class="popup-cost-calc__title">Расчет стоимости восстановления аккумулятора
</p>
</p>
<div class="popup-cost-calc__inputs-wrapper">
<div class="popup-cost-calc__inputs-wrapper">
<div class="popup-cost-calc__inputs-inner">
<div class="popup-cost-calc__inputs-inner">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field__title popup-cost-calc__input-caption">
<div class="text-field__title popup-cost-calc__input-caption">Представьтесь, пожалуйста
</div>
</div>
<label class="text-field__label" for="popup-cost-calc-name">
<label class="text-field__label" for="popup-cost-calc-name">Представьтесь, пожалуйста
</label>
</label>
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-name">
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-name" >
</div>
</div>
</div>
</div>
<div class="popup-cost-calc__inputs-inner">
<div class="popup-cost-calc__inputs-inner">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field__title popup-cost-calc__input-caption">
<div class="text-field__title popup-cost-calc__input-caption">Электронный адрес
</div>
</div>
<label class="text-field__label" for="popup-cost-calc-mail">
<label class="text-field__label" for="popup-cost-calc-mail">Электронный адрес
</label>
</label>
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-mail">
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-mail" >
</div>
</div>
</div>
</div>
</div>
</div>
</form>
</form>