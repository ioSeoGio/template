<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;

use app\widgets\Alert;
use app\widgets\Footer;
use app\widgets\Header;
use app\widgets\Head;

use app\assets\AppAsset;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<?= Head::widget(); ?>

<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= Header::widget(); ?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?= Footer::widget(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
