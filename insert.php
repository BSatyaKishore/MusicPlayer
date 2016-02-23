<html>
    <head>
        <script type="text/javascript" src="js/jquery-2.1.0.js"></script>
    </head>
    <body>
        <?php
        $host  = "host=localhost";
        $port  = "port=5432";
        $dbname  = "dbname=mydb";
        $credentials = "user=postgres password=tiger";
        $db = pg_connect( "$host $port $dbname $credentials");
        $fname = $_GET["fname"];
        $lname = $_GET["lname"];
        $emaill = $_GET["emaill"];
        $passs = $_GET["passs"];
        $sqll = "select count(*) from (select * from users where user_email = '$emaill') as tmp;";
        $rett = pg_query($db, $sqll);
        if(!$rett){
            echo pg_last_error($db);
            exit;
        }
        function redirect($url, $statusCode = 303)
        {
            header('Location: ' . $url, true, $statusCode);
            die();
        }
        $row = pg_fetch_row($rett);
        if($row[0] == 1){
            ?> <script type="text/javascript">
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
            $sql = "insert into users(user_id, user_email, user_password, user_fname, user_lname) values (1002, '$emaill', '$passs', '$fname', '$lname');";
            $ret = pg_query($db, $sql);
            if(!$ret){
                echo pg_last_error($db);
                exit;
            }
            redirect('http://localhost/DBMS/signin.php', 303);
        }
        ?>
    </body>
</html>