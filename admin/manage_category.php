<?php
include('header.php');

//for adding category
$category = '';
$order_number = '';
$msg = '';
$id='';

    //for updating category
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = get_safe_value($_GET['id']);
        $query = "SELECT * FROM category WHERE id='$id'";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);

        $category = $row['category'];
        $order_number = $row['order_number'];
    }

    if(isset($_POST['add_category'])){
        $category = get_safe_value($_POST['category']);
        $order_number = get_safe_value($_POST['order_number']);
        $added_on = date('Y-m-d h:i:s');

        if($id==''){
            //when user enters new entry
            $on_unique = "SELECT * FROM category WHERE category='$category'";
        }else{
            //when user goes for update
            $on_unique = "SELECT * FROM category WHERE category='$category' AND id!='$id'";
        }
        
        $unq = mysqli_query($con, $on_unique);
        if(mysqli_num_rows($unq) > 0){
            $msg = "Category Already Exists";
        }else{
            if($id==''){
                $insert_query = "INSERT INTO category(category,order_number,status,added_on) VALUES('$category','$order_number',1,'$added_on')";
                mysqli_query($con, $insert_query);  
            }else{
                $update_query = "UPDATE category SET category='$category', order_number='$order_number' WHERE id='$id'";
                mysqli_query($con, $update_query);
            }
            redirect('category.php');
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
                                                    <input type="text" name="category" class="form-control" required value="<?php echo $category; ?>">
                                                    <span class="form-bar"></span>
                                                    <span class="text-danger"><?php echo $msg; ?></span>
                                                    <label for="category" class="float-label">Category</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="order_number" class="form-control" required value="<?php echo $order_number;?>">
                                                    <span class="form-bar"></span>
                                                    <label for="order_number" class="float-label">Order Number</label>
                                                </div>
                                                <div>
                                                    <input type="submit" class="btn btn-primary" value="Submit" name="add_category">
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