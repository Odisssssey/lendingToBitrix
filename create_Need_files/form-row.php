
<? if (! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<? if ($arProperty['PROPERTY_TYPE'] == 'S' && $arProperty['USER_TYPE'] !== 'DefaBoolean' && $arProperty['USER_TYPE'] !== 'HTML') :?>
<div class="inpbi popup-cost-calc__inputs-inner <?=$fieldClass?>">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field__title popup-cost-calc__input-caption">
</div>
<label class="text-field__label" for="popup-cost-calc-phone">
</label>
<input class="text-field__input js-text-field__input popup-cost-calc__input" type="text" id="popup-cost-calc-phone">
</div>
</div>
<?endif?>
<?if ($arProperty['PROPERTY_TYPE'] == 'E') :?>
<div class="selbi popup-cost-calc__dropdown popup-cost-calc__inputs-inner popup-cost-calc__inputs-inner--select">
<select class="popup-cost-calc__dropdown-select js-dropdown-battery-voltage">
<option class="popup-cost-calc__dropdown-option">
</option>
<option class="popup-cost-calc__dropdown-option">
</option>
<option class="popup-cost-calc__dropdown-option">
</option>
<option class="popup-cost-calc__dropdown-option">
</option>
<option class="popup-cost-calc__dropdown-option">
</option>
</select>
</div>
<?endif?>