<?php
include("header.php");

$cat_val = '';
$cat_list_arr = array();
if(isset($_GET['category_id'])){
    $cat_val = $_GET['category_id'];
    $cat_list_arr = array_filter(explode(":", $cat_val));
    $cat_list_str = implode(',', $cat_list_arr );
}
?>
<div class="breadcrumb-area gray-bg">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li class="active">Shop Grid Style </li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-page-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="banner-area pb-30">
                    <a href="product-details.html"><img alt="" src="assets/front/img/banner/banner-49.jpg"></a>
                </div>

                <?php
                $cat_id = 0;
                    $dish_query = "SELECT * FROM dish WHERE status = 1 ";
                    if(isset($_GET['category_id']) && $_GET['category_id']!=''){
                        $dish_query .= "AND category_id IN ($cat_list_str) ";
                    }
                    $dish_query .= "ORDER BY dish DESC";
                    $dish_res = mysqli_query($con, $dish_query);
                    $dish_count = mysqli_num_rows($dish_res);
                ?>
                <div class="grid-list-product-wrapper">
                    <div class="product-grid product-view pb-20">
                        <?php if($dish_count != 0){ ?>
                        <div class="row">
                            <?php
                                while($dish_row = mysqli_fetch_assoc($dish_res)){ 
                            ?>
                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img src="<?php echo SITE_DISH_IMAGE.$dish_row['dish_image']; ?>" alt="<?php echo $dish_row['dish']; ?>">
                                        </a>
                                    </div>
                                    <div class="product-content" id="dish_details">
                                        <h4>
                                            <a href="javascript:void(0)"><?php echo $dish_row['dish']; ?> </a>
                                        </h4>
                                        <?php
                                            $dish_attr_query = "SELECT * FROM dish_details WHERE status='1' AND dish_id='".$dish_row['id']."'";
                                            $dish_attr_res = mysqli_query($con, $dish_attr_query);
                                        ?>
                                        <div class="product-price-wrapper">
                                            <?php
                                                while($dish_attr_row = mysqli_fetch_array($dish_attr_res, MYSQLI_ASSOC)){
                                                    echo '<input type="radio" class="dish_attr" name="radio_'.$dish_row['id'].'" onclick=get_dish_price('.$dish_attr_row['price'].') value='.$dish_attr_row['id'].'/>';
                                                    echo $dish_attr_row['attribute'];
                                                    echo "&nbsp&nbsp";
                                                    echo "<span class='price'>(".$dish_attr_row['price'].")</span>";
                                                    echo "&nbsp&nbsp";
                                                }
                                            ?>
                                            <span id="dish_price"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php    
                                }
                            ?>
                        </div>
                        <?php }else{
                            echo "No Dish Found";
                        } ?>
                    </div>

                </div>
            </div>
            <?php
                $cat_query = "SELECT * FROM category WHERE status=1 ORDER BY order_number DESC";
                $cat_res = mysqli_query($con, $cat_query);
            ?>
            <div class="col-lg-3">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">Shop By Categories</h4>
                        <div class="shop-catigory">
                            <a href="shop.php"><u>Clear</u></a>
                            <ul id="faq" class="category_list">
                            <?php
                                while($cat_row = mysqli_fetch_assoc($cat_res)){
                                    $class="selected";
                                        if($cat_id == $cat_row['id']){
                                            $class="active";
                                        }
                                        $is_checked = '';
                                        if(in_array($cat_row['id'],$cat_list_arr)){
                                            $is_checked = "checked='checked'";   
                                        }
                                    echo "<li><input type='checkbox' onclick=set_category_list(".$cat_row['id'].") $is_checked class='category_checks' name='cat_arr[]' value='".$cat_row['id']."'/>".$cat_row['category']."</a> </li>";
                                } 
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="get" id="frmCategoryValue">
    <input type="hidden" name="category_id" id="category_id" value="<?php echo $cat_val; ?>">
</form>
<script>
    function set_category_list(id){
        var cat_val = jQuery('#category_id').val();
        var check = cat_val.search(":"+id);
        if(check != '-1'){
            cat_val = cat_val.replace(":"+id, '');
        }else{
            cat_val = cat_val+":"+id;
        }
        jQuery("#category_id").val(cat_val);
        jQuery("#frmCategoryValue")[0].submit();
    }
</script>

<?php
include("footer.php");
?>