<?php
echo "<?php\n";
?>
 
namespace tests\unit\fixtures;
 
use yii\test\ActiveFixture;
 
class <?= $className ?>Fixture extends ActiveFixture
{
    public $modelClass = '<?= $modelFullClass ?>';
    public $dataFile = '<?= $dataFileFullPath ?>';
}