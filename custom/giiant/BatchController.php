<?php

namespace app\custom\giiant;

/**
 * @author ioSeoGio
 */
class BatchController extends \schmunk42\giiant\commands\BatchController
{
    /**
     * @var string namespace path for model classes
     */
    public $modelNamespace = 'app\\models';

    /**
     * @var string namespace path for crud controller
     */
    public $crudControllerNamespace = 'app\\controllers\\crud';

    /**
     * @var string namespace path for crud search models
     */
    public $crudSearchModelNamespace = 'app\\models\\search';

    /**
     * @var string namespace path for crud views
     */
    public $crudViewPath = '@app/views/crud';

}

