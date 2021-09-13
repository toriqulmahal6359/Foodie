<?php

include('header.php');

if (isset($_GET['type']) && $_GET['type'] != '' && isset($_GET['id']) && $_GET['id'] > 0) {
    $type = get_safe_value($_GET['type']);
    $id = get_safe_Value($_GET['id']);

    if ($type == 'delete') {
        $delete_query = "DELETE FROM coupon_code WHERE id = '$id' ";
        mysqli_query($con, $delete_query);
        redirect('coupon_code.php');
    }

    if ($type == 'active' || $type == 'deactive') {
        $status = 1;
        if ($type == 'deactive') {
            $status = 0;
        }
        $status_query = "UPDATE coupon_code SET status='$status' WHERE id='$id'";
        mysqli_query($con, $status_query);
        redirect('coupon_code.php');
    }
}
$query = "SELECT * FROM coupon_code ORDER BY id DESC";
$res = mysqli_query($con, $query);
?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <!-- Basic table card start -->

                    <!-- Basic table card end -->
                    <!-- Inverse table card start -->

                    <!-- Inverse table card end -->
                    <!-- Hover table card start -->

                    <!-- Hover table card end -->
                    <!-- Contextual classes table starts -->
                    <div class="card">
                        <div class="card-header">
                            <h1>Coupon Code Master</h1>
                            <a href="manage_coupon_code.php" class="category_grid">Add Coupon Code</a>
                            <div class="card-header-right">
                                <ul class="list-unstyled card-option">
                                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                    <li><i class="fa fa-window-maximize full-card"></i></li>
                                    <li><i class="fa fa-minus minimize-card"></i></li>
                                    <li><i class="fa fa-refresh reload-card"></i></li>
                                    <li><i class="fa fa-trash close-card"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table" id="category_table">
                                    <thead>
                                        <tr>
                                            <th>S.no #</th>
                                            <th>Code</th>
                                            <th>Type</th>
                                            <th>Value</th>
                                            <th>Cart Value (min.)</th>
                                            <th>Created at</th>
                                            <th>Expired at</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (mysqli_num_rows($res) > 0) {
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                                <tr class="table">
                                                    <th scope="row"><?php echo $i; ?></th>
                                                    <td width="20%"><?php echo $row['coupon_code']; ?></td>
                                                    <td width="20%"><?php echo $row['coupon_type']; ?></td>
                                                    <td width="20%"><?php echo $row['coupon_value']; ?></td>
                                                    <td width="20%"><?php echo $row['cart_min_value']; ?></td>
                                                    <td width="30%">
                                                        <?php
                                                        $dateStr = strtotime($row['added_on']);
                                                        echo date("d-m-Y H:i:s", $dateStr);
                                                        ?>
                                                    </td>
                                                    <td width="30%">
                                                        <?php 
                                                            if($row["expired_on"] == '00-00-0000 00:00:00'){
                                                                echo "N/A";
                                                            }else{
                                                                echo $row["expired_on"];
                                                            } 
                                                        ?>
                                                    </td>
                                                    <td width="30%">
                                                        <?php if ($row['status'] == 1) { ?>
                                                            <a href="?id=<?php echo $row['id'] ?>&type=deactive"><label class="btn btn-warning">Active</label></a>&nbsp;
                                                        <?php } else { ?>
                                                            <a href="?id=<?php echo $row['id'] ?>&type=active"><label class="btn btn-success">Deactive</label></a>&nbsp;
                                                        <?php } ?>
                                                        <a href="manage_coupon_code.php?id=<?php echo $row['id'] ?>"><label class="btn btn-primary">Edit</label></a>&nbsp;
                                                        <a href="?id=<?php echo $row['id'] ?>&type=delete"><label class="btn btn-danger">Delete</label></a>
                                                    </td>
                                                </tr>
                                            <?php $i++;
                                            }
                                        } else { ?>
                                            <td colspan="5">No Data Available</td>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Contextual classes table ends -->
                    <!-- Background Utilities table start -->

                    <!-- Background Utilities table end -->
                </div>
                <!-- Page-body end -->
            </div>
        </div>
        <!-- Main-body end -->

        <div id="styleSelector">

        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<?php
include('footer.php');
?>