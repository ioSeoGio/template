<?php 
use yii\helpers\Url;
use yii\helpers\StringHelper;

?>

<div class="global-menu">
    <div class="dropdown-menu-1">

        <?php foreach ($menu as $groupName => $records): ?>
            <?php if ($groupName == Yii::t('app', 'Without group')): ?>
                <?php foreach ($records as $row): ?>

                    <?php if ($row['can']): ?>
                        <a class="dropdown-item <?= StringHelper::dirname(Yii::$app->request->url) === StringHelper::dirname($row['url']) ? 'active' : '' ?>" href="<?= $row['url'] ?>"><?= $row['name'] ?></a>
                    <?php endif; ?>

                <?php endforeach; ?>

            <?php else: ?>
                <div class="group">
                    <span class="devider"><?= $groupName ?></span>
                    <?php foreach ($records as $row): ?>

                        <?php if ($row['can']): ?>
                            <a class="dropdown-item <?= StringHelper::dirname(Yii::$app->request->url) === StringHelper::dirname($row['url']) ? 'active' : '' ?>" href="<?= $row['url'] ?>"><?= $row['name'] ?></a>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>
    <div class="content-block">
        <?= $content ?>
    </div>
</div>