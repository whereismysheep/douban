<?php

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		
		// Load the necessary stuff...
		$this->load->helper(array('language', 'url', 'form', 'account/ssl'));
        $this->load->library(array('account/authentication'));
		$this->load->model(array('user_model','account/account_model'));
		$this->lang->load(array('general'));
	}
	
	function index($mark=0)
	{
		maintain_ssl();
		
		if ($this->authentication->is_signed_in())
		{
			$data['mark'] = $mark;
		
			//获取登录用户信息
			$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
			$current_login_uid = $data['account']->uid;

			//最相似的人
			$data['similar_match']   = $this->db->from('match')->where('host_uid',$current_login_uid)->order_by("score", "desc")->limit(6)->get();		
			//防止最相似 和最不同 重复
			$i = 0;
			$temp[$i++] = $current_login_uid;
			foreach($data['similar_match']->result() as $row)
			{
				$temp[$i++] = $row->guest_uid;
			}
			
			//最不同的人
			$data['different_match'] = $this->db->from('match')->where('host_uid',$current_login_uid)->where_not_in('guest_uid',$temp)->order_by("score", "asc") ->limit(3)->get();
		}
		//var_dump($data['different_match']);
		$this->load->view('home', isset($data) ? $data : NULL);
	}
	
}


/* End of file home.php */
/* Location: ./system/application/controllers/home.php */