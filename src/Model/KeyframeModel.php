<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class KeyframeModel
 * @package App\Model
 */
class KeyframeModel extends MainModel 
{
    public function listKeyframesWithCategory()
    {
        $query = "SELECT * FROM Keyframe
            INNER JOIN KeyframeCat 
            ON Keyframe.category_id = KeyframeCat.id
            ORDER BY Keyframe.id";
    
        return $this->database->getAllData($query);
    }
}
