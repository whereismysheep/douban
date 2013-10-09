<?php
/*
 * Account_profile Controller
 */
class Account_profile extends CI_Controller {
	
	/**
	 * Constructor
	 */
    function __construct()
    {
        parent::__construct();
		
		// Load the necessary stuff...
		$this->load->config('account/account');
		$this->load->helper(array('language', 'account/ssl', 'url'));
        $this->load->library(array('account/authentication', 'form_validation'));
		$this->load->model(array('user_model','account/account_model', 'account/account_details_model'));
		$this->load->language(array('general', 'account/account_profile'));
	}
	
	/**
	 * Account profile
	 */
	function index($action = NULL)
	{
		// Enable SSL?
		maintain_ssl($this->config->item("ssl_enabled"));
		
		// Redirect unauthenticated users to signin page
		if ( ! $this->authentication->is_signed_in()) 
		{
			redirect('account/sign_in/?continue='.urlencode(base_url().'account/account_profile'));
		}
		
		// Retrieve sign in user
		$data['account'] = $this->account_model->get_by_id($this->session->userdata('account_id'));
		//$data['account_details'] = $this->account_details_model->get_by_account_id($this->session->userdata('account_id'));
		$data['user_info'] = $this->user_model->get_by_id($this->session->userdata('account_id'));

		$data['profile_info'] = NULL;
		
		// Delete profile picture
		if ($action == 'delete')
		{
			$this->account_details_model->update($data['account']->uid, array('picture' => NULL));
			redirect('account/account_profile');
		}
		
		// Setup form validation
		$this->form_validation->set_error_delimiters('<div class="field_error">', '</div>');
		$this->form_validation->set_rules(array(
			array('field'=>'profile_username', 'label'=>'lang:profile_username', 'rules'=>'trim|required|min_length[2]|max_length[24]')
		));

		$this->form_validation->set_rules(array(
			array('field'=>'profile_introduction', 'label'=>'lang:profile_introduction', 'rules'=>'trim|max_length[70]')
		));
		
		// Run form validation
		if ($this->form_validation->run())
		{
			// If user is changing username and new username is already taken
			if (strtolower($this->input->post('profile_username')) != strtolower($data['account']->username) && $this->username_check($this->input->post('profile_username')) === TRUE)
			{
				$data['profile_username_error'] = lang('profile_username_taken');
				$error = TRUE;
			}
			else//更新用户名
			{
				$data['account']->username = $this->input->post('profile_username');
				$this->account_model->update_username($data['account']->uid, $this->input->post('profile_username'));
			}

			if ($this->input->post('settings_gender')) //更新性别
			{
				$new_data['gender'] = $this->input->post('settings_gender');
				$this->db->where('uid',$data['account']->uid)->update('user_information',$new_data);
			}

			if ($this->input->post('profile_introduction')) //更新自我介绍
			{
				//echo strlen($this->input->post('profile_introduction'));

				$new_data['introduction'] = $this->input->post('profile_introduction');
				$this->db->where('uid',$data['account']->uid)->update('user_information',$new_data);
			}

			if ( ! isset($error))
			{
				$this->session->set_flashdata('profile_info', '更新成功');
				redirect('account/account_profile');
			}
		}
		
		$this->load->view('account/account_profile', $data);
	}
	
	/**
	 * Check if a username exist
	 *
	 * @access public
	 * @param string
	 * @return bool
	 */
	function username_check($username)
	{
		return $this->account_model->get_by_username($username) ? TRUE : FALSE;
	}
	
}


/* End of file account_profile.php */
/* Location: ./application/modules/account/controllers/account_profile.php */