<?php
include('header.php');

//for adding category
$category_id = '';
$dish = '';
$dish_detail = '';
$image='';
$id='';
$img_status = 'required';
$img_format_error = '';
$msg ='';

    //for updating category
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = get_safe_value($_GET['id']);
        $query = "SELECT * FROM dish WHERE id='$id'";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);

        $category_id = $row['category_id'];
        $dish = $row['dish'];
        $dish_detail = $row['dish_detail'];
        $image = $row['dish_image'];
        $img_status = '';
    }

    if(isset($_GET['dish_details_id']) && $_GET['dish_details_id'] > 0){
        $dish_details_id = get_safe_value($_GET['dish_details_id']);
        $id = get_safe_value($_GET['id']);
        $remove_query = "DELETE FROM dish_details WHERE id='$dish_details_id'";
        mysqli_query($con, $remove_query);
        redirect('manage_dish.php?id='.$id);
    }

    if(isset($_POST['add_new_dish'])){
        // prx($_POST);
        $category_id = get_safe_value($_POST['category_id']);
        $dish = get_safe_value($_POST['dish']);
        $dish_detail = get_safe_value($_POST['dish_detail']); 
        $added_on = date('Y-m-d h:i:s');

        if($id==''){
            //when user enters new entry
            $on_unique = "SELECT * FROM dish WHERE dish='$dish'";
        }else{
            //when user goes for update
            $on_unique = "SELECT * FROM dish WHERE dish='$dish' AND id!='$id'";
        }
        
        $unq = mysqli_query($con, $on_unique);
        if(mysqli_num_rows($unq) > 0){
            $msg = "Dish has already been added";
        }else{
           $type = $_FILES['dish_image']['type'];
            if($id==''){ 
                //here image is mandatory
                if($type != 'image/jpeg' && $type != 'image/jpg' && $type != 'image/png'){
                    $img_format_error = 'Image should be in .jpeg, .jpg or .png format';
                }else{
                    //insert an image with proper requirements
                    $image = rand(111111111, 999999999).'_'.$_FILES['dish_image']['name'];
                    move_uploaded_file($_FILES['dish_image']['tmp_name'], SERVER_DISH_IMAGE.$image);
                    $insert_query = "INSERT INTO dish(category_id,dish,dish_detail,dish_image,status,added_on) VALUES('$category_id','$dish','$dish_detail','$image',1,'$added_on')";
                    mysqli_query($con, $insert_query);
                    
                    $dish_id = mysqli_insert_id($con);

                    $attr_arr = $_POST['attribute'];
                    $price_arr = $_POST['price'];
            
                    foreach($attr_arr as $key=>$val){
                        $attr = $val;
                        $price = $price_arr[$key];
            
                        $attr_query = "INSERT INTO dish_details(dish_id,attribute,price,status,added_on) VALUES('$dish_id','$attr','$price','1','$added_on')";
                        mysqli_query($con, $attr_query);
                    }

                    redirect('dish.php'); 
                }
            }else{
                $img_condition = '';
                if($_FILES['dish_image']['name'] != ''){
                    if($type != 'image/jpeg' && $type != 'image/jpg' && $type != 'image/png'){
                        $img_format_error = 'Image should .jpeg, .jpg or .png format';
                    }else{
                        //update an image
                        $new_image = rand(111111111, 999999999).'_'.$_FILES['dish_image']['name'];
                        move_uploaded_file($_FILES['dish_image']['tmp_name'], SERVER_DISH_IMAGE.$new_image);
                        $img_condition = ", dish_image='$new_image'";

                        //old Image delete
                        $old_image_query = "SELECT dish_image FROM dish WHERE id='$id'";
                        $old_img_res = mysqli_query($con, $old_image_query);
                        $oldImageRow = mysqli_fetch_assoc($old_img_res);

                        $old_image = $oldImageRow['dish_image'];
                        unlink(SERVER_DISH_IMAGE.$old_image);
                    }
                }
                if($img_format_error == ''){
                    $update_query = "UPDATE dish SET category_id='$category_id', dish='$dish', dish_detail= '$dish_detail' $img_condition WHERE id='$id'";
                    mysqli_query($con, $update_query);

                    $attribute_Arr = $_POST['attribute'];
                    $price_Arr = $_POST['price'];
                    $dish_detail_Id_Arr = $_POST['dish_details_id'];

                    foreach($attribute_Arr as $key=>$val){
                        $attribute = $val;
                        $price = $price_Arr[$key];
                        
                        if(isset($dish_detail_Id_Arr[$key])){
                            $dish_id = $dish_detail_Id_Arr[$key];
                            $update_attr_query = "UPDATE dish_details SET attribute='$attribute', price='$price' WHERE id='$dish_id'";
                            mysqli_query($con, $update_attr_query);
                        }else{
                            $attr_query = "INSERT INTO dish_details(dish_id,attribute,price,status,added_on) VALUES('$id','$attr','$price','1','$added_on')";
                            mysqli_query($con, $attr_query); 
                        }
                        
                    }

                    redirect('dish.php');
                }
            }
        }
    }

    $category_query = "SELECT * FROM category WHERE status= '1' ORDER BY category ASC";
    $res_category = mysqli_query($con, $category_query);
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
                                            <h1>Manage Dish</h1>
                                            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                        </div>
                                        <div class="card-block">
                                            <form class="form-material" method="POST" enctype="multipart/form-data">
                                                <div class="form-group form-default">
                                                    <select name="category_id" class="form-control" required>
                                                        <option value="">Select Dish Category</option>
                                                        <?php
                                                            while($row_category = mysqli_fetch_array($res_category, MYSQLI_ASSOC)){
                                                                if($row_category['id'] == $category_id){
                                                                    echo '<option value="'.$row_category['id'].'" selected>'.$row_category['category'].'</option>';
                                                                }else{
                                                                    echo '<option value="'.$row_category['id'].'">'.$row_category['category'].'</option>';
                                                                }   
                                                            }
                                                        ?>
                                                    </select>
                                                    <span class="form-bar"></span>
                                                    <label for="category" class="float-label"></label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="dish" class="form-control" required value="<?php echo $dish; ?>">
                                                    <span class="form-bar"></span>
                                                    <span class="text-danger"><?php echo $msg; ?></span>
                                                    <label for="dish" class="float-label">Dish</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <textarea type="textbox" rows="5" name="dish_detail" placeholder="Dish details goes here......" class="form-control" required value="<?php echo $dish_detail; ?>"></textarea>
                                                    <span class="form-bar"></span>
                                                    <label for="dish_detail" class="float-label"></label>
                                                </div>
                                                <br><br>
                                                <div class="form-group form-default">
                                                    <input type="file" name="dish_image" class="form-control" <?php echo $img_status; ?>">
                                                    <span class="form-bar"></span>
                                                    <span class="text-danger"><?php echo $img_format_error; ?></span>
                                                    <label for="dish_image" class="float-label">Dish Image</label>
                                                </div>
                                                <div class="form-group form-default" id="dish_attr_box_1">
                                                    <?php if($id == 0){ ?>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <input type="text" name="attribute[]" class="form-control" placeholder="Attribute" required">
                                                                <span class="form-bar"></span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="price[]" class="form-control" placeholder="Price" required">
                                                                <span class="form-bar"></span>
                                                            </div>
                                                            <div class="col-md-2 mt-2">
                                                                <input type="button" class="btn btn-success" value="Add More" onclick="add_more()">
                                                            </div>
                                                        </div>
                                                    <?php } else{ ?>
                                                      <?php
                                                        $attr_detail_query = "SELECT * FROM dish_details WHERE dish_id='$id'";    
                                                        $attr_details_res = mysqli_query($con, $attr_detail_query);
                                                            $ii = 1;
                                                            while($attr_details_row = mysqli_fetch_array($attr_details_res, MYSQLI_ASSOC)){
                                                      ?>
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <input type="hidden" name="dish_details_id[]" id="dish_details_id" value="<?php echo $attr_details_row['id']?>">
                                                                <input type="text" name="attribute[]" class="form-control" placeholder="Attribute" value="<?php echo $attr_details_row['attribute']; ?>" required ">
                                                                <span class="form-bar"></span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="price[]" class="form-control" placeholder="Price" value="<?php echo $attr_details_row['price']; ?>" required">
                                                                <span class="form-bar"></span>
                                                            </div>
                                                            <?php if($ii != 1){?>
                                                                <div class="col-md-2 mt-2">
                                                                    <input type="button" class="btn btn-success" value="Remove" onclick="remove_more_new(<?php echo $attr_details_row['id']?>)">
                                                                </div>
                                                            <?php } else {?>
                                                                <div class="col-md-2 mt-2">
                                                                    <input type="button" class="btn btn-success" value="Add More" onclick="add_more()">
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <?php $ii++; } ?>
                                                        
                                                    <?php } ?> 
                                                </div>
                                                <div>
                                                    <input type="submit" class="btn btn-primary" value="Submit" name="add_new_dish">
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

<input type="hidden" id="add_more" value="1">
<script>
    function add_more(){
        var add_more = jQuery("#add_more").val();
        add_more++;
        jQuery("#add_more").val(add_more);
        var html = '<div class="row" id="attr_box_'+add_more+'"><div class="col-md-5"><input type="text" name="attribute[]" class="form-control" placeholder="Attribute" required"><span class="form-bar"></span></div><div class="col-md-5"><input type="text" name="price[]" class="form-control" placeholder="Price" required"><span class="form-bar"></span></div><div class="col-md-2 mt-2"><input type="button" class="btn btn-success" value="Remove" onclick="remove_more('+add_more+')"></div></div>' ;
        jQuery("#dish_attr_box_1").append(html);
    }

    function remove_more(id){
        jQuery("#attr_box_"+id).remove(); 
    }

    function remove_more_new(id){
        var result = confirm("Are you sure ?");
        if(result == true){
            var current_path = window.location.href;
            window.location.href = current_path+"&dish_details_id="+id;
        }
    }
</script>

<?php
include('footer.php');
?>