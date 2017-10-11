<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Carpoolerz: Login</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
        <link href="main.css" rel="stylesheet" />
    </head>

    <body>
        <div class="container-fluid">
            <br/>
            <div class="panel panel-default">
                <h1 class="text-center">Log Into Carpoolerz</h1>
                <form role="form" action="login.php" method="post" name="login-form">
                    <div class="form-group">
                        <label for="username">Username: </label>
                        <input type="text" name="username" required class="form-control" id="usr" placeholder="Username"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" name="password" required class="form-control" id="pwd" placeholder="Password"/>
                    </div>
                    <button type="submit" name="userLogin" class="form-control btn btn-primary">Login as a User</button>
                    <br />
                    <br />
                    <button type="submit" name="adminLogin" class="form-control btn btn-danger">Login as a Admin</button>
                    <br />
                </form>
            </div>
        </div>

        <?php
        session_start();
        $dbconn = pg_connect("host=localhost port=5432 dbname=carpoolerz user=postgres password=postgres")
        or die('Could not connect: ' . pg_last_error());

        if(isset($_POST['userLogin'])) {

            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $username = $_SESSION['username'];
            $password = $_SESSION['password'];

            $query = /** @lang text */
                "SELECT * FROM systemuser WHERE username = '$username' AND password = '$password'";

            $result = pg_query($dbconn, $query);

            if (pg_num_rows($result) == 1) {
                ob_start();
                header("Location: ./user/user-profile.php");
                ob_end_flush();
            }
        }

        //    if(isset($_POST['adminLogin'])) {
        //
        //        if (pg_num_rows($result) == 1) {
        //            $_SESSION['username'] = $username;
        //            $_SESSION['password'] = $password;
        //            $_SESSION['is_admin'] = $is_admin;
        //
        //            ob_start();
        //            header("Location: ./admin/admin.php");
        //            ob_end_flush();
        //
        //        }
        //    }

        ?>

    </body>
</html>