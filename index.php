<!DOCTYPE html>
<html lang="en">
<?php 
require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');

// Ensure session is started only if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
// Fetch admin details
$sql = "SELECT * FROM admin WHERE id = '".$_SESSION["id"]."'";
$result = $conn->query($sql);
if ($result && $row1 = mysqli_fetch_array($result)) {
    // Use $row1 safely here
} else {
    echo "Error fetching admin details: " . mysqli_error($conn);
}

// Fetch website management details
$sql_manage = "SELECT * FROM manage_website";
$result_manage = $conn->query($sql_manage);
if ($result_manage && $row_manage = mysqli_fetch_array($result_manage)) {
    // Use $row_manage safely here
} else {
    echo "Error fetching website management details: " . mysqli_error($conn);
}
?>

<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper full-calender">
<div class="page-body">
<div class="row">
<?php if($_SESSION['user'] == 'admin'){ ?>

<div class="col-xl-3 col-md-6">
<div class="card bg-c-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM patient WHERE status='Active' AND delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching patients: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">Total Patient</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-2" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-c-pink update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM doctor WHERE status='Active' AND delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching doctors: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">Total Doctor</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-3" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<!--
<div class="col-xl-3 col-md-6">
<div class="card bg-c-lite-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM admin WHERE delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching admins: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">Discharged Patients</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-4" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>
  -->

<div class="col-xl-3 col-md-6">
<div class="card bg-c-lite-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM admin WHERE delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching performing admins: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">Performing Admin</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-4" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<?php } else if($_SESSION['user'] == 'doctor'){ ?>
<div class="row col-sm-12"><h3>Welcome <?php echo ''.$_SESSION['fname']; ?></h3><br><br></div>
<div class="col-xl-3 col-md-6">
<div class="card bg-c-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div the class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM appointment WHERE doctorid=1 AND appointmentdate='".date("Y-m-d")."' AND delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching today's appointments: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">New Appointment</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-2" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-c-pink update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM patient WHERE status='Active' AND delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching patients: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">Number of Patient</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-3" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-c-lite-green update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">
    <?php
    $sql = "SELECT * FROM appointment WHERE status='Active' AND doctorid=1 AND appointmentdate='".date("Y-m-d")."' AND delete_status='0'";
    if ($qsql = mysqli_query($conn, $sql)) {
        echo mysqli_num_rows($qsql);
    } else {
        echo "Error fetching today's appointments: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0">Today's Appointment</h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-4" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-c-yellow update-card">
<div class="card-block">
<div class="row align-items-end">
<div class="col-8">
<h4 class="text-white">&#x20B9;.
    <?php
    $sql = "SELECT sum(bill_amount) AS total FROM billing_records WHERE bill_type = 'Consultancy Charge'";
    if ($qsql = mysqli_query($conn, $sql)) {
        $row = mysqli_fetch_assoc($qsql);
        echo $row['total'];
    } else {
        echo "Error fetching billing records: " . mysqli_error($conn);
    }
    ?>
</h4>
<h6 class="text-white m-b-0"></h6>
</div>
<div class="col-4 text-right">
<canvas id="update-chart-1" height="50"></canvas>
</div>
</div>
</div>
</div>
</div>

<?php } else if($_SESSION['user'] == 'patient'){

    $sqlpatient = "SELECT * FROM patient WHERE patientid='".$_SESSION['patientid']."'";
    $qsqlpatient = mysqli_query($conn, $sqlpatient);
    if ($qsqlpatient && $rspatient = mysqli_fetch_array($qsqlpatient)) {
        $sqlpatientappointment = "SELECT * FROM appointment WHERE patientid='".$_SESSION['patientid']."'";
        $qsqlpatientappointment = mysqli_query($conn, $sqlpatientappointment);
        if ($qsqlpatientappointment && $rspatientappointment = mysqli_fetch_array($qsqlpatientappointment)) {
            ?>
            <div class="row col-lg-12"><h3><b>Dashboard</b></h3></div>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs md-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home3" role="tab"><i class="fa fa-hand-o-right"></i> Appointment Details</a>
                            <div class="slide"></div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile3" role="tab"><i class="fa fa-hand-o-right"></i> Treatment Records</a>
                            <div class="slide"></div>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content card-block">
                        <div class="tab-pane active" id="home3" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                    <div class="sub-title">Appointment details</div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                                    <h5 class="card-title">Appointment details</h5>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <table id="table1" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Appointment No</th>
                                                                <th>Appointment Date</th>
                                                                <th>Appointment Time</th>
                                                                <th>Department</th>
                                                                <th>Doctor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $rspatientappointment['appointmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmentdate']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmenttime']; ?></td>
                                                                <td><?php echo $rspatientappointment['departmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['doctorid']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="sub-title">Treatment records</div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link" data-toggle="collapse" href="#collapseTwo">
                                                    <h5 class="card-title">Treatment records</h5>
                                                </a>
                                            </div>
                                            <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <table id="table2" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Treatment</th>
                                                                <th>Doctor</th>
                                                                <th>Treatment Date</th>
                                                                <th>Treatment Time</th>
                                                                <th>Treatment Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $rspatientappointment['appointmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmentdate']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmenttime']; ?></td>
                                                                <td><?php echo $rspatientappointment['departmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['doctorid']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profile3" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12 col-xl-6">
                                    <div class="sub-title">Appointment details</div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                                    <h5 class="card-title">Appointment details</h5>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <table id="table1" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Appointment No</th>
                                                                <th>Appointment Date</th>
                                                                <th>Appointment Time</th>
                                                                <th>Department</th>
                                                                <th>Doctor</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $rspatientappointment['appointmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmentdate']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmenttime']; ?></td>
                                                                <td><?php echo $rspatientappointment['departmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['doctorid']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="sub-title">Treatment records</div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header">
                                                <a class="card-link" data-toggle="collapse" href="#collapseTwo">
                                                    <h5 class="card-title">Treatment records</h5>
                                                </a>
                                            </div>
                                            <div id="collapseTwo" class="collapse show" data-parent="#accordion">
                                                <div class="card-body">
                                                    <table id="table2" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Treatment</th>
                                                                <th>Doctor</th>
                                                                <th>Treatment Date</th>
                                                                <th>Treatment Time</th>
                                                                <th>Treatment Description</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $rspatientappointment['appointmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmentdate']; ?></td>
                                                                <td><?php echo $rspatientappointment['appointmenttime']; ?></td>
                                                                <td><?php echo $rspatientappointment['departmentid']; ?></td>
                                                                <td><?php echo $rspatientappointment['doctorid']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo "Error fetching patient's appointment details: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching patient details: " . mysqli_error($conn);
    }
}
?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<?php include('footer.php'); ?>
</html>
