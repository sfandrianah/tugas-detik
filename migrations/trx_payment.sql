CREATE TABLE `trx_payment`
(
    `references_id` varchar(20) NOT NULL,
    `invoice_id`    varchar(20) NOT NULL,
    `item_name`     varchar(255) NULL,
    `amount`        double NULL,
    `payment_type`  enum('virtual_account', 'credit_card') NULL,
    `customer_name` varchar(255) NULL,
    `merchant_id`   varchar(100) NULL,
    `number_va`     varchar(30) NULL,
    `status`        varchar(50) NULL,
    `created_on`    timestamp NULL,
    `modified_on`   timestamp NULL,
    PRIMARY KEY (`references_id`)
);

INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000001', 'INV2110150000001', 'Barang A', 1500000, 'virtual_account', 'Customer A', 'M-2111010000001', '3948307072780805', 'PENDING', '2021-10-16 15:22:09', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000002', 'INV2110150000002', 'Barang B', 1500000, 'virtual_account', 'Customer B', 'M-2111010000001', '4427424449594661', 'PENDING', '2021-10-16 15:22:11', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000003', 'INV2110150000003', 'Barang C', 1500000, 'virtual_account', 'Customer A', 'M-2111010000001', '2803805297439619', 'PENDING', '2021-10-16 15:22:12', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000004', 'INV2110150000004', 'Barang D', 1500000, 'virtual_account', 'Customer B', 'M-2111010000001', '6704106554758181', 'PENDING', '2021-10-16 15:22:13', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000005', 'INV2110150000005', 'Barang E', 1500000, 'virtual_account', 'Customer C', 'M-2111010000001', '4846620550171068', 'PAID', '2021-10-16 15:22:14', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000006', 'INV2110150000006', 'Barang F', 1500000, 'virtual_account', 'Customer D', 'M-2111010000001', '7140105892687862', 'PENDING', '2021-10-16 15:22:14', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000007', 'INV2110150000007', 'Barang G', 2500000, 'credit_card', 'Customer E', 'M-2111010000001', NULL, 'PENDING', '2021-10-16 15:22:38', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000008', 'INV2110150000008', 'Barang H', 2500000, 'credit_card', 'Customer F', 'M-2111010000001', NULL, 'PENDING', '2021-10-16 15:22:39', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000009', 'INV2110150000009', 'Barang I', 2500000, 'credit_card', 'Customer B', 'M-2111010000001', NULL, 'PENDING', '2021-10-16 15:22:42', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000010', 'INV2110150000010', 'Barang J', 1000000, 'virtual_account', 'Customer G', 'M-2111010000001', '9980447807574134', 'PENDING', '2021-10-16 15:22:53', NULL);
INSERT INTO `db_tugas_detik`.`trx_payment` (`references_id`, `invoice_id`, `item_name`, `amount`, `payment_type`, `customer_name`, `merchant_id`, `number_va`, `status`, `created_on`, `modified_on`) VALUES ('21101600000011', 'INV2110150000011', 'Barang K', 1000000, 'virtual_account', 'Customer C', 'M-2111010000001', '9989626329154481', 'PENDING', '2021-10-16 15:22:54', NULL);