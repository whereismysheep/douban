<?php
$this->load->view('public/public_header');
?>
<body>

<?php if ($this->authentication->is_signed_in()): ?><!-- 登录首页 -->
<div class="public_main">
	<div class="fl pl_main_left">
		<div class="match_font">
			与你口味最相似的人
		</div>
		<div class="match_result">
			<?php foreach($similar_match->result() as $row): ?>
				<div class="result_img fl">
					<a href="<?php echo site_url("people/index/$row->guest_uid");?>" class="no_unl" target="_blank">
						<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon($row->guest_uid) ?>"/>
					</a>
					<div class="tc result_name">
						<?php echo $this->account_model->get_account_name($row->guest_uid); ?>
             		</div>
        		</div>
			<?php endforeach; ?>
		</div>

		<div class="match_font">
			呵呵，一些“名人”
		</div>
		<div class="match_result">
			
    		<div class="result_img fl">
				<a href="<?php echo site_url("people/index/23");?>" class="no_unl" target="_blank">
					<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon(23) ?>"/>
				</a>
				<div class="tc result_name">
					<?php echo $this->account_model->get_account_name(23); ?>
        		</div>
			</div>
			
			<div class="result_img fl">
				<a href="<?php echo site_url("people/index/25");?>" class="no_unl" target="_blank">
					<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon(25) ?>"/>
				</a>
				<div class="tc result_name">
					<?php echo $this->account_model->get_account_name(25); ?>
        		</div>
			</div>
			
			<div class="result_img fl">
				<a href="<?php echo site_url("people/index/2");?>" class="no_unl" target="_blank">
					<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon(2) ?>"/>
				</a>
				<div class="tc result_name">
					<?php echo $this->account_model->get_account_name(2); ?>
        		</div>
			</div>
			
			<div class="result_img fl">
				<a href="<?php echo site_url("people/index/41");?>" class="no_unl" target="_blank">
					<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon(41) ?>"/>
				</a>
				<div class="tc result_name">
					<?php echo $this->account_model->get_account_name(41); ?>
        		</div>
			</div>
			
			<div class="result_img fl">
				<a href="<?php echo site_url("people/index/54");?>" class="no_unl" target="_blank">
					<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon(54) ?>"/>
				</a>
				<div class="tc result_name">
					<?php echo $this->account_model->get_account_name(54); ?>
        		</div>
			</div>
			
			<div class="result_img fl">
				<a href="<?php echo site_url("people/index/46");?>" class="no_unl" target="_blank">
					<img src="http://img3.douban.com/icon/<?php echo $this->account_model->get_account_douban_icon(46) ?>"/>
				</a>
				<div class="tc result_name">
					<?php echo $this->account_model->get_account_name(46); ?>
        		</div>
			</div>
			
		</div>
	</div>

	<div class="fr pl_main_right">		
		<div class="search_text">想和某个特定的豆瓣用户比较？<br/>请输入该用户的uid</div>
		<form method="post" action="<?php echo site_url('people/index'); ?>" style="margin-top:5px;">
			<input type="text" name="douban_id" style="width:210px;height:20px;" />
			<input type="submit" value="提交" style="width:55px;height:30px;" />
		</form>
		
		<?php if($mark == 1): ?>
			<div class="search_text_pro">
				uid 有问题～
			</div>
		<?php endif;?>
			
		
		
		<div class="search_intro">
			uid为用户个人主页地址的最后一节，例如：
			<br/>
			http://www.douban.com/people/***/ 中的星号部分
		</div>
		<div class="recommend fr">
			<div class="fl" style="height:30px;line-height:180%;">^_^ 有一点点帮助?</div>
			<a href="javascript:void(function(){var d=document,e=encodeURIComponent,s1=window.getSelection,s2=d.getSelection,s3=d.selection,s=s1?s1():s2?s2():s3?s3.createRange().text:'',r='http://www.douban.com/recommend/?url='+e(d.location.href)+'&title='+e(d.title)+'&sel='+e(s)+'&v=1',x=function(){if(!window.open(r,'douban','toolbar=0,resizable=1,scrollbars=yes,status=1,width=450,height=330'))location.href=r+'&r=1'};if(/Firefox/.test(navigator.userAgent)){setTimeout(x,0)}else{x()}})()" class="fr">
				<img src="http://img3.douban.com/pics/douban-icons/rec_to_douban_24.png" alt="推荐到豆瓣" />
			</a>
		</div>
	</div>	
</div>

<?php else: ?><!-- 未登录首页 -->

