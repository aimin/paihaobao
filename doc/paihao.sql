/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2017/8/18 23:04:20                           */
/*==============================================================*/

CREATE DATABASE `paihao`CHARACTER SET utf8 COLLATE utf8_general_ci;
use `paihao`;

drop table if exists ph_inline;

drop index index_wx_scene on ph_line;

drop table if exists ph_line;

drop table if exists ph_shopper;

drop index index_unionid on ph_users;

drop index index_oppenid on ph_users;

drop table if exists ph_users;

CREATE TABLE `ph_setting` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `value` text,
  `lasttime` bigint(20) DEFAULT NULL,
  `createtime` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`sid`),
  UNIQUE KEY `index_set_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8


/*==============================================================*/
/* Table: ph_inline                                             */
/*==============================================================*/

CREATE TABLE `ph_inline` (
  `in_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lid` bigint(20) DEFAULT NULL,
  `sum` int(11) DEFAULT '0' COMMENT '共排队数',
  `curr_num` int(11) DEFAULT '0',
  `abstain_sum` int(11) DEFAULT '0' COMMENT '共放弃排号总数',
  `starttime` int(11) DEFAULT NULL COMMENT '创建时间',
  `stoptime` bigint(20) DEFAULT NULL COMMENT '排号停止时间',
  `status` int(11) DEFAULT '1' COMMENT '0未开始，1排号中，2已停止',
  PRIMARY KEY (`in_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='排号次';


alter table ph_inline comment '排号次';

/*==============================================================*/
/* Table: ph_line                                               */
/*==============================================================*/
CREATE TABLE `ph_line` (
  `lid` bigint(20) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `lname` varchar(200) DEFAULT NULL,
  `to_tip` varchar(200) DEFAULT NULL COMMENT '手机号',
  `close_tip` varchar(200) DEFAULT NULL COMMENT '微信OPPENID',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `modifytime` int(11) DEFAULT NULL COMMENT '修改时间',
  `image` varchar(256) DEFAULT NULL COMMENT '二维码地址',
  `status` int(11) DEFAULT NULL COMMENT '-1逻辑删除,0正常，1禁用【禁用后无法启动排队】',
  `wx_scene` varchar(50) DEFAULT NULL COMMENT '微信小程序二维码的scene值',
  PRIMARY KEY (`lid`),
  UNIQUE KEY `index_wx_scene` (`wx_scene`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='排号表' ;

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

CREATE TABLE `ph_shopper` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '顾客id',
  `uid` bigint(20) DEFAULT NULL,
  `lid` bigint(20) DEFAULT NULL,
  `in_id` bigint(20) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `modifytime` int(11) DEFAULT NULL COMMENT '最后修改时间',
  `number` int(11) DEFAULT NULL,
  `callsum` int(11) DEFAULT NULL COMMENT '呼号次数',
  `status` int(11) DEFAULT NULL COMMENT '-2管理员消号，-1放弃排号，0排号中，1叫号中，2确认收到叫号,3排号完成',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='顾客排队表';

/*==============================================================*/
/* Table: ph_users                                              */
/*==============================================================*/

CREATE TABLE `ph_users` (
  `uid` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `pwd` varchar(200) DEFAULT NULL,
  `nick` varchar(200) DEFAULT NULL,
  `mob` char(11) DEFAULT NULL COMMENT '手机号',
  `wxopid` varchar(200) DEFAULT NULL COMMENT '微信OPPENID',
  `wxunionid` varchar(200) DEFAULT NULL COMMENT '微信unionID',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `modifytime` int(11) DEFAULT NULL COMMENT '修改时间',
  `image` varchar(256) DEFAULT NULL COMMENT '头像',
  `userinfo` text COMMENT '微信用户信息',
  `lastlogintime` int(11) DEFAULT '0' COMMENT '最后登录时间',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `index_oppenid` (`wxopid`),
  UNIQUE KEY `index_unionid` (`wxunionid`),
  UNIQUE KEY `index_mob` (`mob`),
  UNIQUE KEY `index_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='用户表'
;

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

/*alter table ph_inline add constraint FK_Reference_1 foreign key (lid)
      references ph_line (lid) on delete restrict on update restrict;

alter table ph_line drop constraint FK_Reference_2 foreign key (uid)
      references ph_users (uid) on delete restrict on update restrict;

alter table ph_shopper add constraint FK_Reference_3 foreign key (uid)
      references ph_users (uid) on delete restrict on update restrict;

alter table ph_shopper add constraint FK_Reference_4 foreign key (lid)
      references ph_line (lid) on delete restrict on update restrict;

alter table ph_shopper add constraint FK_Reference_5 foreign key (in_id)
      references ph_inline (in_id) on delete restrict on update restrict;*/

