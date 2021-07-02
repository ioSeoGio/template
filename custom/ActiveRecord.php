<?php
namespace app\custom;

class ActiveRecord extends \yii\db\ActiveRecord {
	
	public static function findModel(int $id)
	{
		$model = self::findOne($id);

		if ($model)
			return $model;

		throw new \yii\web\NotFoundHttpException("Not found 404");
	}
}