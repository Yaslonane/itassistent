<?php

/**
 * Created by PhpStorm.
 * User: andrey
 * Date: 14.04.16
 * Time: 18:33
 */
class Db{

    public static function getConnection(){

        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);

        $db->exec('SET NAMES utf8'); //задаём кодировку ввода/вывода БД

        return $db;
    }

}

?>