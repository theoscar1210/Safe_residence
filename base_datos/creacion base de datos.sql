create database SafeResidence;

use SafeResidence;

create table Usuarios(
	id_usuario int not null auto_increment,
    nombres varchar(50) not null,
    apellidos varchar(50) not null,
    cedula varchar(15) not null,
    telefono varchar(10) null,
    usuario varchar(50) not null,
    contraseña varchar(50) not null,
    id_rol int not null,
    primary key(id_usuario),
    foreign key(id_rol) references roles(id_rol)
);

create table roles(
	id_rol int not null auto_increment,
    rol varchar(50) not null,
    primary key(id_rol)
);

create table ingresos(
	id_ingreso int not null auto_increment,
    fecha datetime not null,
    h_ingreso time not null,
    h_salida time not null,
	id_usuario int not null,
    observaciones text,
    primary key(id_ingreso),
    foreign key(id_usuario) references usuarios(id_usuario)
);

create table apartamentos(
	id_dep int not null auto_increment,
    numero char(4) not null,
    id_propietario int not null,
    primary key(id_dep),
    foreign key(id_propietario) references propietarios(id_propietario)
);

create table propietarios(
	id_propietario int not null auto_increment,
    id_usuario int not null,
    primary key(id_propietario),
    foreign key(id_usuario) references usuarios(id_usuario)
);

use saferesidence;

create table autorizaciones(
	id_autorizacion int not null auto_increment,
    f_inicio date not null,
    f_fin date not null,
    id_usuario int not null,
    observaciones text,
    primary key(id_autorizacion),
    foreign key(id_usuario) references usuarios(id_usuario)
);

insert into roles(rol) values('Administrador'), ('Vigilante'), ('Residente'), ('Propietario');

insert into usuarios(nombres, apellidos, cedula, telefono, usuario, contraseña, id_rol) 
values('Yeison', 'Ipia', '1006908048', '3146386550', 'yeison48', '123456', 1);



