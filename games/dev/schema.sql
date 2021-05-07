drop table appuser cascade;
drop table userStats cascade;

create table appuser (
	userid varchar(50) primary key,
	password varchar(70),
	firstname varchar(30),
	lastname varchar(40),
	gender varchar(10)
);

create table userStats (
	userid varchar(50) primary key,
	guessgame integer,
	rockpaperscissors integer,
	frogs integer
);

