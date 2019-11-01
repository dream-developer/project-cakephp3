
/* --------------------------------------------------------------------------------------------------------------------------------
--
-- 第３章　簡単チュートリアル
--
--------------------------------------------------------------------------------------------------------------------------------  */

--
-- 項　messagesテーブルの作成
--

CREATE TABLE messages(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    user_id INT NOT NULL DEFAULT 0,
    category_id SMALLINT DEFAULT 0,
    status TINYINT NOT NULL DEFAULT 0,
    title VARCHAR(255) NOT NULL,
    body TEXT DEFAULT NULL,
    create_datetime DATETIME DEFAULT NOW()
);


--
-- 項　bakeでMVC(Model, View, Controller)を作成する
--

ALTER TABLE messages DROP user_id;
ALTER TABLE messages DROP category_id;



/* --------------------------------------------------------------------------------------------------------------------------------
--
-- 第５章　データの関連付け
--
--------------------------------------------------------------------------------------------------------------------------------  */

--
-- 項　ユーザーID, カテゴリーIDの追加
--

ALTER TABLE messages ADD user_id INT NOT NULL DEFAULT 0 AFTER status;
ALTER TABLE messages ADD category_id SMALLINT DEFAULT 0 AFTER user_id;

CREATE TABLE users(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    username VARCHAR(64) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status TINYINT NOT NULL DEFAULT 0,
    role VARCHAR(20) DEFAULT NULL,
    pr TEXT DEFAULT NULL,
    create_datetime DATETIME DEFAULT NOW()
);

CREATE TABLE categories(
    id SMALLINT NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

INSERT INTO categories (id, name)
VALUES (0, '指定なし'), (1, '食べ物'), (2, 'スポーツ'), (3, 'ファッション'), (4, '音楽');



/* --------------------------------------------------------------------------------------------------------------------------------
--
-- 第６章　ユーザー機能の追加と改修
--
--------------------------------------------------------------------------------------------------------------------------------  */

--
-- 項　ユーザー認証（Users以外）
--

CREATE TABLE members(
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    membername VARCHAR(255) NOT NULL ,
    memberpass VARCHAR(255) NOT NULL,
    pr TEXT DEFAULT NULL,
    create_datetime DATETIME DEFAULT NOW()
);


--
-- 項　admin権限
--

UPDATE users SET role = 'admin' WHERE id = 5;

