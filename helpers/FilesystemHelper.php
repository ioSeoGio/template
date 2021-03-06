<?php

namespace app\helpers;

use Yii;

class FilesystemHelper {

	public static function getPairsOfTranslations()
	{
        $mainCategory = Yii::$app->id;
        $mainTranslateLanguage = Yii::$app->language;
        
        $ru_pairs = require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'message' . DIRECTORY_SEPARATOR . $mainTranslateLanguage . DIRECTORY_SEPARATOR . $mainCategory . '.php';
        
        $allLanguagesPairs = array_merge_recursive($ru_pairs);
		
		return $allLanguagesPairs;
	}
	
}