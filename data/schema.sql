create table suppliers(
  id Integer PRIMARY KEY AUTOINCREMENT,
  name varchar (100) NOT NULL,
  address_street varchar (150) NOT NULL,
  address_city varchar (150) NOT NULL,
  address_country varchar (150) NOT NULL,
  address_post_code varchar (7) NOT NULL,
  phone_no varchar (16) NOT NULL,
  fax_no varchar (16) NULL,
  payment_terms varchar (150) NOT NULL
);
create table customers(
  id Integer PRIMARY KEY AUTOINCREMENT,
  first_name varchar (100) NOT NULL,
  last_name varchar (120) NOT NULL,
  address_street varchar (150) NOT NULL,
  address_city varchar (150) NOT NULL,
  address_country varchar (150) NOT NULL,
  address_post_code varchar (10) NOT NULL,
  contact_phone_no varchar (20) NOT NULL
);
create table orders(
  o_id Integer PRIMARY KEY AUTOINCREMENT,
  ctm_id int NOT NULL,
  date_order_placed date NOT NULL,
  time_order_placed time NOT NULL,
  total_product_no int (6) NOT NULL,
  order_completed int (1) NOT NULL,
  date_order_completed date NOT NULL,
  any_additional_info text NULL,
  FOREIGN KEY(ctm_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE
);
create table products(
  p_id Integer PRIMARY KEY AUTOINCREMENT,
  p_name varchar (150) NOT NULL,
  in_stock varchar (3) NOT NULL,
  units_in_stock int (6),
  unit_purchase_price double (9,2),
  unit_sale_price double (9,2),
  sp_id int NOT NULL,
  FOREIGN KEY(sp_id) REFERENCES suppliers(id) ON DELETE CASCADE ON UPDATE CASCADE
);
create table orders(
  o_id Integer PRIMARY KEY AUTOINCREMENT,
  ctm_id int NOT NULL,
  date_order_placed date NOT NULL,
  time_order_placed time NOT NULL,
  total_product_no int (6) NOT NULL,
  order_completed varchar (3) (9,2),
  date_order_completed date,
  any_additional_info text NULL,
  FOREIGN KEY(ctm_id) REFERENCES customers(id) ON DELETE CASCADE ON UPDATE CASCADE
);
INSERT INTO suppliers (name,address_street,address_city,address_country,address_post_code,phone_no,fax_no,payment_terms) VALUES ('Diego Rivera Hernández', 'J. Enrique Pestalozzi', 'Benito Juárez', 'CDMX', '03020', '5598745632', '5545781245', 'Tarjeta de Credito');
INSERT INTO suppliers (name,address_street,address_city,address_country,address_post_code,phone_no,fax_no,payment_terms) VALUES ('Abril Romero García', 'Estudio la Nacional 10', 'Iztacalco', 'CDMX', '08920', '5515226587', NULL, 'Efectivo');
INSERT INTO suppliers (name,address_street,address_city,address_country,address_post_code,phone_no,fax_no,payment_terms) VALUES ('Daniela Delgado González', 'Cda Rosales', 'Chimalhuacán', 'Estado de México', '55330', '5578124563', '5598875421', 'Tarjeta de Credito');
INSERT INTO suppliers (name,address_street,address_city,address_country,address_post_code,phone_no,fax_no,payment_terms) VALUES ('Eduardo García Hernández', 'Monedita de Oro', 'Nezahualcóyotl', 'Estado de México', '57000', '5512234556', NULL, 'Tarjeta de Credito');
INSERT INTO suppliers (name,address_street,address_city,address_country,address_post_code,phone_no,fax_no,payment_terms) VALUES ('Miguel Pérez López', 'Tejocote', 'Texcoco', 'Estado de México', '56199', '5578784545', NULL, 'Tarjeta de Credito');

INSERT INTO customers (first_name,last_name,address_street,address_city,address_country,address_post_code,contact_phone_no) VALUES ('Gerardo','Cano','Cda Alcatraz','Chimalhuacán','ESTADO DE MÉXICO','56338','5951137059');
INSERT INTO customers (first_name,last_name,address_street,address_city,address_country,address_post_code,contact_phone_no) VALUES ('DIANA','BACA MONTERO','CALLE MAÑANITAS','NEZAHUALCÓYOTL','ESTADO DE MÉXICO','57000','5531137722');
INSERT INTO customers (first_name,last_name,address_street,address_city,address_country,address_post_code,contact_phone_no) VALUES ('JUAN','ALVAREZ','CALLE 1 DE MAYO','ECATEPEC','ESTADO DE MÉXICO','07410','5548986535');
INSERT INTO customers (first_name,last_name,address_street,address_city,address_country,address_post_code,contact_phone_no) VALUES ('PEDRO','RODRIGUEZ MARTINEZ','CALLE SUR 115','IZTACALCO','CDMX','08700','5578471232');
INSERT INTO customers (first_name,last_name,address_street,address_city,address_country,address_post_code,contact_phone_no) VALUES ('ALEJANDRO','PAZ','CALLE REGINA','CUAUHTÉMOC','CDMX','06090','5587129654');

INSERT INTO products (p_name,in_stock,units_in_stock,unit_purchase_price,unit_sale_price,sp_id) VALUES ('RAM KINGSTON', 'Yes', 500, 700.00, 900.00, 2);
INSERT INTO products (p_name,in_stock,units_in_stock,unit_purchase_price,unit_sale_price,sp_id) VALUES ('SSD KINGSTON', 'Yes', 600, 1000.00, 1200.00, 2);
INSERT INTO products (p_name,in_stock,units_in_stock,unit_purchase_price,unit_sale_price,sp_id) VALUES ('HDD WESTERN DIGITAL', 'No', 0, 700.00, 1500.00, 2);
INSERT INTO products (p_name,in_stock,units_in_stock,unit_purchase_price,unit_sale_price,sp_id) VALUES ('MOTHERBOARD AORUS', 'Yes', 100, 2000.00, 2500.00, 5);
INSERT INTO products (p_name,in_stock,units_in_stock,unit_purchase_price,unit_sale_price,sp_id) VALUES ('PROCESADOR INTEL CORE i9', 'Yes', 50, 7500.000, 9000.00, 4);

INSERT INTO orders (ctm_id,date_order_placed,time_order_placed,total_product_no,order_completed,date_order_completed,any_additional_info) VALUES (1, '2020/01/01', '09:30:00', 15, 'No', '2000/01/01', NULL);