<?php
session_start();
include ('includes/config.php');
include ('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "delete from userregistration where id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    // echo "<script>alert('Data Deleted');</script>";
}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#CDD7D6">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script language="javascript" type="text/javascript">
        var popUpWin = 0;
        function popUpWindow(URLStr, left, top, width, height) {
            if (popUpWin) {
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin = open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width=' + 510 + ',height=' + 430 + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>

</head>

<body>
    <?php include ('includes/header.php'); ?>

    <div class="ts-main-content">
        <?php include ('includes/sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Approve Users</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading">All User Details</div>
                            <div class="panel-body">
                                <h2 id="user-deleted-message">
                                    <?php
                                        if (isset($_GET['del'])) {
                                            echo "Successfully deleted user!";
                                            echo '
                                                <script>
                                                setTimeout(()=>{
                                                    window.location.href = "approve_users.php"
                                                }, 1000)
                                                </script>
                                            ';
                                        }
                                    ?>
                                    
                                </h2>
                                <table id="zctb" class="display table table-striped table-bordered table-hover"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>Student Name</th>
                                            <th>Contact no </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $aid = $_SESSION['id'];
                                        $ret = "select * from userregistration";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();//ok
                                        $res = $stmt->get_result();
                                        $cnt = 1;
                                        while ($row = $res->fetch_object()) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $cnt; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->firstName; ?>
                                                    <?php echo $row->middleName; ?>
                                                    <?php echo $row->lastName; ?>
                                                </td>
                                                
                                                <td>
                                                    <?php echo $row->contactNo; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (($row->admin_approved) == 0) {
                                                        echo '<a onclick="approveRegistration(' . $row->id . ')"  title="View Full Details">';
                                                        echo '<i title="Approve" class="fa fa-check-square-o"></i>';
                                                    } else {
                                                        echo '<a title="View Full Details">';
                                                        echo '<i title="Already Approved" class="fa fa-check-square"></i>';

                                                    }
                                                    echo "</a>";
                                                    ?>
                                                    &nbsp;&nbsp;
                                                    <a href="approve_users.php?del=<?php echo $row->id; ?>"
                                                        title="Delete Record" onclick="return confirm(' Do you want to delete')"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                            $cnt = $cnt + 1;
                                        } ?>


                                    </tbody>
                                </table>


                            </div>
                        </div>


                    </div>
                </div>



            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>

</body>
<script>
    document.addEventListener("DOMContentLoaded", (e) => {
        setTimeout(() => {
            document.getElementById("zctb_length").innerHTML = "";
            document.getElementById("zctb_filter").innerHTML = "";
            document.getElementById("zctb_info").innerHTML = "";
            document.getElementById("zctb_paginate").innerHTML = "";
        }, 100)
    })
    function approveRegistration(id) {

        let currentLocationn = window.location.href;

        let splitted = currentLocationn.split("/");
        splitted = splitted.slice(0, splitted.length - 1);
        console.log("Splited: ", splitted)
        const remerged = splitted.join("/");
        window.location.href = `${remerged}/approve_registration.php?id=${id}`;
    }
    
</script>

</html>