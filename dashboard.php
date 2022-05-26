<?php
session_start();
if (!isset($_SESSION['user'])){
    header('Location: index.php');
}
$userId = (int)$_SESSION['user']['id'];
include_once 'model/Vehicle.php';
$vehicle = new Vehicle($userId);
$vehicleList = $vehicle->get();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Booking</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.css"
    rel="stylesheet"
    />
    <!-- MDB -->
    <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.1.0/mdb.min.js"
    ></script>
    <script
    type="text/javascript"
    src="assets/js/vehicle.js"
    ></script>
    <link href="assets/css/vehicle.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="assets/css/index.css" rel="stylesheet">

</head>
<body>
       <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mybooking.php">My Booking</a>
        </li>

      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

    <!-- Right elements -->
    <div class="d-flex align-items-center">
      <!-- Avatar -->
      <div class="dropdown">
        <!-- Avatar -->
        <div class="dropdown">
          <a class="btn btn-danger" id="logout-user">Logout</a>
        </div>
      </div>
    </div>
    <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->
<div class="container">
    <div class="text-center mb-5">
      <h3>Vehicle Booking</h3>
      <p class="lead">Book yourself safe ride</p>
    </div>
    <?php if (!empty($vehicleList)){
        foreach($vehicleList as $key => $value){?>
            <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex flex-column flex-lg-row">
                <span class="avatar avatar-text rounded-3 me-4 mb-2">
                    <?php echo ($value['type'] == '2') ? '<i class="fa fa-motorcycle" aria-hidden="true"></i>' : '<i class="fa fa-car" aria-hidden="true"></i>'; ?>
                </span>
                <div class="row flex-fill">
                    <div class="col-sm-5">
                    <h4 class="h5"><?= ucwords($value['name'])?></h4>
                    <span class="badge bg-secondary"><?= strtoupper($value['number'])?></span> <span class="badge bg-success"><?= strtoupper($value['company'])?></span>
                    </div>
                    <div class="col-sm-4 py-2">
                      <label for=""><span class="badge bg-black">Owner:</label>
                    <span class="badge bg-primary"><?= ucwords($value['owner_name'])?></span>
                    </div>
                    <div class="col-sm-3 text-lg-end">
                    <a class="btn btn-primary stretched-link book-vehicle" data-vehicle-id="<?= $value['id']?>"><span>Book</span></a>
                    </div>
                </div>
                </div>
            </div>
            </div>
    <?php
    }
    }?>
  </div>
<!-- Add Modal HTML -->
<div id="bookVehicle" class="modal fade" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
    <span class="error d-none already-booked"></span>
			<form id="bookingForm" method="post">
        <input type="hidden" name="vehicleId" id="vehicleId" value="">
        <input type="hidden" name="action" value="book_vehicle">
				<div class="modal-header">
					<h4 class="modal-title">Book Vehicle</h4>
					<button type="button" class="close clear-add-form" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Start Date:</label>
						<input type="text" name="startDate" id="startDate" class="bookingDate startDate">
            <span class="error d-none"></span>
					</div>
					<div class="form-group">
						<label>End Date:</label>
						<input type="text" name="endDate" id="endDate" class="bookingDate endDate">
            <span class="error d-none"></span>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default clear-add-form" data-dismiss="modal" value="Cancel">
					<input type="button" class="btn btn-success" id="bookVehicleSubmit" value="Confirm Booking">
				</div>
			</form>
		</div>
	</div>
</div>



</body>
</html>