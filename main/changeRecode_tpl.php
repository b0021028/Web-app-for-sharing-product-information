<?php
//$success $user $password $user_name ($Fproduct : if $success is true)
//
require_once __DIR__.'/common/functions.php';
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>変更・消去</title>
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
                    <form action="updateProduct.php" method="post">
                        <input type="hidden" name="user" value="<?php echo $user;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                        <input type="hidden" name="id" value="<?php echo $product_id;?>">
                        <!--label>種類 : <input autofocus type="search" name="type" autocomplete="on" list="type" value="" required>
                            <datalist id="type"></datalist>
                        </label-->
                        <label>種類 : <select autofocus name="type" required>
                                <option hidden value="<?php echo $product["TYPE_ID"];?>"><?php echo htmEsc($product["TYPE"]);?></option><?php
                                foreach ($types as $row){
                                    print('<option value='.$row["TYPE_ID"].'>'.htmEsc($row["NAME"]).'</option>');
                                }
                            ?></select>
                        </label>

                        <label>商品名 : <input type="search" name="name" value="<?php echo htmEsc($product["NAME"]);?>" required placeholder="<?php echo htmEsc($product["NAME"]);?>"></label>

                        <label>料金 : <input type="number" name="price" value="<?php echo $product["PRICE"];?>" required>円</label>

                        <label>注文日 : <input type="date" name="order_date" value="<?php echo $product["ORDER_DATE"];?>" required></label>

                        <label>ステータス: <select name="status" required>
                                <option hidden value="<?php echo $product["STATUS_ID"]?>"><?php echo htmEsc($product["STATUS"]);?></option><?php
                                foreach ($status as $row){
                                    print('<option value='.$row["STATUS_ID"].'>'.htmEsc($row["STATUS"]).'</option>');
                                }
                            ?></select>
                        </label>

                        <label>納品日 : <input type="date" name="delivery_date" value="<?php echo $product["DELIVERY_DATE"]?>"></label>

                        <input type="reset" value="入力内容のリセット">
                        <input type="submit" value="変更">
                    </form>
                    <form style="width:fit-content" action="deleteProduct.php" onClick="return confirm('本当に消去しますか?')" method="post">
                        <input type="hidden" name="user" value="<?php echo $user;?>">
                        <input type="hidden" name="password" value="<?php echo $password;?>">
                        <input type="hidden" name="id" value="<?php echo $product_id;?>">
                        <input type="submit" value="消去" style="background-color:#f44">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
