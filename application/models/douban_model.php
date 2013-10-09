<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Douban_model，豆瓣（电影、音乐、书籍）模型，进行CURD操作
 */

class Douban_model extends CI_Model {

	/**
	 * 返回movie image
	 */
	function get_average_score($a_id, $b_id)
	{
		$query = $this->db->from('match')->where('host_uid',$a_id)->where('guest_uid',$b_id)->get();
		if($query->num_rows()>0)
		{
			return $query->row()->score;
		}
		else
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 返回movie image
	 */
	function get_movie_image($movie_id)
	{
		$query = $this->db->from('movie')->where('douban_movie_id',$movie_id)->get();
		if($query->num_rows()>0)
		{
			return $query->row()->image_url;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * 返回book image
	 */
	function get_book_image($book_id)
	{
		$query = $this->db->from('book')->where('douban_book_id',$book_id)->get();
		if($query->num_rows()>0)
		{
			return $query->row()->image_url;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * music image
	 */
	function get_music_image($music_id)
	{
		$query = $this->db->from('music')->where('douban_music_id',$music_id)->get();
		if($query->num_rows()>0)
		{
			return $query->row()->image_url;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * 获取 用户uid 对 movie movie_id 的评分
	 */
	function get_movie_score($uid, $movie_id)
	{
		$query = $this->db->from('movie_user')->where('uid',$uid)->where('douban_movie_id',$movie_id)->get();

		if ($query->num_rows() > 0)
		{
			return $query->row()->score;
		}
		else
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取 用户uid 对 book book_id 的评分
	 */
	function get_book_score($uid, $book_id)
	{
		$query = $this->db->from('book_user')->where('uid',$uid)->where('douban_book_id',$book_id)->get();

		if ($query->num_rows() > 0)
		{
			return $query->row()->score;
		}
		else
		{
			return FALSE;
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取 用户uid 对 music music_id 的评分
	 */
	function get_music_score($uid, $music_id)
	{
		$query = $this->db->from('music_user')->where('uid',$uid)->where('douban_music_id',$music_id)->get();

		if ($query->num_rows() > 0)
		{
			return $query->row()->score;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * 检查 用户uid 是否 已评价 movie movie_id 
	 *
	 * @access public
	 * @param int $uid
	 * @param int $cid
	 * @return boolean
	 */
	function check_if_scored_movie($uid, $movie_id)
	{
		$check = $this->db->from('movie_user')->where('uid',$uid)->where('douban_movie_id',$movie_id)->get();

		if ($check->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * 检查 用户uid 是否 已评价 book book_id 
	 *
	 * @access public
	 * @param int $uid
	 * @param int $cid
	 * @return boolean
	 */
	function check_if_scored_book($uid, $book_id)
	{
		$check = $this->db->from('book_user')->where('uid',$uid)->where('douban_book_id',$book_id)->get();

		if ($check->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * 检查 用户uid 是否 已评价 music music_id 
	 *
	 * @access public
	 * @param int $uid
	 * @param int $cid
	 * @return boolean
	 */
	function check_if_scored_music($uid, $music_id)
	{
		$check = $this->db->from('music_user')->where('uid',$uid)->where('douban_music_id',$music_id)->get();

		if ($check->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * 保存用户$uid 对电影$movie_id 的评分$score 
	 *
	 * @access public
	 * @param int $score
	 * @param int $uid
	 * @param int $movie_id

	 * @return 
	 */

	function movie_scoring($score, $uid, $movie_id)
	{		
		if( $this->check_if_scored_movie($uid,$movie_id) == FALSE )//新增，第一次评分
		{
			$data = array(
				'uid' => $uid,
				'douban_movie_id' => $movie_id,
				'score' => $score
			);
			$this->db->insert('movie_user',$data);
		}
		else//更新，之前已评分
		{
			$old_score = $this->db->from('movie_user')->where('uid',$uid)->where('douban_movie_id',$movie_id)->get()->row()->score;
			
			if($score==$old_score) //更新前后 评分相同
			{
				$q = 1;
				$t = 1;
			}
			else
			{
				$new_data = array(
					'score' => $score
				);
				$this->db->where('uid',$uid)->where('douban_movie_id',$movie_id)->update('movie_user',$new_data);
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 保存用户$uid 对书籍$book_id 的评分$score 
	 *
	 * @access public
	 * @param int $score
	 * @param int $uid
	 * @param int $book_id

	 * @return 
	 */

	function book_scoring($score, $uid, $book_id)
	{		
		if( $this->check_if_scored_book($uid,$book_id) == FALSE )//新增，第一次评分
		{
			$data = array(
				'uid' => $uid,
				'douban_book_id' => $book_id,
				'score' => $score
			);
			$this->db->insert('book_user',$data);
		}
		else//更新，之前已评分
		{
			$old_score = $this->db->from('book_user')->where('uid',$uid)->where('douban_book_id',$book_id)->get()->row()->score;
			
			if($score==$old_score) //更新前后 评分相同
			{
				$q = 1;
				$t = 1;
			}
			else
			{
				$new_data = array(
					'score' => $score
				);
				$this->db->where('uid',$uid)->where('douban_book_id',$book_id)->update('book_user',$new_data);
			}
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 保存用户$uid 对音乐$music_id 的评分$score 
	 *
	 * @access public
	 * @param int $score
	 * @param int $uid
	 * @param int $music_id

	 * @return 
	 */

	function music_scoring($score, $uid, $music_id)
	{		
		if( $this->check_if_scored_music($uid,$music_id) == FALSE )//新增，第一次评分
		{
			$data = array(
				'uid' => $uid,
				'douban_music_id' => $music_id,
				'score' => $score
			);
			$this->db->insert('music_user',$data);
		}
		else//更新，之前已评分
		{
			$old_score = $this->db->from('music_user')->where('uid',$uid)->where('douban_music_id',$music_id)->get()->row()->score;
			
			if($score==$old_score) //更新前后 评分相同
			{
				$q = 1;
				$t = 1;
			}
			else
			{
				$new_data = array(
					'score' => $score
				);
				$this->db->where('uid',$uid)->where('douban_music_id',$music_id)->update('music_user',$new_data);
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加电影
	 */

	function add_movie($movie_id, $image_url)
	{
		if(!$this->get_movie_image($movie_id))
		{
			$data['douban_movie_id']  = $movie_id;
			$data['image_url'] = $image_url;
		
			$this->db->insert('movie',$data);
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加书籍
	 */

	function add_book($book_id, $image_url)
	{
		if(!$this->get_book_image($book_id))
		{
			$data['douban_book_id']  = $book_id;
			$data['image_url'] = $image_url;
		
			$this->db->insert('book',$data);
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加音乐
	 */

	function add_music($music_id, $image_url)
	{
		if(!$this->get_music_image($music_id))
		{
			$data['douban_music_id']  = $music_id;
			$data['image_url'] = $image_url;
		
			$this->db->insert('music',$data);
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加、更新用户的movie收藏信息
	 */
	function update_movie_info($douban_id, $user_id)
	{
		$request_count = 0;
		
		/*
		获取豆瓣收藏 movie
		wish 收藏未评价 统一打3分
		豆瓣API每次调用最多返回50个结果，超过50个则多次发起调用
		*/			
		for($i=1; ;$i+=50)//watched 看过
		{
			$douban_movie_url = "http://api.douban.com/people/$douban_id/collection?apikey=0d9de8033fc7105528d9b809bf5530ff&cat=movie&status=watched&start-index=$i&max-results=50&alt=json";
			$ch_douban_movie = curl_init();
			curl_setopt($ch_douban_movie, CURLOPT_URL, $douban_movie_url);				
			curl_setopt($ch_douban_movie, CURLOPT_RETURNTRANSFER, 1);
			$douban_movie_json = curl_exec($ch_douban_movie);//返回json
			curl_close($ch_douban_movie);
					
			$douban_movie = json_decode($douban_movie_json); //json转换成对象/数组
			if(empty($douban_movie->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_movie->{'entry'}); $j++)
			{
				if(isset($douban_movie->{'entry'}[$j]->{'gd:rating'}->{'@value'}))
					$score = intval( $douban_movie->{'entry'}[$j]->{'gd:rating'}->{'@value'} );//评分
				else
					$score = 3;
					
				$movie_id = intval(substr($douban_movie->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 36));//豆瓣电影id		
				$movie_image = $douban_movie->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_movie($movie_id, $movie_image);
					
				//保存用户对于该电影的评分
				$this->douban_model->movie_scoring($score, $user_id, $movie_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
				
		for($i=1; ;$i+=50)//watching 在看
		{
			$douban_movie_url = "http://api.douban.com/people/$douban_id/collection?apikey=0d9de8033fc7105528d9b809bf5530ff&cat=movie&status=watching&start-index=$i&max-results=50&alt=json";
			$ch_douban_movie = curl_init();
			curl_setopt($ch_douban_movie, CURLOPT_URL, $douban_movie_url);				
			curl_setopt($ch_douban_movie, CURLOPT_RETURNTRANSFER, 1);
			$douban_movie_json = curl_exec($ch_douban_movie);//返回json
			curl_close($ch_douban_movie);
					
			$douban_movie = json_decode($douban_movie_json); //json转换成对象/数组
			if(empty($douban_movie->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_movie->{'entry'}); $j++)
			{
				if(isset($douban_movie->{'entry'}[$j]->{'gd:rating'}->{'@value'}))
					$score = intval( $douban_movie->{'entry'}[$j]->{'gd:rating'}->{'@value'} );//评分
				else
					$score = 3;
					
				$movie_id = intval(substr($douban_movie->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 36));//豆瓣电影id		
				$movie_image = $douban_movie->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_movie($movie_id, $movie_image);
					
				//保存用户对于该电影的评分
				$this->douban_model->movie_scoring($score, $user_id, $movie_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
				
		for($i=1; ;$i+=50)//wish 想看
		{
			$douban_movie_url = "http://api.douban.com/people/$douban_id/collection?apikey=0d9de8033fc7105528d9b809bf5530ff&cat=movie&status=wish&start-index=$i&max-results=50&alt=json";
			$ch_douban_movie = curl_init();
			curl_setopt($ch_douban_movie, CURLOPT_URL, $douban_movie_url);				
			curl_setopt($ch_douban_movie, CURLOPT_RETURNTRANSFER, 1);
			$douban_movie_json = curl_exec($ch_douban_movie);//返回json
			curl_close($ch_douban_movie);
					
			$douban_movie = json_decode($douban_movie_json); //json转换成对象/数组
			if(empty($douban_movie->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_movie->{'entry'}); $j++)
			{
				$score = 3;
					
				$movie_id = intval(substr($douban_movie->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 36));//豆瓣电影id		
				$movie_image = $douban_movie->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_movie($movie_id, $movie_image);
					
				//保存用户对于该电影的评分
				$this->douban_model->movie_scoring($score, $user_id, $movie_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}		
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加、更新用户的book收藏信息
	 */
	function update_book_info($douban_id, $user_id)
	{
		$request_count = 0;
		/*
		获取豆瓣收藏 book
		wish 收藏未评价 统一打3分 
		豆瓣API每次调用最多返回50个结果，超过50个则多次发起调用
		*/			
		for($i=1; ;$i+=50)//read 读过
		{
			$douban_book_url = "http://api.douban.com/people/$douban_id/collection?cat=book&status=read&start-index=$i&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban_book = curl_init();
			curl_setopt($ch_douban_book, CURLOPT_URL, $douban_book_url);
			curl_setopt($ch_douban_book, CURLOPT_RETURNTRANSFER, 1);
			$douban_book_json = curl_exec($ch_douban_book);//返回json
			curl_close($ch_douban_book);
					
			$douban_book = json_decode($douban_book_json); //json转换成对象/数组
			
			if(empty($douban_book->{'entry'}) == TRUE )
			{
				break;
			}
				
			for($j=0; $j<count($douban_book->{'entry'}); $j++)
			{
				if(isset($douban_book->{'entry'}[$j]->{'gd:rating'}->{'@value'}))
					$score = intval( $douban_book->{'entry'}[$j]->{'gd:rating'}->{'@value'} );//评分
				else
					$score = 3;
					
				$book_id = intval(substr($douban_book->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 35));//豆瓣book id
				$book_image = $douban_book->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_book($book_id, $book_image);
					
				//保存用户对于该book的评分
				$this->douban_model->book_scoring($score, $user_id, $book_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
				
		for($i=1; ;$i+=50)//reading 在读
		{
			$douban_book_url = "http://api.douban.com/people/$douban_id/collection?cat=book&status=reading&start-index=$i&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban_book = curl_init();
			curl_setopt($ch_douban_book, CURLOPT_URL, $douban_book_url);				
			curl_setopt($ch_douban_book, CURLOPT_RETURNTRANSFER, 1);
			$douban_book_json = curl_exec($ch_douban_book);//返回json
			curl_close($ch_douban_book);
					
			$douban_book = json_decode($douban_book_json); //json转换成对象/数组
			
			
			if(empty($douban_book->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_book->{'entry'}); $j++)
			{
				if(isset($douban_book->{'entry'}[$j]->{'gd:rating'}->{'@value'}))
					$score = intval( $douban_book->{'entry'}[$j]->{'gd:rating'}->{'@value'} );//评分
				else
					$score = 3;
					
				$book_id = intval(substr($douban_book->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 35));//豆瓣book id		
				$book_image = $douban_book->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_book($book_id, $book_image);
					
				//保存用户对于该book的评分
				$this->douban_model->book_scoring($score, $user_id, $book_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
				
		for($i=1; ;$i+=50)//wish 想读
		{
			$douban_book_url = "http://api.douban.com/people/$douban_id/collection?cat=book&status=wish&start-index=$i&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban_book = curl_init();
			curl_setopt($ch_douban_book, CURLOPT_URL, $douban_book_url);
			curl_setopt($ch_douban_book, CURLOPT_RETURNTRANSFER, 1);
			$douban_book_json = curl_exec($ch_douban_book);//返回json
			curl_close($ch_douban_book);
					
			$douban_book = json_decode($douban_book_json); //json转换成对象/数组
			
			if(empty($douban_book->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_book->{'entry'}); $j++)
			{
				$score = 3;
					
				$book_id = intval(substr($douban_book->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 35));//豆瓣book id		
				$book_image = $douban_book->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_book($book_id, $book_image);
					
				//保存用户对于该book的评分
				$this->douban_model->book_scoring($score, $user_id, $book_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加、更新用户的music收藏信息
	 */
	function update_music_info($douban_id, $user_id)
	{
		$request_count = 0;
		/*
		获取豆瓣收藏 music
		wish 收藏未评价 统一打3分 
		豆瓣API每次调用最多返回50个结果，超过50个则多次发起调用
		*/			
		for($i=1; ;$i+=50)//listened 听过
		{
			$douban_music_url = "http://api.douban.com/people/$douban_id/collection?cat=music&status=listened&start-index=$i&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban_music = curl_init();
			curl_setopt($ch_douban_music, CURLOPT_URL, $douban_music_url);				
			curl_setopt($ch_douban_music, CURLOPT_RETURNTRANSFER, 1);
			$douban_music_json = curl_exec($ch_douban_music);//返回json
			curl_close($ch_douban_music);
					
			$douban_music = json_decode($douban_music_json); //json转换成对象/数组
			
			if(empty($douban_music->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_music->{'entry'}); $j++)
			{
				if(isset($douban_music->{'entry'}[$j]->{'gd:rating'}->{'@value'}))
					$score = intval( $douban_music->{'entry'}[$j]->{'gd:rating'}->{'@value'} );//评分
				else
					$score = 3;
					
				$music_id = intval(substr($douban_music->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 36));//豆瓣电影id		
				$music_image = $douban_music->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_music($music_id, $music_image);
					
				//保存用户对于该music的评分
				$this->douban_model->music_scoring($score, $user_id, $music_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
				
		for($i=1; ;$i+=50)//listening 在听
		{
			$douban_music_url = "http://api.douban.com/people/$douban_id/collection?cat=music&status=listening&start-index=$i&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban_music = curl_init();
			curl_setopt($ch_douban_music, CURLOPT_URL, $douban_music_url);				
			curl_setopt($ch_douban_music, CURLOPT_RETURNTRANSFER, 1);
			$douban_music_json = curl_exec($ch_douban_music);//返回json
			curl_close($ch_douban_music);
					
			$douban_music = json_decode($douban_music_json); //json转换成对象/数组
			
			if(empty($douban_music->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_music->{'entry'}); $j++)
			{
				if(isset($douban_music->{'entry'}[$j]->{'gd:rating'}->{'@value'}))
					$score = intval( $douban_music->{'entry'}[$j]->{'gd:rating'}->{'@value'} );//评分
				else
					$score = 3;
					
				$music_id = intval(substr($douban_music->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 36));//豆瓣电影id		
				$music_image = $douban_music->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_music($music_id, $music_image);
					
				//保存用户对于该music的评分
				$this->douban_model->music_scoring($score, $user_id, $music_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}
				
		for($i=1; ;$i+=50)//wish 想听
		{
			$douban_music_url = "http://api.douban.com/people/$douban_id/collection?cat=music&status=wish&start-index=$i&max-results=50&alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
			$ch_douban_music = curl_init();
			curl_setopt($ch_douban_music, CURLOPT_URL, $douban_music_url);				
			curl_setopt($ch_douban_music, CURLOPT_RETURNTRANSFER, 1);
			$douban_music_json = curl_exec($ch_douban_music);//返回json
			curl_close($ch_douban_music);
					
			$douban_music = json_decode($douban_music_json); //json转换成对象/数组
			
			if(empty($douban_music->{'entry'}) == TRUE )
			{
				break;
			}
								
			for($j=0; $j<count($douban_music->{'entry'}); $j++)
			{
				$score = 3;
					
				$music_id = intval(substr($douban_music->{'entry'}[$j]->{'db:subject'}->{'id'}->{'$t'}, 36));//豆瓣 music id		
				$music_image = $douban_music->{'entry'}[$j]->{'db:subject'}->{'link'}[2]->{'@href'};
					
				$this->douban_model->add_music($music_id, $music_image);
					
				//保存用户对于该music的评分
				$this->douban_model->music_scoring($score, $user_id, $music_id);
			}
			$request_count++;
			if($request_count > 35)
			{
				$request_count = 0;
				sleep(60);
			}
		}		
	}
	
	// --------------------------------------------------------------------
	
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
	
	// --------------------------------------------------------------------

	/**
	 * 检查远程文件是否存在
	 */
	
	function checkRemoteFile($url)
	{
	    $ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL,$url);
   		// don't download content
    	curl_setopt($ch, CURLOPT_NOBODY, 1);
    	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	if(curl_exec($ch)!==FALSE)
    	{
        	return true;
    	}
    	else
    	{
        	return false;
    	}
	}
	
	// --------------------------------------------------------------------

	/**
	 * 增加、更新用户的movie收藏信息
	 */
	function update_user_info($uid)
	{
		$douban_id = $this->account_model->get_account_douban_id($uid);
		$url = "http://api.douban.com/people/$douban_id?alt=json&apikey=0d9de8033fc7105528d9b809bf5530ff";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);				
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$douban_json = curl_exec($ch);//返回json
		curl_close($ch);
					
		$user_info = json_decode($douban_json); //json转换成对象/数组
		
		$douban_icon = (string)substr($user_info->{'link'}[2]->{'@href'},28);
		
		if( strcmp($douban_icon, $this->account_model->get_account_douban_icon($uid)) != 0 )//头像有更新
		{
			$data['douban_icon'] = $douban_icon;
			$this->db->where('uid',$uid)->update('account',$data);
		}
		
	}


}


/* End of file account_model.php */
/* Location: ./application/modules/account/models/account_model.php */