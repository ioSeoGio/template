<?php 

return [
    'created_at' => $this->timestamp()
    	->notNull()
    	->defaultExpression('CURRENT_TIMESTAMP')
    	->comment('Datetime of record creating'),
    	
    'updated_at' => $this->timestamp()
    	->notNull()
    	->defaultExpression('CURRENT_TIMESTAMP')
    	->comment('Datetime of last record updating'),
];