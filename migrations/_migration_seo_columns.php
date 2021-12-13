<?php 

return [
	'seo_url' => $this->string(64)->unique()->comment('Human-readable url'),
	'seo_h1' => $this->string(64)->comment('Replacement of standart h1 page tag'),
	'seo_title' => $this->string(64)->comment('Replacement of standart title page tag'),
	'seo_keywords' => $this->string(64)->comment('Seo keywords'),
	'seo_description' => $this->string(64)->comment('Seo description'),
];