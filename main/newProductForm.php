<?php
    $defo = "";
    $user = $defo;
    $password = $defo;
    if (!(empty($_POST["user"]) || empty($_POST["password"]))){
        $user = $_POST["user"];
        $password = $_POST["password"];
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

            require_once __DIR__."/newProduct_tpl.php";

            exit();
        } else {
            require_once __DIR__."/login.php";
            exit();
        }
    }catch (Exception $e) {
        require_once __DIR__."/exception_tpl.php";
    }

?>
