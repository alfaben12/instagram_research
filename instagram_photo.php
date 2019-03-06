<?php
/*
	Author : Developer FollowersIndo
	site: followersindo.com
*/
	$username = 'thariqalfa';
	$url = "http://www.instagram.com/".$username."/"; 
	$insta_source = file_get_contents($url);
	$shards = explode('window._sharedData = ', $insta_source);
	$insta_json = explode(';</script>', $shards[1]); 
	$json = json_decode($insta_json[0]);
	$entry_data = $json->entry_data;
	$profilePage = $json->entry_data->ProfilePage{0}; 
	$result = array();
	foreach($profilePage->graphql->user->edge_owner_to_timeline_media->edges as $data){
		$result_temp = array(
			'id' => $data->node->id,
			'caption' => $data->node->edge_media_to_caption->edges[0]->node->text,
			'display_url' => $data->node->display_url,
			'display_ig' => 'https://www.instagram.com/p/'. $data->node->shortcode .'/',
			'comment' => $data->node->edge_media_to_comment->count,
			'like' => $data->node->edge_liked_by->count,
			'owner' => $data->node->owner->username,
			'datetime' => date('m/d/Y H:i:s',  $data->node->taken_at_timestamp)
		);
		array_push($result, $result_temp);
	}

	if (count($result) > 0) {
		$json_data =  array(
			"status" => 200,
			"message" => array('head'=> 'Success', 'body'=> 'Complete'),
			"data" => $result
		);
		echo json_encode($json_data);
	}else{
		$json_data =  array(
			"status" => 201,
			"message" => array('head'=> 'Failed', 'body'=> 'Failed'),
		);
		echo json_encode($json_data);
	}
?>
