<?php

    try {
        // データベースに接続
        $pdo = new PDO(
            // ホスト名、データベース名
            'mysql:host=localhost;dbname=order;charset=utf8',
            // ユーザー名
            'root',
            // パスワード
            '',
            // レコード列名をキーとして取得させる
            [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]
        );


    // SQL文作成
        // SQLquery作成
        $query = 'SELECT * FROM user WHERE user_id = :user_id AND password = :password';

        // SQL文をセット
        $stmt = $pdo->prepare($query);

        // バインド
        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':password', $password);

        // SQL文を実行
        $stmt->execute();

        // 実行結果のフェッチ
        $result = $stmt->fetchAll();
        if (empty($result))
        {
            // ログイン失敗で無言バック
            header('Location: ' . "login.html", true , 302);
            exit();
        }
        else
        {
            $user_name = $result[0]["NAME"];
            $user_name = $result[0]["NAME"];
        }


    } catch (PDOException $e) {
        //例外発生したら無視
        require_once 'exception_tpl.php';
        echo $e->getMessage();
        exit();
    }


?>