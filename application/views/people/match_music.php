<?php
$this->load->view('public/header_music');
?>

<body>
	<div class="public_main">
		<div class="photo_infor">
			<a href="http://www.douban.com/people/<?php echo $douban_id; ?>" class="no_unl fl">
    			<img src="http://img3.douban.com/icon/<?php echo $douban_icon; ?>" style="margin-top:40px;"/>
			</a>
			<div class="name_infor fr">
				<?php echo $this->account_model->get_account_name($page_uid); ?>&nbsp;&nbsp;&nbsp;口味相似度
				<?php echo $music_score; ?>%
			</div>
		</div>
	
		<div class="mb_detail">
			<div class="mb_detail_title">
				你们评价相似的音乐 . . . ( <a href="<?php echo site_url("people/music_same/$page_uid"); ?>"  style="color:#00aaaa;font-size:14px;" class="no_unl">&nbsp;<?php echo $music_same_count; ?>张&nbsp;</a> )
			</div>
			<div class="mb_image">
				<?php if ($music_same_count > 0): ?>
					<?php $temp = 0; ?>
					<?php foreach($music_same as $value): ?>
						<?php
							if($temp++ >= 5)
								break;
						?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://music.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_music_image($value); ?>" />
								</a>
							</div>
							<br/>
							<div class="star_display">
								<?php if($this->douban_model->get_music_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								<br/>
								<?php if($this->douban_model->get_music_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>
					
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="star_intro">
			<img src="<?php echo base_url(); ?>resource/public/image/his_one.png" style="margin-right:5px;">
			<span style="margin-right:30px;">
				<?php echo $this->account_model->get_account_name($page_uid); ?>的评价
			</span> 
			<img src="<?php echo base_url(); ?>resource/public/image/my_one.png" style="margin-right:10px;">你的评价
		</div>

		<div class="mb_detail">
			<div class="mb_detail_title">
			你们评价相反的音乐 . . . ( <a href ="<?php echo site_url("people/music_different/$page_uid"); ?>"  style="color:#00aaaa;font-size:14px;" class="no_unl">&nbsp;<?php echo $music_different_count; ?>张&nbsp;</a> )
			</div>
			<div class="mb_image">
				<?php if ($music_different_count > 0): ?>
					<?php $temp = 0; ?>
					<?php foreach($music_different as $value): ?>
						<?php
							if($temp++ >= 5)
								break;
						?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://music.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_music_image($value); ?>"/>
								</a>
							</div>
							<br/>
							<div class="star_display">
								<?php if($this->douban_model->get_music_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								<br/>
								<?php if($this->douban_model->get_music_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_music_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>   
		
		<div class="star_intro">
			<img src="<?php echo base_url(); ?>resource/public/image/his_one.png" style="margin-right:5px;">
			<span style="margin-right:30px;">
				<?php echo $this->account_model->get_account_name($page_uid); ?>的评价
			</span> 
			<img src="<?php echo base_url(); ?>resource/public/image/my_one.png" style="margin-right:10px;">你的评价
		</div>

		<div class="mb_detail" style="height:220px;">
			<div class="mb_detail_title">
				<?php echo $this->account_model->get_account_name($page_uid); ?>收藏的音乐，你没听过 . . . ( <a href ="<?php echo site_url("people/music_recommend/$page_uid"); ?>"  style="color:#00aaaa;font-size:14px;" class="no_unl">&nbsp;<?php echo $music_his_own_count; ?>张&nbsp;</a> )
			</div>
			<div class="mb_image">
				<?php if ($music_his_own_count > 0): ?>
					<?php $temp = 0; ?>
					<?php foreach($music_his_own as $value): ?>
						<?php
							if($temp++ >= 5)
								break;
						?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://music.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_music_image($value); ?>"/>
								</a>
							</div>
							<br/>
							<div class="star_display">
								<?php if($this->douban_model->get_music_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_music_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="star_intro" style="margin-bottom:50px;">
			<img src="<?php echo base_url(); ?>resource/public/image/his_one.png" style="margin-right:5px;">
			<?php echo $this->account_model->get_account_name($page_uid); ?>的评价			
		</div>
	</div>    
</body>

<?php
	$this->load->view('public/public_footer');
?>