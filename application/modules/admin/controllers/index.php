<?php
/*
 * 管理员 控制器
 */

class Index extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
        $this->load->library(array('account/authentication'));
		$this->load->model(array('account/account_model'));
		$this->load->model(array('douban_model'));
		$this->load->model(array('admin/admin_model'));
		$this->lang->load(array('general'));
	}

	//更新 所有用户(n^2) 的匹配结果
	function match()
	{	
		$this->admin_model->match_all_user();
		echo "finish!";
	}
	
	//更新 所有用户(n^2) 的匹配结果
	function match_one_user($uid)
	{
		$this->admin_model->match_one_user($uid);
		echo "finish!";
	}
	
	//更新用户收藏
	function update_collection($start=0)
	{
		$user_list = $this->db->from('account')->where('uid >=',$start)->get();

		
		foreach($user_list->result() as $row)
		{
			echo $row->uid;
			$this->douban_model->update_movie_info($this->account_model->get_account_douban_id($row->uid), $row->uid);
			$this->douban_model->update_book_info( $this->account_model->get_account_douban_id($row->uid), $row->uid);
			$this->douban_model->update_music_info($this->account_model->get_account_douban_id($row->uid), $row->uid);
		}
		echo "finish!";
	}
	
	//更新用户收藏
	function update_collection_unique($uid)
	{
		$this->douban_model->update_movie_info($this->account_model->get_account_douban_id($uid), $uid);
		//$this->douban_model->update_book_info( $this->account_model->get_account_douban_id($uid), $uid);
		//$this->douban_model->update_music_info($this->account_model->get_account_douban_id($uid), $uid);	
		
		echo "finish!";
	}
	
	//更新用户信息（头像）
	function update_user()
	{
		$user_list = $this->db->get('account');

		foreach($user_list->result() as $row)
		{
			$this->douban_model->update_user_info($row->uid);	
		}

		echo "finish!";
	}
	
	function catch_all($start=0)
	{
		for($i = $start; $i <= 1004999; $i++)//64140985
		{
			$douban_user = $i;
			
			$url = "https://api.douban.com/people/$douban_user?alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban = curl_init();
			curl_setopt($ch_douban, CURLOPT_URL, $url);
			curl_setopt($ch_douban, CURLOPT_RETURNTRANSFER, 1);
			$douban_json = curl_exec($ch_douban);//返回json
			curl_close($ch_douban);
					
			$douban = json_decode($douban_json); //json转换成对象/数组
			
			if( empty($douban->{'uri'}->{'$t'}) || empty($douban->{'title'}->{'$t'}) || empty($douban->{'link'}[2]->{'@href'}) )//提交的用户名无效
			{
				sleep(600);
				continue;
			}
			$douban_id = (string)substr($douban->{'uri'}->{'$t'},29);
			$douban_user_name = (string)$douban->{'title'}->{'$t'};
			$douban_icon = (string)substr($douban->{'link'}[2]->{'@href'},28);
			
			//Check if douban_id is taken
			if( $this->douban_model->douban_id_check($douban_id) === FALSE)
			{
				$douban_movie_url = "https://api.douban.com/people/$douban_user/collection?cat=movie&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff&apikey=0d9de8033fc7105528d9b809bf5530ff";
				$ch_douban_movie = curl_init();
				curl_setopt($ch_douban_movie, CURLOPT_URL, $douban_movie_url);				
				curl_setopt($ch_douban_movie, CURLOPT_RETURNTRANSFER, 1);
				$douban_movie_json = curl_exec($ch_douban_movie);//返回json
				curl_close($ch_douban_movie);
				$douban_movie = json_decode($douban_movie_json); //json转换成对象/数组

				$douban_book_url = "https://api.douban.com/people/$douban_user/collection?cat=book&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff&apikey=0d9de8033fc7105528d9b809bf5530ff";
				$ch_douban_book = curl_init();
				curl_setopt($ch_douban_book, CURLOPT_URL, $douban_book_url);				
				curl_setopt($ch_douban_book, CURLOPT_RETURNTRANSFER, 1);
				$douban_book_json = curl_exec($ch_douban_book);//返回json
				curl_close($ch_douban_book);
				$douban_book = json_decode($douban_book_json); //json转换成对象/数组

				$douban_music_url = "https://api.douban.com/people/$douban_user/collection?cat=music&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff&apikey=0d9de8033fc7105528d9b809bf5530ff";
				$ch_douban_music = curl_init();
				curl_setopt($ch_douban_music, CURLOPT_URL, $douban_music_url);				
				curl_setopt($ch_douban_music, CURLOPT_RETURNTRANSFER, 1);
				$douban_music_json = curl_exec($ch_douban_music);//返回json
				curl_close($ch_douban_music);
				$douban_music = json_decode($douban_music_json); //json转换成对象/数组

				/*
				$collection_url = "https://api.douban.com/people/$douban_user/collection?alt=json&max-results=50&apikey=0d9de8033fc7105528d9b809bf5530ff";
				$ch_collection = curl_init();
				curl_setopt($ch_collection, CURLOPT_URL, $collection_url);
				curl_setopt($ch_collection, CURLOPT_RETURNTRANSFER, 1);
				$collection_json = curl_exec($ch_collection);//返回json
				curl_close($ch_collection);
				
				$collection = json_decode($collection_json);
				//var_dump($collection);
				*/
				
				if( count($douban_movie->{'entry'})<46 || count($douban_book->{'entry'})<46 || count($douban_music->{'entry'})<46  )
				{
					//echo "too small";
					continue;
				}
				
				// Create user
				$user_id = $this->account_model->create($douban_user_name, 'douban', NULL, $douban_id, $douban_icon);
				$this->douban_model->update_movie_info($douban_id, $user_id);
				sleep(60);
				$this->douban_model->update_book_info($douban_id, $user_id);
				sleep(60);
				$this->douban_model->update_music_info($douban_id, $user_id);
				sleep(60);
			}
		
		}
		echo "done";
	}

}

/* End of file index.php */
/* Location: ./application/modules/hotel/controllers/index.php */