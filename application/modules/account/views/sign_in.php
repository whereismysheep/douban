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
    	
		<h1 class="public-font font_signin">登录寻羊</h1>

        <div class="sign_main mt90">
        	<div class="sign_frame_top">
			<?php echo form_open(uri_string().($this->input->get('continue')?'/?continue='.urlencode($this->input->get('continue')):'')); ?>
       		<?php if (isset($sign_in_error)) : ?>
				<div class="form_error"><?php echo $sign_in_error; ?></div>				
				<div class="clear"></div>
            	<?php endif; ?>
				<div class="frame">
                	<div class="public-font f15 fl mt7"><?php echo form_label('电 邮'); ?></div>
					<div class="fr">
                	<?php echo form_input(array(
						'class'=>'sign_up_frame',
                        'name' => 'sign_in_username_email',
                        'id' => 'sign_in_username_email',
                        'value' => set_value('sign_in_username_email'),
                        'maxlength' => '24'
                    )); ?>
                	<div class="f12 public-font mt10"><?php echo form_error('sign_in_username_email'); ?></div>
                	<?php if (isset($sign_in_username_email_error)) : ?>
                    <div class="f12 public-font mt10"><?php echo $sign_in_username_email_error; ?></div>
                    <?php endif; ?>
					</div>
           		</div>
            
           		<div class="frame mt30">
                	<div class="public-font f15 fl mt7"><?php echo form_label('密 码'); ?></div>
					<div class="fr">
                	<?php echo form_password(array(
						'class'=>'sign_up_frame',
                        'name' => 'sign_in_password',
                        'id' => 'sign_in_password',
                        'value' => set_value('sign_in_password')
                    )); ?>
                	<div class="f12 public-font mt10"><?php echo form_error('sign_in_password'); ?></div>
					</div>
            	</div>
					
				<div class="check_button h60 mt30">
                 	<div class="check_but_left fl public-font ml50 mt7">
						<?php echo form_checkbox(array(
						'name' => 'sign_in_remember',
						'id' => 'sign_in_remember',
						'value' => 'TRUE',
						'checked' => $this->input->post('sign_in_remember'),
						'class' => 'checkbox fl' 
						)); ?>
						<div class="fr f13">
                        	<span class="gray"><?php echo form_label('记住我'); ?></span>	 
						</div>
            		</div>
                     
					<?php echo form_button(array(
					'type' => 'submit',
					'class' => 'button fr mr30',
					)); ?> 
                          
				</div>
					
            	<!--<?php echo anchor('account/forgot_password', lang('sign_in_forgot_your_password')); ?>-->
		
				<?php echo form_close(); ?>
            </div>
			
			<div class="w150 h25 gray public-font fr">
			<!--
			<span class="f12">> 第一次来？ 请 </span><a href="<?php echo site_url('account/sign_up'); ?>" class="no_unl gray f12" style="color:#007d00;">注册</a>
			-->
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