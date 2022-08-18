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
        if (!empty($result))
        {
            $user_name = $result[0]["NAME"];
            require_once 'viewSelect.php';
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
        require_once 'exception_tpl.php';
        echo $e->getMessage();
        exit();
    }



/*
$defo = "";
$user = $defo;
$password = $defo;
if (!(empty($_GET["user"]) || empty($_GET["password"]))){
    $user = $_GET["user"];
    $password = $_GET["password"];
}

///
 
$size = 5;
$page = 0;






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
    $query = 'SELECT * FROM user WHERE USER_ID = :user_id AND PASSWORD = :password';

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
        $user_name = $result[0]["NAME"];
        require_once 'viewSelect.php';
    }
    else if (false)
    {
        header('Location: '."login.html", true , 302);
        exit();
    }





} catch (PDOException $e) {
    //例外発生したら無視
    require_once 'exception_tpl.php';
    echo $e->getMessage();
    exit();
}

// ループして1レコードずつ取得
foreach ($stmt as $row) {

    echo($row["USER_ID"]."<br>");
    echo($row["NAME"]."<br>");
    echo($row["PASSWORD"]."<br>");
    echo($row["PERMISSION"]."<br>");
}


require_once 'login_tpl.php';
*/
?>