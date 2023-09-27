-- drop database my_db;
-- CREATE DATABASE my_db;
use my_db;

drop table if exists emails;
create table emails (
	id int primary key auto_increment,
    subject varchar(255),
    status varchar(255),
    html_body varchar(255),
    text_body varchar(255),
    meta varchar(255),
    created_at varchar(255)
);

drop table if exists invoices;
create table invoices (
	id int primary key auto_increment,
    amount decimal(10, 2),
    invoice_number varchar(255),
    status smallint unsigned,
    created_at datetime,
    due_date datetime
);

drop table if exists invoice_items;
create table invoice_items (
	id int primary key auto_increment,
    invoice_id int,
    description varchar(255),
    quantity int,
    unit_price decimal(10, 2),
    
    constraint fk_invoice_items foreign key(invoice_id) references invoices(id)
);

select * from invoices;
select * from invoice_items;
select * from users;
