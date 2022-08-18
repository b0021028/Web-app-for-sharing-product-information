<?php
    $defo = "";
    $user = $defo;
    $password = $defo;
    if (!(empty($_POST["user"]) || empty($_POST["password"]))){
        $user = $_POST["user"];
        $password = $_POST["password"];
    }

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
    // user 特定
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

        if (!empty($result))
        {
            // ユーザ名
            $user_name = $result[0]["NAME"];

            // typeを抽出
            $query = 'SELECT `TYPE_ID`, `NAME` FROM `type` order by `TYPE_ID`';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $types = $stmt->fetchAll();

            // statusを抽出
            $query = 'SELECT `STATUS_ID`, `STATUS` FROM `status` order by `STATUS_ID`';
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $status = $stmt->fetchAll();

            require_once "newProduct_tpl.php";

            exit();
        } else {
            require_once "login.php";
            exit();
        }
    }catch (Exception $e) {require_once "exception_tpl.php";}

?>
