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

function insertColorUnit($params)
{
    $query = 'INSERT INTO `available_colors`(`color`, `article`, `description`, `textColor`) VALUES (:color, :article, :description, :textColor);';

    return performQuery($query, $params) ? true : false;
}

/**
 * Update unit, depends of $type value
 *
 * @param $type
 * @param $params
 * @return bool
 */
function updateColorUnit($type, $params) {
    if($type === 'merchType') {
        $query = 'UPDATE `merch_types` SET `merch_type_name` = :merchTypeName WHERE `id` = :id;';
    }

    return performQuery($query, $params) ? true : false;
}

/**
 * Remove unit, depends of $type value
 *
 * @param $type
 * @param $params
 * @return bool
 */
function removeColorUnit($type, $params) {
    if($type === 'merchType') {
        $query = 'DELETE from `merch_types` WHERE `id` = :id;';
    }

    if($type === 'merchUnderType') {
        $query = 'DELETE from `merch_under_types` WHERE `id` = :id;';
    }

    return performQuery($query, $params) ? true : false;
}