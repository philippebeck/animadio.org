<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class HelpersModel
 * @package App\Model
 */
class HelpersModel extends MainModel
{
    public function listHelpersClasses()
    {
        $query = "SELECT * FROM Helpers
                    INNER JOIN HelpersProperty ON Helpers.property = HelpersProperty.id
                    ORDER BY Helpers.id";

        return $this->database->getAllData($query);
    }
}
