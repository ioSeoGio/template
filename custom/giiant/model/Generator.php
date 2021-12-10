<?php

namespace app\custom\giiant\model;

use schmunk42\giiant\helpers\SaveForm;
use Yii;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

class Generator extends \schmunk42\giiant\generators\model\Generator
{
	public $baseClass = 'app\custom\ActiveRecord';

}