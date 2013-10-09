<?php
/*
 * People Controller 用户 控制器
 */

class People extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();

		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
        $this->load->library(array('account/authentication'));
		$this->load->model(array('user_model','douban_model','account/account_model','admin/admin_model'));
		$this->lang->load(array('general'));
	}
	
	//用户主页
	function index($page_uid=NULL)
	{	
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		
		if($this->input->post('douban_id') != NULL)//查看 指定的豆瓣id（新注册）
		{
			$douban_user = $this->input->post('douban_id');
			
			$url = "http://api.douban.com/people/$douban_user?alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban = curl_init();
			curl_setopt($ch_douban, CURLOPT_URL, $url);
			curl_setopt($ch_douban, CURLOPT_RETURNTRANSFER, 1);
			$douban_json = curl_exec($ch_douban);//返回json
			curl_close($ch_douban);
					
			$douban = json_decode($douban_json); //json转换成对象/数组
			
			if( empty($douban->{'uri'}->{'$t'}) || empty($douban->{'title'}->{'$t'}) || empty($douban->{'link'}[2]->{'@href'}) )//提交的用户名无效
			{
				redirect('home/index/1');
			}
			$douban_id = (string)substr($douban->{'uri'}->{'$t'},29);
			$douban_user_name = (string)$douban->{'title'}->{'$t'};
			$douban_icon = (string)substr($douban->{'link'}[2]->{'@href'},28);
			
			// Check if douban_id is taken
			if( $this->douban_model->douban_id_check($douban_id) === FALSE)
			{
				// Create user
				$user_id = $this->account_model->create($douban_user_name, 'douban', NULL, $douban_id, $douban_icon);
				$this->douban_model->update_movie_info($douban_id, $user_id);
				$this->douban_model->update_book_info($douban_id, $user_id);
				$this->douban_model->update_music_info($douban_id, $user_id);
			}
			else
			{
				$user = $this->account_model->get_by_douban_id($douban_id);
				$user_id = $user->uid;
			}
			
			//$this->douban_model->update_movie_info($douban_id, $user_id);
			//$this->douban_model->update_book_info($douban_id, $user_id);
			//$this->douban_model->update_music_info($douban_id, $user_id);			
			$this->admin_model->match_unique_user($current_login_uid, $user_id);
			//$this->admin_model->match_my_user($user_id);
	
			$data['page_uid'] = $user_id;
			$data['douban_id'] = $this->account_model->get_account_douban_id($user_id);
			$data['douban_icon'] = $this->account_model->get_account_douban_icon($user_id);
		}
		else//查看已有的豆瓣id
		{
			$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
			$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
			$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);
			
			//$this->douban_model->update_movie_info($data['douban_id'], $data['page_uid']);
			//$this->douban_model->update_book_info($data['douban_id'], $data['page_uid']);
			//$this->douban_model->update_music_info($data['douban_id'], $data['page_uid']);
		}

		//movie
		$result_movie = $this->admin_model->match_movie($current_login_uid,$data['page_uid']);
		$data['movie_score'] = intval($result_movie['score']);
		if($result_movie['same_c']>0)
			$data['movie_same']  = $result_movie['same'];
		$data['movie_same_count'] = $result_movie['same_c'];
			
		if($result_movie['different_c']>0)
			$data['movie_different']  = $result_movie['different'];
		$data['movie_different_count'] = $result_movie['different_c'];
		
		//book
		$result_book = $this->admin_model->match_book($current_login_uid,$data['page_uid']);			
		$data['book_score'] = intval($result_book['score']);
		if($result_book['same_c']>0)
			$data['book_same']  = $result_book['same'];
		$data['book_same_count'] = $result_book['same_c'];
		
		if($result_book['different_c']>0)
			$data['book_different']  = $result_book['different'];
		$data['book_different_count'] = $result_book['different_c'];
		
		//music
		$result_music = $this->admin_model->match_music($current_login_uid,$data['page_uid']);			
		$data['music_score'] = intval($result_music['score']);
		if($result_music['same_c']>0)
			$data['music_same']  = $result_music['same'];
		$data['music_same_count'] = $result_music['same_c'];
		
		if($result_music['different_c']>0)
			$data['music_different']  = $result_music['different'];
		$data['music_different_count'] = $result_music['different_c'];
		
		//average_score
		$data['average_score'] = intval($this->douban_model->get_average_score($current_login_uid, $data['page_uid']));

		$this->load->view('people/index',$data);
	}
	
	//match movie
	function match_movie($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//movie
		$result_movie = $this->admin_model->match_movie($current_login_uid,$page_uid);
		$data['movie_score'] = $result_movie['score'];
		if($result_movie['same_c']>0)
			$data['movie_same']  = $result_movie['same'];
		$data['movie_same_count'] = $result_movie['same_c'];
			
		if($result_movie['different_c']>0)
			$data['movie_different']  = $result_movie['different'];
		$data['movie_different_count'] = $result_movie['different_c'];
		
		if($result_movie['his_own_c']>0)
			$data['movie_his_own']  = $result_movie['his_own'];
		$data['movie_his_own_count'] = $result_movie['his_own_c'];
		
		$this->load->view('people/match_movie', $data);
	}
	
	//match book
	function match_book($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//book
		$result_book = $this->admin_model->match_book($current_login_uid,$page_uid);			
		$data['book_score'] = $result_book['score'];
		if($result_book['same_c']>0)
			$data['book_same']  = $result_book['same'];
		$data['book_same_count'] = $result_book['same_c'];
		
		if($result_book['different_c']>0)
			$data['book_different']  = $result_book['different'];
		$data['book_different_count'] = $result_book['different_c'];
		
		if($result_book['his_own_c']>0)
			$data['book_his_own']  = $result_book['his_own'];
		$data['book_his_own_count'] = $result_book['his_own_c'];
		
		$this->load->view('people/match_book', $data);
	}
	
	//match music
	function match_music($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//music
		$result_music = $this->admin_model->match_music($current_login_uid,$page_uid);			
		$data['music_score'] = $result_music['score'];
		if($result_music['same_c']>0)
			$data['music_same']  = $result_music['same'];
		$data['music_same_count'] = $result_music['same_c'];
		
		if($result_music['different_c']>0)
			$data['music_different']  = $result_music['different'];
		$data['music_different_count'] = $result_music['different_c'];
		
		if($result_music['his_own_c']>0)
			$data['music_his_own']  = $result_music['his_own'];
		$data['music_his_own_count'] = $result_music['his_own_c'];
		
		$this->load->view('people/match_music', $data);
	}
	
	function movie_same($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//movie
		$result_movie = $this->admin_model->match_movie($current_login_uid,$page_uid);
		$data['movie_score'] = $result_movie['score'];
		$data['movie_same_count'] = $result_movie['same_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_movie['same_c']>0)
		{		
			foreach($result_movie['same'] as $value)
			{
				if($this->douban_model->get_movie_score($current_login_uid, $value) == 5)
				{
					$data['movie_same_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 4)
				{
					$data['movie_same_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 3)
				{
					$data['movie_same_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 2)
				{
					$data['movie_same_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 1)
				{
					$data['movie_same_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/movie_same', $data);
	}
	
	function movie_different($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//movie
		$result_movie = $this->admin_model->match_movie($current_login_uid,$page_uid);
		$data['movie_score'] = $result_movie['score'];		
		$data['movie_different_count'] = $result_movie['different_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_movie['different_c']>0)
		{		
			foreach($result_movie['different'] as $value)
			{
				if($this->douban_model->get_movie_score($current_login_uid, $value) == 5)
				{
					$data['movie_different_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 4)
				{
					$data['movie_different_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 3)
				{
					$data['movie_different_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 2)
				{
					$data['movie_different_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($current_login_uid, $value) == 1)
				{
					$data['movie_different_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/movie_different', $data);
	}
	
	function movie_recommend($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//movie
		$result_movie = $this->admin_model->match_movie($current_login_uid,$page_uid);
		$data['movie_score'] = $result_movie['score'];
		$data['movie_his_own_count'] = $result_movie['his_own_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_movie['his_own_c']>0)
		{
			foreach($result_movie['his_own'] as $value)
			{
				if($this->douban_model->get_movie_score($data['page_uid'], $value) == 5)
				{
					$data['movie_his_own_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($data['page_uid'], $value) == 4)
				{
					$data['movie_his_own_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($data['page_uid'], $value) == 3)
				{
					$data['movie_his_own_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($data['page_uid'], $value) == 2)
				{
					$data['movie_his_own_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_movie_score($data['page_uid'], $value) == 1)
				{
					$data['movie_his_own_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/movie_recommend', $data);
	}
	
	function book_same($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//book
		$result_book = $this->admin_model->match_book($current_login_uid,$page_uid);
		$data['book_score'] = $result_book['score'];
		$data['book_same_count'] = $result_book['same_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_book['same_c']>0)
		{
			foreach($result_book['same'] as $value)
			{
				if($this->douban_model->get_book_score($current_login_uid, $value) == 5)
				{
					$data['book_same_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 4)
				{
					$data['book_same_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 3)
				{
					$data['book_same_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 2)
				{
					$data['book_same_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 1)
				{
					$data['book_same_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/book_same', $data);
	}
	
	function book_different($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//book
		$result_book = $this->admin_model->match_book($current_login_uid,$page_uid);
		$data['book_score'] = $result_book['score'];
		
		$data['book_different_count'] = $result_book['different_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_book['different_c']>0)
		{	
			foreach($result_book['different'] as $value)
			{
				if($this->douban_model->get_book_score($current_login_uid, $value) == 5)
				{
					$data['book_different_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 4)
				{
					$data['book_different_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 3)
				{
					$data['book_different_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 2)
				{
					$data['book_different_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($current_login_uid, $value) == 1)
				{
					$data['book_different_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/book_different', $data);
	}
	
	function book_recommend($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//book
		$result_book = $this->admin_model->match_book($current_login_uid,$page_uid);
		$data['book_score'] = $result_book['score'];
		
		$data['book_his_own_count'] = $result_book['his_own_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_book['his_own_c']>0)
		{
			foreach($result_book['his_own'] as $value)
			{
				if($this->douban_model->get_book_score($data['page_uid'], $value) == 5)
				{
					$data['book_his_own_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($data['page_uid'], $value) == 4)
				{
					$data['book_his_own_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($data['page_uid'], $value) == 3)
				{
					$data['book_his_own_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($data['page_uid'], $value) == 2)
				{
					$data['book_his_own_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_book_score($data['page_uid'], $value) == 1)
				{
					$data['book_his_own_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/book_recommend', $data);
	}
	
	
	function music_same($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//music
		$result_music = $this->admin_model->match_music($current_login_uid,$page_uid);
		$data['music_score'] = $result_music['score'];
		$data['music_same_count'] = $result_music['same_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_music['same_c']>0)
		{
			foreach($result_music['same'] as $value)
			{
				if($this->douban_model->get_music_score($current_login_uid, $value) == 5)
				{
					$data['music_same_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 4)
				{
					$data['music_same_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 3)
				{
					$data['music_same_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 2)
				{
					$data['music_same_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 1)
				{
					$data['music_same_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/music_same', $data);
	}
	
	function music_different($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//music
		$result_music = $this->admin_model->match_music($current_login_uid,$page_uid);
		$data['music_score'] = $result_music['score'];
		$data['music_different_count'] = $result_music['different_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_music['different_c']>0)
		{
			foreach($result_music['different'] as $value)
			{
				if($this->douban_model->get_music_score($current_login_uid, $value) == 5)
				{
					$data['music_different_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 4)
				{
					$data['music_different_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 3)
				{
					$data['music_different_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 2)
				{
					$data['music_different_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($current_login_uid, $value) == 1)
				{
					$data['music_different_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/music_different', $data);
	}
	
	function music_recommend($page_uid)
	{
		if (!$this->authentication->is_signed_in())
		{
			redirect('');
		}

		//获取登录用户信息
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		$current_login_uid = $data['account']->uid;
		$data['page_uid'] = $page_uid ? $page_uid : $current_login_uid;
		$data['douban_id'] = $this->account_model->get_account_douban_id($data['page_uid']);
		$data['douban_icon'] = $this->account_model->get_account_douban_icon($data['page_uid']);

		//music
		$result_music = $this->admin_model->match_music($current_login_uid,$page_uid);
		$data['music_score'] = $result_music['score'];
		$data['music_his_own_count'] = $result_music['his_own_c'];
		
		$data['five_count']  = 0;
		$data['four_count']  = 0;
		$data['three_count'] = 0;
		$data['two_count']   = 0;
		$data['one_count']   = 0;
		
		if($result_music['his_own_c']>0)
		{
			foreach($result_music['his_own'] as $value)
			{
				if($this->douban_model->get_music_score($data['page_uid'], $value) == 5)
				{
					$data['music_his_own_five'][$data['five_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($data['page_uid'], $value) == 4)
				{
					$data['music_his_own_four'][$data['four_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($data['page_uid'], $value) == 3)
				{
					$data['music_his_own_three'][$data['three_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($data['page_uid'], $value) == 2)
				{
					$data['music_his_own_two'][$data['two_count']++] = $value;
				}
				elseif($this->douban_model->get_music_score($data['page_uid'], $value) == 1)
				{
					$data['music_his_own_one'][$data['one_count']++] = $value;
				}
			}
		}
		
		$this->load->view('people/music_recommend', $data);
	}

}

/* End of file people.php */
/* Location: ./application/controllers/people.php */