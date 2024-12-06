-- 更新表结构
ALTER TABLE `message` ADD COLUMN `status` tinyint(4) DEFAULT '0' COMMENT '阅读状态';


-- 更新数据
