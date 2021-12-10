<?php

namespace app\custom\giiant;

/**
 * @author ioSeoGio
 * 
 * Check if config/console.php controllerMap batch has this class before configuring this class
 */
class BatchController extends \schmunk42\giiant\commands\BatchController
{
    /**
     * @var string namespace path for model classes
     */
    public $modelNamespace = 'app\\models';

    /**
     * @var string base class for the generated models
     */
    public $modelBaseClass = 'app\\custom\\ActiveRecord';

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


    /**
     * @var bool is interactive console mode enabled
     */
    public $interactive = false;
}

