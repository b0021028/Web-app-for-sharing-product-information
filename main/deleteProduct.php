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
        require_once __DIR__."/login.php";
        exit();
    }

    try {
        require_once __DIR__.'/common/pdo.php';
        $pdo = newPDO();


    // SQL文作成
    // user 特定
        $result = searchUser($user, $password);

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

            require_once __DIR__."/AfterExcution.php";
            exit();
        } else {
            echo "すでに値がありません";
            exit();
        }




    } catch(Exception $e) {
        echo $e;
    }






?>