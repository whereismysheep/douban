<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * User_model，用户模型
 */

class User_model extends CI_Model {


	/**
	 * Get account by id
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account object
	 */
	function get_by_id($uid)
	{
		return $this->db->get_where('user_information', array('uid' => $uid))->row();
	}

	
	// --------------------------------------------------------------------

	
	/**
	 * 取得用户的关注与被关注信息
	 *
	 * @access public
	 * @param int $uid
	 * @return array $result
	 */
	function get_user_follow($uid) 
	{
		//对我感兴趣的人，我的follower
		$result['follower'] = $this->db->where('uid',$uid)->from('follow')->get();

		//我感兴趣的人，我following的人
		$result['following'] = $this->db->where('fid',$uid)->from('follow')->get();
	
		return $result;
	}


	// --------------------------------------------------------------------

	
	/**
	 * 取得对应相似度分数的描述
	 *
	 * @access public
	 * @param int $score
	 * @return array $result
	 */
	function get_score_explain($score) 
	{
		if($score>=90)
			$explain = "你们简直是同一个人";
		elseif($score>=80)
			$explain = "你们的相似程度令人惊讶";
		elseif($score>=70)
			$explain = "你们很显然是同类";
		elseif($score>=60)
			$explain = "你们不难相处";
		elseif($score>=50)
			$explain = "你们相同点不少";

		elseif($score>=40)
			$explain = "你们分歧不少";
		elseif($score>=30)
			$explain = "你们不像一类人";
		elseif($score>=20)
			$explain = "你们很难相处";
		elseif($score>=10)
			$explain = "你们很难共存";	
		else
			$explain = "你们完全是两种人";

		return $explain;
	}


	// --------------------------------------------------------------------

	
	/**
	 * 取得对应相似度分数的描述，针对宾馆楼层平均相似度
	 *
	 * @access public
	 * @param int $score
	 * @return array $result
	 */
	function get_score_explain_hotel($score) 
	{
		if($score>=90)
			$explain = "乌托邦";
		elseif($score>=80)
			$explain = "乌托邦";

		elseif($score>=70)
			$explain = "气味相投";
		elseif($score>=60)
			$explain = "气味相投";
		
		elseif($score>=50)
			$explain = "鱼龙混杂";
		elseif($score>=40)
			$explain = "鱼龙混杂";

		elseif($score>=30)
			$explain = "保持距离";
		elseif($score>=20)
			$explain = "保持距离";

		elseif($score>=10)
			$explain = "少去为妙";	
		else
			$explain = "少去为妙";

		return $explain;
	}

	// --------------------------------------------------------------------

	/**
	 * 取得用户的自我介绍
	 *
	 * @access public
	 * @param int $uid
	 * @return string $result
	 */
	function get_user_introduction($uid) 
	{
		return $this->db->where('uid',$uid)->from('user_information')->get()->row()->introduction;
	}

	// --------------------------------------------------------------------

	/**
	 * 取得用户的性别
	 *
	 * @access public
	 * @param int $uid
	 * @return string $result
	 */
	function get_user_gender($uid) 
	{
		return $this->db->where('uid',$uid)->from('user_information')->get()->row()->gender;
	}

	// --------------------------------------------------------------------

	/**
	 * 取得 用户a_uid 和 用户b_uid 间的关系
	 *
	 * @access public
	 * @param int $a_uid
	 * @param int $b_uid
	 * @return string relationship
	 */
	function get_relationship($a_uid, $b_uid )
	{	
		$follower  = $this->db->where('uid',$a_uid)->where('fid',$b_uid)->from('follow')->get()->num_rows();//a 被b关注？	
		$following = $this->db->where('uid',$b_uid)->where('fid',$a_uid)->from('follow')->get()->num_rows();//a 已关注b？

		if($follower>0 && $following>0)//相互关注
		{
			$relationship = "each_other";
		}
		elseif($follower>0)//被关注
		{
			$relationship = "follower";
		}
		elseif($following>0)//关注
		{
			$relationship = "following";
		}
		else
		{
			$relationship = "none";
		}
		return $relationship;
	}

	// --------------------------------------------------------------------

	/**
	 * 取得用户的房间号
	 *
	 * @access public
	 * @param int $uid
	 * @return int
	 */
	function get_user_room($uid)
	{
		return $this->db->where('uid',$uid)->from('user_information')->get()->row()->room_number;
	}

	// --------------------------------------------------------------------

