<?php

function getListOfColors($filter = '')
{
    $query = 'SELECT * FROM `available_colors` WHERE 1';

    if (is_string($filter) && (trim($filter) != '')) {
        $query .= ' AND ( (`color` LIKE :filter) OR (`article` LIKE :filter) OR (`description` LIKE :filter) OR (`textColor` LIKE :filter) )';
        $params['filter'] = '%' . $filter . '%';
    }

    return getAllRows($query, $params);
}

/**
 * Edit unit, depends of $action value
 *
 * @param $action
 * @param $params
 * @return bool
 */
function editColorUnit($action, $params) {
    if ($action === 'insert') {
        $query = 'INSERT INTO `available_colors`(`color`, `article`, `description`, `textColor`) 
                    VALUES (:color, :article, :description, :textColor);';
    }
    
    if ($action === 'remove') {
        $query = 'DELETE from `available_colors` WHERE `id` = :id;';
    }

    if ($action === 'update') {
        $query = 'UPDATE `available_colors` 
                    SET `color`=:color,`article`=:article,`description`=:description,`textColor`=:textColor 
                    WHERE `id` = :id;';
    }

    return performQuery($query, $params) ? true : false;
}
