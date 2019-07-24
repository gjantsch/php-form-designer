<?php
/**
 * DB connection for table form.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 *
 */

namespace FormDesigner;

class DB
{

    public static $instance;

    private static $databaseName;

    private static $hostName;

    private static $userName;

    private static $password;

    public static function initialize($database_name, $host_name, $user_name, $password)
    {
        self::$databaseName = $database_name;
        self::$hostName = $host_name;
        self::$userName = $user_name;
        self::$password = $password;

    }

    public static function getInstance()
    {

        try{

            if (self::$instance == null) {

                self::$instance = new \PDO(
                    'mysql:dbname=' . self::$databaseName . ';host=' . self::$hostName . ';',
                    self::$userName,
                    self::$password
                );

                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$instance->exec('SET NAMES utf8');
            }

        } catch (PDOException $e){
            die('Database if offline.');
        }

        return self::$instance;
    }

    public static function query($sql)
    {
        return self::getInstance()->query($sql);
    }

    public static function getStructure($table_name)
    {

        $table_name = stripcslashes($table_name);

        $sql = "SHOW FULL COLUMNS FROM {$table_name}";
        $result = self::query($sql);

        return $result->fetchAll(\PDO::FETCH_ASSOC);

    }
}