	/**
	 * 取得用户所在区域
	 *
	 * @access public
	 * @param int $uid
	 * @return int
	 */
	function get_user_region($uid) 
	{
		$room_number = $this->db->where('uid',$uid)->from('user_information')->get()->row()->room_number;
		return $this->db->where('room_number',$room_number)->from('room')->get()->row()->region;
	}


	// --------------------------------------------------------------------

	/**
	 * 取得用户间的相似度
	 *
	 * @access public
	 * @param int $uid
	 * @return int
	 */
	function get_similarity($a_uid, $b_uid) 
	{
		return $this->db->where('host_uid',$a_uid)->where('guest_uid',$b_uid)->from('match')->get()->row()->score;
	}



	// --------------------------------------------------------------------

	/**
	 * 新增 用户a_uid 被 用户b_uid 关注
	 *
	 * @access public
	 * @param int $a_uid
	 * @param int $b_uid
	 */
	function add_following($a_uid,$b_uid)
	{
		$data = array(
			'uid'   => $a_uid,
			'fid'   => $b_uid,
		);
		$this->db->insert('follow', $data);
	}

	// --------------------------------------------------------------------

	/**
	 * 取消 用户a_uid 被 用户b_uid 关注
	 *
	 * @access public
	 * @param int $a_uid
	 * @param int $b_uid
	 */
	function cancel_following($a_uid,$b_uid)
	{
		$this->db->where('uid', $a_uid)->where('fid', $b_uid)->delete('follow');
	}

	// --------------------------------------------------------------------

