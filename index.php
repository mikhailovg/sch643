
<?php
//точка входа для всех запросов от пользователя
//запрос от пользователя приходит в виде:
//http://<host>/index.php?route=[urlFromUserRequest]
//user request : http://example.com/admin/getPages будет преобразован в следующее:
//http://example.com/index.php?route=admin%2FgetPages
include("./controller/DataStore.php");





    $requestMethod=$_SERVER['REQUEST_METHOD'];
    if($requestMethod==="GET"){
        $userRequestUrl=$_GET["route"];
        $params=new DataStore();
        foreach($_GET as $key => $value){
            $params->set($key,$value);
        }
        delegateRequest($userRequestUrl,$params);
    }else if($requestMethod==="POST"){
        $userRequestUrl=$_POST["route"];
        $params=new DataStore();
        foreach($_POST as $key => $value){
          //  echo "set param ".$key." = ".$value;
            $params->set($key,$value);
        }
        delegateRequest($userRequestUrl,$params);
    }

    //echo $userRequestUrl;


    function delegateRequest( $userRequestUrl,$params){
        $host='localhost';
        $database='school';
        $user='root';
        $pswd='';
        $db=new mysqli($host, $user, $pswd, $database);
        $db -> set_charset("utf8");
        $settings=new DataStore();
        $settings->set("db",$db);
        if($userRequestUrl!=null){
            $urlParts=explode("/",$userRequestUrl);
            //echo $urlParts[0]."\n";
            //echo $urlParts[1];
            if(strpos($urlParts[0],"admin")!==FALSE){
                include("./controller/AdminController.php");
                $adminController=new AdminController($settings);
                $adminController->$urlParts[1]();
            }else if(strpos($urlParts[0],"user")!==FALSE){
                include("./controller/UserController.php");
                $userController=new UserController($settings);
                $userController->$urlParts[1]($params);
            }

        }

    }