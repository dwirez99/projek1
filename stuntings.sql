/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     24/03/2025 05:22:38                          */
/*==============================================================*/


drop table if exists ANTROPOMETRIL;

drop table if exists ANTROPOMETRIP;

drop table if exists ARTIKELINSTANSI;

drop table if exists GURU;

drop table if exists ORANGTUA;

drop table if exists PESERTADIDIK;

drop table if exists PORTOFOLIO;

drop table if exists STATUSGIZI;

drop table if exists USER;

/*==============================================================*/
/* Table: ANTROPOMETRI                                          */
/*==============================================================*/
create table ANTROPOMETRIL
(
   TAHUN                int,
   BULAN                int,
   _3SD                 decimal,
   _2SD                 decimal,
   _1SD                 decimal,
   MEDIAN               decimal,
   1SD                  decimal,
   2SD                  decimal,
   3SD                  decimal
);
create table ANTROPOMETRIP
(
   TAHUN                int,
   BULAN                int,
   _3SD                 decimal,
   _2SD                 decimal,
   _1SD                 decimal,
   MEDIAN               decimal,
   1SD                  decimal,
   2SD                  decimal,
   3SD                  decimal
);

/*==============================================================*/
/* Table: ARTIKELINSTANSI                                       */
/*==============================================================*/
create table ARTIKELINSTANSI
(
   IDARTIKEL            int not null,
   NIP                  varchar(18),
   JUDUL                text,
   THUMBNAIL            text,
   KONTEN               longText,
   primary key (IDARTIKEL)
);

/*==============================================================*/
/* Table: GURU                                                  */
/*==============================================================*/
create table GURU
(
   NIP                  varchar(18) not null,
   IDSTATUS             int,
   ID_USER              int,
   NAMAGURU             varchar(100),
   EMAILGURU            varchar(255),
   NOTELPGURU           varchar(13),
   ALAMATGURU           varchar(100),
   primary key (NIP)
);

/*==============================================================*/
/* Table: ORANGTUA                                              */
/*==============================================================*/
create table ORANGTUA
(
   IDORTU               int not null,
   ID_USER              int,
   NAMAORTU             varchar(50),
   NOTELPORTU           varchar(14),
   EMAILORTU            varchar(50),
   primary key (IDORTU)
);

/*==============================================================*/
/* Table: PESERTADIDIK                                          */
/*==============================================================*/
create table PESERTADIDIK
(
   NISN                 varchar(10) not null,
   IDORTU               int,
   NAMAPD               varchar(100),
   TANGGALLAHIR         date,
   JENISKELAMIN         varchar(10),
   FOTO                 text,
   KELAS                varchar(2),
   TAHUNAJAR            varchar(10),
   SEMESTER             int,
   FASE                 varchar(10),
   TINGGIBADAN          int,
   BERATBADAN           int,
   primary key (NISN)
);

/*==============================================================*/
/* Table: PORTOFOLIO                                            */
/*==============================================================*/
create table PORTOFOLIO
(
   IDPORTOFOLIO         int not null,
   NISN                 varchar(10),
   NIP                  varchar(18),
   LINKGDOCS            text,
   primary key (IDPORTOFOLIO)
);

/*==============================================================*/
/* Table: STATUSGIZI                                            */
/*==============================================================*/
create table STATUSGIZI
(
   IDSTATUS             int not null,
   NISN                 varchar(10),
   Z_SCORE              decimal,
   STATUS               varchar(30),
   TANGGALPEMBUATAN     date,
   primary key (IDSTATUS)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   ID_USER              int not null,
   USERNAME             varchar(255),
   PASSWORD             varchar(255),
   ROLE                 varchar(10),
   primary key (ID_USER)
);

alter table ARTIKELINSTANSI add constraint FK_RELATIONSHIP_4 foreign key (NIP)
      references GURU (NIP) on delete restrict on update restrict;

alter table GURU add constraint FK_RELATIONSHIP_3 foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table GURU add constraint FK_RELATIONSHIP_6 foreign key (IDSTATUS)
      references STATUSGIZI (IDSTATUS) on delete restrict on update restrict;

alter table ORANGTUA add constraint FK_RELATIONSHIP_2 foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table PESERTADIDIK add constraint FK_RELATIONSHIP_1 foreign key (IDORTU)
      references ORANGTUA (IDORTU) on delete restrict on update restrict;

alter table PORTOFOLIO add constraint FK_RELATIONSHIP_7 foreign key (NISN)
      references PESERTADIDIK (NISN) on delete restrict on update restrict;

alter table PORTOFOLIO add constraint FK_RELATIONSHIP_8 foreign key (NIP)
      references GURU (NIP) on delete restrict on update restrict;

alter table STATUSGIZI add constraint FK_RELATIONSHIP_5 foreign key (NISN)
      references PESERTADIDIK (NISN) on delete restrict on update restrict;

