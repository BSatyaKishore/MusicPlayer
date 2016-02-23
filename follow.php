<?php
    $host  = "host=localhost";
    $port  = "port=5432";
    $dbname  = "dbname=mydb";
    $credentials = "user=postgres password=tiger";
    $db = pg_connect("$host $port $dbname $credentials");
    $sql = "insert into followings values(".$_GET['idd'].",".$_GET['fidd'].");";
    $ret = pg_query($db, $sql);
    if(!$ret){
        echo pg_last_error($db);
        exit;
    }
    function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }
    redirect("http://localhost/DBMS/profile.php?id=".$_GET['idd']."&fid=".$_GET['fidd'], 303);
    ?>