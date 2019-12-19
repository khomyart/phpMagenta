<?php

/**
 * Initiation of user session
 */
function initSession()
{
    session_start();
}

/**
 * Checks if user authorized:
 * Function returns TRUE if user is authorized, otherwise - FALSE
 *
 * @return bool
 */
function isAuth()
{
    return isset($_SESSION['auth']);
}

/**
 * Performs user authorization action
 *
 * @param $login
 * @param $password
 * @return bool
 */
function userLogIn($login, $password)
{
    $data = getRow(
        'SELECT * FROM `user` WHERE `email` = :login',
        [
            'login' => $login,
        ]
    );

    if (empty($data) || !password_verify($password, $data['password'])) {
        return false;
    }

    $_SESSION['auth'] = [
        'id' => $data['id'],
        'email' => $data['email'],
        'nickname' => $data['nickname'],
    ];

    return true;
}

/**
 * Returns array with error messages
 *
 * @param string $login
 * @param string $password
 * @param string $nickname
 * @return array $feedbackRegData
 */
function userErrorList($login, $password, $nickname)
{
    $login = trim($login);
    $nickname = trim($nickname);

    $findSimilarLoginQuery = 'SELECT `email` from `user` WHERE `email` = :login';
    $findSimilarNicknameQuery = 'SELECT `nickname` from `user` WHERE `nickname` = :nickname';
    $loginParam = [
        'login' => $login,
    ];
    $nicknameParam = [
        'nickname' => $nickname,
    ];

    if (getRow($findSimilarLoginQuery, $loginParam)) {
        $feedbackUserError['regLogin'] = 'Login already exists';
    }

    if (getRow($findSimilarNicknameQuery, $nicknameParam)) {
        $feedbackUserError['regNickname'] = 'Nickname already exists';
    }

    if (!(strlen($login)>5 && strlen($login)<25)) {
        $feedbackUserError['regLogin'] = 'Login min. length is 3 symbols, max. 25 symbols';
    }

    if (!(strlen($nickname)>4 && strlen($nickname)<16)) {
        $feedbackUserError['regNickname'] = 'Nickname min. length is 4 symbols, max. 16 symbols';
    }

    if (!(strlen($password)>5 && strlen($password)<25)) {
        $feedbackUserError['regPassword'] = 'Password min. length is 5 symbols, max. 25 symbols';
    }

    return $feedbackUserError;
}

/**
 * Used as alternative error list with no login existence checking and no password existence checking
 *
 * @param string $login
 * @param string $nickname
 * @return array $ErrorData
 */
function altUserErrorList($login, $nickname)
{
    $login = trim($login);
    $nickname = trim($nickname);

    if(!(strlen($login)>5 && strlen($login)<25)) {
        $feedbackUserError['regLogin'] = 'Login min. length is 3 symbols, max. 25 symbols';
    }

    if(!(strlen($nickname)>4 && strlen($nickname)<16)) {
        $feedbackUserError['regNickname'] = 'Nickname min. length is 4 symbols, max. 16 symbols';
    }

    return $feedbackUserError;
}

/**
 * Returns string with error message if $login already exist in data base
 *
 * @param $login
 * @return mixed
 */
function userEditLoginExistenceChecker($login)
{
    $login = trim($login);

    $findSimilarLoginQuery = 'SELECT `email` from `user` WHERE `email` = :login';
    $loginParam = [
        'login' => $login,
    ];

    if(getRow($findSimilarLoginQuery, $loginParam)) {
        $feedbackUserError['regLogin'] = 'Login already exists';
    }

    if(!(strlen($login)>5 && strlen($login)<25)) {
        $feedbackUserError['regLogin'] = 'Login min. length is 3 symbols, max. 25 symbols';
    }

    return $feedbackUserError;
}

/**
 * Returns string with error message if $nickname already exist in data base
 *
 * @param $nickname
 * @return mixed
 */
