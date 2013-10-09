<?php
/*
 * Sign_in_with_douban Controller
 */
class Sign_in_with_douban extends CI_Controller {
	
	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
        	$this->load->library(array('account/authentication', 'account/recaptcha', 'form_validation'));
		$this->load->model(array('account/account_model','douban_model','admin/admin_model'));
		$this->load->language(array('general', 'account/sign_in', 'account/connect_third_party'));
	}
	
	/**
	 * Account sign in with douban
	 *
	 * @access public
	 * @return void
	 */
	function index()
	{
		//用豆瓣账号登陆，若第1步返回autorization_code
		if($_GET != NULL && $_GET["code"]!=NULL)
		{
			/*提交第1步返回的autorization_code，获取access_token*/
			$postdata = http_build_query(
				array(
					'client_id' => '0d9de8033fc7105528d9b809bf5530ff',
					'client_secret' => 'c7053e3bd5a12253',
					'redirect_uri' => 'http://www.whereismysheep.com/douban/index.php/account/sign_in_with_douban',
					'grant_type' => 'authorization_code',
					'code' => $_GET["code"]
				)
			);
			$opts = array('http' =>
				array(
					'method'  => 'POST',
					'header'  => 'Content-type: application/x-www-form-urlencoded',
					'content' => $postdata
				)
			);
			$context  = stream_context_create($opts);
			$data = file_get_contents('https://www.douban.com/service/auth2/token', false, $context);
			$data = json_decode($data); //json转换成对象/数组
			$access_token = $data->{'access_token'};

			
			/*curl命令行，提交access_token获取 当前授权用户的各种信息*/
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,'https://api.douban.com/people/@me');
			curl_setopt($ch,CURLOPT_HTTPHEADER,array("Authorization: Bearer $access_token"));
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1); 
			$result_xml = curl_exec($ch);//返回xml string
			curl_close($ch);

			$result = simplexml_load_string($result_xml);
			//echo $result->{'title'};//username
			//echo $result->{'content'};//intro
			//echo $result->{'id'};//douban id
			//echo $result->{'link'}[2]['href'];//avatar url
			$douban_id = substr($result->{'id'},29);
			$douban_user_name = (string)$result->{'title'};
			$douban_icon = (string)substr($result->{'link'}[2]['href'],28);

			// Check if douban_id is taken
			if( $this->douban_model->douban_id_check($douban_id) === TRUE)//该豆瓣用户已添加，直接登录
			{
				// Clear sign in fail counter
				$this->session->unset_userdata('sign_in_failed_attempts');

				$user = $this->account_model->get_by_douban_id($douban_id);
				
				//$this->douban_model->update_movie_info($douban_id, $user->uid);
				
				//$this->douban_model->update_book_info($douban_id, $user->uid);
				
				//$this->douban_model->update_music_info($douban_id, $user->uid);
				
				//$this->admin_model->match_my_user($user->uid);
				
				// Run sign in routine
				$this->authentication->sign_in($user->uid);
			}
			else//新用户通过豆瓣直接注册，暂时不可用
			{
				// Create user
				$user_id = $this->account_model->create($douban_user_name, 'douban', NULL, $douban_id, $douban_icon);
				
				$this->douban_model->update_movie_info($douban_id, $user_id);
				
				$this->douban_model->update_book_info($douban_id, $user_id);
				
				$this->douban_model->update_music_info($douban_id, $user_id);
				
				$this->admin_model->match_my_user();
				
				//echo "Done";
				
				$this->authentication->sign_in($user_id);
			}
		}
	}

	/**
	 * Check if a douban_id exist
	 *
	 * @access public
	 * @param string
	 * @return bool
	 */
	function douban_id_check($douban_id)
	{
		return $this->account_model->get_by_douban_id($douban_id) ? TRUE : FALSE;
	}
}


/* End of file sign_in_with_douban.php */
/* Location: ./application/modules/account/controllers/sign_in_with_douban.php */
