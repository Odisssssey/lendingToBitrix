
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
</div>
</div>
<div class="butbi popup-diagnostics__button-wrap">
</div>
</div>
</form>
<? if ($arResult['AJAX_CALL']) { die(); } ?>