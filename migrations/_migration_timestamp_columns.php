<?php 

return [
    'created_at' => $this->timestamp()
    	->notNull()
    	->defaultExpression('CURRENT_TIMESTAMP')
    	->comment('Дата создания записи'),
    	
    'updated_at' => $this->timestamp()
    	->notNull()
    	->defaultExpression('CURRENT_TIMESTAMP')
    	->comment('Дата редактирования записи'),
];