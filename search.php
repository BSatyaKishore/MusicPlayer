<?php
    session_start();
    ?>

<html>
    <head>
        <title>SongBase</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/cover.css" rel="stylesheet">
        <link href="css/jumbotron-narrow.css" rel="stylesheet">
        <link href="css/global.css" rel="stylesheet">
        <link href="css/estilos.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery-2.1.0.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <style id="holderjs-style" type="text/css"></style>
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
              <li><a href="about.php?id=<?php echo $_SESSION["id"]; ?>&fid=">About</a></li>
              <li><a href="home.php?id=<?php echo $_SESSION["id"]; ?>&play=<?php $rd = rand(3279, 4918); echo "$rd"?>">Home</a></li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">&uhblk;<b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="profile.php?id=<?php echo $_SESSION["id"]; ?>&fid=">Profile</a></li>
                    <li><a href="friends.php?id=<?php echo $_SESSION["id"]; ?>&fid=">Friends</a></li>
                  <li><a href="#">Settings</a></li>
                  <li><a href="<?php $sql = "update users set user_status = 0 where user_id = ". $_SESSION['id'].";";
            pg_query($db, $sql); ?> signin.php">LogOut</a></li>
                  <li class="divider"></li>
                  <li><a href="about.php?id=<?php echo $_SESSION["id"]; ?>&fid=">Help</a></li>
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
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_SESSION['id'] . "&type=artist&result=$row[0]&searcht=";
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
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_SESSION['id'] . "&type=album&result=$row[0]&searcht=";
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
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_SESSION['id'] . "&type=genre&result=$row[0]&searcht=";
                                echo "<li><a href=$tmp id = 'genre'>". $row[1]. "</a></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="#" style="font-size: 15px; margin-top: 30px">Feedback</a></li>
            </ul>
        </div>
        <?php
            if(strtolower($_GET['search']) == "songs i like"){
                $sql = "select * from user_album_song_score where user_id=".$_SESSION['id']."order by user_song_score desc";
                $ret = pg_query($db, $sql);
                echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                <ul id='musicCategories' id='songs'>";
                while ($row = pg_fetch_row($ret)){
                    $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[1]";
                    echo "<li class='slide' style='margin-left: 00px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[1] Song: $row[2], Album: $row[3]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                }
                echo "</ul></article>";
            }else{
                if(strtolower($_GET['search']) == "songs my friends like"){
                    $sql = "select * from user_follow_album_song_acore where user_id=".$_SESSION['id']."order by user_song_score desc";
                    $ret = pg_query($db, $sql);
                    echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                    <ul id='musicCategories' id='songs'>";
                    while ($row = pg_fetch_row($ret)){
                        $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[1]";
                        echo "<li class='slide' style='margin-left: 00px'>
                    <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                        <p style='color: black'>$row[1] Song: $row[2], Album: $row[3]</p>
                        <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                    </li>";
                    }
                    echo "</ul></article>";
                }else{
                    if(strtolower($_GET['search']) == "top songs"){
                        $sql = "select song_id, song_name, album_name from songs, album where songs.album_ind = album.album_id order by song_score desc";
                        $ret = pg_query($db, $sql);
                        echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                        <ul id='musicCategories' id='songs'>";
                        while ($row = pg_fetch_row($ret)){
                            $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                            echo "<li class='slide' style='margin-left: 00px'>
                        <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                            <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                            <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                        </li>";
                        }
                        echo "</ul></article>";
                    }else{
                        if(strtolower($_GET['search']) == "top albums"){
                            $sql = "select song_id, song_name, album_name from songs, album where songs.album_ind = album.album_id order by album_score desc";
                            $ret = pg_query($db, $sql);
                            echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                            <ul id='musicCategories' id='songs'>";
                            while ($row = pg_fetch_row($ret)){
                                $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                                echo "<li class='slide' style='margin-left: 00px'>
                            <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                                <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                                <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                            </li>";
                            }
                            echo "</ul></article>";
                        }else{
                            if(strtolower($_GET['search']) == "top artists"){
                                $sql = "select song_id, song_name, artist_name from songs, artist where songs.artist_ind = artist.artist_id order by artist_score desc";
                                $ret = pg_query($db, $sql);
                                echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                                <ul id='musicCategories' id='songs'>";
                                while ($row = pg_fetch_row($ret)){
                                    $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                                    echo "<li class='slide' style='margin-left: 00px'>
                                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                                    <p style='color: black'>$row[0] Song: $row[1], Artist: $row[2]</p>
                                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                                </li>";
                                }
                                echo "</ul></article>";
                            }else{
                                if(strtolower($_GET['search']) == "artists i like"){
                                    $sql = "select song_id, song_name, artist_name from songs, user_artist_scores, artist where songs.artist_ind = artist.artist_id order by user_artist_score desc";
                                    $ret = pg_query($db, $sql);
                                    echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                                    <ul id='musicCategories' id='songs'>";
                                    while ($row = pg_fetch_row($ret)){
                                        $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                                        echo "<li class='slide' style='margin-left: 00px'>
                                    <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                                        <p style='color: black'>$row[0] Song: $row[1], Artist: $row[2]</p>
                                        <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                                    </li>";
                                    }
                                    echo "</ul></article>";
                                }else{
                                    if(strtolower($_GET['search']) == "albums i like"){
                                        $sql = "select song_id, song_name, album_name from songs, user_album_scores, album where songs.album_ind = album.album_id order by user_album_score desc";
                                        $ret = pg_query($db, $sql);
                                        echo "<article id='division2' style='margin-right: 600px; margin-top: 100px'>
                                        <ul id='musicCategories' id='songs'>";
                                        while ($row = pg_fetch_row($ret)){
                                            $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                                            echo "<li class='slide' style='margin-left: 00px'>
                                        <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                                            <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                                            <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                                        </li>";
                                        }
                                        echo "</ul></article>";
                                    }else{
            $sql1 = "select user_id, user_fname, user_lname from users where user_fname  ilike '%".$_GET['search']."%' or user_lname ilike '%". $_GET['search']."%';";
            $sql2 = "select song_id, song_name, album_name from songs_albums where song_name ilike '%".$_GET['search']."%';";
            $sql3 = "select song_id, song_name, album_name from songs_albums where album_name ilike '%".$_GET['search']."%';";
            $sql4 = "select song_id, song_name, artist_name from songs_artists where artist_name ilike '%".$_GET['search']."%';";
            $sql5 = "select * from (select id2, user_fname, user_lname from user_follow where id1=".$_SESSION['id']. ") as foo where user_fname  ilike '%".$_GET['search']."%' or user_lname ilike '%". $_GET['search']."%';";
            $ret1 = pg_query($db, $sql1);
            $ret2 = pg_query($db, $sql2);
            $ret3 = pg_query($db, $sql3);
            $ret4 = pg_query($db, $sql4);
            $ret5 = pg_query($db, $sql5);
                                }
                            }
                        }
                    }
                }
            }
            }
            ?>
        <div class='container' style='margin-top: 70px'>
            <div>
                <ul class='nav nav-tabs' id='myTab'>
                  <li class='active'><a href='http://www.bootply.com/render/85850#All' data-toggle='tab'>All</a></li>
                  <li class=''><a href='http://www.bootply.com/render/85850#Users' data-toggle='tab'>All Users</a></li>
                  <li class=''><a href='http://www.bootply.com/render/85850#Friends' data-toggle='tab'>Only Friends</a></li>
                  <li class=''><a href='http://www.bootply.com/render/85850#Songs' data-toggle='tab'>Only Songs</a></li>
                  <li class=''><a href='http://www.bootply.com/render/85850#Albums' data-toggle='tab'>Only Albums</a></li>
                  <li class=''><a href='http://www.bootply.com/render/85850#Artists' data-toggle='tab'>Only Artists</a></li>
                </ul>                
                <div class='tab-content'>
                  <div class='tab-pane active' id='All'>
                    <article id='division2' style='margin-right: 600px'>
                <ul id='musicCategories' id='songs'>
                    <?php
                    while($row = pg_fetch_row($ret1)){
                    $sql = "select * from followings where id1=".$_SESSION['id']."and id2=".$row[0];
                    $ret = pg_query($db, $sql);
                    if(pg_fetch_row($ret)){
                        $chk = "Following";
                    }else{
                        $chk = "Follow";
                    }
                    $tmpp = "http://localhost/DBMS/profile.php?id=" . $_SESSION['id'] . "&fid=$row[0]";
                    echo "<div style='background-color: #fff; border-radius: 5px; margin-left: 400px; width: 400px'>
                        <div class='clearfix' style='display: inline'>
                    <div class='friend' style='display: inline'>
                        <a href='#'><img src='imgs/friend_avatar_default.jpg' width='40' height='40'/></a><span class='friendly'><a href='$tmpp'>$row[1] $row[2]</a></span>
                    </div>
                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='display: inline; background-color: #31b0d5; font-size: 20px; font-weight: 5px; margin-left: 20px'>$chk</button>
                    </div></div><br/>";
                    }
                    echo "<br/><br/>";
                    while($row = pg_fetch_row($ret2)){
                    $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                    echo "<li class='slide' style='margin-left: 300px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                    }
                    while($row = pg_fetch_row($ret3)){
                    $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                    echo "<li class='slide' style='margin-left: 300px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                    }
                    while($row = pg_fetch_row($ret4)){
                    $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                    echo "<li class='slide' style='margin-left: 300px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[0] Song: $row[1], Artist: $row[2]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                    }
                    ?>
                </ul>
                    </article>
                  </div>
		  <div class='tab-pane' id='Users'>
                      <article id='division2' style='margin-right: 600px'>
                <ul id='musicCategories' id='songs'>
                      <?php
                            $ret1 = pg_query($db, $sql1);  
                            while($row = pg_fetch_row($ret1)){
                            $sql = "select * from followings where id1=".$_SESSION['id']."and id2=".$row[0];
                            $ret = pg_query($db, $sql);
                            if(pg_fetch_row($ret)){
                                $chk = "Following";
                            }else{
                                $chk = "Follow";
                            }
                            $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&follow=$row[0]";
                            echo "<div style='background-color: #fff; border-radius: 5px; margin-left: 400px; width: 400px'>
                        <div class='clearfix' style='display: inline'>
                    <div class='friend' style='display: inline'>
                        <a href='#'><img src='imgs/friend_avatar_default.jpg' width='40' height='40'/></a><span class='friendly'><a href='$tmpp'>$row[1] $row[2]</a></span>
                    </div>
                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='display: inline; background-color: #31b0d5; font-size: 20px; font-weight: 5px; margin-left: 20px'>$chk</button>
                    </div></div><br/>"; 
                            }
                          ?>
                </ul>
                      </article>
                  </div>
                    <div class='tab-pane' id='Friends'>
                      <article id='division2' style='margin-right: 600px'>
                <ul id='musicCategories' id='songs'>
                      <?php
                            $ret5 = pg_query($db, $sql5);  
                            while($row = pg_fetch_row($ret5)){
                            $sql = "select * from followings where id1=".$_SESSION['id']."and id2=".$row[0];
                            $ret = pg_query($db, $sql);
                            if(pg_fetch_row($ret)){
                                $chk = "Following";
                            }else{
                                $chk = "Follow";
                            }
                            $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&follow=$row[0]";
                            echo "<div style='background-color: #fff; border-radius: 5px; margin-left: 400px; width: 400px'>
                        <div class='clearfix' style='display: inline'>
                    <div class='friend' style='display: inline'>
                        <a href='#'><img src='imgs/friend_avatar_default.jpg' width='40' height='40'/></a><span class='friendly'><a href='$tmpp'>$row[1] $row[2]</a></span>
                    </div>
                    <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' style='display: inline; background-color: #31b0d5; font-size: 20px; font-weight: 5px; margin-left: 20px'>$chk</button>
                    </div></div><br/>"; 
                            }
                          ?>
                </ul>
                      </article>
                  </div>
                  <div class='tab-pane' id='Songs'>
                      <article id='division2' style='margin-right: 600px'>
                <ul id='musicCategories' id='songs'>
                      <?php
                        $ret2 = pg_query($db, $sql2);
                        while($row = pg_fetch_row($ret2)){
                        $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                        echo "<li class='slide' style='margin-left: 300px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                        }
                        ?>
                </ul>
                      </article>
                  </div>
                  <div class='tab-pane ' id='Albums'>
                      <article id='division2' style='margin-right: 600px'>
                <ul id='musicCategories' id='songs'>
                      <?php
                        $ret3 = pg_query($db, $sql3);
                        while($row = pg_fetch_row($ret3)){
                        $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                        echo "<li class='slide' style='margin-left: 300px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[0] Song: $row[1], Album: $row[2]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                        }
                        ?>
                </ul>
                      </article>
                  </div>
                  <div class='tab-pane ' id='Artists'>
                      <article id='division2' style='margin-right: 600px'>
                <ul id='musicCategories' id='songs'>
                      <?php
                        $ret4 = pg_query($db, $sql4);
                        while($row = pg_fetch_row($ret4)){
                        $tmpp = "http://localhost/DBMS/home.php?id=" . $_SESSION['id'] . "&play=$row[0]";
                        echo "<li class='slide' style='margin-left: 300px'>
                <img src='imgs/albumart.jpg' alt='slide1'  class='slideimg'>
                    <p style='color: black'>$row[0] Song: $row[1], Artist: $row[2]</p>
                    <div class='btn' id = 'listen'><a href=$tmpp>Listen</a></div>
                </li>";
                        }
                        ?>
                        </ul>
                      </article>
                  </div>
                </div>
              	</div>
            </div>
        </body>
</html>