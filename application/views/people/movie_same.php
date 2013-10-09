<?php
$this->load->view('public/header_movie');
?>

<body>
	<div class="public_main">
		<div class="photo_infor">
			<a href="http://www.douban.com/people/<?php echo $douban_id; ?>" class="no_unl fl">
    			<img src="http://img3.douban.com/icon/<?php echo $douban_icon; ?>" style="margin-top:40px;"/>
			</a>
			<div class="name_infor fr">
				<?php echo $this->account_model->get_account_name($page_uid); ?>&nbsp;&nbsp;&nbsp;口味相似度
				<?php echo $movie_score; ?>%
			</div>
		</div>
		<div class="star_intro">
			<img src="<?php echo base_url(); ?>resource/public/image/his_one.png" style="margin-right:5px;">
			<span style="margin-right:30px;">
				<?php echo $this->account_model->get_account_name($page_uid); ?>的评价
			</span> 
			<img src="<?php echo base_url(); ?>resource/public/image/my_one.png" style="margin-right:10px;">你的评价
		</div>
	
		<div class="mb_detail" style="height:auto;">
			<div class="mb_detail_title">
				你们评价相似的电影 . . . ( <span style="color:#009148;" class="no_unl">&nbsp;<?php echo $movie_same_count; ?>部&nbsp;</span> )
			</div>
			<div class="mb_image" style="height:auto;">
				<?php if ($movie_same_count > 0): ?>
						
					<!-- 5 star -->
					<?php if ($five_count > 0): ?>
					<?php foreach($movie_same_five as $value): ?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://movie.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_movie_image($value); ?>" />
								</a>
							</div>
							<br/>
							<div class="star_display">			
								<?php if($this->douban_model->get_movie_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								
								<br/>
								
								<?php if($this->douban_model->get_movie_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					
					<!-- 4 star -->
					<?php if ($four_count > 0): ?>
					<?php foreach($movie_same_four as $value): ?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://movie.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_movie_image($value); ?>" />
								</a>
							</div>
							<br/>
							<div class="star_display">				
								<?php if($this->douban_model->get_movie_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								
								<br/>
								
								<?php if($this->douban_model->get_movie_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					
					<!-- 3 star -->
					<?php if ($three_count > 0): ?>
					<?php foreach($movie_same_three as $value): ?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://movie.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_movie_image($value); ?>" />
								</a>
							</div>
							<br/>
							<div class="star_display">
								<?php if($this->douban_model->get_movie_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								
								<br/>
								
								<?php if($this->douban_model->get_movie_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>				
							</div>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					
					<!-- 2 star -->
					<?php if ($two_count > 0): ?>
					<?php foreach($movie_same_two as $value): ?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://movie.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_movie_image($value); ?>" />
								</a>
							</div>
							<br/>
							<div class="star_display">
								<?php if($this->douban_model->get_movie_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								
								<br/>
								
								<?php if($this->douban_model->get_movie_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					
					<!-- 1 star -->
					<?php if ($one_count > 0): ?>
					<?php foreach($movie_same_one as $value): ?>
						<div class="fl img_display">
							<div class="image_mb">
								<a href="http://movie.douban.com/subject/<?php echo $value; ?>/" target="_blank" class="no_unl">
									<img src="<?php echo $this->douban_model->get_movie_image($value); ?>" />
								</a>
							</div>
							<br/>
							<div class="star_display">
								<?php if($this->douban_model->get_movie_score($page_uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_five.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_four.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_three.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_two.png">
								<?php elseif($this->douban_model->get_movie_score($page_uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/his_one.png">
								<?php endif; ?>
								
								<br/>
								
								<?php if($this->douban_model->get_movie_score($account->uid, $value) == 5): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_five.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 4): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_four.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 3): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_three.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 2): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_two.png">
								<?php elseif($this->douban_model->get_movie_score($account->uid, $value) == 1): ?>
									<img src="<?php echo base_url(); ?>resource/public/image/my_one.png">
								<?php endif; ?>			
							</div>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					
				<?php endif; ?>
			</div>
		</div>
    
	</div>    
</body>

<?php
	$this->load->view('public/public_footer');
?>