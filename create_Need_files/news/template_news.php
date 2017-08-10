
<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die(); $this->setFrameMode(true);?>
<div class="newbi reviews__slides swiper-wrapper">
<?foreach($arResult['ITEMS'] as $arItem):?>
<div class="slibi reviews__slide swiper-slide">
<? $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'),
array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
<div class="reviews__slide-review-author-wrap">
<?if($arParams['DISPLAY_PICTURE']!='N' && is_array($arItem['PREVIEW_PICTURE'])):?><?if(!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || ($arItem['DETAIL_TEXT'] && $arResult['USER_HAVE_ACCESS'])):?>
<img class='imgbi reviews__slide-author-image' src='<?=$arItem['PREVIEW_PICTURE']['SRC']?>' alt=''/><?else:?><img class='imgbi reviews__slide-author-image' src='<?=$arItem['PREVIEW_PICTURE']['SRC']?>' alt=''/>
<?endif;?><?endif?>
<div class="reviews__slide-review-author-name-wrap">
<span class="spabi reviews__slide-review-author-name">
<?=$arItem['PROPERTIES']['FIO']['VALUE'];?>
</span>
<span class="spabi reviews__slide-review-author-position">
<?=$arItem['PROPERTIES']['FIO']['VALUE'];?>
</span>
</div>
</div>
<div class="reviews__slide-text-wrap">
<p class="parbi reviews__slide-text">
<?=$arItem['PROPERTIES']['TEXT']['VALUE']['TEXT'];?>
</p>
</div>
</div>
<?endforeach;?>
</div>