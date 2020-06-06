drop table if exists encuentros;

drop table if exists equipos;

drop table if exists inscripciones;

drop table if exists integrantes_equipo;

drop table if exists juegos;

drop table if exists miembros_jurado;

drop table if exists personas;

drop table if exists torneos;

create table equipos (
   id_equipo            int(3) not null auto_increment,
   nombre_equipo        varchar(48),
   primary key (id_equipo)
);

create table juegos (
   id_juego             int(4) not null auto_increment,
   nombre_juego         varchar(48) not null,
   primary key (id_juego)
);

create table personas (
   id_persona           int(4) not null auto_increment,
   nickname_persona     varchar(48) not null,
   nombre_persona       varchar(48),
   apellido_persona     varchar(48),
   telefono_persona     varchar(10),
   email_persona        varchar(64) not null,
   contrasena_persona	varchar(32) not null,
   primary key (id_persona)
);

create table integrantes_equipo (
   id_persona           int(4) not null,
   id_equipo            int(3) not null
);

create table torneos (
   id_torneo            int(3) not null auto_increment,
   id_juego             int(4) not null,
   id_persona           int(4) not null,
   nombre_torneo        varchar(48) not null,
   tipo_torneo          char(1) not null,
   fecha_torneo			datetime not null,
   modalidad            char(1) not null,
   primary key (id_torneo)
);

create table inscripciones (
   id_persona           int(4),
   id_equipo            int(3),
   id_torneo            int(3) not null
);


create table miembros_jurado (
   id_persona           int(4) not null,
   id_torneo            int(3) not null
);

create table encuentros (
   id_encuentro         int(5) not null auto_increment,
   proximo_encuentro    int(5),
   índex_torneo         int(3) not null,
   id_torneo            int(3) not null,
   id_equipo_a          int(3) not null,
   id_equipo_b          int(3) not null,
   fecha_encuentro		datetime,
   puntuacion_a         int(3) not null,
   puntuacion_b         int(3) not null,
   primary key (id_encuentro)
);

alter table encuentros add constraint enc_fk_idea foreign key (id_equipo_a)
      references equipos (id_equipo) on delete restrict on update restrict;

alter table encuentros add constraint enc_fk_ideb foreign key (id_equipo_b)
      references equipos (id_equipo) on delete restrict on update restrict;

alter table encuentros add constraint enc_fk_idt foreign key (id_torneo)
      references torneos (id_torneo) on delete restrict on update restrict;

alter table encuentros add constraint enc_fk_prox foreign key (proximo_encuentro)
      references encuentros (id_encuentro) on delete restrict on update restrict;


alter table inscripciones add constraint ins_fk_ide foreign key (id_equipo)
      references equipos (id_equipo) on delete restrict on update restrict;

alter table inscripciones add constraint ins_fk_idp foreign key (id_persona)
      references personas (id_persona) on delete restrict on update restrict;

alter table inscripciones add constraint ins_fk_idt foreign key (id_torneo)
      references torneos (id_torneo) on delete restrict on update restrict;


alter table integrantes_equipo add constraint int_fk_ide foreign key (id_equipo)
      references equipos (id_equipo) on delete restrict on update restrict;

alter table integrantes_equipo add constraint int_fk_idp foreign key (id_persona)
      references personas (id_persona) on delete restrict on update restrict;


alter table miembros_jurado add constraint jur_fk_idp foreign key (id_persona)
      references personas (id_persona) on delete restrict on update restrict;

alter table miembros_jurado add constraint jur_fk_idt foreign key (id_torneo)
      references torneos (id_torneo) on delete restrict on update restrict;


alter table torneos add constraint tor_fk_ida foreign key (id_persona)
      references personas (id_persona) on delete restrict on update restrict;

alter table torneos add constraint tor_fk_idj2 foreign key (id_juego)
      references juegos (id_juego) on delete restrict on update restrict;
      
alter table personas add constraint per_uq_nkp unique (nickname_persona);

insert into encuentros (id_torneo,index_torneo,id_persona_a,id_persona_b) values
(4,1,1,2),
(4,2,3,4),
(4,3,5,6),
(4,4,7,8),
(4,5,9,10),
(4,6,NULL,NULL),
(4,7,11,NULL),
(4,8,12,NULL),
(4,9,13,NULL),
(4,10,NULL,NULL),
(4,11,NULL,NULL),
(4,12,NULL,NULL);

UPDATE `encuentros` SET `proximo_encuentro` = '32' 
WHERE `encuentros`.`id_encuentro` = 27; 