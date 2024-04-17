-- 更新表结构
ALTER TABLE `df` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT,
CHANGE `lastlogintime` `last_login_time` DATETIME,
CHANGE `createtime` `create_time` DATETIME;
ALTER TABLE `roles` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `dt` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `menu` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT,
CHANGE `orderNum` `order_num` INT;
ALTER TABLE `html` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT,
CHANGE `fileN` `file_n` VARCHAR ( 50 );
ALTER TABLE `logs` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_info` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `layout` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT,
CHANGE `Inscribe` `inscribe` VARCHAR ( 100 ),
CHANGE `musicPlay` `music_play` TINYINT ( 4 ),
CHANGE `sceneId` `scene_id` INT ( 11 );
ALTER TABLE `layout` CHANGE `img1` `bg_img` VARCHAR ( 200 );
ALTER TABLE `layout_img` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `column` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `link` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `music` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `message` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT,
CHANGE `E_mail` `e_mail` VARCHAR ( 100 );
ALTER TABLE `notepad` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `column` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `test` CHANGE `Id` `id` int(11) NOT NULL AUTO_INCREMENT;

-- 更新数据
UPDATE `df`
SET `pic` = '/view/admin/public/assets/img/logo.png'
WHERE
	`nm` = 'df';

UPDATE `menu`
SET `src` = 'admin%2Fcolumn%2Fnotepad'
WHERE
	`title` = '静态分页';
UPDATE `menu`
SET `src` = 'admin%2Flogin%2Fcreate_db'
WHERE
	`title` = '装载数据';

UPDATE `menu`
SET `src` = 'admin%2Fcolumn%2Flayout'
WHERE
	`title` = '布局';
UPDATE `menu`
SET `src` = 'admin%2Fcolumn%2Farticle'
WHERE
	`title` = '文章';
UPDATE `menu`
SET `src` = 'admin%2Fcolumn%2Flink'
WHERE
	`title` = '链接';
UPDATE `menu`
SET `src` = 'admin%2Fcolumn%2Fmusic'
WHERE
	`title` = '音乐';

UPDATE `menu`
SET `src` = 'admin%2Fcolumn%2Fmessage'
WHERE
	`title` = '留言';
UPDATE `menu`
SET `src` = 'url%3A%2Fstatic_pages%2Ffont.html'
WHERE
	`title` = '查看字体';