function userEditNicknameExistenceChecker($nickname)
{
    $nickname = trim($nickname);

    $findSimilarNicknameQuery = 'SELECT `nickname` from `user` WHERE `nickname` = :nickname';
    $nicknameParam = [
        'nickname' => $nickname,
    ];

    if(getRow($findSimilarNicknameQuery, $nicknameParam)) {
        $feedbackUserError['regNickname'] = 'Nickname already exists';
    }

    if(!(strlen($nickname)>4 && strlen($nickname)<16)) {
        $feedbackUserError['regNickname'] = 'Nickname min. length is 4 symbols, max. 16 symbols';
    }

    return $feedbackUserError;
}

/**
 * Adds a new user to DB
 *
 * @param $login
 * @param $password
 * @param $nickname
 *
 * @return bool
 */
function addUser($login, $password, $nickname)
{
    $login = trim($login);
    $nickname = trim($nickname);

    $query = 'INSERT INTO `user` (`email`,`password`,`nickname`) VALUES (:login, :password, :nickname)';
    $params = [
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'nickname' => $nickname,
    ];

    if(empty(userErrorList($login, $password, $nickname))) {
        $result = performQuery($query, $params);
        return $result;
    }
}

/**
 * Edits user with given id
 *
 * @param int $id
 * @param string $email
 * @param string $nickname
 * @param string $type
 * @param string $validationType (full = use full account validation, none = use alternative account validation
 * login = check if login exists, nickname = check if nickname exists)
 *
 * @return bool
 */
function editUser($id, $email, $nickname, $type, $validationType)
{
    $email = trim($email);
    $nickname = trim($nickname);

    $query = 'UPDATE `user` SET `email`= :email,`nickname`= :nickname,`type`= :type WHERE `id`= :id;';
    $params = [
        'id' => $id,
        'email' => $email,
        'nickname' => $nickname,
        'type' => $type,
    ];

    if($validationType == 'full') {
        if(empty(userErrorList($email, '******', $nickname))) {
            $result = performQuery($query, $params);
            return $result;
        }
    } elseif ($validationType == 'none') {
        if(empty(altUserErrorList($email, $nickname))) {
            $result = performQuery($query, $params);
            return $result;
        }
    } elseif ($validationType == 'login') {
        if(empty(userEditLoginExistenceChecker($email))) {
            $result = performQuery($query, $params);
            return $result;
        }
    } elseif ($validationType == 'nickname') {
        if(empty(userEditNicknameExistenceChecker($nickname))) {
            $result = performQuery($query, $params);
            return $result;
        }
    }
}

/**
 * Removes user with given id
 *
 * @param $id
 * @return bool
 */
function removeUser($id)
{
    $query = 'DELETE FROM `user` WHERE `id` = :id;';
    $params = [
        'id' => $id,
    ];

    $result = performQuery($query, $params);

    return  $result;
}

/**
 * Changes user password where user is identified with $id param
 *
 * @param $id
 * @param $oldPassword
 * @param $newPassword
 * @param $repeatNewPassword
 * @return array|string
 */
function userPasswordChange($id, $oldPassword, $newPassword, $repeatNewPassword)
{
    $getPasswordQuery = 'SELECT `password` FROM `user` WHERE `id` = :id;';
    $getPasswordParam = ['id' => $id];
    $oldPasswordFromDb = getRow($getPasswordQuery, $getPasswordParam);

    if (password_verify($oldPassword, $oldPasswordFromDb['password'])) {
        if ($newPassword == $repeatNewPassword) {
            if (!(strlen($newPassword)>5 && strlen($newPassword)<25)) {
                $feedbackPasswordError['newPassword'] = 'Password min. length is 5 symbols, max. 25 symbols';
            } else {
                $feedbackPasswordError = [];
            }
        } else {
            $feedbackPasswordError['repeatNewPassword'] = 'Entered passwords dont much!';
        }
    } else {
        $feedbackPasswordError['oldPassword'] = 'Password is incorrect!';
    }

    if(empty($feedbackPasswordError)) {
        $replacePasswordQuery = 'UPDATE `user` SET `password` = :password WHERE id = :id;';
        $param = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'id' => $id,
        ];

        $replacePasswordQueryResult = performQuery($replacePasswordQuery, $param);
        $feedbackPasswordError = $replacePasswordQueryResult? [] : 'Some problems with DB';
    }

    return $feedbackPasswordError;
}







