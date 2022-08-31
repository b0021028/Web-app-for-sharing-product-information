<?php
    // データ最大値(毎回取得)
    $tmp = $pdo->prepare("SELECT COUNT(*) as ct FROM products WHERE ORDER_USER = :user");
    $tmp->bindParam(':user', $result[0]["USER_ID"]);
    $tmp->execute();
    $maxSize = $tmp->fetchAll()[0]["ct"];

    // 最大ページ最小ページ計算 ページ調整
    if ($page < 0){
        $page = 0;
    }
    $previousFlag = $page > 0;
    $nextFlag = ($page+$size) < $maxSize;
    if (!$nextFlag && $maxSize != 0){
        $page = $page % ($maxSize);
    }



    //SQL文作成
    $subquery = "SELECT * FROM products WHERE ORDER_USER = :user ORDER BY ORDER_DATE ASC, PRODUCT_ID ASC LIMIT :i,:j ";
    $mqselect = "SELECT type.NAME AS TYPE, p.NAME as NAME, PRICE, ORDER_DATE, DELIVERY_DATE, status.status AS STATUS ";
    $mqinnerjoin = "Inner Join type on type.type_id = p.type Inner Join status on status.STATUS_ID = p.ORDER_STATUS ";
    $mqfrom = "FROM ({$subquery}) as p {$mqinnerjoin} ";
    $query = "{$mqselect} {$mqfrom}";

    //データ取り出し
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user', $result[0]["USER_ID"]);
    $stmt->bindParam(':j', $size , PDO::PARAM_INT);
    $stmt->bindParam(':i', $page, PDO::PARAM_INT);
    $stmt->execute();

    $product = $stmt->fetchAll();
    require_once __DIR__.'/viewSelect_tpl_2.php';



?>
