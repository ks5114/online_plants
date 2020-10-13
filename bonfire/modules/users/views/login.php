<?php
	$site_open = $this->settings_lib->item('auth.allow_register');
?>
<p><br/><a href="<?php echo site_url(); ?>">&larr; <?php echo lang('us_back_to') . $this->settings_lib->item('site.title'); ?></a></p>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
		<div class="m-grid__item m-grid__item--fluid m-login__wrapper">
			<div class="m-login__container">
				<div class="m-login__logo">
					<a href="#">
						<img src="<?php echo Template::theme_url('images/logo-1.png'); ?>">
					</a>
				</div>
				<div class="m-login__signin">
					<div class="m-login__head">
						<h3 class="m-login__title">Sign In To Admin</h3>
					</div>
					
		
					<?php echo form_open(LOGIN_URL, array('autocomplete'=>'off','class'=>'m-login__form m-form')); ?>
						<?php echo Template::message(); ?>

						<?php
							if (validation_errors()) :
						?>
						<div class="row-fluid">
							<div class="span12">
								<div class="alert alert-error fade in">
								<a data-dismiss="alert" class="close">&times;</a>
									<?php echo validation_errors(); ?>
								</div>
							</div>
						</div>
						<?php endif; ?>
						<div class="form-group m-form__group <?php echo iif( form_error('login') , 'error') ;?>">
							<input class="form-control m-input" type="text" placeholder="<?php echo $this->settings_lib->item('auth.login_type') == 'both' ? lang('bf_username') .'/'. lang('bf_email') : ucwords($this->settings_lib->item('auth.login_type')) ?>" name="login" id="login_value" value="<?php echo set_value('login'); ?>">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" type="password" name="password" id="password" value="" placeholder="<?php echo lang('bf_password'); ?>">
						</div>
						<div class="row m-login__form-sub">
							<?php if ($this->settings_lib->item('auth.allow_remember')) : ?>
							<div class="col m--align-left m-login__form-left">
								<label class="m-checkbox  m-checkbox--focus">
									<input type="checkbox" name="remember_me" id="remember_me" value="1"> <?php echo lang('us_remember_note'); ?>
									<span></span>
								</label>
							</div>
							<?php endif; ?>
							<div class="col m--align-right m-login__form-right">
								<a href="javascript:;" id="m_login_forget_password" class="m-link">Forget Password ?</a>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="submit" name="log-me-in" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary" value="<?php e(lang('us_let_me_in')); ?>">Sign In</button>
						</div>
					</form>
				</div>
				<!-- <div class="m-login__signup">
					<div class="m-login__head">
						<h3 class="m-login__title">Sign Up</h3>
						<div class="m-login__desc">Enter your details to create your account:</div>
					</div>
					<form class="m-login__form m-form" action="">
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="password" placeholder="Password" name="password">
						</div>
						<div class="form-group m-form__group">
							<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
						</div>
						<div class="row form-group m-form__group m-login__form-sub">
							<div class="col m--align-left">
								<label class="m-checkbox m-checkbox--focus">
									<input type="checkbox" name="agree">I Agree the <a href="#" class="m-link m-link--focus">terms and conditions</a>.
									<span></span>
								</label>
								<span class="m-form__help"></span>
							</div>
						</div>
						<div class="m-login__form-action">
							<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">Sign Up</button>&nbsp;&nbsp;
							<button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom  m-login__btn">Cancel</button>
						</div>
					</form>
				</div> -->
				<div class="m-login__forget-password">
					<div class="m-login__head">
						<h3 class="m-login__title">Forgotten Password ?</h3>
						<div class="m-login__desc">Enter your email to reset your password:</div>
					</div>
					<form class="m-login__form m-form" action="">
						<div class="form-group m-form__group">
							<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
						</div>
						<div class="m-login__form-action">
							<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primaryr">Request</button>&nbsp;&nbsp;
							<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Cancel</button>
						</div>
					</form>
				</div>
				<!-- <div class="m-login__account">
					<span class="m-login__account-msg">
						Don't have an account yet ?
					</span>&nbsp;&nbsp;
					<a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">Sign Up</a>
				</div> -->
			</div>
		</div>
	</div>
</div>	
<!-- end:: Page -->