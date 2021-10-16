<?php
$GLOBALS["HIT_TYPE"] = "APP";
$currentPath = __DIR__;
$GLOBALS["MAIN_DIR"] = $currentPath;
include_once __DIR__.'/app/util/helpers.php';
spl_autoload_register(function ($class_name) {
    if (file_exists(__DIR__ . '/' . $class_name . '.php')) {
        include __DIR__ . '/' . $class_name . '.php';
    } else if (file_exists(__DIR__ . '/' . $class_name . '.php')) {
        include __DIR__ . '/' . strtolower($class_name) . '.php';
    } else {
//        echo $class_name;
        $class_name = str_replace('/', '\\', $class_name);
        if (file_exists(__DIR__ . '/' . $class_name . '.php')) {
            include __DIR__ . '/' . $class_name . '.php';
        } else {
            $class_name = str_replace('\\', '/', $class_name);
            if (file_exists(__DIR__ . '/' . $class_name . '.php')) {
                include __DIR__ . '/' . $class_name . '.php';
            }
        }
    }

});
include_once __DIR__ . '/routes.php';

if(isset($GLOBALS["HTML_FOUND_ROUTE"])){
    $htmlFoundRoute = $GLOBALS["HTML_FOUND_ROUTE"];
    $isContent = false;
    $htmlFoundRouteContent = null;
    $htmlNotFoundRouteContent = null;
//    echo json_encode($htmlFoundRoute);
    foreach ($htmlFoundRoute as $item) {
        if($isContent == false){
            if(isset($item["result"])) {
                if($item["result"]) {
                    if (isset($item["data"])) {
                        $htmlFoundRouteContent = $item["data"];
                        $isContent = true;
                    }
                } else {
                    if (isset($item["data"])) {
                        $htmlNotFoundRouteContent = $item["data"];
                    }
                }
            }
        }

    }
    if($isContent){
        echo $htmlFoundRouteContent;
    } else {
        echo $htmlNotFoundRouteContent;
    }

}

//$routeData = array();
//if (file_exists($currentPath . "/routes.json")) {
//    $fileJsonConfig = file_get_contents(__DIR__ . "/routes.json");
//    $routeDataDecode = @json_decode($fileJsonConfig);
//    if ($routeDataDecode === null
//        && json_last_error() !== JSON_ERROR_NONE) {
////        echo "incorrect data";
//    } else {
//        $routeData = $routeDataDecode;
//    }
//}
//$scriptName = $_SERVER["SCRIPT_NAME"];
//$replaceNameIndex = str_replace("/index.php", "", $scriptName);
//$httpURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"];
//$httpURLWithoutPath = $httpURL . $replaceNameIndex;
//$httpFullURL = $httpURL . $_SERVER["REQUEST_URI"];
//$httpFullURL = str_replace("%20", " ", $httpFullURL);
//$replaceOnlyPath = str_replace($httpURLWithoutPath, "", $httpFullURL);
////echo $httpURLWithoutPath . "</br>";
////echo $httpFullURL . "</br>";
////echo $replaceOnlyPath;
////echo json_encode($routeData);
//$isFoundRoute = false;
//$routeFoundData = array();
//foreach ($routeData as $itemRoute) {
//    $itemRoutePath = $itemRoute->path;
//    if ($replaceOnlyPath == $itemRoutePath) {
//        $isFoundRoute = true;
//        $routeFoundData = $itemRoute;
//    }
//}
//if ($isFoundRoute) {
//    echo "HTTP FOUND";
//    $itemRoutePath = $routeFoundData->path;
//    $itemRoutePath = $routeFoundData->path;
//}
//echo "TEST";
//$scriptName = $_SERVER["SCRIPT_NAME"];


//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $actual_link;

//print_r($_SERVER);