<?php if ($flashes = Yii::$app->session->getAllFlashes()): ?>
    <div class="alert-wrapper">
        <?php foreach ($flashes as $type => $message):

            $msgArray = [];
            gettype($message) == 'array' ? $msgArray = $message : array_push($msgArray, $message);

            switch ($type):
                case "success":
                    $msgType = "alert alert-success";
                    break;
                case "error":
                    $msgType = "alert alert-error";
                    break;
                default:
                    $msgType = "alert";
                    break;
            endswitch;?>

            <?php foreach ($msgArray as $key => $oneMessage): ?>
                <div class="<?= $msgType ?>" style="display: none;">
                    <div class="alert-message"><?= $oneMessage ?></div>
                    <div class="alert-point">
                        <p>+</p>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endforeach; ?>
    </div>
<?php endif; ?>
