DROP TABLE IF EXISTS users;

DROP TABLE IF EXISTS projects;

USE doings;

CREATE TABLE users (
	id int primary key AUTO_INCREMENT not null,
	email varchar(70) not null,
	password varchar(70) not null,
	name varchar(50) not null
);

CREATE TABLE projects (
	id int primary key AUTO_INCREMENT not null,
	id_user int,
	name varchar(50) not null
);

CREATE TABLE tasks (
	id int primary key AUTO_INCREMENT not null,
	id_user int,
	id_project int,
	name varchar(50) not null,
	data_start DATE,
	data_stop DATE,
	deadline DATETIME,
	url varchar(100)
);