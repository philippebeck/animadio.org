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
            INNER JOIN ClassCat 
            ON Class.category_id = ClassCat.id
            INNER JOIN ClassMedia 
            ON Class.media_id = ClassMedia.id
            ORDER BY Class.id";
    
        return $this->database->getAllData($query);
    }
}
