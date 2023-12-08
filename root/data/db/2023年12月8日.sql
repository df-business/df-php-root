-- 更新字段名
ALTER TABLE `df` CHANGE `Id` `id` INT ( 11 ),
CHANGE `lastlogintime` `last_login_time` DATETIME,
CHANGE `createtime` `create_time` DATETIME;
ALTER TABLE `roles` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `dt` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `menu` CHANGE `Id` `id` INT ( 11 ),
CHANGE `orderNum` `order_num` INT;
ALTER TABLE `html` CHANGE `Id` `id` INT ( 11 ),
CHANGE `fileN` `file_n` VARCHAR ( 50 );
ALTER TABLE `logs` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `home_user_info` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `home_layout` CHANGE `Id` `id` INT ( 11 ),
CHANGE `Inscribe` `inscribe` VARCHAR ( 100 ),
CHANGE `musicPlay` `music_play` TINYINT ( 4 ),
CHANGE `sceneId` `scene_id` INT ( 11 );
ALTER TABLE `home_layout_img` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `home_column` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `home_link` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `home_music` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `message` CHANGE `Id` `id` INT ( 11 ),
CHANGE `E_mail` `e_mail` VARCHAR ( 100 );
ALTER TABLE `notepad` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `column` CHANGE `Id` `id` INT ( 11 );
ALTER TABLE `test` CHANGE `Id` `id` INT ( 11 );
--
-- 菜单
UPDATE menu
SET src = 'admin%2Fcolumn%2Fnotepad'
WHERE
	title = '记事本';
UPDATE menu
SET src = 'admin%2Fcolumn%2Fcolumn'
WHERE
	title = '关于此站点';
UPDATE menu
SET src = 'admin%2Fhome%2Fcreate_db'
WHERE
	title = '装载数据';
UPDATE menu
SET src = 'admin%2Fcolumn%2Fmessage'
WHERE
	title = '留言管理';
UPDATE menu
SET src = 'url%3A%2Fstatic_pages%2Ffont.html'
WHERE
	title = '查看字体';
