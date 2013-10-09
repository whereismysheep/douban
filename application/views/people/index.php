<?php
$this->load->view('public/public_header');
?>
<body>

<div class="public_main" style="height:550px;">
	<table class="match_main">
			<tr>
				<td class="person_infor">
					<a href="http://www.douban.com/people/<?php echo $account->douban_id; ?>"  target="_blank">
    					<?php
    						if($account->douban_icon != "user_normal.jpg")//大头像
    						{
    							$icon = "ul" . substr($account->douban_icon,1);
    							
    							if($this->douban_model->checkRemoteFile("http://img3.douban.com/icon/$icon") == FALSE)//大图不存在
    							{
    								$icon = $douban_icon;
    							}
    						}
    						else
    						{
    							$icon = $account->douban_icon;
    						}
    					?>
						<img src="http://img3.douban.com/icon/<?php echo $icon; ?>" />
					</a>
				</td>
				<td class="match_word">
					<span style="font-family:'Arial';font-size:36px;font-style:oblique;color:#8d8d8d;">VS</span>
				</td>
				<td class="person_infor">
					<a href="http://www.douban.com/people/<?php echo $douban_id; ?>" target="_blank"> 
    					<?php
    						if($douban_icon!="user_normal.jpg")//大头像
    						{
    							$icon = "ul" . substr($douban_icon,1);
    							
    							if($this->douban_model->checkRemoteFile("http://img3.douban.com/icon/$icon") == FALSE)//大图不存在
    							{
    								$icon = $douban_icon;
    							}
    						}
    						else
    						{
    							$icon = $douban_icon;
    						}
    					?>
						<img src="http://img3.douban.com/icon/<?php echo $icon; ?>" />
					</a>
				</td>
			</tr>
			<tr>
				<td class="person_infor" style="height:30px;">
					<?php echo $account->username; ?>
				</td>
				<td class="match_word" style="height:30px;">
					<span style="font-family:'Heiti SC';font-size:20px;">平均相似度
					<?php echo $average_score; ?>%</span>
				</td>
				<td class="person_infor" style="height:30px;">
					<?php echo $this->account_model->get_account_name($page_uid); ?>
				</td>
			</tr>
	</table>
	
	<div class="match_detail">	
		<div class="detail_content fl" style="margin-right:100px;">
			<img src="http://img1.douban.com/pics/nav/lg_movie_a10.png" style="margin-bottom:30px;"/>
			<div class="match_score"><?php echo $movie_score; ?>%</div>				
			<input type="button" class="font_check" value="查看详细" onclick="window.open('<?php echo site_url("people/match_movie/$page_uid");?>')" />
			
		</div>
		<div class="detail_content fl" style="margin-right:100px;">
			<img src="http://img1.douban.com/pics/nav/lg_book_a10.png" style="margin-bottom:30px;"/>
			<div class="match_score"><?php echo $book_score; ?>%</div>	
						
			<input type="button" class="font_check" value="查看详细" onclick="window.open('<?php echo site_url("people/match_book/$page_uid");?>')" />	
		</div>
		<div class="detail_content fl">
			<img src="http://img1.douban.com/pics/nav/lg_music_a10.png" style="margin-bottom:30px;"/>
			<div class="match_score"><?php echo $music_score; ?>%</div>
			
			<input type="button" class="font_check" value="查看详细" onclick="window.open('<?php echo site_url("people/match_music/$page_uid");?>')" />
			
		</div>
	</div>	
</div>

</body>

<?php
$this->load->view('public/public_footer');
?>