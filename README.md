# qbox
就是一个提问箱（弱鸡版）
# 数据库创建示例
user表：用户id“uid”，INT(11)，PK，NN，Unsigned，自增；用户名“username”，VARCHAR(64)，NN；密码“pw”，VARCHAR(32)，NN

questions表：问题id“id”，int(11)，PK，NN，Unsigned，自增；UID“uid”，INT(11)，NN，body“msg”，TEXT，NN；readed，INT(1)，Unsigned，NN，只有0和1

config表：id“id”，INT(1)，PK，NN，Unsigned，只能是1；邀请码“reg_ref_code”，VARCHAR(32)，NN，把邀请码MD5加密了塞进去；注册权限“reg_auth”，INT(1)，只能是0和1，0是开放，1注册需要邀请码。

blacklist表：id，INT(11),PK,UN,NN;ip VARCHAR(64),NN;uid,INT(11),UN,NN;qid,INT(11),NN,UN;
