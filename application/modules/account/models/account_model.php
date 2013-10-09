<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {
	
	/**
	 * Get account by id
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account object
	 */
	function get_by_id($account_id)
	{
		return $this->db->get_where('account', array('uid' => $account_id))->row();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Get account by douban_id
	 *
	 * @access public
	 * @param string $douban_id
	 * @return object account object
	 */
	function get_by_douban_id($douban_id)
	{
		return $this->db->get_where('account', array('douban_id' => $douban_id))->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account by username
	 *
	 * @access public
	 * @param string $username
	 * @return object account object
	 */
	function get_by_username($username)
	{
		return $this->db->get_where('account', array('username' => $username))->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account by email
	 *
	 * @access public
	 * @param string $email
	 * @return object account object
	 */
	function get_by_email($email)
	{
		return $this->db->get_where('account', array('email' => $email))->row();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get account by username or email
	 *
	 * @access public
	 * @param string $username_email
	 * @return object account object
	 */
	function get_by_username_email($username_email)
	{
		return $this->db->from('account')->where('username', $username_email)->or_where('email', $username_email)->get()->row();
	}
	
	// --------------------------------------------------------------------

	/**
	 * 通过account_id查询人物姓名
	 *
	 * @access public
	 * @param int $account_id
	 * @return string username
	 */
	function get_account_name($account_id)
	{
		$query = $this->db->from('account')->where('uid',$account_id)->get();
		return $query->row()->username;
	}

	// --------------------------------------------------------------------
	
	
	/**
	 * 通过account_id查询douban id
	 *
	 * @access public
	 * @param int $account_id
	 * @return string username
	 */
	function get_account_douban_id($account_id)
	{
		$query = $this->db->from('account')->where('uid',$account_id)->get();
		return $query->row()->douban_id;
	}

	// --------------------------------------------------------------------
	
	/**
	 * 通过account_id查询douban icon
	 *
	 * @access public
	 * @param int $account_id
	 * @return string username
	 */
	function get_account_douban_icon($account_id)
	{
		$query = $this->db->from('account')->where('uid',$account_id)->get();
		return $query->row()->douban_icon;
	}

	// --------------------------------------------------------------------
	
	
	/**
	 * Create an account
	 *
	 * @access public
	 * @param string $username
	 * @param string $hashed_password
	 * @return int insert id
	 */
	function create($username, $email = NULL, $password = NULL, $douban_id = NULL, $douban_icon = NULL)
	{
		// Create password hash using phpass
		if ($password !== NULL)
		{
			$this->load->helper('account/phpass');
			$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
			$hashed_password = $hasher->HashPassword($password);
		}
		
		$this->load->helper('date');
		$this->db->insert('account', array(
			'username' => $username, 
			'createdon' => mdate('%Y-%m-%d %H:%i:%s', now()),
			'douban_id' => $douban_id,
			'douban_icon' => $douban_icon
		));
		
		return $this->db->insert_id();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Change account username
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $new_username
	 * @return void
	 */
	function update_username($account_id, $new_username)
	{
		$this->db->update('account', array('username' => $new_username), array('uid' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Change account email
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $new_email
	 * @return void
	 */
	function update_email($account_id, $new_email)
	{
		$this->db->update('account', array('email' => $new_email), array('uid' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Change account password
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $hashed_password
	 * @return void
	 */
	function update_password($account_id, $password_new)
	{
		$this->load->helper('account/phpass');
		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		$new_hashed_password = $hasher->HashPassword($password_new);
		
		$this->db->update('account', array('password' => $new_hashed_password), array('uid' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update account last signed in dateime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function update_last_signed_in_datetime($account_id)
	{
		$this->load->helper('date');
		
		$this->db->update('account', array('lastsignedinon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('uid' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update password reset sent datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return int password reset time
	 */
	function update_reset_sent_datetime($account_id)
	{
		$this->load->helper('date');
		
		$resetsenton = mdate('%Y-%m-%d %H:%i:%s', now());
		
		$this->db->update('account', array('resetsenton' => $resetsenton), array('uid' => $account_id));
		
		return strtotime($resetsenton);
	}
	
	/**
	 * Remove password reset datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function remove_reset_sent_datetime($account_id)
	{
		$this->db->update('account', array('resetsenton' => NULL), array('uid' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update account deleted datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function update_deleted_datetime($account_id)
	{
		$this->load->helper('date');
		
		$this->db->update('account', array('deletedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('uid' => $account_id));
	}
	
	/**
	 * Remove account deleted datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function remove_deleted_datetime($account_id)
	{
		$this->db->update('account', array('deletedon' => NULL), array('uid' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Update account suspended datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function update_suspended_datetime($account_id)
	{
		$this->load->helper('date');
		
		$this->db->update('account', array('suspendedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('uid' => $account_id));
	}
	
	/**
	 * Remove account suspended datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function remove_suspended_datetime($account_id)
	{
		$this->db->update('account', array('suspendedon' => NULL), array('uid' => $account_id));
	}
	
}


/* End of file account_model.php */
/* Location: ./application/modules/account/models/account_model.php */