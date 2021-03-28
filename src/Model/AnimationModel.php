<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class AnimationModel
 * @package App\Model
 */
class AnimationModel extends MainModel 
{
    public function listAnimationsWithCategory()
    {
        $query = "SELECT 
            Animation.id, Animation.name, Animation.effect, 
            AnimationCat.category 
            FROM Animation
            INNER JOIN AnimationCat 
            ON Animation.category_id = AnimationCat.id
            ORDER BY Animation.id";
    
        return $this->database->getAllData($query);
    }
}
