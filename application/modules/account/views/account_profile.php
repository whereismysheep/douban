<?php
$this->load->view('public/public_header');
?>
<body>
	<div class="public-main">
		<div class="h200 w600 public-font pb10" style="border-bottom:1px dashed #C3C3C3;">
			<img id="photo_big" src="<?php echo base_url(); ?>data/avatar/<?php echo $account->uid; ?>/big.jpg" class="fl w100 h100 mt50" style="border:1px solid #000;"/>		
			<h1 class=" f15 mt80 w460 fr">
            	<span class="f18 mr10"><?php echo $this->account_model->get_account_name($account->uid); ?></span>的帐号
           	</h1>
			</br>
			<h2 class="f14 mt30 gray w460 fr account_infor" >
				<a href="<?php echo site_url('account/account_profile'); ?>" class="blue mr30 no_unl">基本信息</a> 
				<a href="<?php echo site_url('account/upload_avatar'); ?>" class="mr30 no_unl" style="color:#3e3e3e;">更新头像</a> 	
				<a href="<?php echo site_url('account/account_password'); ?>" class="no_unl mr30" style="color:#3e3e3e;">修改密码</a>
				<a href="<?php echo site_url('account/sign_out'); ?>" class="no_unl" style="color:#3e3e3e;">退出</a>
			</h2>
		</div>
        
		<div class="w600 h500 public-font f15">

			<?php echo form_open_multipart(uri_string()); ?>
           	<div class="w600 h100 mt50">
            	<div class="user_name w400 h100 fl">
            		<div class=" mb20">
                		称呼
            		</div>
            		
                	<?php echo form_input(array(
                        'name' => 'profile_username',
                        'id' => 'profile_username',
						'class'=>'pl10 public-font f15',
                        'value' => set_value('profile_username') ? set_value('profile_username') : (isset($account->username) ? $account->username : ''),
                        'maxlength' => '8'
                    )); ?>
                	<?php echo form_error('profile_username'); ?>
                	<?php if (isset($profile_username_error)) : ?>
                	<span class="field_error"><?php echo $profile_username_error; ?></span>
                	<?php endif; ?>
            	</div>

				<div class="user_gender w200 h100 fr">
					<div class="mb20">
                	性别
            		</div>         			
                	<?php $s = ($this->input->post('settings_gender') ? $this->input->post('settings_gender') : (isset($user_info->gender) ? $user_info->gender : '')); ?>
                	<select name="settings_gender" class="settings_gender pl10 public-font f15">
                    	<option value="s"<?php if ($s == 's') echo ' selected="selected"'; ?> >secret</option>
                    	<option value="m"<?php if ($s == 'm') echo ' selected="selected"'; ?> > 男 </option>
                    	<option value="f"<?php if ($s == 'f') echo ' selected="selected"'; ?> > 女 </option>
                	</select>
               </div>
            </div>

			<div class="introuce mt40">
            	<div class="mb20">
               		自我介绍 ( 最多70个字 )
            	</div>
                   	
				<?php echo form_textarea(array(
                        'name' => 'profile_introduction',
                        'id' => 'profile_introduction',
						'class'=>'pl10 public-font f15',
                        'value' => set_value('profile_introduction') ? set_value('profile_introduction') : (isset($user_info->introduction) ? $user_info->introduction : ''),
						'wrap' => 'virtual'
				)); ?> 

                <?php echo form_error('profile_introduction'); ?>
                <?php if (isset($profile_introduction_error)) : ?>
                <div class="field_error"><?php echo $profile_introduction_error; ?></div>
                <?php endif; ?>
            </div>
            
        
            <?php echo form_button(array(
				'type' => 'submit',
				'class' => 'update_button mt50 mb50 fl mr30'
			)); ?>

           	<?php if ($this->session->flashdata('profile_info')) : ?><!-- 更新成功 提示 -->
				<div class="mt60" style="color:#00a800;">
					<?php echo $this->session->flashdata('profile_info'); ?>
				</div>
            <?php endif; ?>

            <?php echo form_close(); ?>
    	</div>
	</div>      
</body>
<?php
	$this->load->view('public/public_footer');
?>	
