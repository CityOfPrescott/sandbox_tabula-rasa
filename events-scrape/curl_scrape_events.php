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
		//echo count($titles);
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
		$time_new = '';
		$time_start = '';
		$time_end = '';
		$multi_day = '';
		$where = '';
		$venue = '';
		$venue[0] = '';
		$venue[1] = '';
		$venue[2] = '';
		$venue_city_state = '';
		$venue_city_state[0] = '';
		$venue_city_state[1] = '';
		$venue_city_state[2] = '';
		$venue_title = '';
		$venue_address = '';
		$venue_city = '';
		$venue_state = '';
		$venue_zip = '';
		$cost = '';
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
		$title = ucwords( $title );
		
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

			// Remove em dash
			$em_dash = html_entity_decode('&#x2013;', ENT_COMPAT, 'UTF-8');
			$when = str_replace($em_dash, '-', $when);

			if ( !strpos( $when, '-' ) ) {
				
				$first = preg_split("/ @ /", $when);
				$date_start = $first[0];
				$time_start = $first[1];
				$date_end = $date_start;
				$time_end = $time_start;
			
			} else {
		
				$when = explode( ' - ', $when );
				$first = $when[0];
				$second = $when[1];
				
				if ( !strpos( $second, '@' ) ){

					if ( !strpos( $first, '@' ) ){
						$date_start = $first;
						$date_end = $second;			
					
					} else {
						$first = preg_split('/ @ /i', $first);
						$date_start = $first[0];
						$time_start = $first[1];
						$date_end = $date_start;
						$time_end = $second;
					}
				} else {

					$first = preg_split('/ @ /i', $first);
					$second = preg_split('/ @ /i', $second);
					$date_start = $first[0];
					$time_start = $first[1];
					$date_end = $second[0];
					$time_end = $second[1];
					
				}
			
			}

		
		$when_start = date('Y-m-d H:i:s', strtotime($date_start . ' ' . $time_start));
		$when_end = date('Y-m-d H:i:s', strtotime($date_end . ' ' . $time_end));
		
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
		
		if ( strpos( $where, '<br' ) ) {
		
			$venue = preg_split('/<br[^>]*>/i', $where);
			if ( !empty($venue[0] ) ) { $venue_title = $venue[0]; }
			if ( !empty($venue[1] ) ) { $venue_address = $venue[1]; }
			if ( !empty($venue[2] ) ) { $venue_city = $venue[2]; }
			
			//if ( strpos( $venue_city, '/[\s,]+/' ) ) {
			if ( $venue_city ) {
				$venue_city_state = preg_split('/[\s,]+/i', $venue_city);
				array_shift($venue_city_state);
				//print_r($venue_city_state);
				//echo $venue_city_state[1] ;
				if ( !empty($venue_city_state[0] ) ) { 
					$venue_city = $venue_city_state[0]; 
				}
				if ( !empty($venue_city_state[1] ) ) { 
					$venue_state = $venue_city_state[1]; 
				}
				if ( !empty($venue_city_state[2] ) ) { 
					$venue_zip = $venue_city_state[2]; 
				}
			}
		}

		// COST
		if ( strpos( $main_content, '<div class="ai1ec-cost">' ) ) {
			$start = strpos( $main_content, '<div class="ai1ec-cost">' ); 
			$end = strpos( $main_content, '<div class="ai1ec-contact">' ); 
			$section = $end - $start;
			$cost = substr($main_content, $start, $section);
			$start = strpos( $cost, '<div class="ai1ec-field-value">' ); 
			$end = strpos( $cost, '</div>', $start );  
			$section = $end - $start;
			$cost = substr($cost, $start, $section);
			$cost = str_replace( '<div class="ai1ec-field-value">', '', $cost );
		}		
			
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
			$cat_section = explode( '<div class="ai1ec-categories">', $main_content );
			$cat_section = $cat_section[1];					
			
			$start = strpos( $cat_section, '<div class="ai1ec-field-value">' ); 
			$end = strpos( $cat_section, '</div>', $start );  
			$section = $end - $start;
			$cat_section = substr($cat_section, $start, $section);	
			$cat_section .= "</div>";
			$cats_array = explode('<a', $cat_section);

			array_shift($cats_array);
	
			$cats = array();
			foreach ( $cats_array as $cat ){
				$cat = '<a class' . $cat;
				$cats[] = strip_tags($cat);
			}			
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
		

		$cats_string = '';
		if ( $cats ) {
			foreach ( $cats as $cat ) {
				$cats_string .= $cat . ', ';
			}
			$cats_string = rtrim( $cats_string, ',');
		}
		
		$slug = $Url;
		$slug_replace = home_url() . '/event/';
		$slug = str_replace('http://visit-prescott.com/wordpress/ai1ec_event/', '', $slug);
		$output = 
			'<strong>' . $title . '</strong><br />' . 
			'Url: ' . $slug . '<br />' . 
			//$date . "|" . 
			//$time . "<br />" . 
			'Start Date: ' . $when_start . "<br />" . 
			'End Date: ' . $when_end . "<br />" . 
			//'Multi-day: ' . $multi_day . "<br />" . 
			//$where . "|" . 
			'Venue: ' . $venue_title . "|" . 
			$venue_address . "|" . 
			$venue_city . "|" . 
			$venue_state . "|" . 
			$venue_zip . "<br />" . 
			'Cost: ' . $cost . "<br />" . 
			'Organizer: ' . $name  . "|" . 
			$phone  . "|" . 
			$email  . "|" . 
			$web  . "<br />" . 
			'Categories: ' . $cats_string  . "<br />" . 
			'Image: ' . $image  . "<br />";
			//$content
		;
		

		
		$output = str_replace(array("\r","\n"),"",$output);
		echo  $output . "\r\n";
		//echo '<hr />';

		$new_post = array(
			'title' => $title, 
			'slug' => $slug,
			'date' => $date,
			'time' => $time,
			'when_start' => $when_start,
			'when_end' => $when_end,
			'multi_day' => $multi_day,
			'where' => $where,
			'venue_title' => $venue_title,
			'venue_address' => $venue_address,
			'venue_city' => $venue_city,
			'venue_state' => $venue_state,
			'venue_zip' => $venue_zip,
			'cost' => $cost,
			'name' => $name,
			'phone' => $phone,
			'email' => $email,
			'web' => $web,
			'cats' => $cats,
			'image' => $image,
			'content' => $content			
		);
		add_event_posts( $new_post );
		
    curl_close ($ch); 
}

