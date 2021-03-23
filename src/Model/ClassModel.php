<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class ClassModel
 * @package App\Model
 */
class ClassModel extends MainModel 
{
    public function listClassesWithCategory()
    {
        $query = "SELECT * FROM Class
            INNER JOIN Category 
            ON Class.category_id = Category.id
            ORDER BY Category.id";
    
        return $this->database->getAllData($query);
    }
}
