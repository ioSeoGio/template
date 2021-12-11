<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\helpers\Url;

use app\widgets\Alert;
use app\widgets\Footer;
use app\widgets\Header;
use app\widgets\Head;
use app\modules\admin\widgets\Menu;

use app\assets\AppAsset;
AppAsset::register($this);
use app\modules\admin\assets\AdminAsset;
AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<?= Head::widget(['layoutView' => $this]); ?>

<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= Header::widget(); ?>

<main role="main" class="flex-shrink-0">
    <div class="container-fluid">
        <?php
        if (isset($this->params['breadcrumbs'])) {
            $toAdminUrl = Url::to(['/admin']);
            $adminLabel = 'Админка';
            $currentPageIsAdmin = Yii::$app->request->url === $toAdminUrl;

            array_unshift($this->params['breadcrumbs'], $currentPageIsAdmin ? $adminLabel : [
                'label' => $adminLabel,
                'url' => $toAdminUrl,
            ]);
        } ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= Alert::widget() ?>

        <?php Menu::begin() ?>
            <?= $content ?>
        <?php Menu::end() ?>
    </div>
</main>

<?= Footer::widget(); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
