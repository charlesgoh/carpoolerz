<?php
	session_start();
	
	$username = $_SESSION['username'];
	$password = $_SESSION['password'];
	
	$dbconn = pg_connect("host=localhost port=5432 dbname=carpoolerz user=postgres password=postgres")
	or die('Could not connect: ' . pg_last_error());
	
	$query = /** @php text */
	"SELECT * FROM systemuser s WHERE '$username' = s.username AND '$password' = s.password AND s.is_admin = 'TRUE'";
	
	$result = pg_query($dbconn, $query);
	
	if (pg_num_rows($result) == 0) {
		header("Location: /carpoolerz/login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
	
	<head>
		<?php include '../header.shtml'; ?>
		<?php include 'admin-navbar.shtml'; ?>
	</head>
	
	<body>
		<div class=container>
			<h1>Bids</h1>
			<p>
				<a href="create_bid.php" class="btn btn-success">Create A Bid</a>
			</p>
		</div>
		<div class=container>
			<br>
			<!-- Display all successful bids -->
			<h3 class="text-center">All Successful Bids</h3>
			<table class="table table-striped table-hover custom-table">
				<thead class="thead-inverse">
					<tr>
						<th>Relevant Ride ID</th>
						<th>Amount</th>
						<th>Passenger</th>
						<th>Driver</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query = '
						SELECT b.ride_id, b.amount, b.passenger, cr.driver
						FROM bid b, created_rides cr 
						WHERE b.ride_id = cr.ride_id AND b.success ORDER BY b.ride_id ASC;';
						$result = pg_query($query);
						while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
							echo "\t<tr>\n";
							foreach ($row as $col_value) {
								echo "\t\t<td>$col_value</td>\n";
							}
							echo "\t\t<td><a class='btn btn-primary' href='view_bid.php?ride_id=".$row['ride_id']."&passenger=".$row['passenger']."'>View</a>
							<a class='btn btn-warning' href='update_bid.php?ride_id=".$row['ride_id']."&passenger=".$row['passenger']."'>Update</a>
							<a class='btn btn-danger' href='delete_bid.php?ride_id=".$row['ride_id']."&passenger=".$row['passenger']."'>Delete</a>
							</td>\n";
							echo "\t</tr>\n";
						}
					?>
				</tbody>
			</table>
		</div>
		<div class=container>
			<br>
			<!-- Display all unsuccesful bids -->
			<h3 class="text-center">All Unsuccessful Bids</h3>
			<table class="table table-striped table-hover custom-table">
				<thead class="thead-inverse">
					<tr>
						<th>Relevant Ride ID</th>
						<th>Amount</th>
						<th>Passenger</th>
						<th>Driver</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query = '
						SELECT b.ride_id, b.amount, b.passenger, cr.driver
						FROM bid b, created_rides cr 
						WHERE b.ride_id = cr.ride_id AND NOT b.success ORDER BY b.ride_id ASC;';
						$result = pg_query($query);
						while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
							echo "\t<tr>\n";
							foreach ($row as $col_value) {
								echo "\t\t<td>$col_value</td>\n";
							}
							echo "\t\t<td><a class='btn btn-primary' href='view_bid.php?ride_id=".$row['ride_id']."&passenger=".$row['passenger']."'>View</a>
							<a class='btn btn-warning' href='update_bid.php?ride_id=".$row['ride_id']."&passenger=".$row['passenger']."'>Update</a>
							<a class='btn btn-danger' href='delete_bid.php?ride_id=".$row['ride_id']."&passenger=".$row['passenger']."'>Delete</a>
							</td>\n";
							echo "\t</tr>\n";
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</html>

