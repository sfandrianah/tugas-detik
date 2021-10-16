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
