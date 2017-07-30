<?
function YATranslate ($string, $lang1='ru', $lang2='en') {
	 $yandex_translate_key = 'trnsl.1.1.20170727T123001Z.f830369604d4cbb3.d42560127ee377ce754d314ae2ff6ecf547bb18f';
	 
	 $request = @file_get_contents('https://translate.yandex.net/api/v1.5/tr.json/translate?key=' . $yandex_translate_key . '&text=' . $string . '&lang=' . $lang1 . '-' . $lang2);
	 
	 if ($request) {
	 $array = json_decode($request, true);
	$text = $array['text'][0];
	} else {
	$text = $string;
	}
	return $text;
}

function createProperty($ID, $propForm, $propCodeForm){
 $ibp = new CIBlockProperty;
 $arFields = Array(
	"NAME" => $propForm,
	"ACTIVE" => "Y",
	"SORT" => 500, // Сортировка
	"CODE" => $propCodeForm,
	"PROPERTY_TYPE" => "S", // string
	"FILTRABLE" => "Y", // Выводить на странице списка элементов поле для фильтрации по этому свойству
	"IBLOCK_ID" => $ID
   );
  $propId = $ibp->Add($arFields);
  
}

function createTextProperty($ID, $propForm, $propCodeForm){
 $ibp = new CIBlockProperty;
 $arFields = Array(
	"NAME" => $propForm,
	"ACTIVE" => "Y",
	"SORT" => 500, // Сортировка
	"CODE" => $propCodeForm,
	"PROPERTY_TYPE" => "S", // string
	"USER_TYPE" => 'HTML',    //текст
	"FILTRABLE" => "Y", // Выводить на странице списка элементов поле для фильтрации по этому свойству
	"IBLOCK_ID" => $ID
   );
  $propId = $ibp->Add($arFields);
  
}

function createForm($nameForm, $codeForm, $typeForm = "forms"){
	$ib = new CIBlock;
	$arFields = Array(
	  "ACTIVE" => "Y",
	  "SITE_ID" => "s1",
	  "IBLOCK_TYPE_ID" => $typeForm,
	  "NAME" => $nameForm,
	  "CODE" => $codeForm,
	  "SORT" => "500",
	  "GROUP_ID" => Array("2"=>"D", "3"=>"R")
	 );
	 
	$ID = $ib->Add($arFields);
	return $ID;
}

function addElement($nameOption, $IDSelect){
	$el = new CIBlockElement;
	
	$arLoadProductArray = Array(
	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
	  "IBLOCK_ID"      => $IDSelect,
	  "PROPERTY_VALUES"=> $nameOption,
	  "NAME"           => $nameOption,
	  "ACTIVE"         => "Y",            // активен
	);
	
	$PRODUCT_ID = $el->Add($arLoadProductArray);
}

function addSelectProperty($ID, $IDSelect, $selectForm, $selectCodeForm){
	$ibp = new CIBlockProperty;
	$arFields = Array(
		"NAME" => $selectForm,
		"ACTIVE" => "Y",
		"SORT" => 500, // Сортировка
		"CODE" => $selectCodeForm,
		"PROPERTY_TYPE" => "E", // select
		"FILTRABLE" => "Y", // Выводить на странице списка элементов поле для фильтрации по этому свойству
		"IBLOCK_ID" => $ID,
		"LINK_IBLOCK_ID" =>$IDSelect
	);
	$propId = $ibp->Add($arFields);
  
}

function pProcessing($val){

		$nameForm = $val[3];          //имя формы
		
		$codeForm = explode(" ", YATranslate(explode(" ", $nameForm)[0]))[0];  //код формы
		
		$ID = createForm($nameForm, $codeForm);
	return $ID;
}

function labelProcessing($ID, $val){
	$propForm = $val[3];			//свойство
		
	$propCodeForm = explode(" ", YATranslate(explode(" ", $propForm)[0]))[0];  //код свойства
	
	createProperty($ID, $propForm, $propCodeForm);
	
	return $propForm;
}


$html = file_get_contents('http://university.netology.ru/user_data/tarutin/bitrix/index.html');

preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $html, $matches, PREG_SET_ORDER);


foreach ($matches as $key => $val) {
	
	if($val[2] == "p"){
		if ($isSelect == 1){
			$isSelect = 0;
			$numOption = 0;
			addSelectProperty($ID, $IDSelect, $selectForm, $selectCodeForm);
		}
		
		$ID = pProcessing($val);
		
	}
	if($val[2] == "label"){
		$nextKey = $key + 1;
		if($matches[$nextKey][2] == "textarea"){
			
			if ($isSelect == 1){
				$isSelect = 0;
				$numOption = 0;
				addSelectProperty($ID, $IDSelect, $selectForm, $selectCodeForm);
			}
			
			$propForm = $propNameTextForm;			//свойство
				
			$propCodeForm = explode(" ", YATranslate(explode(" ", $propForm)[0]))[0];  //код свойства
			
			createTextProperty($ID, $propForm, $propCodeForm);
			
		}else{

			if ($isSelect == 1){
				$isSelect = 0;
				$numOption = 0;
				addSelectProperty($ID, $IDSelect, $selectForm, $selectCodeForm);
			}
			$propForm = labelProcessing($ID, $val);
		}
	}
	
	if($val[2] == "option"){
		
		if(!isset($numOption)){
			$isNonSimb = $val[0];
		}
		
		if(($val[0] == $isNonSimb) && ($isSelect == 1)){
			$isSelect = 0;
			$numOption = 0;
			addSelectProperty($ID, $IDSelect, $selectForm, $selectCodeForm);
		}

		$isSelect = 1;
		$numOption ++;
		
		if($numOption == 2){
			$selectForm = $val[3]; // свойство
			$selectCodeForm = explode(" ", YATranslate(explode(" ", $propForm)[0]))[0];  //код свойства
			$IDSelect = createForm($selectForm, $selectCodeForm, 'select');
			
		}
		
		if($numOption >= 2){
			$nameOption = $selectForm . $numOption;
			
			addElement($nameOption, $IDSelect);
		}
		
	}
	if($val[2] == "div"){
		$propNameTextForm = $val[3];
	}
	

}
?>