
INSERT INTO `user` (USER_ID, `NAME`, PASSWORD, `E-MAIL`, PERMISSION) VALUES ('user1', 'example user', 'passwd' ,'user1@example.com', 2),('user2', 'example user2', 'passwd' ,'user2@example.com', 1);

INSERT INTO `type` (TYPE_ID, `NAME`) VALUES (1, '書籍'), (2, 'サプライ品'), (3, 'ドローン');

INSERT INTO `status` (STATUS_ID, STATUS) VALUES (1, '発注済み'), (2, '納品済み'), (3, '未発注'), (4, '返品');