<?php
    session_start();
    $_SESSION['id'] = $_GET['id'];
    $_SESSION['fid'] = "";
?>

<html>
    <head>
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/cover.css" rel="stylesheet">
        <link href="css/jumbotron-narrow.css" rel="stylesheet">
        <link href="css/global.css" rel="stylesheet">
        <style id="holderjs-style" type="text/css"></style>
        <script type="text/javascript" src="js/jquery-2.1.0.js"></script>
    </head>
    <body>
        <?php
            $host  = "host=localhost";
            $port  = "port=5432";
            $dbname  = "dbname=mydb";
            $credentials = "user=postgres password=tiger";
            $db = pg_connect( "$host $port $dbname $credentials"  );
         ?>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid" style="background-color: #ec971f; box-shadow: 5px 5px 5px #888">
            <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="color: #080808; font-family: fantasy; font-size: 30px" href="http://getbootstrap.com/examples/dashboard/#">SongBase</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" style="margin-right: 50px">
                <li><a href="about.php?id=<?php echo $_GET["id"] ?>&fid=">About</a></li>
                <li><a href="home.php?id=<?php echo $_GET["id"] ?>&play=<?php $rd = rand(3279, 4918); echo "$rd"?>">Home</a></li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">&uhblk;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="profile.php?id=<?php echo $_GET["id"] ?>&fid=">Profile</a></li>
                    <li><a href="friends.php?id=<?php echo $_GET["id"] ?>&fid=">Friends</a></li>
                  <li><a href="#">Settings</a></li>
                  <li><a href="<?php $sql = "update users set user_status = 0 where user_id = ". $_GET['id'].";";
            pg_query($db, $sql); ?> signin.php">LogOut</a></li>
                  <li class="divider"></li>
                  <li><a href="about.php?id=<?php echo $_GET["id"] ?>&fid=">Help</a></li>
                </ul>
              </li>
          </ul>
            <div class="col-lg-6" style="margin-top: 10px; width: 800px; margin-left: 100px">
                <form class="navbar-form navbar-left" role="search" action="search.php">
                    <div class="form-group">
                        <input name="search" type="text" class="form-control" placeholder="Search" style="width: 600px">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
          </div>
        </div>
      </div>
    </div>
        <div class="col-sm-3 col-md-2 sidebar" style="background-color: #285e8e">
            <ul class="nav nav-sidebar">
                <li class="dropdown" style="margin-top: 20px">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Artists<span class="caret"></span></button>
                    <ul class="dropdown-menu" style="height: auto; max-height: 300px; width: 200px; overflow-x: hidden">
                        <?php
                            $sql = "select artist_id, artist_name from artist order by artist_score desc;";
                            $ret = pg_query($db, $sql);
                            if(!$ret){
                                echo pg_last_error($db);
                                exit;
                            }
                            while($row = pg_fetch_row($ret)){
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_GET['id'] . "&type=artist&result=$row[0]&searcht=";
                                echo "<li><a href = $tmp id = 'artist'>". $row[1]. "</a></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li class="dropdown" style="margin-top: 30px">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Albums <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="height: auto; max-height: 300px; width: 200px; overflow-x: hidden">
                        <?php
                            $sql = "select album_id, album_name from album order by album_score desc;";
                            $ret = pg_query($db, $sql);
                            if(!$ret){
                                echo pg_last_error($db);
                                exit;
                            }
                            while($row = pg_fetch_row($ret)){
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_GET['id'] . "&type=album&result=$row[0]&searcht=";
                                echo "<li><a href= $tmp id = 'album'>". $row[1]. "</a></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li class="dropdown" style="margin-top: 40px">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Genres <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="height: auto; max-height: 300px; width: 200px; overflow-x: hidden">
                        <?php
                            $sql = "select genre_id, genre_name from genre order by genre_score desc;";
                            $ret = pg_query($db, $sql);
                            if(!$ret){
                                echo pg_last_error($db);
                                exit;
                            }
                            while($row = pg_fetch_row($ret)){
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_GET['id'] . "&type=genre&result=$row[0]&searcht=";
                                echo "<li><a href=$tmp id = 'genre'>". $row[1]. "</a></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="#" style="font-size: 15px; margin-top: 30px">Feedback</a></li>
            </ul>
        </div>
        <div id="content" class="clearfix">
        <section id="left">
            <div id="userStats" class="clearfix" style="height: 300px">
                <div class="pic">
                    <a href="#"><img src="img/friend_avatar_default.jpg" width="150" height="150" /></a><br/><br/>
                    <?php
                        if($_GET['fid'] != ""){
                            $sql = "select * from followings where id1=".$_GET['id']."and id2=".$_GET['fid'];
                            $ret = pg_query($db, $sql);
                            $t = "http://localhost/DBMS/follow.php?idd=".$_GET['id']."&fidd=".$_GET['fid'];
                            if(pg_fetch_row($ret)){
                                $chk = "Following";
                            }else{
                                $chk = "Follow";
                            }
                            echo "<button name='follow' type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='display: inline; background-color: #31b0d5; font-size: 20px; font-weight: 5px'><a href=$t>$chk</a></button>";
                        }
                        ?>
                </div>
                <div class="data" style="height: 270px">
                    <h1><?php
                        if($_GET["fid"] == ""){
                            $id = $_GET["id"];
                        }else{
                            $id = $_GET["fid"];
                        }
                        $sql = "select user_fname, user_lname from users where user_id = $id;";
                        $ret = pg_query($db, $sql);
                        $row = pg_fetch_row($ret);
                        echo "$row[0]"." "."$row[1]";
                    ?></h1>
                    <h3>IIT Delhi</h3>
                    <h4><a href='#'><?php
                        if($_GET["fid"] == ""){
                            $id = $_GET["id"];
                        }else{
                            $id = $_GET["fid"];
                        }
                        $sql = "select user_email from users where user_id = $id;";
                        $ret = pg_query($db, $sql);
                        $row = pg_fetch_row($ret);
                        echo "$row[0]";
                    ?></a></h4>
                    <div class="sep"></div>
                    <ul class="numbers clearfix">
                        <li>Songs Rated<strong>185</strong></li>
                        <li>Best Rated<strong>344</strong></li>
                        <li class="nobrdr">Worst Rated<strong>127</strong></li>
                    </ul>
                </div>
            </div>
            <h1>About Me:</h1>
            <p>Nice to meet you.</p>
        </section>
    <section id="right">
    <div class="gcontent">
        <div class="head"><h1>Friends List</h1></div>
        <div class="boxy">
                <p>Your friends - <?php
                    if($_GET["fid"] == ""){
                        $id = $_GET["id"];
                    }else{
                        $id = $_GET["fid"];
                    }
                    $sql = "select count(*) from followings where id1 = ".$id;
                    $ret = pg_query($db, $sql);
                    $row = pg_fetch_row($ret);
                    echo $row[0];
                ?> total</p>
                <div class="friendslist clearfix">
                    <?php
                        if($_GET["fid"] == ""){
                            $id = $_GET["id"];
                        }else{
                            $id = $_GET["fid"];
                        }
                        $sql = "select user_fname, user_lname, id2 from user_follow where id1 =".$id;
                        $ret = pg_query($db, $sql);
                        for($i = 0; $i < 6; $i++){
                            $row = pg_fetch_row($ret);
                            $temp = "http://localhost/DBMS/profile.php?id=".$_GET["id"]."&fid=".$row[2];
                            echo "<div class='friend'>
                                <a href='#'><img src='imgs/friend_avatar_default.jpg' width='40' height='40' /></a><span class='friendly'><a href='$temp'>$row[0] $row[1]</a></span>
                                </div>";
                        }
                    ?>
                </div>
                <span><?php
                $temp = "http://localhost/DBMS/friends.php?id=".$_GET["id"]."&fid=".$_GET["fid"];
                echo "<a href=$temp>See all...</a>";
                ?></span>
            </div>
            </div>
            </section>
        </div>
    </body>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</html>
