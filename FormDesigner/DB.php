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

    public static function getTableCreate($table)
    {
        $sql = "SHOW CREATE TABLE " . $table;
        $result = self::getInstance()->query($sql);
        return $result->fetchAll(\PDO::FETCH_ASSOC)[0]['Create Table'];

    }

    public static function getStructure($table_name)
    {

        $table_name = stripcslashes($table_name);

        $sql = "SHOW FULL COLUMNS FROM {$table_name}";
        $result = self::query($sql);

        return $result->fetchAll(\PDO::FETCH_ASSOC);

    }

    public static function setStructure($table_name, $items)
    {
        // Get the create table
        $create = explode("\n", DB::getTableCreate($table_name));
        $alter = [];
        foreach ($create as $line) {
            $line = trim($line);

            if (substr($line, 0, 1) == '`') {
                $field_name = trim(substr($line, 0, strpos($line, ' ')), '`');

                if (true || isset($items[$field_name])) {

                    $json = [];
                    foreach (Field::getOptionsKeys() as $key) {
                        if (!empty($items[$field_name][$key]['value'])) {
                            $json[$key] = $items[$field_name][$key]['value'];
                        }
                    }

                    if (strpos($line, "COMMENT")) {
                        $line = substr($line, 0, strpos($line, "COMMENT"));
                    } else {
                        $line = trim($line, ',');
                    }

                    $line = $line . " COMMENT '" . addslashes(json_encode($json)). "'";

                    $alter[] = "ALTER TABLE $table_name MODIFY COLUMN $line";
                }
            }
        }

        foreach ($alter as $sql) {
            DB::query($sql);
        }
    }


    public static function getTables()
    {
        $tables = [];
        $sql = "SHOW TABLES";
        $result = self::query($sql);
        $records = $result->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($records as $table) {
            $tables[$table['Tables_in_' . self::$databaseName]] = $table['Tables_in_' . self::$databaseName];
        }

        asort($tables);

        return $tables;

    }
}