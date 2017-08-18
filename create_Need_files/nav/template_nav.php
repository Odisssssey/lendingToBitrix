
<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<? foreach($arResult as $arItem): if($arParams['MAX_LEVEL'] == 1 && $arItem['DEPTH_LEVEL'] > 1) continue; ?>
<?if($arItem['SELECTED']):?>
<?else:?>
<li class="litbi page-header__nav-item">
<a class='ancbi page-header__nav-link selected' href='<?=$arItem['LINK']?>' ><?=$arItem['TEXT']?>
</a>
</li>
<li class="litbi page-header__nav-item">
<a class='ancbi page-header__nav-link' href='<?=$arItem['LINK']?>' ><?=$arItem['TEXT']?>
</a>
</li>
<?endif?>
<?endforeach?>
<?endif?>