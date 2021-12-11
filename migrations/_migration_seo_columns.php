<?php 

return [
	'seo_url' => $this->string(64)->unique()->comment('Человеко-понятный url'),
	'seo_h1' => $this->string(64)->comment('Замена стандартного h1 тега страницы'),
	'seo_title' => $this->string(64)->comment('Замена стандартному title страницы'),
	'seo_keywords' => $this->string(64)->comment('Seo ключевые слова'),
	'seo_description' => $this->string(64)->comment('Seo описание'),
];