	/**
	 * 根据匹配情况（各集合大小） 生成文氏图 边长
	 *
	 * @access public
	 * @param int $my_own
	 * @param int $his_own
	 * @param int $same
	 * @param int $different

	 * @return array length

		length_X  小正方形边长
		length_Y  交集的宽度
		交集面积 = length_X * length_X
		length_Z + length_Z + length_X = 250
		length_a  相同集的宽度
		length_b  相反集的宽度
		length_a + length_b = length_Y

	 */
	function get_venn_length($my_own,$his_own,$same,$different)
	{
		$length['length_X'] = 0;
		$length['length_Y'] = 0;
		//$length['length_Z'] = 0;
		$length['length_a'] = 0;
		$length['length_b'] = 0;

		if($my_own >= $his_own) //我的（左侧）人物正方形 更大
		{
			$length['length_X'] = intval( sqrt( 250 * 250 * ( $his_own + $same + $different ) / ( $my_own + $same + $different ) ) );
			if($length['length_X'] <= 25 || $length['length_X']==250 )//小正方形的边长太小(包括2个正方形都太小)，忽略，不生成文氏图
			{
				$length['type'] = "none"; //  http://localhost/whereismysheep/index.php/people/index/21
				return $length;
			}

			$length['length_Y'] = intval( 250 * 250 * ( $same + $different ) / ( $my_own + $same + $different ) / $length['length_X'] );
			
			if($length['length_Y'] <= 15) //seperate  交集太小，两个正方形分离
			{
				$length['type'] = "seperate";//  http://localhost/whereismysheep/index.php/people/index/22
			}
			elseif($length['length_Y'] > 15 && $length['length_Y'] <= ($length['length_X']-15)) //normal  正常交集
			{
				//$length['length_Z'] = intval( ( 250 - $length['length_X'] ) / 2 );
				$length['length_a'] = intval( $length['length_Y'] * $same / ( $same + $different ) );
				$length['length_b'] = $length['length_Y'] - $length['length_a'];

				if( $length['length_a']/$length['length_Y'] < 0.1 ) //相同集合太小，忽略
				{
					$length['type'] = "normal_only_different";// http://localhost/whereismysheep/index.php/people/index/3

				}
				else if( $length['length_b']/$length['length_Y'] < 0.1 ) //相反集合太小，忽略
				{
					$length['type'] = "normal_only_same";// http://localhost/whereismysheep/index.php/people/index/

				}
				else //正常情况
				{
					$length['type'] = "normal";// http://localhost/whereismysheep/index.php/people/index/5
				}
			}
			elseif($length['length_Y'] > ($length['length_X']-15) ) //contain  交集等于小正方形，被大正方形包含
			{
				$length['length_a'] = intval( $length['length_Y'] * $same / ( $same + $different ) );
				$length['length_b'] = $length['length_Y'] - $length['length_a'];
				if( $his_own/$my_own <= 220/250 )
				{
					if( $length['length_a']/$length['length_Y'] < 0.1 ) //相同集合太小，忽略
					{
						$length['type'] = "contain_only_different";// http://localhost/whereismysheep/index.php/people/index/3
					}
					elseif( $length['length_b']/$length['length_Y'] < 0.1 ) //相反集合太小，忽略
					{
						$length['type'] = "contain_only_same";// http://localhost/whereismysheep/index.php/people/index/
					}
					else //正常情况
					{
						$length['type'] = "contain";// http://localhost/whereismysheep/index.php/people/index/5
					}
				}
				else //2个正方形大小相近，包含，合并为1个显示
				{
					if( $length['length_a']/$length['length_Y'] < 0.1 ) //相同集合太小，忽略
					{
						$length['type'] = "contain_merge_only_different";// http://localhost/whereismysheep/index.php/people/index/3
					}
					elseif( $length['length_b']/$length['length_Y'] < 0.1 ) //相反集合太小，忽略
					{
						$length['type'] = "contain_merge_only_same";// http://localhost/whereismysheep/index.php/people/index/
					}
					else
					{
						$length['type'] = "contain_merge";// http://localhost/whereismysheep/index.php/people/index/5
					}
				}
			}
		}
		elseif($my_own < $his_own) //TA的（右侧）人物正方形 更大
		{
			$length['length_X'] = intval( sqrt( 250 * 250 * ( $my_own + $same + $different ) / ( $his_own + $same + $different ) ) );	
			if($length['length_X'] <= 25)//小正方形的边长太小，忽略，不生成文氏图
			{
				$length['type'] = "none"; //  http://localhost/whereismysheep/index.php/people/index/21
				return $length;
			}

			$length['length_Y'] = intval( 250 * 250 * ( $same + $different ) / ( $his_own + $same + $different ) / $length['length_X'] );
			
			if($length['length_Y'] <= 15) //seperate  交集太小，两个正方形分离
			{
				$length['type'] = "seperate";//  http://localhost/whereismysheep/index.php/people/index/22
			}
			elseif($length['length_Y'] > 15 && $length['length_Y'] <= ($length['length_X']-15)) //normal  正常交集
			{
				//$length['length_Z'] = intval( ( 250 - $length['length_X'] ) / 2 );
				$length['length_a'] = intval( $length['length_Y'] * $same / ( $same + $different ) );
				$length['length_b'] = $length['length_Y'] - $length['length_a'];

				if( $length['length_a']/$length['length_Y'] < 0.1 ) //相同集合太小，忽略
				{
					$length['type'] = "normal_only_different";// http://localhost/whereismysheep/index.php/people/index/3

				}
				else if( $length['length_b']/$length['length_Y'] < 0.1 ) //相反集合太小，忽略
				{
					$length['type'] = "normal_only_same";// http://localhost/whereismysheep/index.php/people/index/

				}
				else //正常情况
				{
					$length['type'] = "normal";// http://localhost/whereismysheep/index.php/people/index/5
				}
			}
			elseif($length['length_Y'] > ($length['length_X']-15) ) //contain  交集等于小正方形，被大正方形包含
			{
				$length['length_a'] = intval( $length['length_Y'] * $same / ( $same + $different ) );
				$length['length_b'] = $length['length_Y'] - $length['length_a'];
				if( $my_own/$his_own <= 220/250 )
				{
					if( $length['length_a']/$length['length_Y'] < 0.1 ) //相同集合太小，忽略
					{
						$length['type'] = "contain_only_different";// http://localhost/whereismysheep/index.php/people/index/3
					}
					elseif( $length['length_b']/$length['length_Y'] < 0.1 ) //相反集合太小，忽略
					{
						$length['type'] = "contain_only_same";// http://localhost/whereismysheep/index.php/people/index/
					}
					else //正常情况
					{
						$length['type'] = "contain";// http://localhost/whereismysheep/index.php/people/index/5
					}
				}
				else //2个正方形大小相近，包含，合并为1个显示
				{
					if( $length['length_a']/$length['length_Y'] < 0.1 ) //相同集合太小，忽略
					{
						$length['type'] = "contain_merge_only_different";// http://localhost/whereismysheep/index.php/people/index/3
					}
					elseif( $length['length_b']/$length['length_Y'] < 0.1 ) //相反集合太小，忽略
					{
						$length['type'] = "contain_merge_only_same";// http://localhost/whereismysheep/index.php/people/index/
					}
					else
					{
						$length['type'] = "contain_merge";// http://localhost/whereismysheep/index.php/people/index/5
					}
				}
			}
		}
		//else //一样大
		//{}

		return $length;
	}

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */