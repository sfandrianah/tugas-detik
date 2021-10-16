<?php

\app\Util\Routes::get("/payment", [\app\controllers\PaymentController::class, "find"]);
\app\Util\Routes::post("/payment", [\app\controllers\PaymentController::class, "save"]);