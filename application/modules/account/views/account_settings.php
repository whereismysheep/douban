<?php
$this->load->view('public/public_header');
?>

<div class="public-main">
	<div class="h160 w600" style="border-bottom:1px dashed #C3C3C3;">
		<div class="profile_photo fl mt25">
			<img id="photo_big" src="<?php echo base_url(); ?>data/avatar/<?php echo $account->uid; ?>/big.jpg" />
		</div>	
		<h1 class="public-font f15 mt40 w280 fr mr160"><span class="f18 fb mr10"><?php echo $this->account_model->get_account_name($account->uid); ?></span>的帐号</h1>
		</br>
		<h2 class="public-font f12 mt30 gray w400 fr mr40" >		
			<a href="<?php echo site_url('account/upload_avatar'); ?>" class="mr30 no_unl gray">更新头像</a> 	
			<a href="<?php echo site_url('account/account_password'); ?>" class="fb no_unl gray mr30">修改密码</a>
			<a href="<?php echo site_url('account/sign_out'); ?>" class="no_unl gray">退出</a>
			
		</h2>
	</div>

    <div class="container_12">
        
        <div class="grid_8">

            <?php echo form_open(uri_string()); ?>
			
			<div class="grid_2 alpha">
                <?php echo form_label('性别'); ?>
            </div>
            <div class="grid_6 omega">
                <?php $s = ($this->input->post('settings_gender') ? $this->input->post('settings_gender') : (isset($account_details->gender) ? $account_details->gender : '')); ?>
                <select name="settings_gender">
                    <option value=""><?php echo lang('settings_select'); ?></option>
                    <option value="m"<?php if ($s == 'm') echo ' selected="selected"'; ?>><?php echo '男'; ?></option>
                    <option value="f"<?php if ($s == 'f') echo ' selected="selected"'; ?>><?php echo '女'; ?></option>
                </select>
            </div>
            <div class="clear"></div>
            
            <div class="prefix_2 grid_6 alpha omega">
                <?php echo form_button(array(
                        'type' => 'submit',
                        'class' => 'button',
                        'content' => lang('settings_save')
                    )); ?>
            </div>
            <?php echo form_fieldset_close(); ?>
            <?php echo form_close(); ?>
        </div>
        <div class="clear"></div>


    </div>

<?php
$this->load->view('public/public_footer');
?>	