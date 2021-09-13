<?php
include('header.php');

if (isset($_GET['type']) && $_GET['type'] != '' && isset($_GET['id']) && $_GET['id'] > 0) {
    $type = get_safe_value($_GET['type']);
    $id = get_safe_Value($_GET['id']);

    if ($type == 'active' || $type == 'deactive') {
        $status = 1;
        if ($type == 'deactive') {
            $status = 0;
        }
        $status_query = "UPDATE dish SET status='$status' WHERE id='$id'";
        mysqli_query($con, $status_query);
        redirect('dish.php');
    }
}
$query = "SELECT dish.*, category.category FROM dish, category WHERE dish.category_id = category.id ORDER BY dish.id DESC";
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
                            <h1>Dish Master</h1>
                            <a href="manage_dish.php" class="category_grid">Add New Dish</a>
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
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Dish</th>
                                            <th>Dish Details</th>
                                            <th>Added On</th>
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
                                                    <td width="25%" >
                                                        <a target="_blank" href="<?php echo SITE_DISH_IMAGE.$row['dish_image']; ?>"><img style=" border-radius: 75%;" src="<?php echo SITE_DISH_IMAGE.$row['dish_image']; ?>" alt="<?php echo $row['dish']?>" width="100px"></a>
                                                    </td>
                                                    <td width="20%"><?php echo $row['category']; ?></td>
                                                    <td width="20%"><?php echo $row['dish']; ?></td>
                                                    <td width="20%"><?php echo (strlen($row['dish_detail'])>= 40) ?  substr($row['dish_detail'], 0, 40)."..." : $row['dish_detail']; ?></td>
                                                    <td width="50%">
                                                        <?php
                                                        $dateStr = strtotime($row['added_on']);
                                                        echo date("d-m-Y H:i:s", $dateStr);
                                                        ?>
                                                    </td>
                                                    <td width="30%">
                                                        <?php if ($row['status'] == 1) { ?>
                                                            <a href="?id=<?php echo $row['id'] ?>&type=deactive"><label class="btn btn-warning">Active</label></a>&nbsp;
                                                        <?php } else { ?>
                                                            <a href="?id=<?php echo $row['id'] ?>&type=active"><label class="btn btn-success">Deactive</label></a>&nbsp;
                                                        <?php } ?>
                                                        <a href="manage_dish.php?id=<?php echo $row['id'] ?>"><label class="btn btn-primary">Edit</label></a>&nbsp;
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