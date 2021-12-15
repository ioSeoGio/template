<?php
echo "<?php\n";
?>
 
namespace <?= $fixturesNamespace ?>;
 
use yii\test\ActiveFixture;
 
class <?= $className ?>Fixture extends ActiveFixture
{
    public $modelClass = '<?= $modelFullClass ?>';
    public $dataFile = '<?= $dataFileFullPath ?>';

    public $depends = [
<?php foreach ($dependencies as $dependencyClass): ?>
        '<?= $dependencyClass ?>',
<?php endforeach; ?>
    ];
}