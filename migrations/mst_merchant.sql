CREATE TABLE `mst_merchant`
(
    `merchant_id`   varchar(15) NOT NULL,
    `merchant_name` varchar(255) NULL,
    PRIMARY KEY (`merchant_id`)
);

INSERT INTO mst_merchant (`merchant_id`, `merchant_name`) VALUES ('M-2111010000001', 'Merchant A');
INSERT INTO mst_merchant (`merchant_id`, `merchant_name`) VALUES ('M-2111010000002', 'Merchant B');
INSERT INTO mst_merchant (`merchant_id`, `merchant_name`) VALUES ('M-2111010000003', 'Merchant C');
INSERT INTO mst_merchant (`merchant_id`, `merchant_name`) VALUES ('M-2111010000004', 'Merchant D');
INSERT INTO mst_merchant (`merchant_id`, `merchant_name`) VALUES ('M-2111010000005', 'Merchant E');