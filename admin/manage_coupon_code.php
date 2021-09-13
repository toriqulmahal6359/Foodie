<?php
include('header.php');

//for adding category
$coupon_code = '';
$coupon_type = '';
$coupon_value = '';
$cart_min_value = '';
$expired_on = '';
$id='';
$msg ='';

    //for updating category
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = get_safe_value($_GET['id']);
        $coupon_query = "SELECT * FROM coupon_code WHERE id='$id'";
        $res = mysqli_query($con, $coupon_query);
        $row = mysqli_fetch_assoc($res);

        $coupon_code = $row['coupon_code'];
        $coupon_type = $row['coupon_type'];
        $coupon_value = $row['coupon_value'];
        $cart_min_value = $row['cart_min_value'];
        $dateStr = strtotime($row['expired_on']);
        $expired_on = date('d-m-Y h:i:s', $dateStr);
    }

    if(isset($_POST['add_coupon_value'])){
        $coupon_code = get_safe_value($_POST['coupon_code']);
        $coupon_type = get_safe_value($_POST['coupon_type']);
        $coupon_value = get_safe_value($_POST['coupon_value']);
        $cart_min_value = get_safe_value($_POST['cart_min_value']);
        $expired_on = get_safe_value($_POST['expired_on']);
        $added_on = date('Y-m-d h:i:s');

        if($id==''){
            //when user enters new entry
            $coupon_on_unique = "SELECT * FROM coupon_code WHERE coupon_code='$coupon_code'";
        }else{
            //when user goes for update
            $coupon_on_unique = "SELECT * FROM coupon_code WHERE coupon_code='$coupon_code' AND id!='$id'";
        }
        
        $unique = mysqli_query($con, $coupon_on_unique);
        if(mysqli_num_rows($unique) > 0){
            $msg = "Coupon Code has already been added";
        }else{
            if($id==''){
                $coupon_insert_query = "INSERT INTO coupon_code(coupon_code,coupon_type,coupon_value,cart_min_value,expired_on,status,added_on) VALUES('$coupon_code','$coupon_type','$coupon_value','$cart_min_value','$expired_on', 1,'$added_on')";
                mysqli_query($con, $coupon_insert_query); 
            }else{
                $coupon_update_query = "UPDATE coupon_code SET coupon_code='$coupon_code', coupon_type='$coupon_type', coupon_value='$coupon_value', cart_min_value= '$cart_min_value', expired_on='$expired_on' WHERE id='$id'";
                mysqli_query($con, $coupon_update_query);
            }
            return redirect('coupon_code.php');
        }
    }
?>


<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <!-- Page-header start -->

            <!-- Page-header end -->
            <div class="pcoded-inner-content">
                <!-- Main-body start -->
                <div class="main-body">
                    <div class="page-wrapper">

                        <!-- Page body start -->
                        <div class="page-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h1>Manage Coupon Code</h1>
                                            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                        </div>
                                        <div class="card-block">
                                            <form class="form-material" method="POST">
                                                <div class="form-group form-default">
                                                    <input type="text" name="coupon_code" class="form-control" value="<?php echo $coupon_code; ?>">
                                                    <span class="form-bar"></span>
                                                    <span class="text-danger"><?php echo $msg; ?></span>
                                                    <label for="coupon_code" class="float-label">Coupon Code</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <select name="coupon_type" required class="form-control">
                                                        <option value="#">Select type</option>
                                                        <?php
                                                            $arr = array("P"=>'Percentage', "F"=>'Fixed');
                                                            foreach($arr as $key=>$val){
                                                                if($key == $coupon_type){
                                                                    echo "<option value='".$key."' selected>".$val."</option>";
                                                                }else{
                                                                    echo "<option value='".$key."'>".$val."</option>";
                                                                }
                                                                
                                                            }
                                                        ?>
                                                    </select>
                                                    <span class="form-bar"></span>
                                                    <label for="coupon_type" class="float-label">Coupon Type</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="coupon_value" class="form-control" value="<?php echo $coupon_value; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="coupon_value" class="float-label">Coupon Value</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="cart_min_value" class="form-control" value="<?php echo $cart_min_value ; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="cart_min_value" class="float-label">Cart Value (Min.)</label>
                                                </div>
                                                
                                                <div class="form-group form-default">
                                                    <input type="datetime-local" name="expired_on" class="form-control" value="<?php echo $expired_on; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="expired_on" class="float-label">Expired on</label>
                                                </div>

                                                <div>
                                                    <input type="submit" class="btn btn-primary" value="Submit" name="add_coupon_value">
                                                    <input type="submit" class="btn btn-light" value="Cancel"></input>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page body end -->
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