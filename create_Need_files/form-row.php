
<? if (! defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<? if ($arProperty['PROPERTY_TYPE'] == 'S') :?>
<div class="inpbi popup-cost-calc__inputs-inner <?=$fieldClass?>">
<div class="text-field js-text-field popup-cost-calc__text-field-inner">
<div class="text-field__title popup-cost-calc__input-caption">
</div>
<label class='text-field__label' for='form-field-<?=$arProperty['ID']?>'><?=$arProperty['LABEL']?> <?=$arProperty['IS_REQUIRED'] == 'Y'?'*':''?></label>
</label>
<input type='text' name='<?=$arProperty['FORM_NAME']?>' class='text-field__input js-text-field__input popup-cost-calc__input field-name-<?=$arProperty['CODE']?><?=$arProperty['IS_REQUIRED'] == 'Y'?'required':''?>' id='form-field-<?=$arProperty['ID']?>'>
</div>
</div>
<?endif?>
<?if ($arProperty['PROPERTY_TYPE'] == 'E') :?>
<div class="selbi popup-cost-calc__dropdown popup-cost-calc__inputs-inner popup-cost-calc__inputs-inner--select">
<select data-placeholder='<?=$arProperty['LABEL']?>' name='<?=$arProperty['FORM_NAME']?>' class='popup-cost-calc__dropdown-select js-dropdown-battery-voltage <?=$arProperty['IS_REQUIRED'] == 'Y'?'required':''?>' id='form-field-<?=$arProperty['ID']?>'>
<option value='' class='popup-cost-calc__dropdown-option'></option><?foreach ($arProperty['ENUM'] as $value):?><option class='popup-cost-calc__dropdown-option' value='<?=$value['ID']?>'><?=$value['NAME']?></option><?endforeach ?>
</select>
</div>
<?endif?>