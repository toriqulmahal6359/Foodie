<?php
include('header.php');

if (isset($_GET['type']) && $_GET['type'] != '' && isset($_GET['id']) && $_GET['id'] > 0) {
    $type = get_safe_value($_GET['type']);
    $id = get_safe_Value($_GET['id']);

    if ($type == 'delete') {
        $delete_query = "DELETE FROM contact WHERE id = '$id' ";
        mysqli_query($con, $delete_query);
        redirect('contact_us.php');
    }
}
$query = "SELECT * FROM contact_us ORDER BY added_on DESC";
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
                            <h1>Contact Us</h1>
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Added on</th>
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
                                                    <td width="10%"><?php echo $row['name']; ?></td>
                                                    <td width="20%"><?php echo $row['email']; ?></td>
                                                    <td width="20%"><?php echo $row['mobile']; ?></td>
                                                    <td width="30%"><?php echo (strlen($row['subject'])>= 30) ?  substr($row['subject'], 0, 30)."..." : $row['subject']; ?></td>
                                                    <td width="50%"><?php echo (strlen($row['message'])>= 40) ?  substr($row['message'], 0, 40)."..." : $row['message']; ?></td>
                                                    <td width="30%">
                                                    <?php 
                                                       $dateStr = strtotime($row['added_on']); 
                                                       echo date('d-m-Y h:i:s', $dateStr); 
                                                    ?>
                                                    </td>
                                                    <td width="10%">
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