<div class="public_main" style="color:#CCC;">

	<div class="first" style="color:black;">
		-_- 豆瓣新版API 「不再提供用户收藏」...
		<br/>
		寻羊无法继续服务了...
		<br/>
		顺便，要工作了。
		<br/>
		于是，先这样吧~
	</div>
	
	<div class="first" >
		豆瓣上谁和你共同喜好最多？
		<br/>
		你们之间除了共同喜好外，又隐藏了多少分歧？
		<br/>
		究竟，谁和你 「最臭味相投」？
		<br/>
		寻羊尝试回答这些问题，使你更舒服地使用豆瓣～
	</div>
	
	<div class="second">
		<span style="font-size:28px;">试用步骤</span>
		<br/>
		
		1. 发一封豆邮给 试验员 <a href="http://www.douban.com/people/dbcaulfield/" class="no_unl" style="color:#00a3e8;" target="_blank">D.B.</a> ，告诉他你要参加试验。
		<br/>
		<a href="http://www.douban.com/people/dbcaulfield/" target="_blank" style="margin-top:15px;margin-left:15px;">
			<img src="http://img3.douban.com/icon/u2319731-26.jpg"/>
		</a>
		<br/>
		2. 睡个午觉（其实一般1小时之内我们就会高兴地回应你），醒来洗一把脸 . . .
		<br/>
		&nbsp;&nbsp;&nbsp;点击下方的“用豆瓣帐号登陆”，就可以开始尝鲜啦～
		<form method="get" action="https://www.douban.com/service/auth2/auth" style="margin-top:20px;margin-left:15px;">
				<input type="hidden" name="client_id" value="0d9de8033fc7105528d9b809bf5530ff">
				<input type="hidden" name="redirect_uri" value="http://www.whereismysheep.com/douban/index.php/account/sign_in_with_douban">
				<input type="hidden" name="response_type" value="code">
				
				<input type="image" src="http://img3.douban.com/pics/douban-icons/login_with_douban_32.png" />
		</form>
	</div>
	<div class="third">
		我们已经做了这些工作
		<br/>
		1. 从电影、音乐、书籍 3个方面 分别评估你们的相似度
		<br/>
		2. 不仅统计共同喜好，更记录相反的口味
		<br/>
		3. 推送与你最臭味相投的人，还可以随意指定某个他／她进行比较		
	</div>
	<div class="four">
		<span style="font-size:28px;">其它</span>
		<div style="margin-top:30px;">
			寻羊的访问速度有时会比较慢，我们也在想办法解决 . . .
		</div>
		<div style="margin-top:30px;">
			寻羊 正处于，并且将长期处于「试验状态」，不妨保持关注吧～
		</div>
		<a href="http://www.douban.com/people/dbcaulfield" target="_blank" class="no_unl fl" style="margin-right:40px;">
			<img src="<?php echo base_url(); ?>resource/public/image/douban.png" />
		</a>
		<a  href="http://www.weibo.com/sheepseeker" target="_blank" class="no_unl fl" style="margin-right:40px;">
			<img src="<?php echo base_url(); ?>resource/public/image/weibo.png"/>
		</a>
		<a href="http://www.twitter.com/WhereIsMySheep" target="_blank" class="no_unl fl" >
			<img src="<?php echo base_url(); ?>resource/public/image/twitter.jpg" />
		</a>
	</div>
	
	<!--
	<div class="first">
		豆瓣上谁和你共同喜好最多？
		<br/>
		你们之间除了共同喜好外，<span style="font-weight:bold;">又隐藏了多少分歧？</span>
		<br/>
		究竟，谁和你<span style="font-weight:bold;color:#00aa55;">「最臭味相投」</span>？
		<br/>
		寻羊尝试回答这些问题，使你更舒服地使用豆瓣～
	</div>
	
	<div class="second">
		<span style="font-size:28px;font-weight:bold;">试用步骤</span>
		<br/>
		
		1. 发一封豆邮给 试验员 <a href="http://www.douban.com/people/dbcaulfield/" class="no_unl" style="color:#00a3e8;" target="_blank">D.B.</a> ，告诉他你要参加试验。
		<br/>
		<a href="http://www.douban.com/people/dbcaulfield/" target="_blank" style="margin-top:15px;margin-left:15px;">
			<img src="http://img3.douban.com/icon/u2319731-26.jpg"/>
		</a>
		<br/>
		2. 睡个午觉（其实一般1小时之内我们就会高兴地回应你），醒来洗一把脸 . . .
		<br/>
		&nbsp;&nbsp;&nbsp;点击下方的“用豆瓣帐号登陆”，就可以开始尝鲜啦～
		<form method="get" action="https://www.douban.com/service/auth2/auth" style="margin-top:20px;margin-left:15px;">
				<input type="hidden" name="client_id" value="0d9de8033fc7105528d9b809bf5530ff">
				<input type="hidden" name="redirect_uri" value="http://www.whereismysheep.com/douban/index.php/account/sign_in_with_douban">
				<input type="hidden" name="response_type" value="code">
				
				<input type="image" src="http://img3.douban.com/pics/douban-icons/login_with_douban_32.png" />
		</form>
	</div>
	<div class="third">
		我们已经做了这些工作
		<br/>
		1. 从电影、音乐、书籍 3个方面 分别评估你们的相似度
		<br/>
		2. 不仅统计共同喜好，更记录相反的口味
		<br/>
		3. 推送与你最臭味相投的人，还可以随意指定某个他／她进行比较		
	</div>
	<div class="four">
		<span style="font-size:28px;font-weight:bold;">其它</span>
		<div style="margin-top:30px;">
			寻羊的访问速度有时会比较慢，我们也在想办法解决 . . .
		</div>
		<div style="margin-top:30px;">
			寻羊 正处于，并且将长期处于[试验状态]，不妨保持关注吧～
		</div>
		<a href="http://www.douban.com/people/dbcaulfield" target="_blank" class="no_unl fl" style="margin-right:40px;">
			<img src="<?php echo base_url(); ?>resource/public/image/douban.png" />
		</a>
		<a  href="http://www.weibo.com/sheepseeker" target="_blank" class="no_unl fl" style="margin-right:40px;">
			<img src="<?php echo base_url(); ?>resource/public/image/weibo.png"/>
		</a>
		<a href="http://www.twitter.com/WhereIsMySheep" target="_blank" class="no_unl fl" >
			<img src="<?php echo base_url(); ?>resource/public/image/twitter.jpg" />
		</a>
	</div>
	-->
</div>

<?php endif; ?>
  
</body>
<?php
$this->load->view('public/public_footer');
?>