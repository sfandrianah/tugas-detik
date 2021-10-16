# Tugas Interview Detik
## Cara menjalankan aplikasi ini
1. clone git ini
```bash
git clone https://github.com/sfandrianah/tugas-detik.git
```

2. lakukan terminal run
```console
php detik-cli run
```
setelah dijalankan akan otomatis melakukan konfigurasi db
```console
mac@192 tugas-detik % php detik-cli run
Please Configuration Database for running this application.
DB Host (127.0.0.1) = 127.0.0.1 //Your DB Host
DB Port (3306) = 3306 // Your DB Port
DB Username (root) = root //Your Username Password
DB Password = testing //Your DB Password
DB Name (db_tugas_detik) = db_tugas_detik //DB Name yang akan di buat
Connected successfully
Create Database db_tugas_detik successfully
Migrations Table mst_merchant Successfully
Migrations Table trx_payment Successfully

Application started to http://127.0.0.1:6789
```

## Contoh pemanggilan aplikasi ini
1. Transaction CLI, lakukan run di terminal,
```bash
php detik-cli transaction {references_id} {status}
```
status only PENDING, PAID, FAILED
```bash
php detik-cli transaction 21101600000005 PAID
```
2. Pemanggilan Rest API
anda bisa testing menggunakan postman atau lainnya :
- Pembuatan/Create Transaksi Pembayaran:
```bash
URL: http://127.0.0.1:6789/payment
Method: POST
Header: 
Accept:application/json
Content-Type:application/json
Request Body:
{
    "invoice_id": "INV2110150000001",
    "item_name": "Barang A",
    "amount": 1000000,
    "payment_type": "virtual_account",
    "customer_name": "Customer A",
    "merchant_id": "M-2111010000001"
}
Response:
{
    "result": true,
    "code": 200,
    "message": "Payment Save Success",
    "data": {
        "references_id": "21101600000011",
        "number_va": "9989626329154481",
        "status": "PENDING"
    }
}
```
- Mendapatkan/Get Status Transaksi Pembayaran yang Terakhir/Terupdate:
```bash
URL: http://127.0.0.1:6789/payment
Method: GET
Header: 
Accept:application/json
Content-Type:application/json
Params: ?references_id={references_id}&merchant_id={merchant_ids}
Example: http://127.0.0.1:6789/payment?references_id=21101600000005&merchant_id=M-2111010000001
Response:
{
    "result": true,
    "code": 200,
    "message": "Payment is found",
    "data": {
        "references_id": "21101600000005",
        "invoice_id": "INV2110150000005",
        "status": "PAID"
    }
}
```


