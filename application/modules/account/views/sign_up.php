<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="stylesheet" href="<?php echo base_url(); ?>resource/public/css/base.css" type="text/css" media="screen" charset="utf-8" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>resource/account/css/account.css" type="text/css" media="screen" charset="utf-8" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>resource/public/css/common.css" type="text/css" media="screen" charset="utf-8" />

	<script src="<?php echo base_url(); ?>resource/public/js/baidutongji.js" type="text/javascript" language="javascript"></script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>
		寻羊 Where is My Sheep
	</title>
</head>

<body style="width:100%;height:100%;background-color:#f5f5f5;">
	<div class="account">    	
		<h1 class="public-font font_signup">第 1 步 .&nbsp;&nbsp;注册 寻羊帐号</h1>
				
        <div class="sign_main mt60">
        	<div class="sign_frame_top">
			<?php echo form_open(uri_string()); ?>
        		<div class="frame">
					<div class="public-font f15 fl mt7" style="color:#5b5b5b;"><?php echo form_label('电 邮'); ?></div>
                	<div class="fr">
						<?php echo form_input(array(
							'class'=>'sign_up_frame',
                			'name' => 'sign_up_email',
                    		'id' => 'sign_up_email',
                    		'value' => set_value('sign_up_email'),
                    		'maxlength' => '160'
                		)); ?>
						<div class="f12 public-font mt10"><?php echo form_error('sign_up_email'); ?></div>
					<?php if (isset($sign_up_email_error)) : ?>
						<div class="f12 public-font mt10"><?php echo $sign_up_email_error; ?></div>
					<?php endif; ?>
					</div>
				</div>

				<div class="frame mt40">
					<div class="public-font f15 fl mt7" style="color:#5b5b5b;"><?php echo form_label('密 码'); ?></div>
					<div class="fr">
						<?php echo form_password(array(
							'class'=>'sign_up_frame',
                			'name' => 'sign_up_password',
                    		'id' => 'sign_up_password',
                    		'value' => set_value('sign_up_password')
               			)); ?>
						<div class="f12 public-font mt10"><?php echo form_error('sign_up_password'); ?></div>
					</div>
				</div>

				<div class="frame mt40">
					<div class="public-font f15 fl mt7" style="color:#5b5b5b;"><?php echo form_label('称 呼'); ?></div>
               	 	<div class="fr">
						<?php echo form_input(array(
							'class'=>'sign_up_frame',
                    		'name' => 'sign_up_username',
                    		'id' => 'sign_up_username',
                   			'value' => set_value('sign_up_username'),
                    		'maxlength' => '24'
						)); ?>
						<div class="f12 public-font mt10"><?php echo form_error('sign_up_username'); ?></div>
					<?php if (isset($sign_up_username_error)) : ?>
						<div class="f12 public-font mt10"><?php echo $sign_up_username_error; ?></div>
					<?php endif; ?>
					</div>
				</div>

            </div>
           
			<div class="mt50 sign_register_bottom">
				<div class="f12 fl public-font font_re">
					已有帐号?&nbsp;
					<a href="<?php echo site_url('account/sign_in'); ?>" class="no_unl" style="color:#c4c4c4;">登录</a>
				</div>
                <?php echo form_button(array(
                    'type' => 'submit',
                    'class' => 'button ml40',
                )); ?>
			</div>
   			<?php echo form_close(); ?>
			</div>

			<div class="w150 h25 gray public-font fr">
			
				<form method="get" action="https://www.douban.com/service/auth2/auth">
					<input type="hidden" name="client_id" value="0c9c858fbdb43de825d590af391cb9b8">
					<input type="hidden" name="redirect_uri" value="http://www.whereismysheep.com/beta/index.php/account/sign_in_with_douban">
					<input type="hidden" name="response_type" value="code">
				
					<input type="image" src="<?php echo base_url(); ?>resource/account/image/login_with_douban_18.png" width="110" height="18" />
				</form>
			</div>
		</div>
	</div>
	
    <div class="h30"></div>
</body>
</html>