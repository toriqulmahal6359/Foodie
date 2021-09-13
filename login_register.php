<?php
include('header.php');
?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg1">
                            <h4> login </h4>
                        </a>
                        <a data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="#" method="post">
                                        <input type="text" name="user-name" placeholder="Username">
                                        <input type="password" name="user-password" placeholder="Password">
                                        <div class="button-box">
                                            <div class="login-toggle-btn">
                                                <input type="checkbox">
                                                <label>Remember me</label>
                                                <a href="#">Forgot Password?</a>
                                            </div>
                                            <button type="submit"><span>Login</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="lg2" class="tab-pane">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form method="post" id="frmRegistration">
                                        <input type="text" name="name" id="name" placeholder="Name" required>
                                        <input type="email" name="email" id="email" placeholder="Email" required>
                                        <div id="email_error" class="field_error"></div>
                                        <input type="password" name="password" id="password" placeholder="Password" required>
                                        <input type="mobile" name="mobile" id="mobile" placeholder="Mobile" required>
                                        
                                        <div class="button-box">
                                            <button type="submit" id="register_submit"><span>Register</span></button>
                                        </div>
                                        <input type="hidden" name="type" value="register">
                                        <div id="success_msg" class="success_field"></div>
                                    </form>
                                </div>
                            </div>
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