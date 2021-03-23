<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class KeyframeModel
 * @package App\Model
 */
class KeyframeModel extends MainModel 
{
    public function listKeyframesWithFamily()
    {
        $query = "SELECT * FROM Keyframe
            INNER JOIN Family 
            ON Keyframe.family_id = Family.id
            ORDER BY Family.id";
    
        return $this->database->getAllData($query);
    }
}
