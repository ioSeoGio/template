<?php
//'generators' => [

return [
    // Имя генератора
    'giiant-model' => [
        // Класс генератора
        'class' => 'schmunk42\giiant\generators\model\Generator',
        // Настройки шаблонов
        'templates' => [
            // Имя шаблона => путь к шаблону
            'seog_template' => '@app/custom/giiant/model',
        ]
    ],
    'giiant-crud' => [
        // Класс генератора
        'class' => 'schmunk42\giiant\generators\crud\Generator',
        // Настройки шаблонов
        'templates' => [
            // Имя шаблона => путь к шаблону
            'seog_template' => '@app/custom/giiant/crud',
        ]
    ],
];