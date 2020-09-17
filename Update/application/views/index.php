<?php
    $user_id = $this->session->userdata('userid');
    if($user_id != ''){
        echo "<script>location.replace('".base_url()."home');</script>";
    }
?>
<!DOCTYPE html>
<head>
<title>E - Learning Apps | Login ke Aplikasi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="<?php base_url(); ?>assets/css/bootstrap.min.css" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="<?php base_url(); ?>assets/css/style.css" rel='stylesheet' type='text/css' />
<link href="<?php base_url(); ?>assets/css/style-responsive.css" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="<?php base_url(); ?>assets/css/font.css" type="text/css"/>
<link href="<?php base_url(); ?>assets/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="<?php base_url(); ?>assets/js/jquery2.0.3.min.js"></script>

<script src="<?php echo base_url();?>assets/sweetalert2-8.8.0/package/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/sweetalert2-8.8.0/package/dist/sweetalert2.min.css">
</head>
<body>
<div class="log-w3">
<div class="w3layouts-main">
	<h2>Silahkan Login</h2>
		<form enctype='application/json' id="loginform">
			<input type="text" class="ggg" id="username" name="username" placeholder="E-MAIL" required="">
			<input type="password" class="ggg" id="password" name="password" placeholder="PASSWORD" required="">
			<!-- <h6><a href="#">Forgot Password?</a></h6> -->
				<div class="clearfix"></div>
				<input type="submit" value="Sign In" name="btn_login" id="btn_login">
		</form>
		<!-- <p>Don't Have an Account ?<a href="registration.html">Create an account</a></p> -->
</div>
</div>
<script src="<?php base_url(); ?>assets/js/bootstrap.js"></script>
<script src="<?php base_url(); ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php base_url(); ?>assets/js/scripts.js"></script>
<script src="<?php base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?php base_url(); ?>assets/js/jquery.nicescroll.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php base_url(); ?>assets/js/jquery.scrollTo.js"></script>
</body>
</html>

<script type="text/javascript">
	$(function () {
		$(document).ready(function () {
			// alert("asd");
		});
		
		$('#loginform').submit(function (e) {
            $('#btn_login').text('Tunggu Sebentar...');
            $('#btn_login').attr('disabled',true);

            e.preventDefault();
            var me = $(this);
            // alert(me.serialize());
            $.ajax({
                type: "post",
                url: "<?=base_url()?>Auth/Log_Pro",
                data: me.serialize(),
                dataType: "json",
                success:function (response) {
                    if(response.success == true){
                        location.replace("<?=base_url()?>Home")
                    }
                    else{
                        if(response.message == 'L-01'){
                            Swal.fire({
                              type: 'error',
                              title: 'Oops...',
                              text: 'User dan password tidak sesuai dengan database!',
                              // footer: '<a href>Why do I have this issue?</a>'
                            }).then((result)=>{
                                $('#username').val('');
                                $('#password').val('');
                                $('#btn_login').text('Login');
                                $('#btn_login').attr('disabled',false);
                            });
                        }
                        else if(response.message == 'L-02'){
                            Swal.fire({
                              type: 'error',
                              title: 'Oops...',
                              text: 'User tidak di temukan!',
                              footer: '<a href>Why do I have this issue?</a>'
                            }).then((result)=>{
                                $('#username').val('');
                                $('#password').val('');
                                $('#btn_login').text('Login');
                                $('#btn_login').attr('disabled',false);
                            });
                        }
                        else{
                            Swal.fire({
                              type: 'error',
                              title: 'Oops...',
                              text: 'Undefine Error Contact your system administrator!',
                              footer: '<a href>Why do I have this issue?</a>'
                            }).then((result)=>{
                                $('#username').val('');
                                $('#password').val('');
                                $('#btn_login').text('Login');
                                $('#btn_login').attr('disabled',false);
                            });
                        }
                    }
                }
            });
        });
	});
</script>