function add_event_posts( $new_post ) {

echo 'adding post+start<br />';

	// Setup variables

	$title = $new_post['title'];
	$slug = $new_post['slug'];
	$date = $new_post['date'];
	$time = $new_post['time'];
	$when_start = $new_post['when_start'];
	$when_end = $new_post['when_end'];
	$multi_day = $new_post['multi_day'];
	$where = $new_post['where'];
	$venue_title = $new_post['venue_title'];
	$venue_address = $new_post['venue_address'];
	$venue_city = $new_post['venue_city'];
	$venue_state = $new_post['venue_state'];
	$venue_zip = $new_post['venue_zip'];
	$cost = $new_post['cost'];
	$organizer_name = $new_post['name'];
	$phone = $new_post['phone'];
	$email = $new_post['email'];
	$web = $new_post['web'];
	$cats = $new_post['cats'];
	$image = $new_post['image'];
	$content = $new_post['content'];	
	
	//Check if post has already been added
	//echo 'title section';
	//echo $sanitized_title = sanitize_title( $title );
	//$repeat = get_page_by_title( $title, OBJECT, 'tribe_events' );
	
	//echo 'get page title';
	//print_r($repeat);

$page_path = $slug;
$repeat = get_page_by_path( basename( untrailingslashit( $page_path ) ) , OBJECT, 'tribe_events');
	
	/*
	$repeat_date = '';
	if ( $repeat ) {
		echo 'general repeat';
		$post_url = get_post( $repeat->ID );
		$post_url = $post_url->post_name;
		echo 'repeat date: ' . $repeat_date = get_post_meta( $repeat->ID, '_EventEndDate', true );
		echo '<br />When date: ' .  $when_end;
	}
	*/
	if ( $repeat ) {
	//if ( $repeat_date == $when_end ) {
	//if ( $post_url == $slug ) {
		echo 'This is a post_array repeat<br />'; 
	} else {

	// Check if venue and organizer match
	$match = '';
	if ( $venue_title == $organizer_name ) { 
		$match = true;
	}	
	


		// Check if venue already exists
	$repeat = get_page_by_title( $venue_title, OBJECT, 'tribe_venue' );
	if ( $repeat ) { 
		echo 'This is a venue repeat<br />';
		$venue_id = $repeat->ID;
	} else {
	
		// Create post object
		$args = array(
			'post_title'    => $venue_title,
			'post_content'  => '',
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_type'			=> 'tribe_venue'
		);

		// Insert the post into the database
		$venue_id = wp_insert_post( $args );
		
		add_post_meta( $venue_id, '_VenueAddress', $venue_address, true );
		add_post_meta( $venue_id, '_VenueCity', $venue_city, true );
		add_post_meta( $venue_id, '_VenueState', $venue_state, true );
		add_post_meta( $venue_id, '_VenueZip', $venue_zip, true );
		add_post_meta( $venue_id, '_VenueCountry', 'United States', true );
		add_post_meta( $venue_id, '_VenueShowMap', 1, true );
		add_post_meta( $venue_id, '_VenueOrigin', 'events-calendar', true );		
		
		if ( $match ) {
			add_post_meta( $venue_id, '_VenueURL', $web, true );		
			add_post_meta( $venue_id, '_VenuePhone', $phone, true );		
			add_post_meta( $venue_id, '_VenueEmail', $email, true );					
		}
	
	}
	
	// Check if organizer already exists
	if (!$match) {
		$repeat = get_page_by_title( $organizer_name, OBJECT, 'tribe_organizer' );
		if ( $repeat ) { 
			echo 'This is a organizer repeat<br />';
			$organizer_id = $repeat->ID;
		} else {
		
			// Create post object
			$args = array(
				'post_title'    => $organizer_name,
				'post_content'  => '',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'			=> 'tribe_organizer'
			);

			// Insert the post into the database
			$organizer_id = wp_insert_post( $args );
			
			add_post_meta( $organizer_id, '_OrganizerEmail', $email, true );
			add_post_meta( $organizer_id, '_OrganizerPhone', $phone, true );
			//add_post_meta( $organizer_id, '_OrganizerOrganizer', $name, true );
			//add_post_meta( $organizer_id, '_OrganizerWebsite', $web, true );
			add_post_meta( $organizer_id, '_OrganizerOrigin', 'events-calendar', true );				
		
		}	
	}
	
	// Create post object
	$args = array(
		'post_title'    => $title,
		'post_name'    => $slug,
		'post_content'  => $content,
		'post_status'   => 'publish',
		'post_author'   => 1,
		//'post_category' => array(8,39),
		'post_type'			=> 'tribe_events'
	);

echo 'adding post<br />';

	// Insert the post into the database
	$post_id = wp_insert_post( $args );
	
	add_post_meta( $post_id, '_EventStartDate', $when_start, true );
	add_post_meta( $post_id, '_EventEndDate', $when_end, true );
	add_post_meta( $post_id, '_EventShowMap', 1, true );
	//add_post_meta( $post_id, '_EventShowMapLink', 1, true );
	add_post_meta( $post_id, '_EventURL', $web, true );
	add_post_meta( $post_id, '_EventCost', $cost, true );
	add_post_meta( $post_id, '_EventVenueID', $venue_id, true );
	if ( !$match ) {
		add_post_meta( $post_id, '_EventOrganizerID', $organizer_id, true );
	}
	
	// Get categories
	
echo 'adding cats<br />';
print_r($cats);
	
	if ($cats ) {
	$term_id_array = array();
	foreach ( $cats as $cat ) {
		$term_id = term_exists( $cat, 'tribe_events_cat' );
		if ( $term_id ) {
			$term_id = $term_id['term_id'];
			$term_id_array[] = (int)$term_id; 
		} else {
			$term_id = wp_insert_term(
				$cat, // the term 
				'tribe_events_cat' // the taxonomy
			);	
			//echo "<hr />" . $term_id. '<br />';
				//print_r($term_id);	
				//echo '<br />';				
			$term_id_array[] = $term_id['term_id'];
		}	
	}
		wp_set_object_terms( $post_id, $term_id_array, 'tribe_events_cat' );
	}

	
	//get photo
	$getImageFile = 'http://visit-prescott.com/wordpress/' . $image;
	echo 'IMAGE SECTION --------------------->';
	echo 'Image: ' . $image . '<br />';
	echo 'IMage SLug: ' . $image_slug = str_replace('wp-content/uploads/', '', $image);
	echo '<br />Image Slug Final: ' . $image_slug = str_replace('.jpg', '.tmp', $image_slug );
	
	if ( $image ) {
		add_the_photo( $post_id, $getImageFile, $title, $image );
	}
	
	}
}

