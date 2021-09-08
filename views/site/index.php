<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div ng-app class="site-index">
    <div class="body-content">
        <input type="text" ng-model="name" placeholder="Введите имя">
        {{name}}
    </div>
</div>
