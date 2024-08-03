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
    var_dump($_POST);
    var_dump($_GET);
    // exit(); // Uncomment to stop execution for debugging
    
    if (isset($_GET['editid'])) {
        $sql = "UPDATE doctor SET doctorname='$_POST[doctorname]',mobileno='$_POST[mobilenumber]',departmentid='$_POST[department]',loginid='$_POST[loginid]',status='$_POST[status]',education='$_POST[education]',experience='$_POST[experience]',consultancy_charge='$_POST[consultancy_charge]' WHERE doctorid='$_GET[editid]'";
        if ($qsql = mysqli_query($conn, $sql)) {
            echo "Doctor Record Updated Successfully";
            echo "<script>setTimeout(\"location.href = 'view-doctor.php';\",1500);</script>";
        } else {
            echo mysqli_error($conn);
        }
    } else {
        $passw = hash('sha256', $_POST['password']);
        function createSalt() {
            return '2123293dsj2hu2nikhiljdsd';
        }
        $salt = createSalt();
        $pass = hash('sha256', $salt . $passw);
        $sql = "INSERT INTO doctor(doctorname,mobileno,departmentid,loginid,password,status,education,experience,consultancy_charge) values('$_POST[doctorname]','$_POST[mobilenumber]','$_POST[department]','$_POST[loginid]','$pass','$_POST[status]','$_POST[education]','$_POST[experience]','$_POST[consultancy_charge]')";
        if ($qsql = mysqli_query($conn, $sql)) {
            echo "Doctor Record Inserted Successfully";
            echo "<script>setTimeout(\"location.href = 'view-doctor.php';\",1500);</script>";
        } else {
            echo mysqli_error($conn);
        }
    }
}

if (isset($_GET['editid'])) {
    $sql = "SELECT * FROM doctor WHERE doctorid='$_GET[editid]'";
    $qsql = mysqli_query($conn, $sql);
    $rsedit = mysqli_fetch_array($qsql);
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
<h4>Doctor</h4>
</div>
</div>
</div>
<div class="col-lg-4">
<div class="page-header-breadcrumb">
<ul class="breadcrumb-title">
<li class="breadcrumb-item">
<a href="dashboard.php"> <i class="feather icon-home"></i> </a>
</li>
<li class="breadcrumb-item"><a>Doctor</a></li>
<li class="breadcrumb-item"><a href="add_user.php">Doctor</a></li>
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
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Doctor Name</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="doctorname" id="doctorname" placeholder="Enter name...." required="" value="<?php if(isset($_GET['editid'])) { echo $rsedit['doctorname']; } ?>">
            <span class="messages"></span>
        </div>
        <label class="col-sm-2 col-form-label">Mobile No</label>
        <div class="col-sm-4">
            <input type="number" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="Enter mobilenumber...." required="" value="<?php echo $rsedit['mobileno']; ?>">
            <span class="messages"></span>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Department</label>
        <div class="col-sm-4">
            <select class="form-control" name="department" id="department" placeholder="Enter lastname...." required="">
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
        <label class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="loginid" id="loginid" value="<?php if (isset($_GET['editid'])) { echo $rsedit['loginid']; } ?>"/>
            <span class="messages"></span>
        </div>
    </div>

    <?php if (!isset($_GET['editid'])) { ?>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-4">
            <input class="form-control" type="password" name="password" id="password"/>
            <span class="messages"></span>
        </div>
        <label class="col-sm-2 col-form-label">Confirm Password</label>
        <div class="col-sm-4">
            <input class="form-control" type="password" name="cnfirmpassword" id="cnfirmpassword"/>
            <span class="messages" id="confirm-pw" style="color: red;"></span>
        </div>
    </div>
    <?php } ?>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Education</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="education" id="education" value="<?php if (isset($_GET['editid'])) { echo $rsedit['education']; } ?>" />
        </div>
        <label class="col-sm-2 col-form-label">Experience</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="experience" id="experience" value="<?php if (isset($_GET['editid'])) { echo $rsedit['experience']; } ?>"/>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Consultancy Charge</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="consultancy_charge" id="consultancy_charge" value="<?php if (isset($_GET['editid'])) { echo $rsedit['consultancy_charge']; } ?>"/>
        </div>
        <label class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-4">
            <select name="status" id="status" class="form-control" required="">
                <option value="">-- Select One -- </option>
                <option value="Active" <?php if (isset($_GET['editid']) && $rsedit['status'] == 'Active') { echo 'selected'; } ?>>Active</option>
                <option value="Inactive" <?php if (isset($_GET['editid']) && $rsedit['status'] == 'Inactive') { echo 'selected'; } ?>>Inactive</option>
            </select>
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

<?php include('footer.php');?>

<script type="text/javascript">
    $('#main').keyup(function(){
        $('#confirm-pw').html('');
    });

    $('#cnfirmpassword').change(function(){
        if ($('#cnfirmpassword').val() != $('#password').val()) {
            $('#confirm-pw').html('Password Not Match');
        }
    });

    $('#password').change(function(){
        if ($('#cnfirmpassword').val() != $('#password').val()) {
            $('#confirm-pw').html('Password Not Match');
        }
    });
</script>
