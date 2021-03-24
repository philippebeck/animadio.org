<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class VariableModel
 * @package App\Model
 */
class VariableModel extends MainModel 
{
    public function listVariablesWithCategory()
    {
        $query = "SELECT * FROM Variable
            INNER JOIN VariableCat 
            ON Variable.category_id = VariableCat.id
            ORDER BY Variable.id";
    
        return $this->database->getAllData($query);
    }
}
