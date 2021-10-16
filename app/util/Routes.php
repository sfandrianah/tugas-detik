<?php

namespace app\Util;

class Routes
{

    public static function get()
    {
        $arg_list = func_get_args();
        $method = "GET";
        return self::render($method, $arg_list);
    }

    public static function post()
    {
        $arg_list = func_get_args();
        $method = "POST";
        return self::render($method, $arg_list);
    }

    public static $urut = 0;

    public static function render($method, $data)
    {
        self::$urut++;
//        echo self::$urut;
//        echo json_encode($data);
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (!isset($GLOBALS["HTML_FOUND_ROUTE"])) {
            $GLOBALS["HTML_FOUND_ROUTE"][self::$urut] = array();
        }
        $arg_list = $data;
        $url = $arg_list[0];
        $routeData = array();

        $className = null;
        $classMethod = null;
        if (isset($arg_list[1])) {
            if (is_array($arg_list[1])) {
                $item2ArgList = $arg_list[1];
                if (isset($item2ArgList[0])) {
                    $className = $item2ArgList[0];
                }
                if (isset($item2ArgList[1])) {
                    $classMethod = $item2ArgList[1];
                }
            }
        }
        $routeData[] = array(
            "path" => $url,
            "className" => $className,
            "classMethod" => $classMethod
        );
//        print_r($_SERVER);
        $scriptName = $_SERVER["SCRIPT_NAME"];
        $replaceNameIndex = str_replace("/index.php", "", $scriptName);
        $httpURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
        $httpURLWithoutPath = $httpURL . $replaceNameIndex;
        $httpFullURL = $httpURL . $_SERVER["REQUEST_URI"];
        $httpFullURL = str_replace("%20", " ", $httpFullURL);
        $replaceOnlyPath = str_replace($httpURLWithoutPath, "", $httpFullURL);
        $expRepOnlyPath = explode("?",$replaceOnlyPath);
        if(isset($expRepOnlyPath[1])){
            $replaceOnlyPath = $expRepOnlyPath[0];
        }
//        echo $replaceOnlyPath;
        if ($method == $requestMethod) {
//            echo $replaceOnlyPath;
            $isFoundRoute = false;
            $routeFoundData = array();
            foreach ($routeData as $itemRoute) {
                $itemRoutePath = $itemRoute["path"];
                if ($replaceOnlyPath == $itemRoutePath) {
                    $isFoundRoute = true;
                    $routeFoundData = $itemRoute;
                }
            }
            if ($isFoundRoute) {
//                $GLOBALS["IS_FOUND_ROUTE"] = true;

                $itemRouteClassName = $routeFoundData["className"];
                $itemRouteClassMethod = $routeFoundData["classMethod"];
                $itemRouteClassNameNew = new $itemRouteClassName();
                $returnMethod = $itemRouteClassNameNew->{$itemRouteClassMethod}();
//                $GLOBALS["HTML_FOUND_ROUTE"][self::$urut] = $returnMethod;
//            $itemRoutePath = $routeFoundData->path;
                $GLOBALS["HTML_FOUND_ROUTE"][self::$urut] = array(
                    "result" => true,
                    "data" => $returnMethod,
                );
            } else {
                $GLOBALS["HTML_FOUND_ROUTE"][self::$urut] = array(
                    "result" => false,
                    "data" => "NOT FOUND",
                );
            }
        } else {
            $isFoundRoute = false;
            $routeFoundData = array();
            foreach ($routeData as $itemRoute) {
                $itemRoutePath = $itemRoute["path"];
                if ($replaceOnlyPath == $itemRoutePath) {
                    $isFoundRoute = true;
                    $routeFoundData = $itemRoute;
                }
            }
            if($isFoundRoute){
                $returnData = "the ".$requestMethod." method is not supported this route";
                $GLOBALS["HTML_FOUND_ROUTE"][self::$urut] = array(
                    "result" => false,
                    "data" => $returnData,
                );
            } else {
                $returnData = "NOT FOUND";
                $GLOBALS["HTML_FOUND_ROUTE"][self::$urut] = array(
                    "result" => false,
                    "data" => $returnData,
                );
            }

        }

//        if($GLOBALS["IS_FOUND_ROUTE"] == false){
//            echo "NOT FOUND";
//        }

    }
}