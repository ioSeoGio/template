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
    'seog-widget' => [
        // Класс генератора
        'class' => 'app\custom\giiant\widgets\Generator',
        // Настройки шаблонов
        'templates' => [
            // Имя шаблона => путь к шаблону
            'seog_template' => '@app/custom/giiant/widgets',
        ]
    ],
    'seog-fixtures' => [
        'class' => 'app\custom\giiant\fixtures\Generator',
        'templates' => [
            'seog_template' => '@app/custom/giiant/fixtures',
        ],
    ],
    'fixture' => [
        'class' => 'elisdn\gii\fixture\Generator',
    ],
];