<?php
    $defo = "";
    $user = $defo;
    $password = $defo;
    if (!(empty($_POST["user"]) || empty($_POST["password"]))){
        $user = $_POST["user"];
        $password = $_POST["password"];
    }

    if (!empty($_POST["id"])){
        $product_id = $_POST["id"];
    } else {
        require_once "login.php";
        exit();
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
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':user_id', $user);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        // 実行結果のフェッチ
        $result = $stmt->fetchAll();

        if (!empty($result))
        {
            // ユーザ名
            $user_name = $result[0]["NAME"];

            // レコード取得
            $query = "SELECT p.PRODUCT_ID AS ID, type.TYPE_ID AS TYPE_ID, type.NAME AS TYPE, p.NAME as NAME, PRICE, ORDER_DATE, DELIVERY_DATE, status.status AS STATUS, status.STATUS_ID AS STATUS_ID".
            " FROM (".
            " SELECT * FROM products WHERE ORDER_USER = :user AND PRODUCT_ID = :product_id".
            " ) as p".
            " Inner Join type on type.type_id = p.type".
            " Inner Join status on status.STATUS_ID = p.ORDER_STATUS";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);

            $stmt->execute();

            // DELETE
            $query = "DELETE FROM products WHERE PRODUCT_ID = :product_id AND ORDER_USER = :user";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':user', $user);
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $success = $stmt->execute();

            require_once "AfterExcution.php";
            exit();
        } else {
            echo "すでに値がありません";
            exit();
        }




    } catch(Exception $e) {echo $e;}






?>