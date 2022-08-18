<!DOCTYPE html>
<html>
<head><!--https://qreat.tech/2712/-->
    <meta charset="utf-8">
    <title>ログイン!</title>
    <link rel="stylesheet" href="css/webapp.css"/>
    <script type="text/javascript" src="js/vsel.js"></script>
</head>
<body>
    <div id="app">
        <div id="header">
            
            <a>ようこそ <?php echo $user_name;?> さん</a>
        </div>
        <div id="main">
            <div id="leftcontent">
                <form action='javascript:search(0);'>
                    <input style="height: 40px;" type="search" name="search" placeholder="検索ワード入力"><br>
                    <input type="submit" value="検索">
                </form><br>
                <input type="button" value="リセット" onClick="reset();"><br><br>

                <form action="newProductForm.php" method="post">
                    <input type="hidden" name="user" value="<?php echo $user;?>">
                    <input type="hidden" name="password" value="<?php echo $password;?>">
                    <input type="submit" value="追加">

                </form><br>

            </div>

            <div id="content">
                <div id="listview"><br>
                </div>

            </div>
            <div id="rightcontent">
            </div>
        </div>

        <div id="footer">
            <div id="page">
                <input type="button" name="first" value="最初のページ" onClick="getPage(min)"/>
                <input type="button" name="back" value="前へ" onClick="movePage(-1)"/>
                <input type="button" name="next" value="次へ" onClick="movePage(+1)"/>
                <input type="button" name="last" value="最後のページ" onClick="getPage(30000000000)"/>
            </div>
        </div>
    </div>
</body>
<script>

    async function setRecodes(jsondata){
        let docElement = ajax.docElement;
        //レコードを消す
        docElement.innerHTML = "";//.toString();
        let x,key;
        //要素ブロック精製用
        let txt, div;
        for (x in jsondata["values"]){
            // 追加する内容作成
            if (jsondata["values"][x]["USERNAME"] == "<?php echo $user_name;?>"){
                txt = '<form action="changeRecode.php" method="post"><input type="hidden" name="user" value="<?php echo $user;?>"><input type="hidden" name="password" value="<?php echo $password;?>">'
                txt +=`<input type='hidden' name="id" value='${jsondata["values"][x]["ID"]}'><input type="submit", value="データを変更する"></form><br>`;
            } else {
                txt = "";
            }

            for (key in jsondata["key"]){
                txt += jsondata["key"][key];
                txt += " : ";
                if (key == "PRICE"){
                    txt += `${jsondata["type"]["currency"]["head"]} ${jsondata["values"][x][key].toLocaleString(jsondata["type"]["locate"])}${jsondata["type"]["currency"]["foot"]}`
                }else{
                    txt += jsondata["values"][x][key]||"-- - -- - -- - --";
                }
                txt +="<br>";
            }
            //要素追加
            div = document.createElement("div");
            div.className = "recode";
            div.innerHTML = txt;
            docElement.appendChild(div);
            //見た目用停止
            await sleep(200);
        }
    }

    let max = <?php echo $maxSize||0?>;
    let min = 0;
    let listview = document.getElementById("listview");
    ajax = new AjaxSelectviewer("ajax/select.php?<?php echo "user=$user&password=$password";?>", listview, setRecodes);
    function getPage(num){ajax.getRecode(num);}
    function movePage(num){ajax.getRecode(ajax.page+num);}
    function search(num){ajax.search(document.getElementsByName("search")[num].value);}
    function reset(){ajax.searchkey="";ajax.getRecode(0);}


    getPage(0);
</script>
</html>
