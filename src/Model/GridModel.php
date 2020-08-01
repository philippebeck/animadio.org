<?php

namespace App\Model;

use Pam\Model\MainModel;

/**
 * Class GridModel
 * @package App\Model
 */
class GridModel extends MainModel
{
    public function listGridClasses()
    {
        $query = "SELECT * FROM Grid
                    INNER JOIN GridProperty ON Grid.property = GridProperty.id
                    INNER JOIN GridValue ON Grid.valor = GridValue.id
                    ORDER BY Grid.id";

        return $this->database->getAllData($query);
    }
}
