# qbox
就是一个提问箱（弱鸡版）
# 数据库创建示例
```sql
CREATE TABLE `user`(
`uid` INT(11) Unsigned NOT NULL primary key AUTO_INCREMENT,
`username` VARCHAR(64) NOT NULL,
`pw` VARCHAR(32) NOT NULL,
`last_ip` TEXT
);

CREATE TABLE `questions`(
`id` int(11) Unsigned NOT NULL primary key AUTO_INCREMENT,
`uid` INT(11) NOT NULL,
`msg` TEXT NOT NULL,
`submit_ip` TEXT
);
CREATE TABLE `config`(
`id` INT(1) Unsigned NOT NULL primary key, /*只能是1*/
`reg_ref_code` VARCHAR(32) NOT NULL , /*把邀请码MD5加密了塞进去*/
`reg_auth` TINYINT(1) /*--只能是0和1，0是开放，1注册需要邀请码。*/
);
UPDATE `config` SET `id` = 1
```
