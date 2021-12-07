<?php
namespace app\custom;

class ActiveRecord extends \yii\db\ActiveRecord {
	
	public static function findModel(int $id)
	{
		$model = self::findOne($id);

		if ($model) {
			return $model;
		}

		throw new \yii\web\NotFoundHttpException();
	}

	public function saveOrUpdate()
	{
		if ($this->validate()) {
			return $this->save();
		} else {
			$notUniqueAttributes = array_keys($this->errors);

			$attributesForFinding = [];
			foreach ($notUniqueAttributes as $attributeName) {
				$attributesForFinding[$attributeName] = $this->$attributeName;
			}

			$oldModel = static::findOne($attributesForFinding);
			if ($oldModel) {
				$attributeList = array_keys($this->attributes);

				foreach ($attributeList as $attributeName) {
					$oldModel->$attributeName = $this->$attributeName ?: $oldModel->$attributeName;
				}
				return $oldModel->save();
			} else {
				// There is another errors that makes search by attributes not right

				return false;
				// throw new \yii\web\NotFoundHttpException();
			}
		}

		return false;
	}
}