<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />
<title><?=$title;?></title>
<link media="screen" rel="stylesheet" type="text/css" href="css/login.css"  />
<!-- blue theme is default -->
<link rel="stylesheet" type="text/css" href="css/black-theme-login.css" />
<!--[if lte IE 6]><link media="screen" rel="stylesheet" type="text/css" href="css/login-ie.css" /><![endif]-->
</head>

<body>
	<div id="wrapper">
	<?=form_open('index',array('class'=>'login_form'))."\n";?>
		<fieldset>
			<div class="title_wrapper">
				<h1>Please Log in</h1>
				<a href="#">Forgot Password?</a>
			</div>
			<div class="inputs">
				<div class="inputs_inner">
					
					<label>
						<strong>Username:</strong>
						<span class="input"><?=form_input('username','');?></span>
					</label>
					<label>
						<strong>Password:</strong>
						<span class="input"><?=form_password('password','');?></span>
					</label>
					<span class="button first_btn"><span><span>Log in</span></span><?=form_submit('submit','submit');?></span>
				</div>
			</div>
			<div class="reminder">
				<?=form_checkbox('remember','keepalive',FALSE);?> Remember me on this computer
			</div>
		</fieldset>
	</form>
	
	</div>
</body>
</html>
