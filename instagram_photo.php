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
	$image = array();
	$link = array();
	foreach($profilePage->graphql->user->edge_owner_to_timeline_media->edges as $data){
		$image[] = $data->node->display_url;
		$link[] = $data->node->shortcode;
	}
	$json_data =  array(
		"result" => TRUE,
		"message" => array('head'=> 'Success', 'body'=> 'Sukses ambil data data'),
		"form_error" => '',
		"redirect" => '',
		"data" => array(
			"image" => $image,
			"link" => $link
		)
	);
	echo json_encode($json_data);
?>
