
<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) { die(); } use Bitrix/Main/Localization/Loc; Loc::loadMessages(__FILE__); $this->setFrameMode(true); ?>
<? if ($arResult['AJAX_CALL']) : $APPLICATION->RestartBuffer(); endif;<? if ($arResult['AJAX_CALL']) : $APPLICATION->RestartBuffer(); endif; ?>
<form class="frmbi popup-cost__form" name="popup-cost" action='<?= POST_FORM_ACTION_URI ?>' method='post' id='iblock_add_request_call'>
<p class="prfbi popup-cost-calc__title">Расчет стоимости восстановления аккумулятора
</p>
<div class="fehbi popup-cost-calc__inputs-wrapper">
<input type='hidden' name='iblock_submit' value='Y'/> <input type='hidden' name='form_<?= $arParams['ORM_ID'] ?>' value='Y'/> <?= bitrix_sessid_post() ?>']
<?= bitrix_sessid_post() ?>
<? foreach ($arResult['GROUPS'] as $group) : ?>
<? foreach ($group['FIELDS'] as $arProperty) :  CDFASiteTemplateTools::IncludeFile('form-diagnostic-row.php', array( 'arProperty' => $arProperty, 'params'   => $arParams, 'fieldClass' => 'js-field-title', )); ?>
<? endforeach ?>
<? endforeach ?> 
<div class="chbbi popup-diagnostics__checkbox-wrapper">
<div class="checkbox">
<span class="checkbox__custom-checkbox-wrap">
<input class="checkbox__custom-checkbox-input" type="checkbox" id="popup-diagnostics-agreement" name="popup-diagnostics-agreement" checked required>
<span class="checkbox__custom-checkbox-inner">
<svg class="checkbox__custom-checkbox-icon">
<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/icons/sprite.svg#check">
</use>
</svg>
</span>
<svg class="checkbox__custom-checkbox-border">
<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?=SITE_TEMPLATE_PATH?>/icons/sprite.svg#check">
</use>
</svg>
</span>
<label class="checkbox__label" for="popup-diagnostics-agreement">Подтверждаю согласие на обработку моих
<a class="checkbox__label-link js-personal-data-open">
</a>
</label>
</div>
</div>
<div class="butbi popup-diagnostics__button-wrap">
<?$arParams["BUTTON_TITLE"] = 'Отправить заявку';?>
<button class="button popup-callback__button js-popup-callback-submit" name="iblock_submit" type="submit">
<?= $arParams["BUTTON_TITLE"] ?>
</button>
</div>
</div>
</form>