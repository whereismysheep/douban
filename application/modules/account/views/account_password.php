<?php
$this->load->view('public/public_header');
?>
<body>
<div class="public-main">
	<div class="h200 w600 public-font pb10" style="border-bottom:1px dashed #C3C3C3;">	
		<img id="photo_big" src="<?php echo base_url(); ?>data/avatar/<?php echo $account->uid; ?>/big.jpg" class="fl w100 h100 mt50 mr10" style="border:1px solid #000;"/>	
		<h1 class="f15 mt80 w460 fr">
			<span class="f18 mr10"><?php echo $this->account_model->get_account_name($account->uid); ?></span>的帐号
		</h1>
		</br>
		<h2 class="f14 mt30 gray w460 fr account_infor" >
			<a href="<?php echo site_url('account/account_profile'); ?>" class="mr30 no_unl" style="color:#3e3e3e;">基本信息</a> 
			<a href="<?php echo site_url('account/upload_avatar'); ?>" class="mr30 no_unl" style="color:#3e3e3e;">更新头像</a> 	
			<a href="<?php echo site_url('account/account_password'); ?>" class="blue no_unl mr30">修改密码</a>
			<a href="<?php echo site_url('account/sign_out'); ?>" class="no_unl" style="color:#3e3e3e;">退出</a>
			
		</h2>
	</div>
	<div class="password_content w600 public-font f15">

		<?php echo form_open(uri_string()); ?>
           
			<div class="frame mt50">           
               	新密码 <span class="gray"> ( 字母、符号或数字 , 至少6位 )</span>
            	<br/>
                <?php echo form_password(array(
                        'name' => 'password_new_password',
                        'id' => 'password_new_password',
						'class'=>'password_frame mt10',
                        'value' => set_value('password_new_password'),
                        'autocomplete' => 'off'
                    )); ?>
                <?php echo form_error('password_new_password'); ?>
			</div>
            
            <div class="frame mt10">
                确认新密码 
            	<br/>
                <?php echo form_password(array(
                        'name' => 'password_retype_new_password',
                        'id' => 'password_retype_new_password',
						'class'=>'password_frame mt10',
                        'value' => set_value('password_retype_new_password'),
                        'autocomplete' => 'off'
                    )); ?>
                <?php echo form_error('password_retype_new_password'); ?>
            </div>
           
            <?php echo form_button(array(
				'type' => 'submit',
             	'class' => 'account_ps_bt mt15 fl mr30',
                'content' => ''
             )); ?>

			  <?php if ($this->session->flashdata('password_info')) : ?><!-- 更新成功 提示 -->
				<div class="mt25" style="color:#00a800;">
					<?php echo $this->session->flashdata('password_info'); ?>
				</div>
            <?php endif; ?>
           
		<?php echo form_close(); ?>
	</div>	
</div>
</body>
<?php
	$this->load->view('public/public_footer');
?>	
