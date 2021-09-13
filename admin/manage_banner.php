<?php
include('header.php');

//for adding category
$banner_image='';
$heading = '';
$sub_heading = '';
$link = '';
$link_txt = '';
$order_number = '';
$id='';
$img_status = 'required';
$img_format_error = '';
$msg ='';

    //for updating category
    if(isset($_GET['id']) && $_GET['id'] > 0){
        $id = get_safe_value($_GET['id']);
        $query = "SELECT * FROM banner WHERE id='$id'";
        $res = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($res);

        $image = $row['banner_image'];
        $heading = $row['heading'];
        $sub_heading = $row['sub_heading'];
        $link = $row['link'];
        $link_txt = $row['link_txt'];
        $order_number = $row['order_number'];
        
        $img_status = '';
    }

    if(isset($_GET['dish_details_id']) && $_GET['dish_details_id'] > 0){
        $dish_details_id = get_safe_value($_GET['dish_details_id']);
        $id = get_safe_value($_GET['id']);
        $remove_query = "DELETE FROM dish_details WHERE id='$dish_details_id'";
        mysqli_query($con, $remove_query);
        redirect('manage_dish.php?id='.$id);
    }

    if(isset($_POST['add_banner'])){
        // prx($_POST);
        $heading = get_safe_value($_POST['heading']);
        $sub_heading = get_safe_value($_POST['sub_heading']);
        $link = get_safe_value($_POST['link']); 
        $link_txt = get_safe_value($_POST['link_txt']); 
        $order_number = get_safe_value($_POST['order_number']); 
        $added_on = date('Y-m-d h:i:s');


            if($id==''){ 
                $type = $_FILES['banner_image']['type'];
                //here image is mandatory
                if($type != 'image/jpeg' && $type != 'image/jpg' && $type != 'image/png'){
                    $img_format_error = 'Image should be in .jpeg, .jpg or .png format';
                }else{
                    //insert an image with proper requirements
                    $image = rand(111111111, 999999999).'_'.$_FILES['banner_image']['name'];
                    move_uploaded_file($_FILES['banner_image']['tmp_name'], SERVER_BANNER_IMAGE.$image);
                    $insert_query = "INSERT INTO banner(heading,sub_heading,link,link_txt,order_number,banner_image,status,added_on) VALUES('$heading','$sub_heading','$link','$link_txt','$order_number','$image',1,'$added_on')";
                    mysqli_query($con, $insert_query);

                    redirect('banner.php'); 
                }
            }else{
                $img_condition = '';
                if($_FILES['banner_image']['type'] == ''){
                    $update_query = "UPDATE banner SET heading='$heading', sub_heading='$sub_heading', link='$link', link_txt='$link_txt', order_number='$order_number' WHERE id='$id'";
                    mysqli_query($con, $update_query);
                    redirect('banner.php');
                }else{
                    $type = $_FILES['banner_image']['type'];
                    if($type != 'image/jpeg' && $type != 'image/jpg' && $type != 'image/png'){
                        $img_format_error = 'Image should be in .jpeg, .jpg or .png format';
                    }else{
                        //update an image
                        $new_image = rand(111111111, 999999999).'_'.$_FILES['banner_image']['name'];
                        move_uploaded_file($_FILES['banner_image']['tmp_name'], SERVER_BANNER_IMAGE.$new_image);
                        $img_condition = ", banner_image='$new_image'";

                        //old Image delete
                        $old_image_query = "SELECT banner_image FROM banner WHERE id='$id'";
                        $old_img_res = mysqli_query($con, $old_image_query);
                        $oldImageRow = mysqli_fetch_assoc($old_img_res);

                        $old_image = $oldImageRow['banner_image'];
                        unlink(SERVER_BANNER_IMAGE.$old_image);

                        //Update Banner Query if have banner image
                        $update_query = "UPDATE banner SET heading='$heading', sub_heading='$sub_heading', link='$link', link_txt='$link_txt', order_number='$order_number' $img_condition WHERE id='$id'";
                        mysqli_query($con, $update_query);
                        redirect('banner.php');
                    }
                }
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
                                            <h1>Manage Banner</h1>
                                            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
                                        </div>
                                        <div class="card-block">
                                            <form class="form-material" method="POST" enctype="multipart/form-data">
                                                <div class="form-group form-default">
                                                    <input type="text" name="heading" class="form-control" required value="<?php echo $heading; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="heading" class="float-label">Heading</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="sub_heading" class="form-control" required value="<?php echo $sub_heading; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="sub_heading" class="float-label">Sub Heading</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="order_number" class="form-control" required value="<?php echo $order_number; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="order_number" class="float-label">Order Number</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="file" name="banner_image" class="form-control" <?php echo $img_status; ?>">
                                                    <span class="form-bar"></span>
                                                    <span class="text-danger"><?php echo $img_format_error; ?></span>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="link" class="form-control" required value="<?php echo $link; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="link" class="float-label">Link</label>
                                                </div>
                                                <div class="form-group form-default">
                                                    <input type="text" name="link_txt" class="form-control" required value="<?php echo $link_txt; ?>">
                                                    <span class="form-bar"></span>
                                                    <label for="link_txt" class="float-label">Link Text</label>
                                                </div>
                                                <div>
                                                    <input type="submit" class="btn btn-primary" value="Submit" name="add_banner">
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