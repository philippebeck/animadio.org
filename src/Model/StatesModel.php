<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class StatesModel
 * @package App\Model
 */
class StatesModel extends MainModel
{
    public function listStatesClasses()
    {
        $query = "SELECT * FROM States
                    INNER JOIN StatesProperty ON States.property = StatesProperty.id
                    ORDER BY States.id";

        return $this->database->getAllData($query);
    }
}
