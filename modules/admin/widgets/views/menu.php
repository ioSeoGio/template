<?php 
use yii\helpers\Url;
use yii\helpers\StringHelper;

?>

<div class="global-menu">
    <div class="dropdown-menu-1">

        <?php foreach ($menu as $groupName => $records): ?>
            <?php if ($groupName == 'Без группы'): ?>
                <?php foreach ($records as $label => $url): ?>
                    <a class="dropdown-item <?= StringHelper::dirname(Yii::$app->request->url) === StringHelper::dirname($url) ? 'active' : '' ?>" href="<?= $url ?>"><?= $label ?></a>
                <?php endforeach; ?>

            <?php else: ?>
                <div class="group">
                    <span class="devider"><?= $groupName ?></span>
                    <?php foreach ($records as $label => $url): ?>
                        <a class="dropdown-item <?= StringHelper::dirname(Yii::$app->request->url) === StringHelper::dirname($url) ? 'active' : '' ?>" href="<?= $url ?>"><?= $label ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>
    <div class="content-block">
        <?= $content ?>
    </div>
</div>