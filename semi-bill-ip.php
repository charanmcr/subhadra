<?php

include 'connect.php';
session_start();
include "check.php";
$pid = $_GET['pid'];
$tid = $_GET['tid'];
$name = $_GET['name'];
$sql = mysqli_query($con,"select distinct(token_id) as token_id,patient_id,date from patient_billing_details where patient_id='$pid' and token_id = '$tid'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title></title>
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/img/favicon.png">
	<!-- Fontfamily -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<!-- Datatables CSS -->
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
	<!-- Main CSS -->
	<link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<!-- Main Wrapper -->
	<div class="main-wrapper"> <?php include 'menu.php'; ?>
		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">
				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col">
							<h3 class="page-title">Date Wise InPatient Bill details of <?php echo strtoupper($name);?></h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="search-ipb.php">InPatient Bill Details</a></li>
								<li class="breadcrumb-item active">Date Wise InPatient Bill details</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<input type="text" id="myInput" onkeyup="searchFun()">
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="myTable" class="table table-striped">
										<thead>
											<tr>
												<th>Patient ID</th>
												<th>TOKEN ID</th>
												<th>Date</th>
												<th>BILL</th>
											</tr>
										</thead>
										<tbody> <?php
                                                    while($run = mysqli_fetch_assoc($sql))
                                                    {
														$newDate = date("d-m-Y", strtotime($run['date']));  
                                                        $dd = strval($run['date']);
                                                        echo '<tr>
                                                        <td>'.$run['patient_id'].'</td>
														<td>'.$run['token_id'].'</td>
                                                        <td>'.$newDate.'</td>
                                                        <td><a href="gb-semi.php?pid='.$run['patient_id'].'&tid='.$run['token_id'].'&date='.strval($run['date']).'" class="btn btn-primary">
														<i class="fas fa-eye">VIEW-BILL</i>
													    </a><td>
                                                        </tr>';
                                                    }
                                                ?> </tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="text-end"> <?php echo '<a href="gb.php?pid='.$pid.'&tid='.$tid.'" class="btn btn-primary"><i class="fas fa-eye"></i> PRINT FULL BILL</a>' ?> </div>
			</div>
		</div>
		<!-- /Page Wrapper -->
	</div>
	<!-- /Main Wrapper -->
	<!-- jQuery -->
	<script src="assets/js/jquery-3.6.0.min.js"></script>
	<!-- Bootstrap Core JS -->
	<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Slimscroll JS -->
	<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	<!-- Datatables JS -->
	<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="assets/plugins/datatables/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>
	<script>
	const searchFun = () => {
		let filter = document.getElementById('myInput').value.toUpperCase();
		let myTable = document.getElementById('myTable');
		let tr = myTable.getElementsByTagName('tr');
		for(var i = 0; i < tr.length; i++) {
			let td = tr[i].getElementsByTagName('td')[1];
			let t1 = tr[i].getElementsByTagName('td')[0];
			let t2 = tr[i].getElementsByTagName('td')[2];
			if(td || t2) {
				let textvlaue = td.textContent || td.innerHTML;
				let phone = t2.textContent || t2.innerHTML;
				let pid = t1.textContent || t1.innerHTML;
				if(textvlaue.toUpperCase().indexOf(filter) > -1 || phone.indexOf(filter) > -1 || pid.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}
		}
	}
	</script>
</body>

</html>