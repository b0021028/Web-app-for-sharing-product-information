<?php
// 読み込み
    $defo = "";
    $user = $defo;
    $password = $defo;
    if (!(empty($_POST["user"]) || empty($_POST["password"]))){
        $user = $_POST["user"];
        $password = $_POST["password"];
    }


    if (!(empty($_POST["type"]) || empty($_POST["name"]) || empty($_POST["order_date"]) || empty($_POST["status"]) ) ){
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
        require_once __DIR__."/newProductForm.php";
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

            // インサート
            $query = 'INSERT INTO `products` (TYPE, NAME, PRICE, ORDER_DATE, DELIVERY_DATE, ORDER_STATUS, ORDER_USER) VALUES (:type, :name, :price, :order_date, :delivery_date, :status, :user)';
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
            $stmt->bindParam(":delivery_date", $delivery_date);
            $stmt->bindParam(":status", $status["STATUS_ID"], PDO::PARAM_INT);
            $stmt->bindParam(":user", $user);

            $success = $stmt->execute();

            // インサート成功
            if ($success){
                //同一ユーザが同時に複数存在したらやばいコード 追加したレコードを取得 (ちょっと冗長(where句))

                $query = "SELECT p.PRODUCT_ID AS ID, type.NAME AS TYPE, p.NAME as NAME, PRICE, ORDER_DATE, DELIVERY_DATE, status.status AS STATUS".
                " FROM (".
                " SELECT * FROM products WHERE ORDER_USER = :user".
            //**/" AND TYPE = :type AND NAME = :name AND PRICE = :price AND ORDER_DATE = :order_date AND DELIVERY_DATE = :delivery_date AND ORDER_STATUS = :status".
                " ORDER BY PRODUCT_ID DESC LIMIT 1".
                " ) as p".
                " Inner Join type on type.type_id = p.type".
                " Inner Join status on status.STATUS_ID = p.ORDER_STATUS";

                $stmt = $pdo->prepare($query);
                /*
                $stmt->bindParam(":type", $type["TYPE_ID"], PDO::PARAM_INT);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":price", $price, PDO::PARAM_INT);
                $stmt->bindParam(":order_date", $order_date);
                if (is_null($delivery_date)){
                    $stmt->bindParam(":delivery_date", $delivery_date, PDO::PARAM_NULL);
                } else {
                    $stmt->bindParam(":delivery_date", $delivery_date);
                }
                $stmt->bindParam(":delivery_date", $delivery_date);
                $stmt->bindParam(":status", $status["STATUS_ID"], PDO::PARAM_INT);
                //*/
                $stmt->bindParam(":user", $user);

                $stmt->execute();

                $Fproduct = $stmt->fetchAll()[0];

            }
            //$success $user $password $user_name ($Fproduct)
            require_once __DIR__."/AfterExcution.php";


        } else {
            echo "error :: retry login";
            exit();
        }
    }catch (Exception $e) {
        require_once __DIR__."/exception_tpl.php";
    }

?>