function add_the_photo( $postid, $url, $title, $image_slug ) {

echo 'adding photo<br />';

	$tmp = download_url( $url );
	if( is_wp_error( $tmp ) ){
	 //continue;
	 echo 'Photo double';
		// download failed, handle error
	}	else {
	/*	
			echo 'error1<br />';
			echo $url . '<br />';
			print_r($tmp);
			echo 'image_slug: ' . $image_slug . '<br />';
			echo $tmp = 'C:\Windows\TEMP/' . $image_slug; 
			echo 'image_slug: ' . $image_slug . '<br />';
	*/
			//print_r($tmp);	
		$post_id = $postid;
		$desc = $title . "Event";
		$file_array = array();

		// Set variables for storage
		// fix file filename for query strings
		preg_match('/[^\?]+\.(jpg|jpe|jpeg|gif|png)/i', $url, $matches);
		$file_array['name'] = basename($matches[0]);
		$file_array['tmp_name'] = $tmp;

		// If error storing temporarily, unlink
		if ( is_wp_error( $tmp ) ) {
			echo 'error2<br />';
			@unlink($file_array['tmp_name']);
			$file_array['tmp_name'] = '';
		}

		// do the validation and storage stuff
		$id = media_handle_sideload( $file_array, $post_id, $desc );

		// If error storing permanently, unlink
		if ( is_wp_error($id) ) {
			echo 'error3<br />';
			@unlink($file_array['tmp_name']);
			//return $id;
		}
		echo 'image src: ' . $src = wp_get_attachment_url( $id );
		set_post_thumbnail( $post_id, $id );
	}
	echo '<hr />';	
}
?>