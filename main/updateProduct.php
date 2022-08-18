<?php
// 読み込み
    $defo = "";
    $user = $defo;
    $password = $defo;
    if (!(empty($_POST["user"]) || empty($_POST["password"]))){
        $user = $_POST["user"];
        $password = $_POST["password"];
    }


    if (!(empty($_POST["id"]) || empty($_POST["type"]) || empty($_POST["name"]) || empty($_POST["order_date"]) || empty($_POST["status"]) ) ){
        $product_id = $_POST["id"];
        $type = $_POST["type"];
        $name = $_POST["name"];
        $order_date = $_POST["order_date"];
        $status = $_POST["status"];
        if (empty($_POST["price"])){
            $price = "0";
        } else {
            $price = $_POST["price"];
        }
        if (empty($_POST["delivery_date"])){
            $delivery_date = null;
        } else {
            $delivery_date = $_POST["delivery_date"];
        }
    } else {
        require_once "changeRecode.php";
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

            // typeを抽出 レスポンス用
            $query = 'SELECT `TYPE_ID`, `NAME` FROM `type` WHERE `TYPE_ID` = :type ORDER BY `TYPE_ID`';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":type", $type);
            $stmt->execute();
            $type = $stmt->fetchAll()[0];
            

            // statusを抽出 レスポンス用
            $query = 'SELECT `STATUS_ID`, `STATUS` FROM `status` WHERE `STATUS_ID` = :status ORDER BY `STATUS_ID`';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":status", $status, PDO::PARAM_INT);
            $stmt->execute();
            $status = $stmt->fetchAll()[0];

            // アップデート
            $query = 'UPDATE `products` SET TYPE = :type, NAME = :name, PRICE = :price, ORDER_DATE = :order_date, DELIVERY_DATE = :delivery_date, ORDER_STATUS = :status'.
            ' WHERE PRODUCT_ID = :product_id AND ORDER_USER = :user';
            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":type", $type["TYPE_ID"], PDO::PARAM_INT);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":price", $price, PDO::PARAM_INT);
            $stmt->bindParam(":order_date", $order_date);

            if (is_null($delivery_date)){
                $stmt->bindParam(":delivery_date", $delivery_date, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(":delivery_date", $delivery_date);
            }

            $stmt->bindParam(":status", $status["STATUS_ID"], PDO::PARAM_INT);
            $stmt->bindParam(":user", $user);
            $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);
            $success = $stmt->execute();

            // 更新成功
            if ($success){
                //更新したレコードを取得

                $query = "SELECT p.PRODUCT_ID AS ID, type.NAME AS TYPE, p.NAME as NAME, PRICE, ORDER_DATE, DELIVERY_DATE, status.status AS STATUS".
                " FROM (".
                " SELECT * FROM products WHERE PRODUCT_ID = :product_id AND (TRUE OR ORDER_USER = :user)".
                " ORDER BY PRODUCT_ID DESC LIMIT 1".
                " ) as p".
                " Inner Join type on type.type_id = p.type".
                " Inner Join status on status.STATUS_ID = p.ORDER_STATUS";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":user", $user);
                $stmt->bindParam(":product_id", $product_id, PDO::PARAM_INT);

                $stmt->execute();
                $Fproduct = $stmt->fetchAll()[0];

            }
            //$success $user $password $user_name ($Fproduct)
            require_once "AfterExcution.php";


        } else {
            echo "error :: retry login";
            exit();
        }
    }catch (Exception $e) {require_once "exception_tpl.php";}

?>
