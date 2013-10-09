<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model 
{
	/**
	 * 计算 所有用户(n^2) 的匹配结果
	 */
	function match_all_user()
	{
		$true_user_list = $this->db->from('account')->where('lastsignedinon >',0)->get();
		$user_list = $this->db->get('account');

		foreach($true_user_list->result() as $row_a)
		{
			foreach($user_list->result() as $row_b)
			{
				if($row_a->uid != $row_b->uid)
				{
					$average_score = 0;

					//movie
					$result_movie = $this->admin_model->match_movie( $row_a->uid, $row_b->uid );
					$average_score += $result_movie['score'];
					$data = array(
						'score' => $result_movie['score'],
						'host_uid'  => $row_a->uid,
						'guest_uid' => $row_b->uid
					);
					$query = $this->db->from('match_movie')->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_movie['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->update('match_movie',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match_movie',$data);
					}
					
					//book
					$result_book = $this->admin_model->match_book( $row_a->uid, $row_b->uid );
					$average_score += $result_book['score'];
					$data = array(
						'score' => $result_book['score'],
						'host_uid'  => $row_a->uid,
						'guest_uid' => $row_b->uid
					);
					$query = $this->db->from('match_book')->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_book['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->update('match_book',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match_book',$data);
					}
					
					//music
					$result_music = $this->admin_model->match_music( $row_a->uid, $row_b->uid );
					$average_score += $result_music['score'];
					$data = array(
						'score' => $result_music['score'],
						'host_uid'  => $row_a->uid,
						'guest_uid' => $row_b->uid
					);
					$query = $this->db->from('match_music')->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_music['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->update('match_music',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match_music',$data);
					}
					
					//average
					$average_score = round($average_score/3, 2);
					$data = array(
						'score' => $average_score,
						'host_uid'  => $row_a->uid,
						'guest_uid' => $row_b->uid
					);
					$query = $this->db->from('match')->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_music['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$row_a->uid)->where('guest_uid',$row_b->uid)->update('match',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match',$data);
					}
				}
			}
			echo "finish!";
		}

	}

	// --------------------------------------------------------------------
	
	/**
	 * 计算 所有用户uid 和所有人(n) 的匹配结果
	 */
	function match_one_user($uid)
	{
		$user_list = $this->db->get('account');

		foreach($user_list->result() as $row)
		{
				if($uid != $row->uid)
				{
					$average_score = 0;

					//movie
					$result_movie = $this->admin_model->match_movie( $uid, $row->uid );
					$average_score += $result_movie['score'];
					$data = array(
						'score' => $result_movie['score'],
						'host_uid'  => $uid,
						'guest_uid' => $row->uid
					);
					$query = $this->db->from('match_movie')->where('host_uid',$uid)->where('guest_uid',$row->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_movie['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$uid)->where('guest_uid',$row->uid)->update('match_movie',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match_movie',$data);
					}
					
					//book
					$result_book = $this->admin_model->match_book( $uid, $row->uid );
					$average_score += $result_book['score'];
					$data = array(
						'score' => $result_book['score'],
						'host_uid'  => $uid,
						'guest_uid' => $row->uid
					);
					$query = $this->db->from('match_book')->where('host_uid',$uid)->where('guest_uid',$row->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_book['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$uid)->where('guest_uid',$row->uid)->update('match_book',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match_book',$data);
					}
					
					//music
					$result_music = $this->admin_model->match_music( $uid, $row->uid );
					$average_score += $result_music['score'];
					$data = array(
						'score' => $result_music['score'],
						'host_uid'  => $uid,
						'guest_uid' => $row->uid
					);
					$query = $this->db->from('match_music')->where('host_uid',$uid)->where('guest_uid',$row->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_music['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$uid)->where('guest_uid',$row->uid)->update('match_music',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match_music',$data);
					}
					
					//average
					$average_score = round($average_score/3, 2);
					$data = array(
						'score' => $average_score,
						'host_uid'  => $uid,
						'guest_uid' => $row->uid
					);
					$query = $this->db->from('match')->where('host_uid',$uid)->where('guest_uid',$row->uid)->get();
					if( $query->num_rows() > 0 && $query->row('score') != $result_music['score'] )//已存在，且不相同，进行更新
					{
						//echo "更新 ";
						$this->db->where('host_uid',$uid)->where('guest_uid',$row->uid)->update('match',$data);
					}
					elseif($query->num_rows() <= 0)//不存在，进行插入
					{
						//echo "插入 ";
						$this->db->insert('match',$data);
					}					
				}

		}

	}

	// --------------------------------------------------------------------
	
	/**
	 * 计算 user_a 和 user_b 的匹配结果
	 */
	function match_unique_user($user_a, $user_b)
	{
		$average_score = 0;

		//movie
		$result_movie = $this->admin_model->match_movie( $user_a, $user_b );
		$average_score += $result_movie['score'];
		$data = array(
			'score' => $result_movie['score'],
			'host_uid'  => $user_a,
			'guest_uid' => $user_b
		);
		$query = $this->db->from('match_movie')->where('host_uid',$user_a)->where('guest_uid',$user_b)->get();
		if( $query->num_rows() > 0 && $query->row('score') != $result_movie['score'] )//已存在，且不相同，进行更新
		{
			//echo "更新 ";
			$this->db->where('host_uid',$user_a)->where('guest_uid',$user_b)->update('match_movie',$data);
		}
		elseif($query->num_rows() <= 0)//不存在，进行插入
		{
			//echo "插入 ";
			$this->db->insert('match_movie',$data);
		}
					
		//book
		$result_book = $this->admin_model->match_book( $user_a, $user_b );
		$average_score += $result_book['score'];
		$data = array(
			'score' => $result_book['score'],
			'host_uid'  => $user_a,
			'guest_uid' => $user_b
		);
		$query = $this->db->from('match_book')->where('host_uid',$user_a)->where('guest_uid',$user_b)->get();
		if( $query->num_rows() > 0 && $query->row('score') != $result_book['score'] )//已存在，且不相同，进行更新
		{
			//echo "更新 ";
			$this->db->where('host_uid',$user_a)->where('guest_uid',$user_b)->update('match_book',$data);
		}
		elseif($query->num_rows() <= 0)//不存在，进行插入
		{
			//echo "插入 ";
			$this->db->insert('match_book',$data);
		}
					
		//music
		$result_music = $this->admin_model->match_music( $user_a, $user_b );
		$average_score += $result_music['score'];
		$data = array(
			'score' => $result_music['score'],
			'host_uid'  => $user_a,
			'guest_uid' => $user_b
		);
		$query = $this->db->from('match_music')->where('host_uid',$user_a)->where('guest_uid',$user_b)->get();
		if( $query->num_rows() > 0 && $query->row('score') != $result_music['score'] )//已存在，且不相同，进行更新
		{
			//echo "更新 ";
			$this->db->where('host_uid',$user_a)->where('guest_uid',$user_b)->update('match_music',$data);
		}
		elseif($query->num_rows() <= 0)//不存在，进行插入
		{
			//echo "插入 ";
			$this->db->insert('match_music',$data);
		}
					
		//average
		$average_score = round($average_score/3, 2);
		$data = array(
			'score' => $average_score,
			'host_uid'  => $user_a,
			'guest_uid' => $user_b
		);
		$query = $this->db->from('match')->where('host_uid',$user_a)->where('guest_uid',$user_b)->get();
		if( $query->num_rows() > 0 && $query->row('score') != $result_music['score'] )//已存在，且不相同，进行更新
		{
			//echo "更新 ";
			$this->db->where('host_uid',$user_a)->where('guest_uid',$user_b)->update('match',$data);
		}
		elseif($query->num_rows() <= 0)//不存在，进行插入
		{
			//echo "插入 ";
			$this->db->insert('match',$data);
		}					
	}

	// --------------------------------------------------------------------

	/**
	 * 对 用户 A和B 的movie 进行 相似度评分 
	 *
	 * @access public
	 * @param int $A_id
	 * @param int $b_id
	 * @return array $result
	 */
	function match_movie($A_id, $B_id)
	{
		//选取A、B评价过的所有movie
		$movie_A = $this->db->where('uid', $A_id)->from('movie_user')->get();
		$movie_B = $this->db->where('uid', $B_id)->from('movie_user')->get();
		
		//$hash;          //保存所有A或B评价过的人物douban_movie_id：对于$hash[i]，若值为1，表示A、B中只有1人评价过该人物i； 若值为2，表示A、B2人都评价过该人物i
		//$hash_score_A;  //记录用户A的打分情况
		//$hash_score_B;
		$hash=array();
		$hash_score_A=array();
		$hash_score_B=array();
		
		//返回结果集
		$score = 0;//匹配得分

		$result['same_c'] = 0;//相同	
		$result['different_c']= 0;//相反
		$result['his_own_c']  = 0;  //A未评价，B已评价 的人物数目，推荐
		$result['my_own_c']   = 0;  //A已评价，B未评价 的人物数目

		$result['high'] = 0;//最高分
		$result['low']  = 0;//最低分
		
		$my_count = 0;//计算我的集合大小
		$his_count = 0;//计算ta的集合大小

		foreach ($movie_A->result() as $row)//遍历 用户A评价过的movie
		{
			$my_count++;
			$hash[ $row->douban_movie_id ] = 1;
			$hash_score_A[ $row->douban_movie_id ] = intval( $row->score );
		}

		foreach ($movie_B->result() as $row)//遍历 用户B评价过的movie
		{
			$his_count++;
			if(array_key_exists($row->douban_movie_id,$hash) && $hash[ $row->douban_movie_id ] == 1)//用户A也评价过
			{
				$hash[ $row->douban_movie_id ] = 2;
				$hash_score_B[ $row->douban_movie_id ] = intval( $row->score );
			}
			else
			{
				$hash[ $row->douban_movie_id ] = 1;
				$hash_score_B[ $row->douban_movie_id ] = intval( $row->score );
			}
		}
		
		$cross_count = 0;//计算交集大小

		foreach ($hash as $key => $value) //遍历 所有A或B 评价过的movie
		{
			if($value==1) //1人评价过，另1人未评价
			{
				if( array_key_exists($key,$hash_score_A) && $hash_score_A[$key] != null ) //A已评价，B未评价
				{
					//$result['score'] += $this->get_score($hash_score_A[$key], 0);
					$result['my_own'][ $result['my_own_c']++ ] = $key; //记录A已评价，B未评价的人物
				}
				else if( array_key_exists($key,$hash_score_B) && $hash_score_B[$key] != null) //A未评价，B已评价
				{
					//$result['score'] += $this->get_score(0, $hash_score_B[$key]);
					$result['his_own'][ $result['his_own_c']++ ] = $key; //记录A未评价，B已评价的人物
				}
			}
			else if($value==2)//2人都评价过
			{
				$cross_count++;
				
				//计算最高、最低分值
				if( $hash_score_A[ $key ]==5 )
				{
					$result['high'] += 10;
					$result['low']  += -10;
				}
				elseif( $hash_score_A[ $key ]==4 )
				{
					$result['high'] += 8;
					$result['low']  += -8;
				}
				elseif( $hash_score_A[ $key ]==3)
				{
					$result['high'] += 4;
					$result['low']  += -6;
				}
				elseif( $hash_score_A[ $key ]==2 )
				{
					$result['high'] += 8;
					$result['low']  += -8;
				}
				elseif( $hash_score_A[ $key ]==1 )
				{
					$result['high'] += 10;
					$result['low']  += -10;
				}
				
				//取得A、B 对 movie $key 的打分
				$a = $hash_score_A[$key];
				$b = $hash_score_B[$key];

				if( ($a>=3 && $b>=3) || ($a<3 && $b<3) ) //态度相同
				{
					$result['same'][ $result['same_c'] ] = $key;
					$result['same_c']++;
				}
				else //态度相反
				{
					$result['different'][$result['different_c']] = $key;
					$result['different_c']++;
				}

				$score += $this->get_score($a,$b);
			}
		}
		
		//交集 与我的收藏集合的比例分，比例越小得分越低
		$my_score = 0;
		if($my_count != 0)
		{
			$cross = $cross_count/$my_count;
			if($cross >= 0.5)
			{
				$my_score = 1;
			}
			elseif($cross >= 0.4)
			{
				$my_score = 0.95;
			}
			elseif($cross >= 0.3)
			{
				$my_score = 0.9;
			}
			elseif($cross >= 0.2)
			{
				$my_score = 0.85;
			}
			elseif($cross >= 0.1)
			{
				$my_score = 0.8;
			}
			else
			{
				$my_score = 0.6;
			}
		}
		
		//交集 与ta的收藏集合的比例分，比例越小得分越低
		$his_score = 0;
		if($his_count != 0)
		{
			$cross = $cross_count/$his_count;
			if($cross >= 0.1)
			{
				$his_score = 1;
			}
			elseif($cross >= 0.05)
			{
				$his_score = 0.9;
			}
			elseif($cross >= 0.025)
			{
				$his_score = 0.8;
			}
			elseif($cross >= 0.0125)
			{
				$his_score = 0.7;
			}
			else
			{
				$his_score = 0.6;
			}
		}
		
		//交集相似度
		if($result['high']-$result['low']!=0)
		{
			$cross_similarity = ($score + $result['high'])/($result['high']-$result['low']);
		}
		else
		{
			$cross_similarity = 0;
		}
		
		$result['score'] = round(100 * $his_score * $my_score * $cross_similarity, 2);

		//更新 match_movie 表	
		$new_match['score'] = $result['score'];
		$this->db->where('host_uid',$A_id)->where('guest_uid',$B_id)->update('match_movie',$new_match);

		return $result;
	}
	
	// --------------------------------------------------------------------

	/**
	 * 对 用户 A和B book 进行 相似度评分 
	 *
	 * @access public
	 * @param int $A_id
	 * @param int $b_id
	 * @return array $result
	 */
	function match_book($A_id, $B_id)
	{
		//选取A、B评价过的所有book
		$book_A = $this->db->where('uid', $A_id)->from('book_user')->get();
		$book_B = $this->db->where('uid', $B_id)->from('book_user')->get();
		
		//$hash;          //保存所有A或B评价过的人物douban_book_id：对于$hash[i]，若值为1，表示A、B中只有1人评价过该人物i； 若值为2，表示A、B2人都评价过该人物i
		//$hash_score_A;  //记录用户A的打分情况
		//$hash_score_B;
		$hash=array();
		$hash_score_A=array();
		$hash_score_B=array();
		
		//返回结果集
		$score = 0;//匹配得分

		$result['same_c'] = 0;//相同
		$result['same_like_c']     = 0;//都喜欢
		$result['same_dislike_c']  = 0;//都讨厌
		
		$result['different_c']= 0;//相反
		$result['different_i_like_c']  = 0;//我喜欢，ta讨厌
		$result['different_i_dislike_c']  = 0;//我讨厌，ta喜欢

		$result['his_own_c']  = 0;  //A未评价，B已评价 的人物数目，推荐
		$result['my_own_c']   = 0;  //A已评价，B未评价 的人物数目

		$result['high'] = 0;//最高分
		$result['low']  = 0;//最低分
		
		$my_count = 0;//计算我的集合大小
		$his_count = 0;//计算ta的集合大小

		foreach ($book_A->result() as $row)//遍历 用户A评价过的book
		{
			$my_count++;
			$hash[ $row->douban_book_id ] = 1;
			$hash_score_A[ $row->douban_book_id ] = intval( $row->score );
		}

		foreach ($book_B->result() as $row)//遍历 用户B评价过的book
		{
			$his_count++;
			if(array_key_exists($row->douban_book_id,$hash) && $hash[ $row->douban_book_id ] == 1)//用户A也评价过
			{
				$hash[ $row->douban_book_id ] = 2;
				$hash_score_B[ $row->douban_book_id ] = intval( $row->score );
			}
			else
			{
				$hash[ $row->douban_book_id ] = 1;
				$hash_score_B[ $row->douban_book_id ] = intval( $row->score );
			}
		}
		
		$cross_count = 0;//计算交集大小

		foreach ($hash as $key => $value) //遍历 所有A或B 评价过的book
		{
			if($value==1) //1人评价过，另1人未评价
			{
				if( array_key_exists($key,$hash_score_A) && $hash_score_A[$key] != null ) //A已评价，B未评价
				{
					//$result['score'] += $this->get_score($hash_score_A[$key], 0);
					$result['my_own'][ $result['my_own_c']++ ] = $key; //记录A已评价，B未评价的人物
				}
				else if( array_key_exists($key,$hash_score_B) && $hash_score_B[$key] != null) //A未评价，B已评价
				{
					//$result['score'] += $this->get_score(0, $hash_score_B[$key]);
					$result['his_own'][ $result['his_own_c']++ ] = $key; //记录A未评价，B已评价的人物
				}
			}
			else if($value==2)//2人都评价过
			{
				$cross_count++;
				
				//计算最高、最低分值
				if( $hash_score_A[ $key ]==5 )
				{
					$result['high'] += 10;
					$result['low']  += -10;
				}
				elseif( $hash_score_A[ $key ]==4 )
				{
					$result['high'] += 8;
					$result['low']  += -8;
				}
				elseif( $hash_score_A[ $key ]==3)
				{
					$result['high'] += 4;
					$result['low']  += -6;
				}
				elseif( $hash_score_A[ $key ]==2 )
				{
					$result['high'] += 8;
					$result['low']  += -8;
				}
				elseif( $hash_score_A[ $key ]==1 )
				{
					$result['high'] += 10;
					$result['low']  += -10;
				}
				
				//取得A、B 对 book $key 的打分
				$a = $hash_score_A[$key];
				$b = $hash_score_B[$key];

				if( ($a>=3 && $b>=3) || ($a<3 && $b<3) ) //态度相同
				{
					$result['same'][ $result['same_c'] ] = $key;
					$result['same_c']++;
				}
				else //态度相反
				{
					$result['different'][$result['different_c']] = $key;
					$result['different_c']++;
				}

				$score += $this->get_score($a,$b);
			}
		}
		
		//交集 与我的收藏集合的比例分，比例越小得分越低
		$my_score = 0;
		if($my_count != 0)
		{
			$cross = $cross_count/$my_count;
			if($cross >= 0.5)
			{
				$my_score = 1;
			}
			elseif($cross >= 0.4)
			{
				$my_score = 0.95;
			}
			elseif($cross >= 0.3)
			{
				$my_score = 0.9;
			}
			elseif($cross >= 0.2)
			{
				$my_score = 0.85;
			}
			elseif($cross >= 0.1)
			{
				$my_score = 0.8;
			}
			else
			{
				$my_score = 0.6;
			}
		}
		
		//交集 与ta的收藏集合的比例分，比例越小得分越低
		$his_score = 0;
		if($his_count != 0)
		{
			$cross = $cross_count/$his_count;
			if($cross >= 0.1)
			{
				$his_score = 1;
			}
			elseif($cross >= 0.05)
			{
				$his_score = 0.9;
			}
			elseif($cross >= 0.025)
			{
				$his_score = 0.8;
			}
			elseif($cross >= 0.0125)
			{
				$his_score = 0.7;
			}
			else
			{
				$his_score = 0.6;
			}
		}
		
		//交集相似度
		if($result['high']-$result['low']!=0)
		{
			$cross_similarity = ($score + $result['high'])/($result['high']-$result['low']);
		}
		else
		{
			$cross_similarity = 0;
		}
		
		$result['score'] = round(100 * $his_score * $my_score * $cross_similarity, 2);

		//更新 match_book 表	
		$new_match['score'] = $result['score'];
		$this->db->where('host_uid',$A_id)->where('guest_uid',$B_id)->update('match_book',$new_match);

		return $result;
	}
	
	// --------------------------------------------------------------------

	/**
	 * 对 用户 A和B music 进行 相似度评分 
	 *
	 * @access public
	 * @param int $A_id
	 * @param int $b_id
	 * @return array $result
	 */
	function match_music($A_id, $B_id)
	{
		//选取A、B评价过的所有music
		$music_A = $this->db->where('uid', $A_id)->from('music_user')->get();
		$music_B = $this->db->where('uid', $B_id)->from('music_user')->get();
		
		//$hash;          //保存所有A或B评价过的人物douban_music_id：对于$hash[i]，若值为1，表示A、B中只有1人评价过该人物i； 若值为2，表示A、B2人都评价过该人物i
		//$hash_score_A;  //记录用户A的打分情况
		//$hash_score_B;
		$hash=array();
		$hash_score_A=array();
		$hash_score_B=array();
		
		//返回结果集
		$score = 0;//匹配得分

		$result['same_c'] = 0;//相同
		$result['same_like_c']     = 0;//都喜欢
		$result['same_dislike_c']  = 0;//都讨厌
		
		$result['different_c']= 0;//相反
		$result['different_i_like_c']  = 0;//我喜欢，ta讨厌
		$result['different_i_dislike_c']  = 0;//我讨厌，ta喜欢

		$result['his_own_c']  = 0;  //A未评价，B已评价 的人物数目，推荐
		$result['my_own_c']   = 0;  //A已评价，B未评价 的人物数目

		$result['high'] = 0;//最高分
		$result['low']  = 0;//最低分
		
		$my_count = 0;//计算我的集合大小
		$his_count = 0;//计算ta的集合大小

		foreach ($music_A->result() as $row)//遍历 用户A评价过的music
		{
			$my_count++;
			$hash[ $row->douban_music_id ] = 1;
			$hash_score_A[ $row->douban_music_id ] = intval( $row->score );
		}

		foreach ($music_B->result() as $row)//遍历 用户B评价过的music
		{
			$his_count++;
			if(array_key_exists($row->douban_music_id,$hash) && $hash[ $row->douban_music_id ] == 1)//用户A也评价过
			{
				$hash[ $row->douban_music_id ] = 2;
				$hash_score_B[ $row->douban_music_id ] = intval( $row->score );
			}
			else
			{
				$hash[ $row->douban_music_id ] = 1;
				$hash_score_B[ $row->douban_music_id ] = intval( $row->score );
			}
		}
		
		$cross_count = 0;//计算交集大小

		foreach ($hash as $key => $value) //遍历 所有A或B 评价过的music
		{
			if($value==1) //1人评价过，另1人未评价
			{
				if( array_key_exists($key,$hash_score_A) && $hash_score_A[$key] != null ) //A已评价，B未评价
				{
					//$result['score'] += $this->get_score($hash_score_A[$key], 0);
					$result['my_own'][ $result['my_own_c']++ ] = $key; //记录A已评价，B未评价的人物
				}
				else if( array_key_exists($key,$hash_score_B) && $hash_score_B[$key] != null) //A未评价，B已评价
				{
					//$result['score'] += $this->get_score(0, $hash_score_B[$key]);
					$result['his_own'][ $result['his_own_c']++ ] = $key; //记录A未评价，B已评价的人物
				}
			}
			else if($value==2)//2人都评价过
			{
				$cross_count++;
				
				//计算最高、最低分值
				if( $hash_score_A[ $key ]==5 )
				{
					$result['high'] += 10;
					$result['low']  += -10;
				}
				elseif( $hash_score_A[ $key ]==4 )
				{
					$result['high'] += 8;
					$result['low']  += -8;
				}
				elseif( $hash_score_A[ $key ]==3)
				{
					$result['high'] += 4;
					$result['low']  += -6;
				}
				elseif( $hash_score_A[ $key ]==2 )
				{
					$result['high'] += 8;
					$result['low']  += -8;
				}
				elseif( $hash_score_A[ $key ]==1 )
				{
					$result['high'] += 10;
					$result['low']  += -10;
				}
				
				//取得A、B 对 music $key 的打分
				$a = $hash_score_A[$key];
				$b = $hash_score_B[$key];

				if( ($a>=3 && $b>=3) || ($a<3 && $b<3) ) //态度相同
				{
					$result['same'][ $result['same_c'] ] = $key;
					$result['same_c']++;
				}
				else //态度相反
				{
					$result['different'][$result['different_c']] = $key;
					$result['different_c']++;
				}

				$score += $this->get_score($a,$b);
			}
		}
		
		//交集 与我的收藏集合的比例分，比例越小得分越低
		$my_score = 0;
		if($my_count != 0)
		{
			$cross = $cross_count/$my_count;
			if($cross >= 0.5)
			{
				$my_score = 1;
			}
			elseif($cross >= 0.4)
			{
				$my_score = 0.95;
			}
			elseif($cross >= 0.3)
			{
				$my_score = 0.9;
			}
			elseif($cross >= 0.2)
			{
				$my_score = 0.85;
			}
			elseif($cross >= 0.1)
			{
				$my_score = 0.8;
			}
			else
			{
				$my_score = 0.6;
			}
		}
		
		//交集 与ta的收藏集合的比例分，比例越小得分越低
		$his_score = 0;
		if($his_count != 0)
		{
			$cross = $cross_count/$his_count;
			if($cross >= 0.1)
			{
				$his_score = 1;
			}
			elseif($cross >= 0.05)
			{
				$his_score = 0.9;
			}
			elseif($cross >= 0.025)
			{
				$his_score = 0.8;
			}
			elseif($cross >= 0.0125)
			{
				$his_score = 0.7;
			}
			else
			{
				$his_score = 0.6;
			}
		}
		
		//交集相似度
		if($result['high']-$result['low']!=0)
		{
			$cross_similarity = ($score + $result['high'])/($result['high']-$result['low']);
		}
		else
		{
			$cross_similarity = 0;
		}
		
		$result['score'] = round(100 * $his_score * $my_score * $cross_similarity, 2);

		//更新 match_music 表	
		$new_match['score'] = $result['score'];
		$this->db->where('host_uid',$A_id)->where('guest_uid',$B_id)->update('match_music',$new_match);

		return $result;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 根据 用户A和B 对某个收藏的评价，返回用户A和B的相似度
	 *
	 * @access public
	 * @param int $a
	 * @param int $b
	 * @return int score
	 */
	function get_score($a,$b)
	{
		if($a==5)
		{
			if($b==5)
			{
				$score = 10;
			}
			else if($b==4)
			{
				$score = 6;
			}
			else if($b==3)
			{
				$score = 2;
			}
			else if($b==2)
			{
				$score = -8;
			}
			else if($b==1)
			{
				$score = -10;
			}
		}
		else if($a==4)
		{
			if($b==5)
			{
				$score = 6;
			}
			else if($b==4)
			{
				$score = 8;
			}
			else if($b==3)
			{
				$score = 3;
			}
			else if($b==2)
			{
				$score = -6;
			}
			else if($b==1)
			{
				$score = -8;
			}
		}
		else if($a==3)
		{
			if($b==5)
			{
				$score = 2;
			}
			else if($b==4)
			{
				$score = 3;
			}
			else if($b==3)
			{
				$score = 4;
			}
			else if($b==2)
			{
				$score = -4;
			}
			else if($b==1)
			{
				$score = -6;
			}
		}
		else if($a==2)
		{
			if($b==5)
			{
				$score = -8;
			}
			else if($b==4)
			{
				$score = -6;
			}
			else if($b==3)
			{
				$score = -4;
			}
			else if($b==2)
			{
				$score = 8;
			}
			else if($b==1)
			{
				$score = 6;
			}
		}
		else if($a==1)
		{
			if($b==5)
			{
				$score = -10;
			}
			else if($b==4)
			{
				$score = -8;
			}
			else if($b==3)
			{
				$score = -6;
			}
			else if($b==2)
			{
				$score = 6;
			}
			else if($b==1)
			{
				$score = 10;
			}
		}
		
		return $score;
	}

	
}

/* End of file admin_model.php */
/* Location: ./application/modules/admin/models/admin_model.php */