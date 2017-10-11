<?php
	session_start();

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $is_admin = $_SESSION['is_admin'];

    $dbconn = pg_connect("host=localhost port=5432 dbname=carpoolerz user=postgres password=postgres")
                or die('Could not connect: ' . pg_last_error());

    $query = /** @lang text */
        "SELECT * FROM systemuser WHERE '$username' = username AND '$password' = password AND is_admin = TRUE";

    $result = pg_query($dbconn, $query);

    if (pg_num_rows($result) == 0) {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include 'common/header.shtml'; ?>
    </head>

    <body>
        <?php include 'common/navbar-authenticated.shtml'; ?>

        <?php

        ?>

        <div class=container>
            <!-- Display all user information -->
            <h1>User Information</h1>
            <table class="table table-striped table-hover custom-table">
                <thead class="thead-inverse">
                <tr>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Password</th>
                    <th>License Number</th>
                    <th>Is Admin</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = 'SELECT * FROM systemuser';
                $result = pg_query($query);
                while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    echo "\t<tr>\n";
                    foreach ($line as $col_value) {
                        echo "\t\t<td>$col_value</td>\n";
                    }
                    echo "\t</tr>\n";
                }
                ?>
                </tbody>
            </table>

            <br>
            <


            <div class=container>
                <!-- Display all current driver offered rides -->
                <h1>Rides Information</h1>
                <table class="table table-striped table-hover custom-table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Ride ID</th>
                        <th>Car Plate No.</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = 'SELECT * FROM ride';
                    $result = pg_query($query);
                    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                        echo "\t<tr>\n";
                        foreach ($line as $col_value) {
                            echo "\t\t<td>$col_value</td>\n";
                        }
                        echo "\t</tr>\n";
                    }
                    ?>
                    </tbody>
                </table>

                <!-- Display all bids -->
                <h1>All Bids</h1>
                <table class="table table-striped table-hover custom-table">
                    <thead class="thead-inverse">
                    <tr>
                        <th>Amount</th>
                        <th>Ride ID</th>
                        <th>Passenger</th>
                        <th>Success</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = 'SELECT * FROM bid';
                    $result = pg_query($query);
                    while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
                        echo "\t<tr>\n";
                        foreach ($line as $col_value) {
                            echo "\t\t<td>$col_value</td>\n";
                        }
                        echo "\t</tr>\n";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>

        <?php include 'common/footer.shtml'; ?>
    </body>

</html>
