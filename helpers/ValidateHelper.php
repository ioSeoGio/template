<?php

namespace app\helpers;

use Yii;

class ValidateHelper {
    
	public static function validateWebaddress(string $url)
	{
        $url = trim($url);

        if (substr($url, -1) == "/")
            $url = mb_substr($url, 0, -1);

        // Массив с компонентами URL, сгенерированный функцией parse_url()
        if (!$arUrl = parse_url($url))
            return false;
        // Возвращаемое значение. По умолчанию будет считать наш URL некорректным.
        $url = null;


        // Если не был указан протокол, или
        // указанный протокол некорректен для url
        if (!array_key_exists("scheme", $arUrl)
            || !in_array($arUrl["scheme"], array("http", "https")))
        {
            $arUrl["scheme"] = "http";
        }
        // Задаем протокол по умолчанию - http

        if (!isset($arUrl["path"])) {
            $arUrl["path"] = "";
        }
        // Если функция parse_url смогла определить host
        if (array_key_exists("host", $arUrl) &&
                !empty($arUrl["host"]))
            // Собираем конечное значение url
            $url = sprintf("%s://%s%s", $arUrl["scheme"],
                            $arUrl["host"], $arUrl["path"]);

        // Если значение хоста не определено
        // (обычно так бывает, если не указан протокол),
        // Проверяем $arUrl["path"] на соответствие шаблона URL.
        else if (preg_match("/^\w+\.[\w\.]+(\/.*)?$/", $arUrl["path"]))
            // Собираем URL
            $url = sprintf("%s://%s", $arUrl["scheme"], $arUrl["path"]);

        // Если url валидный и передана строка параметров запроса
        if ($url && !empty($arUrl["query"])) {
            $url .= sprintf("?%s", $arUrl["query"]);
        }

        if (substr($url, -1) == "?")
            $url = mb_substr($url, 0, -1);

        return $url;
	}

    public static function validateInstanceName(string $name)
    {
        $specialChars = ['\\', '"', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', ';', "'", ',', '.', '/', '', '~', '`', '='];
        $name = str_replace($specialChars, '', $name);
        
        return $name;
    }
}
