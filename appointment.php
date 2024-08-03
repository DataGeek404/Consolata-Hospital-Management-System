<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('check_login.php');
include('head.php');
include('header.php');
include('sidebar.php');
include('connect.php');

if (isset($_POST['btn_submit'])) {
    if (isset($_GET['editid']) && $_GET['editid'] !== '') {
        $editid = $_GET['editid'];
        $patient = $_POST['patient'] ?? null;
        $department = $_POST['department'] ?? null;
        $appointmentdate = $_POST['appointmentdate'] ?? null;
        $appointmenttime = $_POST['appointmenttime'] ?? null;
        $doctor = $_POST['doctor'] ?? null;
        $status = $_POST['status'] ?? null;

        if ($patient && $department && $appointmentdate && $appointmenttime && $doctor && $status) {
            $sql = "UPDATE appointment SET patientid='$patient', departmentid='$department', appointmentdate='$appointmentdate', appointmenttime='$appointmenttime', doctorid='$doctor', status='$status' WHERE appointmentid='$editid'";
            if ($qsql = mysqli_query($conn, $sql)) {
                echo "Appointment Record Updated Successfully";
                echo "<script>setTimeout(\"location.href = 'appointment.php';\",1500);</script>";
            } else {
                echo mysqli_error($conn);
            }
        }
    } else {
        $patient = $_POST['patient'] ?? null;
        if ($patient) {
            $sql = "UPDATE patient SET status='Active' WHERE patientid='$patient'";
            $qsql = mysqli_query($conn, $sql);

            $department = $_POST['department'] ?? null;
            $appointmentdate = $_POST['appointmentdate'] ?? null;
            $appointmenttime = $_POST['appointmenttime'] ?? null;
            $doctor = $_POST['doctor'] ?? null;
            $status = $_POST['status'] ?? null;
            $reason = $_POST['reason'] ?? null;

            if ($department && $appointmentdate && $appointmenttime && $doctor && $status && $reason) {
                $sql = "INSERT INTO appointment(patientid, departmentid, appointmentdate, appointmenttime, doctorid, status, app_reason) VALUES('$patient', '$department', '$appointmentdate', '$appointmenttime', '$doctor', '$status', '$reason')";
                if ($qsql = mysqli_query($conn, $sql)) {
                    echo "Appointment Record Inserted Successfully";
                    echo "<script>setTimeout(\"location.href = 'appointment.php?patientid=$patient';\",1500);</script>";
                } else {
                    echo mysqli_error($conn);
                }
            }
        }
    }
}

if (isset($_GET['editid'])) {
    $editid = $_GET['editid'];
    $sql = "SELECT * FROM appointment WHERE appointmentid='$editid'";
    $qsql = mysqli_query($conn, $sql);
    $rsedit = mysqli_fetch_array($qsql) ?? null;
}
?>

<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Appointment</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Appointment</a></li>
                                    <li class="breadcrumb-item"><a href="appointment.php">Appointment</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header"></div>
                                <div class="card-block">
                                    <form id="main" method="post" action="" enctype="multipart/form-data">
                                        <?php
                                        if (isset($_GET['patid'])) {
                                            $patid = $_GET['patid'];
                                            $sqlpatient = "SELECT * FROM patient WHERE patientid='$patid'";
                                            $qsqlpatient = mysqli_query($conn, $sqlpatient);
                                            $rspatient = mysqli_fetch_array($qsqlpatient) ?? null;

                                            if ($rspatient) {
                                                echo $rspatient['patientname'] . " (Patient ID - " . $rspatient['patientid'] . ")";
                                                echo "<input type='hidden' name='select4' value='" . $rspatient['patientid'] . "'>";
                                            }
                                        }
                                        ?>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Patient</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="patient" id="patient" required="">
                                                    <option>-- Select One--</option>
                                                    <?php
                                                    $sqlpatient = "SELECT * FROM patient WHERE status='Active'";
                                                    $qsqlpatient = mysqli_query($conn, $sqlpatient);
                                                    while ($rspatient = mysqli_fetch_array($qsqlpatient)) {
                                                        $selected = ($rspatient['patientid'] == $rsedit['patientid']) ? "selected" : "";
                                                        echo "<option value='$rspatient[patientid]' $selected>$rspatient[patientid] - $rspatient[patientname]</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Department</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="department" id="department" required="">
                                                    <option value="">-- Select One --</option>
                                                    <?php
                                                    $sqldepartment = "SELECT * FROM department WHERE status='Active'";
                                                    $qsqldepartment = mysqli_query($conn, $sqldepartment);
                                                    while ($rsdepartment = mysqli_fetch_array($qsqldepartment)) {
                                                        $selected = ($rsdepartment['departmentid'] == $rsedit['departmentid']) ? "selected" : "";
                                                        echo "<option value='$rsdepartment[departmentid]' $selected>$rsdepartment[departmentname]</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Date</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" name="appointmentdate" id="appointmentdate" value="<?php echo $rsedit['appointmentdate'] ?? ''; ?>" required="">
                                                <span class="messages"></span>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Time</label>
                                            <div class="col-sm-4">
                                                <input type="time" class="form-control" name="appointmenttime" id="appointmenttime" value="<?php echo $rsedit['appointmenttime'] ?? ''; ?>" required="">
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Doctor</label>
                                            <div class="col-sm-4">
                                                <select name="doctor" class="form-control" required="">
                                                    <option value="">Select Doctor</option>
                                                    <?php
                                                    $sqldoctor = "SELECT * FROM doctor INNER JOIN department ON department.departmentid=doctor.departmentid WHERE doctor.status='Active'";
                                                    $qsqldoctor = mysqli_query($conn, $sqldoctor);
                                                    while ($rsdoctor = mysqli_fetch_array($qsqldoctor)) {
                                                        $selected = (isset($_GET['patid']) && $rsdoctor['doctorid'] == $rsedit['doctorid']) ? "selected" : "";
                                                        echo "<option value='$rsdoctor[doctorid]' $selected>$rsdoctor[doctorname] ($rsdoctor[departmentname])</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-4">
                                                <select name="status" id="status" class="form-control" required="">
                                                    <option value="">-- Select One --</option>
                                                    <option value="Active" <?php if (isset($_GET['patid']) && $rsedit['status'] == 'Active') echo 'selected'; ?>>Active</option>
                                                    <option value="Inactive" <?php if (isset($_GET['patid']) && $rsedit['status'] == 'Inactive') echo 'selected'; ?>>Inactive</option>
                                                </select>
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Reason</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="reason" id="reason" required=""><?php echo $rsedit['app_reason'] ?? ''; ?></textarea>
                                                <span class="messages"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" name="btn_submit" class="btn btn-primary m-b-0">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
