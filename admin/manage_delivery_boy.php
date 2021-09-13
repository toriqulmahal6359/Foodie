<?php
include('header.php');

//for adding category
$name = '';
$email = '';
$mobile = '';
$password = '';
$id='';
$msg ='';

    //for updating category
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = get_safe_value($_GET['id']);
        $query = "SELECT * FROM delivery_boy WHERE id='$id'";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);

        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $password = $row['password'];
    }

    if(isset($_POST['add_delivery_boy'])){
        $name = get_safe_value($_POST['name']);
        $email = get_safe_value($_POST['email']);
        $mobile = get_safe_value($_POST['mobile']);
        $password = get_safe_value($_POST['password']);
        $added_on = date('Y-m-d h:i:s');

        if($id==''){
            //when user enters new entry
            $on_unique = "SELECT * FROM delivery_boy WHERE mobile='$mobile'";
        }else{
            //when user goes for update
            $on_unique = "SELECT * FROM delivery_boy WHERE mobile='$mobile' AND id!='$id'";
        }
        
        $unq = mysqli_query($con, $on_unique);
        if(mysqli_num_rows($unq) > 0){
            $msg = "Delivery boy has already been added";
        }else{
            if($id==''){
                $insert_query = "INSERT INTO delivery_boy(name,email,mobile,password,status,added_on) VALUES('$name','$email','$mobile','$password',1,'$added_on')";
                mysqli_query($con, $insert_query);  
            }else{
                $update_query = "UPDATE delivery_boy SET name='$name', email='$email', mobile='$mobile' WHERE id='$id'";
                mysqli_query($con, $update_query);
            }
            redirect('delivery_boy.php');
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
                                            <h1>Manage Category</h1>
                                            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                        </div>
                                        <div class="card-block">
                                            <form class="form-material" method="POST">
                                                <div class="form-group form-default">
                                                    <input type="text" name="name" class="form-control" required value="<?php echo $name; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="name" class="float-label">Name</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="email" class="form-control" required value="<?php echo $email; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="email" class="float-label">Email</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="mobile" class="form-control" required value="<?php echo $mobile; ?>">
                                                    <span class="form-bar"></span>
                                                    <span class="text-danger"><?php echo $msg; ?></span>
                                                    <label for="mobile" class="float-label">Mobile</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="password" name="password" class="form-control" required value="<?php echo $password; ?>>
                                                    <span class="form-bar"></span>
                                                    <label for="password" class="float-label">Password</label>
                                                </div>

                                                <div>
                                                    <input type="submit" class="btn btn-primary" value="Submit" name="add_delivery_boy">
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