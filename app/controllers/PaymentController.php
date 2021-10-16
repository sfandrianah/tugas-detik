<?php

namespace app\controllers;

use app\util\DB;

class PaymentController
{
    public function find()
    {
        $result = true;
        $resultCode = 200;
        $message = "Payment is found";
        $resultData = null;
        header('Content-Type: application/json; charset=utf-8');
        if (isset($_GET["references_id"]) && isset($_GET["merchant_id"])) {
            $references_id = $_GET["references_id"];
            $merchant_id = $_GET["merchant_id"];
            $check_payment = DB::query("SELECT * FROM trx_payment WHERE merchant_id = '" . $merchant_id . "' AND references_id = '" . $references_id . "' ");
            if ($check_payment->result()) {
                $get_payment = $check_payment->get();
                if (count($get_payment) > 0) {
                    $itemPayment = $get_payment[0];
                    $invoice_id = $itemPayment["invoice_id"];
                    $status = $itemPayment["status"];
                    $resultData = array(
                        "references_id" => $references_id,
                        "invoice_id" => $invoice_id,
                        "status" => $status,
                    );
                } else {
                    $result = false;
                    $message = "Payment Not Found";
                }
            } else {
                $result = false;
                $message = "Payment Not Found";
            }
        } else {
            $result = false;
            $resultCode = 400;
            $message = "Bad Request";
        }
        $resultArray = array(
            "result" => $result,
            "code" => $resultCode,
            "message" => $message,
            "data" => $resultData
        );
        return json_encode($resultArray);
    }

    public function save()
    {
        $currentDate = date("ymd");
        $currentDateTimestamp = date("Y-m-d H:i:s");
        $refStatus = "PENDING";
        header('Content-Type: application/json; charset=utf-8');
        $result = true;
        $resultCode = 200;
        $message = "Payment Save Success";
        $resultData = null;
        $request = json_decode(file_get_contents('php://input'), true);
        $dataKey = ["invoice_id", "item_name", "amount",
            "payment_type", "customer_name", "merchant_id"];
        foreach ($dataKey as $itemKey) {
            if ($result) {
                if (!isset($request[$itemKey])) {
                    $result = false;
                    $resultCode = 400;
                    $message = "Bad Request";
                }
            }
        }
        if ($result) {
            $check_py = DB::query("SELECT MAX(references_id) as ref_id FROM trx_payment WHERE references_id LIKE '" . $currentDate . "%'");
            $fixRefId = $currentDate . "00000001";
            if ($check_py->result()) {
                $get_code = $check_py->get();

//                echo $start_code;
                if (count($get_code) > 0) {
                    $max_code = $get_code[0]["ref_id"];
                    $replace_max_code = str_replace($currentDate, "", $max_code);
                    if (is_numeric($replace_max_code)) {
                        $max_code_plus = intval($replace_max_code) + 1;
                        $start_code = str_pad($max_code_plus, 8, "0", STR_PAD_LEFT);
                        $fixRefId = $currentDate . $start_code;
                    }
                }
//                echo json_encode($get_code);
            }


            $invoice_id = $request['invoice_id'];
            $item_name = $request['item_name'];
            $amount = $request['amount'];
            $payment_type = $request['payment_type'];
            $customer_name = $request['customer_name'];
            $merchant_id = $request['merchant_id'];
            $number_va = null;
            if (strtolower($payment_type) == "virtual_account") {
                $number_va = randomNumber(16);
            } else if (strtolower($payment_type) == "credit_card") {
            } else {
                $result = false;
                $message = "payment_type only virtual_account & credit_card";
            }
            $check_merchant = DB::query("SELECT * FROM mst_merchant WHERE merchant_id = '" . $merchant_id . "' ");
            if ($check_merchant->result()) {
                $get_merchant = $check_merchant->get();
                if (count($get_merchant) == 0) {
                    $result = false;
                    $message = "merchant_id Not Found";
                }
            } else {
                $result = false;
                $message = "merchant_id Not Found";
            }


            if ($result) {
                $dataInsert = array(
                    "references_id" => $fixRefId,
                    "invoice_id" => $invoice_id,
                    "item_name" => $item_name,
                    "amount" => $amount,
                    "payment_type" => $payment_type,
                    "customer_name" => $customer_name,
                    "merchant_id" => $merchant_id,
                    "number_va" => $number_va,
                    "status" => $refStatus,
                    "created_on" => $currentDateTimestamp,
                );
                $resultSave = DB::table("trx_payment")->save($dataInsert);

                if ($resultSave->result()) {
                    $resultData = array(
                        "references_id" => $fixRefId,
                        "number_va" => $number_va,
                        "status" => $refStatus,
                    );
                } else {
                    $resultCode = 500;
                    $result = false;
                    $message = $resultSave->message();
                }
            }
        }
//        echo $request["merchant_id"];
//        $entityBody = file_get_contents('php://input');
//        echo json_encode($data);
//        return "MASUK SAVE";
        $resultArray = array(
            "result" => $result,
            "code" => $resultCode,
            "message" => $message,
            "data" => $resultData
        );
        return json_encode($resultArray);
    }
}