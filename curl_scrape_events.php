<?php
function curl_download_first($Url){

    if (!function_exists('curl_init')){
        die('cURL is not installed. Install and try again.');
    }
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
		//curl_setopt($ch, CURLOPT_POST, TRUE);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, array("searchId" => $sID));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		$result = curl_exec($ch); 
	

		$start = strpos( $result, '<div class="ai1ec-stream-view">' ); 
		$end = strpos( $result, '<!--/.ai1ec-stream-view-->'); 
		$section = $end - $start;		
		$result = substr($result, $start, $section);
		
		$titles = explode('<div class="ai1ec-event-title">', $result );
		echo count($titles);
		array_shift($titles);
		
		foreach ( $titles as $title ) {
			$start = strpos( $title, 'href="http://vi' ); 
			$end = strpos( $title, '?instance_id', $start ); 
			$section = $end - $start;
			$url = substr($title, $start, $section);
			$url = str_replace('href="', '', $url);
			$url_array[] = $url;
		}
		return $url_array;
}

function curl_download($Url){
	
    if (!function_exists('curl_init')){
        die('cURL is not installed. Install and try again.');
    }
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
		//curl_setopt($ch, CURLOPT_POST, TRUE);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, array("searchId" => $sID));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$title = '';
		$when = '';
		$date = '';
		$time = '';	
		$multi_day = '';
		$where = '';
		$name = '';
		$email = '';
		$phone = '';
		$web = '';
		$cats = '';
		$image = '';
		$content = '';
			
    // perform post 
		$result = curl_exec($ch); 
		$start = strpos( $result, '<h1 class="entry-title">' ); 
		$end = strpos( $result, '<!-- .entry-content -->' ); 
		$section = $end - $start;
		$main_content = substr($result, $start, $section);

		
		// TITLE
		$start = strpos( $main_content, '<h1 class="entry-title">' ); 
		$end = strpos( $main_content, '</h1>', $start ); 
		$section = $end - $start;
		$title = substr($main_content, $start, $section);
		$title = substr($title, $start, $section);
		$title = str_replace( '<h1 class="entry-title">', '', $title );
		
		// WHEN
		$start = strpos( $main_content, '<div class="ai1ec-time">' ); 
		$end = strpos( $main_content, '<div class="ai1ec-map' ); 
		$section = $end - $start;
		$when = substr($main_content, $start, $section);
		$start = strpos( $when, '<div class="ai1ec-field-value">' ); 
		$end = strpos( $when, '</div>', $start ); 
		$section = $end - $start;
		$when = substr($when, $start, $section);
		$when = str_replace( '<div class="ai1ec-field-value">', '', $when );
		$keep_going = false;
		if ( strpos($when, '2015') || strpos($when, '2014') || strpos($when, '2016')) { $keep_going = true; }
		if ( !$keep_going ) { return; }
		if ( strpos( $when, '@' ) ) {
			$datetime = explode( ' @ ', $when );
			$date = $datetime[0];
			$time = $datetime[1];
		}
		if ( strpos( $when, ' – ' ) ) {
			//$when = explode( ' - ', $when );
			$multi_day = $when;
		}		
		
		// WHERE
		$start = strpos( $main_content, '<div class="ai1ec-location">' ); 
		$end = strpos( $main_content, '<div class="ai1ec-contact">' ); 
		$section = $end - $start;
		$where = substr($main_content, $start, $section);		
		$start = strpos( $where, '<div class="ai1ec-field-value">' ); 
		$end = strpos( $where, '</div>', $start );  
		$section = $end - $start;
		$where = substr($where, $start, $section);					
		$where = str_replace( '<div class="ai1ec-field-value">', '', $where );					


		// CONTACT
		if ( strpos( $main_content, '<div class="ai1ec-contact">' ) ) {
			$contact = explode( '<div class="ai1ec-contact">', $main_content );
			$contact = $contact[1];
			$start = strpos( $contact, '<div class="ai1ec-field-value">' ); 
			$end = strpos( $contact, '</div>', $start );  
			$section = $end - $start;
			$contact = substr($contact, $start, $section);					
			$contact = str_replace( '<div class="ai1ec-field-value">', '', $contact );	
			

			//// name
			if ( strpos( $contact, '<i class="icon-user"></i>' ) ) {
			$start = strpos( $contact, '<i class="icon-user"></i>' ); 
			$end = strpos( $contact, '</span>', $start );
			$section = $end - $start;
			$name = substr($contact, $start, $section);
			$name = str_replace( '<i class="icon-user"></i>', '', $name );	
			}
			
			//// phone
			if ( strpos( $contact, '<i class="icon-phone"></i>' ) ) {
			$start = strpos( $contact, '<i class="icon-phone"></i>' ); 
			$end = strpos( $contact, '</span>', $start );
			$section = $end - $start;
			$phone = substr($contact, $start, $section);
			$phone = str_replace( '<i class="icon-phone"></i>', '', $phone );	
			}
			
			//// email
			if ( strpos( $contact, 'mailto:' ) ) {
			$start = strpos( $contact, 'mailto:' ); 
			$end = strpos( $contact, '">', $start );
			$section = $end - $start;
			$email = substr($contact, $start, $section);
			$email = str_replace( 'mailto:', '', $email );	
			}
			
			
			//// website
			if ( strpos( $contact, 'ai1ec-contact-url' ) ) {
			$start = strpos( $contact, 'href="', $start ); 
			$end = strpos( $contact, '">', $start );
			$section = $end - $start;
			$web = substr($contact, $start, $section);
			$web = str_replace( 'href="', '', $web );			
			}
		}		
		// CATEGORIES
		
		if ( strpos( $main_content, '<div class="ai1ec-categories">' ) ) {
		//$cats = explode( '<div class="ai1ec-categories">', $main_content );
		//print_r($cats);
			$cats = explode( '<div class="ai1ec-categories">', $main_content );
			$cats = $cats[1];		
			$start = strpos( $cats, '<span ' ); 
			$end = strpos( $cats, '</span>' ); 
			$section = $end - $start;
			$cats = substr($cats, $start, $section);	
			$start = strpos( $cats, 'title="' ); 
			$end = strpos( $cats, '">' ); 
			$section = $end - $start;
			$cats = substr($cats, $start, $section);	
			$cats = str_replace( 'title="', '', $cats );			
		}


		

		// CONTENT
		$start = strpos( $main_content, '<p>' ); 
		$end = strpos( $main_content, '<footer class="ai1ec-event-footer">' ); 
		$section = $end - $start;
		$content = substr($main_content, $start, $section);			
		
		$content_array = explode( '<p>', $content);
		$image = $content_array[1];
		unset($content_array[0]);
		unset($content_array[1]);	
		$content = '<p>' . implode( '<p>', $content_array);
		
		
		// IMAGE
		$start = strpos( $image, 'wp-content/uploads/' ); 
		$end = strpos( $image, '">' ); 
		$section = $end - $start;
		$image = substr($image, $start, $section);			
		
		/*
		$output = 
			'<h2>' . $title . '</h2>' . 
			'Date: ' . $date . '<br />' . 
			'Time: ' . $time . '<br />' . 
			'Multi-Day: ' . $multi_day . '<br />' . 
			'Where: ' . $where . '<br />' . 
			'Name: ' . $name  . '<br />' . 
			'Phone: ' . $phone  . '<br />' . 
			'Email: ' . $email  . '<br />' . 
			'Web: ' . $web  . '<br />' . 
			'Cats: ' . $cats  . '<br />' . 
			'Image: ' . $image  . '<br />' . 
			'Content: ' . $content  . '<br />'
			;
		*/
		$output = 
			$title . "|" . 
			$date . "|" . 
			$time . "|" . 
			$multi_day . "|" . 
			$where . "|" . 
			$name  . "|" . 
			$phone  . "|" . 
			$email  . "|" . 
			$web  . "|" . 
			$cats  . "|" . 
			$image  . "|" . 
			$content
		;
		
		//$output = str_replace(array("\r","\n"),"",$output);
		//echo  $output . "\r\n";
		
		// Create post object
		$my_post = array(
			'post_title'    => $title,
			'post_content'  => $content,
			'post_status'   => 'publish',
			'post_author'   => 1,
			//'post_category' => array(8,39),
			'post_type'			=> 'tribe_events'
		);

		// Insert the post into the database
		wp_insert_post( $my_post );
		
    curl_close ($ch); 
}
?>