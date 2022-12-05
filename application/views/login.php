<!DOCTYPE html>
<html lang="en">

<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Askpa - Login</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/app.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bundles/bootstrap-social/bootstrap-social.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/components.css">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url(); ?>assets/img/logo-fav.ico' />
</head>
<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="card card-primary">
                            <div class="card-header" style="display:block;text-align:center;">
                                <img src="<?php echo base_url(); ?>assets/img/logo-app.png" width="200px">
                            </div>
                            <div class="card-body">
                                <h4>Login</h4>
                                <?php if($this->session->flashdata('unsuccess')){?>
									<div>
										<p class="alert alert-warning" style="padding: 7px 20px;"><?php echo $this->session->flashdata('unsuccess'); ?><span class="closebtn"onclick="close()">&times;</span></p>
									</div>
								<?php }else if($this->session->flashdata('success')){?>
                                    <div>
										<p class="alert alert-success" style="padding: 7px 20px;"><?php echo $this->session->flashdata('success'); ?><span class="closebtn"onclick="close()">&times;</span></p>
									</div>
                                <?php }?>
                                <form method="POST" action="<?php echo base_url('Login/auth');?>" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                        Please fill in your email
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="#" class="text-small">
                                                Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                        please fill in your password
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="save" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- General JS Scripts -->
    <script src="<?php echo base_url()?>assets/js/app.min.js"></script>
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="<?php echo base_url()?>assets/js/scripts.js"></script>
    <!-- Custom JS File -->
    <script src="<?php echo base_url()?>assets/js/custom.js"></script>
    <script>
    var close = document.getElementsByClassName("closebtn");
    var i;
    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>
</body>
<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>