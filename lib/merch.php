<?php

/**
 * Getting list of merch types, like men, woman clothes
 *
 * @param string $filter
 * @return array
 */
function getListOfMerchTypes($filter = '')
{
    $query = 'SELECT * FROM `merch_types` WHERE 1';

    if (is_string($filter) && (trim($filter) != '')) {
        $query .= ' AND ( (`first_name` LIKE :filter) OR (`last_name` LIKE :filter) OR (`phone` LIKE :filter) )';
        $params['filter'] = '%' . $filter . '%';
    }

    return getAllRows($query, $params);
}

/**
 * Getting list of merch under types, like types of men or woman clothes
 *
 * @param string $filter
 * @return array
 */
function getListOfMerchUnderTypes($filter = '')
{
    $query = 'SELECT * FROM `merch_under_types` WHERE 1';

    if (is_string($filter) && (trim($filter) != '')) {
        $query .= ' AND ( (`first_name` LIKE :filter) OR (`last_name` LIKE :filter) OR (`phone` LIKE :filter) )';
        $params['filter'] = '%' . $filter . '%';
    }

    return getAllRows($query, $params);
}

/**
 * Colors which are related to merch under type
 *
 * @param string $filter
 * @return array
 */
function getListOfColourPack($filter = '')
{
    $query = 'SELECT m.merch_under_type_id, m.color_id, a.color, a.article, a.description, a.textColor 
                FROM `merch_under_types_color` as m 
                LEFT JOIN `available_colors` as a ON m.color_id = a.id;';

    if (is_string($filter) && (trim($filter) != '')) {
        $query .= ' AND ( (`first_name` LIKE :filter) OR (`last_name` LIKE :filter) OR (`phone` LIKE :filter) )';
        $params['filter'] = '%' . $filter . '%';
    }

    return getAllRows($query, $params);
}

function getListOfAvailableColors()
{
    $query = 'SELECT * FROM `available_colors`;';

    return getAllRows($query);
}

/**
 * List of available sizes which are related to merch under type
 *
 * @param string $filter
 * @return array
 */
function getListOfAvailableSizes($filter = '')
{
    $query = 'SELECT * FROM `available_sizes` WHERE 1';

    if (is_string($filter) && (trim($filter) != '')) {
        $query .= ' AND ( (`first_name` LIKE :filter) OR (`last_name` LIKE :filter) OR (`phone` LIKE :filter) )';
        $params['filter'] = '%' . $filter . '%';
    }

    $results = getAllRows($query, $params);

    return $results;
}

/**
 * Create some unit, depends of $type value
 *
 * @param $type
 * @param $params
 * @return bool
 */
function insertUnit($type, $params)
{
    if($type === 'merchType') {
        $query = 'INSERT INTO `merch_types`(`merch_type_name`) VALUES (:merchTypeName);';
    }

    if($type === 'merchUnderType') {
        $query = 'INSERT INTO `merch_under_types`(`merch_type_id`, `merch_under_type_name`, `img`, `description`, `price`) 
                        VALUES (:merchTypeId, :merchUnderTypeName, :img, :description, :price);';
    }

    if($type === 'merchUnderTypeColor') {
        $query = 'INSERT INTO `merch_under_types_color`(`merch_under_type_id`, `color_id`) 
                        VALUES (:merchUnderTypeId, :colorId);';
    }

    if($type === 'size') {
        $query = 'INSERT INTO `available_sizes`(`merch_under_type_id`, `S_a`, `S_b`, `S_c`, `M_a`, `M_b`, `M_c`, `L_a`, `L_b`, `L_c`, `XL_a`, `XL_b`, `XL_c`, `XXL_a`, `XXL_b`, `XXL_c`, `3XL_a`, `3XL_b`, `3XL_c`, `4XL_a`, `4XL_b`, `4XL_c`, `5XL_a`, `5XL_b`, `5XL_c`) 
        VALUES (:merch_under_type_id, :S_a, :S_b, :S_c, :M_a, :M_b, :M_c, :L_a, :L_b, :L_c, :XL_a, :XL_b, :XL_c, :XXL_a, :XXL_b, :XXL_c, :3XL_a, :3XL_b, :3XL_c, :4XL_a, :4XL_b, :4XL_c, :5XL_a, :5XL_b, :5XL_c)';
    }

    return performQuery($query, $params) ? true : false;
}

/**
 * Update unit, depends of $type value
 *
 * @param $type
 * @param $params
 * @return bool
 */
function updateUnit($type, $params) {
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
function removeUnit($type, $params) {
    if($type === 'merchType') {
        $query = 'DELETE from `merch_types` WHERE `id` = :id;';
    }

    if($type === 'merchUnderType') {
        $query = 'DELETE from `merch_under_types` WHERE `id` = :id;';
    }

    return performQuery($query, $params) ? true : false;
}

/**
 * Returns array with error messages
 *
 * @param string $phone
 * @param string $firstName
 * @param string $lastName
 * @return array
 */
function contactErrorList($phone, $firstName, $lastName)
{
    $phone = trim($phone);
    $firstName = trim($firstName);
    $lastName = trim($lastName);

    if (strlen($phone) !== 0) {
        if(strlen($phone) > 20) {
            $feedbackContactError['phone'] = 'Phone max. length is 20 symbols';
        }
    } else {
        $feedbackContactError['phone'] = 'Phone field be empty';
    }

    if (strlen($firstName) !== 0) {
        if(strlen($firstName) > 30) {
            $feedbackContactError['firstName'] = 'First name max. length is 30 symbols';
        }
    } else {
        $feedbackContactError['firstName'] = 'First name cannot be empty';
    }

    if (strlen($lastName) !== 0) {
        if(strlen($lastName) > 30) {
            $feedbackContactError['lastName'] = 'Last name max. length is 30 symbols';
        }
    } else {
        $feedbackContactError['lastName'] = 'Last name cannot be empty';
    }

    return $feedbackContactError;
}

