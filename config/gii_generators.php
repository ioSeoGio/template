<?php

return [
    // Имя генератора
    'giiant-model' => [
        // Класс генератора
        'class' => 'app\custom\giiant\model\Generator',
        // Настройки шаблонов
        'templates' => [
            // Имя шаблона => путь к шаблону
            'seog_template' => '@app/custom/giiant/model',
        ]
    ],
    'giiant-crud' => [
        // Класс генератора
        'class' => 'app\custom\giiant\crud\Generator',
        // Настройки шаблонов
        'templates' => [
            // Имя шаблона => путь к шаблону
            'seog_template' => '@app/custom/giiant/crud',
        ]
    ],
];