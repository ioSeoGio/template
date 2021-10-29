<?php

namespace app\custom;

use Yii;

/**
 * Base controller for API
 */
abstract class BaseApiController extends \yii\rest\Controller
{

    /**
     * Configuring authenticator and set cosr pre-flight filter in order to deal with api requests right
     * Chrome asking for OPTIONS pre-flight requests, so corsFilter must be set
     *
     * @return array Behaviours
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // Configuring corsFilter & re-add authenticator
        $behaviors['authenticator'] = [
            'class' => $this->getAuthenticatorClass(),
        ];
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);
        $behaviors['corsFilter'] = [
            'class' => $this->getCorsFilterClass(),
        ];
        $behaviors['authenticator'] = $auth;
        $behaviors['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;


		$behaviors['access'] = $this->accessRules();

        $behaviors['authenticator']['only'] = $this->getAuthOnlyActions();
        $behaviors['authenticator']['except'] = $this->getAuthExceptActions();

        return $behaviors;
    }

    /**
     * Gets the authenticator class
     *
     * @return string
     */
    protected function getAuthenticatorClass()
    {
    	return \yii\filters\auth\HttpBasicAuth::className();
    }

    /**
     * Gets the cors filter class
     *
     * @return string
     */
    protected function getCorsFilterClass()
    {
    	return \yii\filters\Cors::className();
    }

    /**
     * Gets the access rules
     * 	`return [
     *	`	'class' => \yii\filters\AccessControl::className(),
     *	`	'rules' => [
     *	`	]
     *  `];
     *
     * @return array
     */
   	abstract protected function accessRules();

    /**
     * Gets the auth only actions
     *
     * @return array Actions to apply authenticator rules 
     */
    protected function getAuthOnlyActions()
    {
    	return [
        ];
    }

    /**
     * Gets the auth except actions
     *
     * @return array Actions to be ignored in authenticator rules
     */
    protected function getAuthExceptActions()
    {
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
    	return [
            'options',
            

            'auth',
        ];
    }

    /**
     * @return array Actions of controller
     * Base controller implements auth action for other ones'
     */
    public function actions()
    {
        $actions = parent::actions();

        $actions['auth'] = [
            'class' => 'yii\authclient\AuthAction',
            'successCallback' => [$this, 'oAuthSuccess'],
        ];

        return $actions;
    }

    /**
     * Success callback of auth action - means that this function gonna be called, when authentication was successful
     *
     * @param $client Client interface of yii framework (see \yii\authclient\AuthAction)
     */
    public function oAuthSuccess($client)
    {
        \common\helpers\AuthHelper::validateAuth($client, true);
    }

    /**
     * Function to update model attributes for create/update actions
     *
     * @param $model \yii\base\Model Model to update
     * @param $attributes array Attributes for model updating
     * @param $returnStatusCode int HttpStatus code to return
     *
     * @throws \common\exceptions\ModelValidateException When model not saved
     *
     * @return \yii\base\Model
     */
    protected function updateModel(\yii\base\Model $model, array $attributes, int $returnStatusCode = 200)
    {
        $model->load($attributes, '');

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode($returnStatusCode);

            return $model;
        }
        
        \common\helpers\ErrorHelper::throwAllErrors($model);
    }
}
