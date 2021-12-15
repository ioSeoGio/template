<?php

namespace app\custom;

use Yii;

use app\helpers\WebHelper;


class ActiveRecord extends \yii\db\ActiveRecord {
	
    /**
     * Gets the photo full path
     *
     * @param $photoPropertyName str name of model property that containt photo name (by default 'photo')
     *
     * @return string Full path of image to display
     * @throws \yii\base\InvalidConfigException If model has no IMG_PATH const or given photo property
     */
    public function getPhotoPath(string $photoPropertyName = 'photo')
    {
    	if (defined('static::IMG_PATH')) {
    		if (isset($this->$photoPropertyName)) {
    			if (WebHelper::isExternal($this->$photoPropertyName)) {
    				return $this->$photoPropertyName;
    			}

        		return Yii::getAlias(static::IMG_PATH) . $this->$photoPropertyName;
    		} else {
	    		throw new \yii\base\InvalidConfigException(static::class." has no property $photoPropertyName");
    		}
    	} else {
	    	throw new \yii\base\InvalidConfigException('Constant IMG_PATH of '.static::class.' has not defined.');
    	}
    }

	/**
	 * Finds a model
	 *
	 * @param $id int
	 *
	 * @return \yii\db\ActiveRecord
	 * @throws \yii\web\NotFoundHttpException if model not found
	 */
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
				// Maybe it worth to throw 404 exception
				// throw new \yii\web\NotFoundHttpException();
			}
		}

		return false;
	}

    /**
     * Additional fiels to display to rest controllers
     * By default adds all related records to return in rest controller
     * Use ModelClass::find()->with() to get related methods
     *
     * @return array $fields
     */
    public function fields()
    {
        $fields = parent::fields();
        
        $fields['related'] = function () {
            return $this->relatedRecords;
        };
        
        return $fields;
    }

	/**
	 * Finds a with model with given related models
	 *
	 * @param $attributes array Filter attributes to find model
	 * @param $related array Names of relations to get related objects
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public static function findWithRelated(array $attributes, array $related = [])
	{
        return static::find($attributes)
            ->with($related);
	}
}