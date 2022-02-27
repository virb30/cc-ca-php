create table `item` (
  id_item BIGINT primary key,
  category TEXT,
  description TEXT,
  price DECIMAL,
  width INT,
  height INT,
  length INT,
  weight INT
);
insert into `item` (
    id_item,
    category,
    description,
    price,
    width,
    height,
    length,
    weight
  )
values (
    1,
    'Instrumentos Musicais',
    'Guitarra',
    1000,
    100,
    30,
    10,
    3
  );
insert into `item` (
    id_item,
    category,
    description,
    price,
    width,
    height,
    length,
    weight
  )
values (
    2,
    'Instrumentos Musicais',
    'Amplificador',
    5000,
    100,
    50,
    50,
    20
  );
insert into `item` (
    id_item,
    category,
    description,
    price,
    width,
    height,
    length,
    weight
  )
values (3, 'Acessórios', 'Cabo', 30, 10, 10, 10, 0.9);
create table `coupon` (
  code char(50),
  percentage DECIMAL,
  expire_date timestamp,
  primary key (code)
);
insert into `coupon` (code, percentage, expire_date)
values ('VALE20', 20, '2023-10-10T10:00:00');
insert into `coupon` (code, percentage, expire_date)
values ('VALE20_EXPIRED', 20, '2020-10-10T10:00:00');
create table `order` (
  id_order BIGINT PRIMARY KEY,
  coupon text,
  code text,
  cpf text,
  issue_date timestamp,
  freight numeric,
  sequence integer
);
create table `order_item` (
  id_order integer,
  id_item integer,
  price numeric,
  quantity integer,
  primary key (id_order, id_item)
);