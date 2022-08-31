<?php
if (isset($password)){
    function newPDO(){

/*****************************/
        $pdo_dsn      = 'mysql:host=localhost;dbname=order;charset=utf8';
        $pdo_username = 'root';
        $pdo_password = '';
/*****************************/

        //( ホスト名、データベース名, ユーザー名, パスワード, レコード列名をキーとして取得させる)
        return new PDO($pdo_dsn, $pdo_username, $pdo_password , [ PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]);
    }

    function searchUser($user_id, $password){
            $pdo = newPDO();
        // SQL文作成
            // SQLquery作成
            $query = 'SELECT * FROM user WHERE user_id = :user_id AND password = :password';

            // SQL文をセット
            $stmt = $pdo->prepare($query);
    
            // バインド
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':password', $password);
    
            // SQL文を実行
            $stmt->execute();
    
            // 実行結果のフェッチ
            $result = $stmt->fetchAll();

            return $result;
    }

}
else {
    //print(file_get_contents("404.html"));
    require_once __DIR__.'/../error/403.php';
    exit;
}
?>