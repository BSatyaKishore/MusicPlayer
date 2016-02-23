<html>
    <head>
        <script type="text/javascript" src="js/jquery-2.1.0.js"></script>
    </head>
<?php
        $host  = "host=localhost";
        $port  = "port=5432";
        $dbname  = "dbname=mydb";
        $credentials = "user=postgres password=tiger";
        $db = pg_connect( "$host $port $dbname $credentials");
        $email = $_GET["email"];
        $pass = $_GET["pass"];
        $sql = "select count(*) from (select * from users where user_email = '$email' and user_password = '$pass') as tmp;";
        $ret = pg_query($db, $sql);
        if(!$ret){
            echo pg_last_error($db);
            exit;
        }
        $row = pg_fetch_row($ret);
        function redirect($url, $statusCode = 303)
        {
            header('Location: ' . $url, true, $statusCode);
            die();
        }
        if($row[0] == 1){
            $sql = "select user_id from users where user_email = '$email' and user_password = '$pass';";
            $ret = pg_query($db, $sql);
            if(!$ret){
                echo pg_last_error($db);
                exit;
            }
            $row = pg_fetch_row($ret);
            $id = $row[0];
            $sql = "update users set user_status = 1 where user_id = $id;";
            $ret = pg_query($db, $sql);
            if(!$ret){
                echo pg_last_error($db);
                exit;
            }
            $randm = rand(3279, 4918);
            redirect("http://localhost/DBMS/home.php?id=$id&fid=&play=$randm" , 303);
        }else{
            $sql = "select count(*) from (select * from users where user_email = '$email') as tmp;";
            $ret = pg_query($db, $sql);
            if(!$ret){
                echo pg_last_error($db);
                exit;
            }
            $row = pg_fetch_row($ret);
            if($row[0] === 1){
            ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    var r = confirm("Guess! You have forgotten your password");
                    if(r){
                        window.location.href = "http://localhost/DBMS/forgot.php";
                    }else{
                        window.location.href = "http://localhost/DBMS/signin.php";
                    }
                });
                        </script> <?php
            }else{
                ?>
                <script type="text/javascript">
                $(document).ready(function(){
                    var r = confirm("Guess! You need to SignUp");
                    window.location.href = "http://localhost/DBMS/signin.php";
                });
                        </script> <?php
            }
        }
        ?>
</html>