<?php
//$success $user $password $user_name ($Fproduct : if $success is true)
//
require_once __DIR__.'/common/functions.php';
?><!DOCTYPE html>
<html>
    <head><!--https://qreat.tech/2712/-->
        <meta charset="utf-8">
        <title>実行結果</title>
        <link rel="stylesheet" href="css/webapp.css"/>
        <style type="text/css">
         form {
            display: inline-block;
            padding:5px;
            text-align:center;
            margin:10px;
        }
        </style>
    </head>
    <body>
        <div id="app">
            <div id="header">
                <a><?php echo htmEsc($user_name);?> さん、実行結果です</a>
            </div>
            <div id="main">
                <div id="content">
                    <p>
<?php
                    $tmp = "実行";
                    if ($success){
                        $tmp = $tmp."に成功";
                    }
                    echo htmEsc($tmp."しました");

?>
                    </p><br>
                    <div>
<?php                    
                        if ($success && isset($Fproduct)){
                            echo "種類 : ".htmEsc($Fproduct["TYPE"])."<br>";
                            echo "商品名 : ".htmEsc($Fproduct["NAME"])."<br>";
                            echo "料金 : JPY ".$Fproduct["PRICE"]."円"."<br>";
                            echo "注文日 : ".$Fproduct["ORDER_DATE"]."<br>";
                            echo "納品日 : ";
                            if (is_null($Fproduct["DELIVERY_DATE"])){
                                echo "-- - -- - -- - --";
                            } else {
                                echo $Fproduct["DELIVERY_DATE"];
                            }
                            echo "<br>"."ステータス : ".$Fproduct["STATUS"];
                        }
?>
                    </div>
                    <span>
                    <form action="newProductForm.php" method="post">
                        <input type="hidden" name="user" value="<?php echo $user;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                        <input type="submit" value="新規追加">
                    </form>
<?php
                    if ($success && isset($Fproduct)){ 
?>     
                    <form action="changeRecode.php" method="post">
                        <input type="hidden" name="user" value="<?php echo $user;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                        <input type="hidden" name="id" value="<?php echo $Fproduct["ID"];?>">
                        <input type="submit" value="変更する">
                    </form>
<?php
                    }
?>
                    <form action="select.php" method="get">
                        <input type="hidden" name="user" value="<?php echo $user;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                        <input type="submit" value="一覧に戻る">
                    </form>
                    </span>
                </div>

            </div>
        </div>
