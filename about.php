<?php
    session_start();
    $_SESSION['id'] = $_GET['id'];
    $_SESSION['fid'] = "";
?>

<html>
    <head>
        <title>About</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/cover.css" rel="stylesheet">
        <link href="css/jumbotron-narrow.css" rel="stylesheet">
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
              <li><a href="home.php?id=<?php echo $_GET["id"] ?>&&play=<?php $rd = rand(3279, 4918); echo "$rd" ?>">Home</a></li>
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
        <div>
            <br/>
            <br/>
            <h2 style="color: black">About</h2>
            <p>This is SongBase. Thank you. Enjoy.</p>
            <p>Co-founded by <a href="http://facebook.com/deepakcool25">Deepak</a> and <a href="http://facebook.com/b.satyakishore">Satya</a> and <a href="http://facebook.com/b.satyakishore">Avinash</a></p>
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
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_GET['id'] . "&type=artist&result=$row[0]&search=";
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
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_GET['id'] . "&type=album&result=$row[0]&search=";
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
                                $tmp = "http://localhost/DBMS/songs.php?id=" . $_GET['id'] . "&type=genre&result=$row[0]&search=";
                                echo "<li><a href=$tmp id = 'genre'>". $row[1]. "</a></li>";
                            }
                        ?>
                    </ul>
                </li>
                <li class="divider"></li>
                <li><a href="#" style="font-size: 15px; margin-top: 30px">Feedback</a></li>
            </ul>
        </div>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
    </body>
</html>
