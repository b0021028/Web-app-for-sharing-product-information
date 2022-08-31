# Web-app-for-sharing-product-information
#### using language :
  - PHP 8.1.2 (cli)
  - Apache/2.4.52 (Win64)
  - mysql  Ver 15.1 Distrib 10.4.22-MariaDB, for Win64 (AMD64)
  - html + javascript + css
###### I am using xampp v8.1.2 and vscode for development (by b0021028)
----
- ## How to trial use
  - Step 1
    - Get and install mysql&apach (or others with (mysql and apach) such as xampp).
  
  - Step 2
    - Create a table in mysql by referring to  "sqlcreate.sql".
    - Create a table in mysql by referring to "masterdata example.sql".
  
  - Step 3
    - Put the "main" directory in place, start apache, and open index.html inside the "main" directory with apache in your browser.

---
- ## Workflow
- ### login ~ view 
  - ~ START ~ 
  - main/index.html or main/login.html
   --- user login form.
   
   &#8595; (url request) form action "ログイン". | missing login. &#8593; 
  - main/login.php
  --- login & get user property.
 
  &#8595; (server side)  login success.
  - main/viewSelect.php
  --- get data of products (rough info)(not clear :-( ) .
  - main/viewSelect_tpl_2.php
  --- html template for view product data.
  
  &#8595; return template
  - (client) (client url :: main/login.php?xxx)

  &#8595;  (+main/js/vsel.js) ajax(Fetch API) get request
  - main/ajax/select.php

  &#8595; return json
  &#8595; Format with javascript from json to html tags
  - (client) can see products
  - ~ END ~
 
- ### view ~ create product 
  - ~ START ~ 
  -    (client) can see products
   (client url :: main/login.php?xxx or main/select.php?xxx)

  &#8595; form action "追加"
  - 
  - ~ END ~
- ### view ~ create product 
  - ~ START ~ 
  -    (client) can see products
   (client url :: main/login.php?xxx or main/select.php?xxx)

  &#8595; form action "追加" (post)
  - main/newProductForm.php
  - main/newProduct_tpl.php

  &#8595; return template
  - (client) set new product data

  &#8595; form action "送信" (post) | Not enough data &#8593;
  - main/newProduct.php
  - main/AfterExcution.php
  ---common result template

  &#8595; return template
  - (client)
    \| -> if form action "新規作成" continue workfrow "view ~ create product" 
    \| -> if form action "変更" "update this recode" 

  &#8595; if form action "一覧に戻る"
  - main/select.php
  - ~ END ~


  ###### I ran out of energy for now...
