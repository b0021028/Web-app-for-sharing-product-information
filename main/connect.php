<?php

    try {
        require_once __DIR__.'/common/pdo.php';
        $pdo = newPDO();


    // ユーザ特定//SQL文作成
        $result = searchUser($user, $password);
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
        require_once __DIR__.'/exception_tpl.php';
        echo $e->getMessage();
        exit();
    }


?>