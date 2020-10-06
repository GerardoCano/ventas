create table suppliers(
  SpID integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  SpName varchar (100) NOT NULL,
  SpAddressStreet varchar (150) NOT NULL,
  SpAddressCity varchar (150) NOT NULL,
  SpAddressCountry varchar (150) NOT NULL,
  SpAddressPostCode varchar (7) NOT NULL,
  SpPhoneNo varchar (16) NOT NULL,
  SpFaxNo varchar (16) NULL,
  SpPaymentTerms varchar (150) NOT NULL
);
create table products(
  PdID integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  PdName varchar (150) NOT NULL,
  PdInStock int (1) NOT NULL,
  PdUnitsInStock int (6) NOT NULL,
  PdUnitPurchasePrice decimal (8,2) NOT NULL,
  PdUnitSalePrice decimal (8,2) NOT NULL,
  SpId int NOT NULL,
  FOREIGN KEY(SpId) REFERENCES suppliers(SpID) ON DELETE CASCADE ON UPDATE CASCADE
);
create table customers(
  CtmID integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  CtmFirstName varchar (100) NOT NULL,
  CtmLastName varchar (120) NOT NULL,
  CtmAddressStreet varchar (150) NOT NULL,
  CtmAddressCity varchar (150) NOT NULL,
  CtmAddressCountry varchar (150) NOT NULL,
  CtmAddressPostCode varchar (10) NOT NULL,
  CtmContactPhoneNo varchar (20) NOT NULL
);
create table orders(
  OrID integer NOT NULL PRIMARY KEY AUTO_INCREMENT,
  CtmId integer NOT NULL,
  OrDateOrderPlaced date NOT NULL,
  OrTimeOrderPlaced time NOT NULL,
  OrOrderTotalProductNo int (6) NOT NULL,
  OrOrderCompleted int (1) NOT NULL,
  OrDateOrderCompleted date NOT NULL,
  OrAnyAdditionalInfo text NULL,
  FOREIGN KEY(CtmId) REFERENCES customers(CtmID) ON DELETE CASCADE ON UPDATE CASCADE
);
create table order_product(
  OrOrderId integer NOT NULL,
  PdProductId integer NOT NULL,
  OPTotalProductSaleCost decimal (9,2) NOT NULL,
  OPArrangeDeliveryDate date NOT NULL,
  OPArrangeDeliveryTime time NOT NULL,
  OPProductDelivery int (1) NOT NULL,
  OPActualDeliveryDate date NOT NULL,
  OPActualDeliveryTime time NOT NULL,
  FOREIGN KEY(OrOrderId) REFERENCES orders(OrID) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(PdProductId) REFERENCES products(PdID) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO customers VALUES (NULL,'GERARDO','CANO','CDA ALCATRAZ','CHIMALHUACAN','ESTADO DE MÉXICO','56338','5951137059');
INSERT INTO customers VALUES (NULL,'DIANA','BACA MONTERO','CALLE MAÑANITAS','NEZAHUALCÓYOTL','ESTADO DE MÉXICO','57000','5531137722');
INSERT INTO customers VALUES (NULL,'JUAN','ALVAREZ','CALLE 1 DE MAYO','ECATEPEC','ESTADO DE MÉXICO','07410','5548986535');
INSERT INTO customers VALUES (NULL,'PEDRO','RODRIGUEZ MARTINEZ','CALLE SUR 115','IZTACALCO','CDMX','08700','5578471232');
INSERT INTO customers VALUES (NULL,'ALEJANDRO','PAZ','CALLE REGINA','CUAUHTÉMOC','CDMX','06090','5587129654');
INSERT INTO suppliers (SpName,SpAddressStreet,SpAddressCity,SpAddressCountry,SpAddressPostCode,SpPhoneNo,SpFaxNo,SpPaymentTerms) VALUES ('DIEGO RIVERA HERNÁNDEZ', 'J. ENRIQUE PESTALOZZI', 'BENITO JUÁREZ', 'CDMX', '03020', '5598745632', '5545781245', 'TARJETA DE CREDITO');
INSERT INTO suppliers (SpName,SpAddressStreet,SpAddressCity,SpAddressCountry,SpAddressPostCode,SpPhoneNo,SpFaxNo,SpPaymentTerms) VALUES ('ABRIL ROMERO GARCÍA', 'ESTUDIO LA NACIONAL 10', 'IZTACALCO', 'CDMX', '08920', '5515226587', NULL, 'EFECTIVO');
INSERT INTO suppliers (SpName,SpAddressStreet,SpAddressCity,SpAddressCountry,SpAddressPostCode,SpPhoneNo,SpFaxNo,SpPaymentTerms) VALUES ('DANIELA DELGADO GONZALEZ', 'CDA ROSALES', 'CHIMALHUACAN', 'ESTADO DE MEXICO', '55330', '5578124563', '5598875421', 'TARJETA DE CREDITO');
INSERT INTO suppliers (SpName,SpAddressStreet,SpAddressCity,SpAddressCountry,SpAddressPostCode,SpPhoneNo,SpFaxNo,SpPaymentTerms) VALUES ('EDUARDO GARCÍA HERNÁNDEZ', 'MONEDITA DE ORO', 'NEZAHUALCÓYOTL', 'ESTADO DE MÉXICO', '57000', '5512234556', NULL, 'TARJETA DE CREDITO');
INSERT INTO suppliers (SpName,SpAddressStreet,SpAddressCity,SpAddressCountry,SpAddressPostCode,SpPhoneNo,SpFaxNo,SpPaymentTerms) VALUES ('MIGUEL PÉREZ LÓPEZ', 'TEJOCOTE', 'TEXCOCO', 'ESTADO DE MEXICO', '56199', '5578784545', NULL, 'TARJETA DE CREDITO');
INSERT INTO products VALUES (NULL,'RAM KINGSTON', 1, 500, 700.000, 900.000, 1);
INSERT INTO products VALUES (NULL,'SSD KINGSTON', 1, 600, 1000.000, 1200.000, 2);
INSERT INTO products VALUES (NULL,'HDD WESTERN DIGITAL', 0, 0, 700.000, 1500.000, 3);
INSERT INTO products VALUES (NULL,'MOTHERBOARD AORUS', 1, 100, 2000.000, 2500.000, 4);
INSERT INTO products VALUES (NULL,'PROCESADOR INTEL CORE i9', 1, 50, 7500.000, 9000.000, 5);
INSERT INTO orders VALUES (NULL,1,'2020-08-31','12:30:00',5,1,'2020-09-10', NULL);
INSERT INTO orders VALUES (NULL,2,'2020-08-25','17:30:00',20,0,'0000-00-00', NULL);
INSERT INTO orders VALUES (NULL,5,'2020-09-01','13:30:00',10,0,'0000-00-00', NULL);
INSERT INTO orders VALUES (NULL,3,'2020-09-10','10:20:00',7,1,'2020-09-5', NULL);
INSERT INTO orders VALUES (NULL,4,'2020-07-20','11:40:00',5,1,'2020-09-10', NULL);
INSERT INTO order_product VALUES (1,1, 4500.00, '2020-08-25','17:30:00', 0, '0000-00-00','00:00:00');
INSERT INTO order_product VALUES (2,3, 30000.00, '2020-08-31','12:30:00', 1, '2020-09-01','14:30:00');
INSERT INTO order_product VALUES (3,2, 12000.00, '2020-09-01','13:30:00', 0, '0000-00-00', '00:00:00');
INSERT INTO order_product VALUES (4,4, 17500.00, '2020-09-10','10:20:00', 1, '2020-09-08','18:25:00');
INSERT INTO order_product VALUES (5,5, 45000.00, '2020-07-20','11:40:00', 0, '0000-00-00','00:00:00');