<?php
        $host  = "host=localhost";
        $port  = "port=5432";
        $dbname  = "dbname=mydb";
        $credentials = "user=postgres password=tiger";
        $db = pg_connect( "$host $port $dbname $credentials");
        $emailn = $_GET["emailn"];
        $passn = $_GET["passn"];
        $sqln = "update users set user_password = '$passn' where user_email = '$emailn';";
        $ret = pg_query($db, $sqln);
        if(!$ret){
            echo pg_last_error($db);
            exit;
        }
        function redirect($url, $statusCode = 303)
        {
            header('Location: ' . $url, true, $statusCode);
            die();
        }
        redirect("http://localhost/DBMS/signin.php", 303);
        ?>