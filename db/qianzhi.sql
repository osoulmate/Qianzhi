DROP TABLE IF EXISTS articles;
CREATE TABLE `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `index_id` varchar(34) NOT NULL COMMENT '标题日期盐的哈希值',
  `category_id` int(11) NOT NULL COMMENT '分类id',
  `promulgator_id` int(10) NOT NULL COMMENT '发布者id',
  `title` varchar(100) NOT NULL COMMENT '文章标题',
  `author` varchar(32) DEFAULT NULL COMMENT '作者',
  `interpreter` varchar(32) DEFAULT NULL COMMENT '翻译',
  `date` datetime NOT NULL COMMENT '发布日期',
  `hits` int(10) NOT NULL DEFAULT '0' COMMENT '阅读数',
  `content` longtext NOT NULL COMMENT '文章内容',
  `flag` int(3) NOT NULL DEFAULT '0' COMMENT '-1：回收，0：正常，1：推荐，2：置顶',
  `isview` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否正式发布（0：草稿，1：正式）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COMMENT='文章信息表';


DROP TABLE IF EXISTS categories;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `name` varchar(20) NOT NULL COMMENT '分类名',
  `parent_id` int(10) unsigned DEFAULT NULL COMMENT '父级分类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='文章分类信息表';

INSERT INTO categories VALUES('1','Linux','0');
INSERT INTO categories VALUES('2','编程','0');
INSERT INTO categories VALUES('3','运维','0');
INSERT INTO categories VALUES('5','SUSE','1');
INSERT INTO categories VALUES('6','RedHat','1');
INSERT INTO categories VALUES('7','PHP','2');
INSERT INTO categories VALUES('8','Python','2');
INSERT INTO categories VALUES('9','说吧','0');
INSERT INTO categories VALUES('10','谈情说爱','9');
INSERT INTO categories VALUES('11','技术漫话','9');
INSERT INTO categories VALUES('12','其它','2');

DROP TABLE IF EXISTS comments;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父级评论id',
  `article_id` int(11) NOT NULL COMMENT '关联文章id',
  `user_id` int(10) NOT NULL COMMENT '评论用户id',
  `content` varchar(32) NOT NULL COMMENT '评论内容',
  `date` datetime NOT NULL COMMENT '评论日期',
  `praise` varchar(11) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '评论点赞数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='评论表';

DROP TABLE IF EXISTS systems;
CREATE TABLE `systems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(32) NOT NULL COMMENT '博客名字',
  `index_view_items_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '主页视图条目限制',
  `class_view_items_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '分类视图条目限制',
  `year_view_items_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '年度视图条目限制',
  `month_view_items_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '月度视图条目限制',
  `day_view_items_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '每日视图条目限制',
  `search_view_items_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '搜索视图条目限制',
  `copyright` varchar(32) NOT NULL DEFAULT '5' COMMENT 'copyright info',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='系统配置表';

INSERT INTO systems VALUES('1','千知博客','6','5','5','5','5','5','');

DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(32) NOT NULL COMMENT '用户昵称',
  `email` varchar(32) NOT NULL COMMENT '用户邮箱',
  `username` varchar(32) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '用户密码',
  `sex` varchar(2) DEFAULT NULL COMMENT '用户性别',
  `photo` blob COMMENT '用户头像',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为管理员',
  `visitor_ip` varchar(16) DEFAULT NULL COMMENT '注册地公网ip',
  `visitor_location` varchar(16) DEFAULT NULL COMMENT '注册地理位置',
  `visitor_browser` varchar(16) DEFAULT NULL COMMENT '注册浏览器版本',
  `registry_date` datetime NOT NULL COMMENT '注册日期',
  `registry_source` varchar(50) DEFAULT 'local' COMMENT '注册来源',
  `token` varchar(50) NOT NULL COMMENT '注册令牌',
  `token_expire_time` datetime NOT NULL COMMENT '注册令牌过期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'default0,no active',
  `reset_token` varchar(50) DEFAULT NULL COMMENT '重置密码令牌',
  `reset_token_expire_time` varchar(50) DEFAULT '2999-10-10 10:10:01' COMMENT '重置密码令牌过期时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='用户信息表';

INSERT INTO users VALUES('1','Administrator','admin@163.com','admin','21232f297a57a5a743894a0e4a801fc3','','','1','','','','2010-10-10 10:10:10','','2999-10-10 10:10:10','1','','');
