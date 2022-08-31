<?php
    $defo = "";
    $user = $defo;
    $password = $defo;
    if (!(empty($_GET["user"]) || empty($_GET["password"]))){
        $user = $_GET["user"];
        $password = $_GET["password"];
    }


    if (isset($_GET["size"]))
    {
        $size = intval((string)$_GET["size"]);
    } else if (!isset($size)){
        $size = 5;
    }

    if (isset($_GET["page"]))
    {
        $page = intval((string)$_GET["page"]);
    } else if (!isset($page)){
        $page = 0;
    }
    if ($page < 0)
    {
        $page = 0;
    }



    try {
        require_once __DIR__.'/common/pdo.php';
        $pdo = newPDO();

    // SQL文作成
        $result = searchUser($user, $password);
        if (!empty($result))
        {
            $user_name = $result[0]["NAME"];
            require_once __DIR__.'/viewSelect.php';
            exit();
        }
        else
        {
            // ログイン失敗で無言バック
            header('Location: ' . "login.html", true , 302);
            exit();
        }





    } catch (PDOException $e) {
        //例外発生したら無視
        require_once __DIR__.'/exception_tpl.php';
        echo $e->getMessage();
        exit();
    }


    /*
    // ループして1レコードずつ取得
    foreach ($stmt as $row) {

        echo($row["USER_ID"]."<br>");
        echo($row["NAME"]."<br>");
        echo($row["PASSWORD"]."<br>");
        echo($row["PERMISSION"]."<br>");
    }


    require_once __DIR__.'/login_tpl.php';
    */
?>