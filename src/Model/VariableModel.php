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
            INNER JOIN Category 
            ON Variable.category_id = Category.id
            ORDER BY Category.id";
    
        return $this->database->getAllData($query);
    }
}
