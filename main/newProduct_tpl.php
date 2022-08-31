<?php //$statuses $types $user $user_name $password?
require_once __DIR__.'/common/functions.php';
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>新規追加</title>
        <link rel="stylesheet" href="css/webapp.css"/>
        <style type="text/css">
         form label {
            display: block;
            padding:5px;
            text-align:center;
            margin:10px;
            background-color:#f2f2;
        }
        </style>
    </head>

    <body>
        <div id="app">
            <div id="header">

                <a><?php echo header_message($user_name);?></a>
            </div>
            <div id="main">
                <div id="content">
                    <form action="newProduct.php" method="post">
                        <input type="hidden" name="user" value="<?php echo $user;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                        <!--label>種類 : <input autofocus type="search" name="type" autocomplete="on" list="type" value="" required>
                            <datalist id="type"></datalist>
                        </label-->
                        <label>種類 : <select autofocus name="type" required>
                                <option hidden value="">選択してください</option><?php
                                foreach ($types as $row){
                                    print('<option value='.$row["TYPE_ID"].'>'.$row["NAME"].'</option>');
                                }
                            ?></select>
                        </label>

                        <label>商品名 : <input type="search" name="name" value="" required placeholder="(例) コケ・コーレ"></label>

                        <label>料金 : <input type="number" name="price" value="" required>円</label>

                        <label>注文日 : <input type="date" name="order_date" value="" required></label>

                        <label>ステータス: <select name="status" required>
                                <option hidden value="">選択してください</option><?php
                                foreach ($status as $row){
                                print('<option value='.$row["STATUS_ID"].'>'.$row["STATUS"].'</option>');
                                }
                            ?></select>
                        </label>

                        <label>納品日 : <input type="date" name="delivery_date" value=""></label>

                        <input type="reset" value="入力内容のリセット">
                        <input type="submit" value="送信">

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
