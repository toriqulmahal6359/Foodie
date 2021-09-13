jQuery("#frmRegistration").on('submit', function(e){
    e.preventDefault();
    jQuery("#"+data.field).html('');
    jQuery.ajax({
        url: "login_register_submit.php",
        type: 'post',
        data: jQuery("#frmRegistration").serialize(),
        success: function(result){
            var data = jQuery.parseJSON(result);
            if(data.status == 'error'){
                jQuery("#"+data.field).html(data.msg);
            }
            if(data.status == 'success'){
                jQuery("#"+data.field).html(data.msg);
                jQuery("#frmRegistration")[0].reset();
            }
        }
    })
})