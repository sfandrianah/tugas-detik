<?php

namespace app\util;

class DB
{
    public static $conn;
    public static $resultData = array(
        "result" => false,
        "message" => "",
        "get" => "",
        "statement" => null,
    );

    public static $dbData = array(
        "TABLE" => null
    );

    public static function init()
    {
        $mainDir = $GLOBALS["MAIN_DIR"];
        if (file_exists($mainDir . "/config.json")) {
            $fileJsonConfig = file_get_contents($mainDir . "/config.json");
            $data = @json_decode($fileJsonConfig);
            if ($data === null
                && json_last_error() !== JSON_ERROR_NONE) {
//        echo "incorrect data";
            } else {
                if (isset($data->database)) {
                    $dbData = $data->database;
                    $dbDataConfig = array();
                    if (isset($dbData->db_host)) {
                        $dbHost = $dbData->db_host;
                        $dbDataConfig["db_host"] = $dbHost;
                    }
                    if (isset($dbData->db_port)) {
                        $dbPort = $dbData->db_port;
                        $dbDataConfig["db_port"] = $dbPort;
                    }
                    if (isset($dbData->db_host)) {
                        $dbHost = $dbData->db_host;
                        $dbDataConfig["db_host"] = $dbHost;
                    }
                    if (isset($dbData->db_username)) {
                        $dbUsername = $dbData->db_username;
                        $dbDataConfig["db_username"] = $dbUsername;
                    }
                    if (isset($dbData->db_password)) {
                        $dbPassword = $dbData->db_password;
                        $dbDataConfig["db_password"] = $dbPassword;
                    }
                    if (isset($dbData->db_name)) {
                        $dbName = $dbData->db_name;
                        $dbDataConfig["db_name"] = $dbName;
                    }
                    $isExistDB = true;
                    $GLOBALS["DB_DATA_CONFIG"] = $dbDataConfig;
                }
            }

        }
    }

    public static function showConfig()
    {
        self::init();
        $dbDataConfig = $GLOBALS["DB_DATA_CONFIG"];
        return $dbDataConfig;
    }

    public static function connect()
    {
        self::init();
        $servername = null;
        $username = null;
        $password = null;
        $port = null;
        $dbname = null;
        if (isset($GLOBALS["DB_DATA_CONFIG"])) {
            $dbDataConfig = $GLOBALS["DB_DATA_CONFIG"];
            $servername = $dbDataConfig["db_host"];
            $username = $dbDataConfig["db_username"];
            $password = $dbDataConfig["db_password"];
            $port = $dbDataConfig["db_port"];
            $dbname = $dbDataConfig["db_name"];
        }

        try {
            self::$conn = new \PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
            self::$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        } catch (\PDOException $e) {
            $hitType = "";
            if (isset($GLOBALS["HIT_TYPE"])) {
                $hitType = $GLOBALS["HIT_TYPE"];
            }
            $message = "Connection failed: " . $e->getMessage() . "\n Please Configuration Database Set it correctly";
            if ($hitType == "CLI") {
                echo $message;
//                echo "Connection failed: " . $e->getMessage() . "\n Please Configuration Database Set it correctly";
            } else {

            }
            self::$resultData["result"] = false;
            self::$resultData["message"] = $message;

        }
    }

    public static function disconnect()
    {
        self::$conn = null;
    }

    public static function query($query)
    {
        self::connect();
        $conn = self::$conn;
        $sql = $query;
//        $result = $conn->exec($sql);
        $STH = $conn->prepare($sql);
        $STH->execute();
//        $result = $STH->fetchAll();
//        echo json_encode($result);
//        print_r($STH->fetchAll());

        $databaseErrors = $STH->errorInfo();
        if (!empty($databaseErrors)) {
            if (intval($databaseErrors[0]) == "0") {
                self::$resultData["result"] = true;
                self::$resultData["message"] = "";
                self::$resultData["statement"] = $STH;
            } else {
                $errorInfo = print_r($databaseErrors, true); # true flag returns val rather than print
                $errorLogMsg = "error info: $errorInfo";
                self::$resultData["result"] = false;
                self::$resultData["message"] = $errorLogMsg;
//                echo $errorLogMsg . "\nCreate Database $dbname Failed: \n Please Configuration Database Set it correctly\n";
            }

        } else {
            self::$resultData["result"] = true;
            self::$resultData["message"] = "";
        }
        return new static;
    }

    public static function get()
    {
        if (isset(self::$resultData["statement"])) {
            $statement = self::$resultData["statement"];
            return $statement->fetchAll();
        }
    }


    public static function result()
    {
        return self::$resultData["result"];
    }

    public static function message()
    {
        return self::$resultData["message"];
    }

    public static function table($table = "")
    {
        self::$dbData["TABLE"] = $table;
        return new static;
    }

    public static function save($insData)
    {
        $table = self::$dbData["TABLE"];
        $columns = implode(", ", array_keys($insData));
        $columnValue = "";
        foreach (array_keys($insData) as $array_key) {
            $columnValue .= ":" . $array_key . ",";
        }
        $columnValue = rtrim($columnValue, ",");
        $sql = "INSERT INTO `$table`($columns) VALUES ($columnValue)";
        self::connect();
        $conn = self::$conn;
        if ($conn != null) {
            try {
                $STH = $conn->prepare($sql);
                foreach (array_keys($insData) as $item){
                    $STH->bindParam(':'.$item,$insData[$item],\PDO::PARAM_STR);
                }

                $STH->execute();

                $databaseErrors = $STH->errorInfo();
                if (!empty($databaseErrors)) {
                    if (intval($databaseErrors[0]) == "0") {
                        self::$resultData["result"] = true;
                        self::$resultData["message"] = "";
                        self::$resultData["statement"] = $STH;
                    } else {
                        $errorInfo = print_r($databaseErrors, true); # true flag returns val rather than print
                        $errorLogMsg = "error info: $errorInfo";
                        self::$resultData["result"] = false;
                        self::$resultData["message"] = $errorLogMsg;
//                echo $errorLogMsg . "\nCreate Database $dbname Failed: \n Please Configuration Database Set it correctly\n";
                    }

                } else {
                    self::$resultData["result"] = true;
                    self::$resultData["message"] = "";
                }
            } catch (\PDOException $e) {
                $hitType = "";
                if (isset($GLOBALS["HIT_TYPE"])) {
                    $hitType = $GLOBALS["HIT_TYPE"];
                }
                $message = $e->getMessage();
                if ($hitType == "CLI") {
                    echo $message;
                } else {

                }
//                print_r($e);
                self::$resultData["result"] = false;
                self::$resultData["message"] = $message;

            }
        }
//        echo $sql;
        return new static;
    }

}