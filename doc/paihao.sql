/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2017/8/18 23:04:20                           */
/*==============================================================*/


drop table if exists ph_inline;

drop index index_wx_scene on ph_line;

drop table if exists ph_line;

drop table if exists ph_shopper;

drop index index_unionid on ph_users;

drop index index_oppenid on ph_users;

drop table if exists ph_users;

/*==============================================================*/
/* Table: ph_inline                                             */
/*==============================================================*/
create table ph_inline
(
   in_id                bigint not null,
   lid                  bigint,
   sum                  int comment '共排队数',
   curr_num             int,
   abstain_sum          int comment '共放弃排号总数',
   starttime            integer comment '创建时间',
   stoptime             bigint comment '排号停止时间',
   status               int comment '0未开始，1排号中，2已停止',
   primary key (in_id)
);

alter table ph_inline comment '排号次';

/*==============================================================*/
/* Table: ph_line                                               */
/*==============================================================*/
create table ph_line
(
   lid                  bigint not null,
   uid                  bigint,
   lname                varchar(200),
   to_tip               varchar(200) comment '手机号',
   close_tip            varchar(200) comment '微信OPPENID',
   createtime           integer comment '创建时间',
   modifytime           integer comment '修改时间',
   image                varchar(256) comment '头像',
   status               int comment '-1逻辑删除,0正常，1禁用【禁用后无法启动排队】',
   wx_scene             varchar(50) comment '微信小程序二维码的scene值',
   primary key (lid)
);

alter table ph_line comment '排号表';

/*==============================================================*/
/* Index: index_wx_scene                                        */
/*==============================================================*/
create unique index index_wx_scene on ph_line
(
   wx_scene
);

/*==============================================================*/
/* Table: ph_shopper                                            */
/*==============================================================*/
create table ph_shopper
(
   cid                  bigint not null comment '顾客id',
   uid                  bigint,
   lid                  bigint,
   in_id                bigint,
   createtime           integer comment '创建时间',
   number               int,
   callsum              int comment '呼号次数',
   status               int comment '-2管理员消号，-1放弃排号，0排号中，1叫号中，2确认收到叫号,3排号完成',
   primary key (cid)
);

alter table ph_shopper comment '顾客排队表';

/*==============================================================*/
/* Table: ph_users                                              */
/*==============================================================*/
create table ph_users
(
   uid                  bigint not null,
   name                 varchar(200),
   pwd                  varchar(200),
   nick                 varchar(200),
   mob                  char(11) comment '手机号',
   wxopid               varchar(200) comment '微信OPPENID',
   wxunionid            varchar(200) comment '微信unionID',
   createtime           integer comment '创建时间',
   modifytime           integer comment '修改时间',
   image                varchar(256) comment '头像',
   userinfo             text comment '微信用户信息',
   primary key (uid)
);

alter table ph_users comment '用户表';

/*==============================================================*/
/* Index: index_oppenid                                         */
/*==============================================================*/
create index index_oppenid on ph_users
(
   wxopid
);

/*==============================================================*/
/* Index: index_unionid                                         */
/*==============================================================*/
create index index_unionid on ph_users
(
   wxunionid
);

alter table ph_inline add constraint FK_Reference_1 foreign key (lid)
      references ph_line (lid) on delete restrict on update restrict;

alter table ph_line add constraint FK_Reference_2 foreign key (uid)
      references ph_users (uid) on delete restrict on update restrict;

alter table ph_shopper add constraint FK_Reference_3 foreign key (uid)
      references ph_users (uid) on delete restrict on update restrict;

alter table ph_shopper add constraint FK_Reference_4 foreign key (lid)
      references ph_line (lid) on delete restrict on update restrict;

alter table ph_shopper add constraint FK_Reference_5 foreign key (in_id)
      references ph_inline (in_id) on delete restrict on update restrict;

