<?php
function curl_download($Url, $post_id){
	
    if (!function_exists('curl_init')){
        die('cURL is not installed. Install and try again.');
    }
  
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
		//curl_setopt($ch, CURLOPT_POST, TRUE);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, array("searchId" => $sID));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$type = '';
		$display = '';
		$title = '';
		$dates = '';
		$date_start = '';
		$time_start = '';
		$date_end = '';
		$time_end = '';		
		$location = '';
		$location_name = '';
		$address = '';
		$city = '';
		$state = '';
		$zip = '';
		$description = '';
		$meta = '';	
		$name = '';
		$phone = '';
		$email = '';
		$web = '';
			
    // perform post 
		$result = curl_exec($ch); 
		$start = strpos( $result, "<div class='event display" ); 
		
		if ( $start ) {
		
		$end = strpos( $result, '<!-- /#main -->' ); 
		$section = $end - $start;
		$main_content = substr($result, $start, $section);
	
    // get type
		$start = strpos( $main_content, "<p class='type_" ); 
		$end = strpos( $main_content, " '></p>", $start ); 
		$section = $end - $start;
		$type = substr($main_content, $start, $section);
		$type = str_replace("'>", "", $type);	
		$type = str_replace("<p class='type_", "", $type);		
		
		if ( $type != 'city_meetings' ) {
		if ( $type != 'library' ) {
		

		$start = strpos( $main_content, "<div class='event display_" ); 
		$end = strpos( $main_content, "'>", $start ); 
		$section = $end - $start;
		$display = substr($main_content, $start, $section);
		$display = str_replace("<div class='event display_", "", $display);
		$display = str_replace("'>", "", $display);
		
		
// Open the file to get existing content
//$test_output = $post_id . ' - ' . $display . '<br />';


			if ( $display == 'y' ) { 
    // perform title 
		$start = strpos( $main_content, "<h3>" ); 
		$end = strpos( $main_content, '</h3>', $start ); 
		$section = $end - $start;
		$title = substr($main_content, $start, $section);
		$title = str_replace('<h3>', '', $title);
		
    // perform dates
		$start = strpos( $main_content, '<p class="date_time">' ); 
		$end = strpos( $main_content, '</p>', $start ); 
		$section = $end - $start;
		$dates = substr($main_content, $start, $section);
		$dates = str_replace('<p class="date_time">', '', $dates);
		
		if ( strpos( $dates, '-' ) ) {
			$first = preg_split("/ - /", $dates);
			$date_start = $first[0];
			
			if ( preg_match ( '/( from | at )/', $first[1] ) ) {
				if ( preg_match ( '/( from )/', $first[1] ) ) {
					$first = preg_split('/ from /', $first[1]);
					$date_end = $first[0];
					
					if ( preg_match ( '/( to )/', $first[1] ) ) {
						$first = preg_split('/ to /', $first[1]);
						$time_start = $first[0];
						$time_end = $first[1];
					} else {
						$time_start = $first[1];
						$time_end = $first[1];						
					}
					
				} else {
					$first = preg_split('/ at /', $first[1]);
					$date_end = $first[0];
					$time_start = $first[1];
					$time_end = $first[1];				
				}
			} else {
				$date_end = $first[1];
			}
		} else { // did not have - 
			if ( preg_match ( '/( from | at )/', $dates ) ) {
				if ( preg_match ( '/( from )/', $dates ) ) {
					$first = preg_split('/ from /', $dates);
					$date_start = $first[0];
					$date_end = $first[0];
					
					if ( preg_match ( '/( to )/', $first[1] ) ) {
						$first = preg_split('/ to /', $first[1]);
						$time_start = $first[0];
						$time_end = $first[1];
					} else {
						$time_start = $first[1];
						$time_end = $first[1];						
					}
					
				} else {
					$first = preg_split('/ at /', $dates);
					$date_start = $first[0];
					$date_end = $first[0];
					$time_start = $first[1];
					$time_end = $first[1];				
				}
			} 	
		}

		$when_start = date('Y-m-d H:i:s', strtotime($date_start . ' ' . $time_start));
		$when_end = date('Y-m-d H:i:s', strtotime($date_end . ' ' . $time_end));
		
		// location
		$start = strpos( $main_content, '<p class=\'location\'>' ); 
		$end = strpos( $main_content, '</p>', $start ); 
		$section = $end - $start;
		$location = substr($main_content, $start, $section);
		$location = str_replace('<p class=\'location\'>', '', $location);

			// name
			$start = strpos( $location, '<span class=\'location_name\'>' ); 
			$end = strpos( $location, '</span>', $start ); 
			$section = $end - $start;
			$location_name = substr($location, $start, $section);
			$location_name = str_replace('<span class=\'location_name\'>', '', $location_name);
			
			// address
			$start = strpos( $location, '<span class=\'address\'>' ); 
			$end = strpos( $location, '</span>', $start ); 
			$section = $end - $start;
			$address = substr($location, $start, $section);
			$address = str_replace('<span class=\'address\'>', '', $address);			
			
			// city
			$start = strpos( $location, '<span class=\'city\'>' ); 
			$end = strpos( $location, '</span>', $start ); 
			$section = $end - $start;
			$city = substr($location, $start, $section);
			$city = str_replace('<span class=\'city\'>', '', $city);			

			// state
			$start = strpos( $location, '<span class=\'state\'>' ); 
			$end = strpos( $location, '</span>', $start ); 
			$section = $end - $start;
			$state = substr($location, $start, $section);
			$state = str_replace('<span class=\'state\'>', '', $state);			

			// zip
			$start = strpos( $location, '<span class=\'zip\'>' ); 
			$end = strpos( $location, '</span>', $start ); 
			$section = $end - $start;
			$zip = substr($location, $start, $section);
			$zip = str_replace('<span class=\'zip\'>', '', $zip);						
		
		// Description
		$start = strpos( $main_content, '<div class=\'desc\'>' ); 
		$end = strpos( $main_content, '</div>', $start ); 
		$section = $end - $start;
		$description = substr($main_content, $start, $section);
		$description = str_replace('<div class=\'desc\'>', '', $description);	

		// Meta
		//echo 'Main content: ' . $main_content . '<br />';
		$start = strpos( $main_content, '<div class=\'meta\'>' ); 
		$end = strpos( $main_content, '</div>', $start ); 
		$section = $end - $start;
		$meta = substr($main_content, $start, $section);
		$meta = str_replace('<div class=\'meta\'>', '', $meta);	

			// Name
			$start = strpos( $meta, '<span class=\'contact_name\'>' ); 
			$end = strpos( $meta, '</span>', $start ); 
			$section = $end - $start;
			$name = substr($meta, $start, $section);
			$name = str_replace('<span class=\'contact_name\'>', '', $name);	
			
			// Phone
			$start = strpos( $meta, '<span class=\'contact_phone\'>' ); 
			$end = strpos( $meta, '</span>', $start ); 
			$section = $end - $start;
			$phone = substr($meta, $start, $section);
			$phone = str_replace('<span class=\'contact_phone\'>', '', $phone);	

			// Email
			$start = strpos( $meta, '<span class=\'contact_email\'>' ); 
			$end = strpos( $meta, '</span>', $start ); 
			$section = $end - $start;
			$email = substr($meta, $start, $section);
			$email = str_replace('<span class=\'contact_email\'>', '', $email);	

			// Web
			$start = strpos( $meta, '<span class=\'web\'>' ); 
			$end = strpos( $meta, '</span>', $start ); 
			$section = $end - $start;
			$web = substr($meta, $start, $section);
			$web= str_replace('<span class=\'web\'>', '', $web);				
		
/*
		$output = 
		'ID: ' . $post_id . 
		'<br />title: ' . $title . 
		'<br />Dates: ' . $dates .
		'<br />Location: ' . $location . 
		'<br />Description: ' . $description . 
		'<br />Name: ' . $name . 
		'<br />Phone: ' . $phone . 
		'<br />Email: ' . $email . 
		'<br />Web: ' . $web
		;
		*/
		
		//$output = 'Dates: ' .  $dates . '<br />Date Start: ' . $date_start . '<br />Time Start: ' . $time_start . '<br />Date end: ' . $date_end . '<br />Time End: ' . $time_end . '<br />Start: ' . $when_start . '<br />End: ' . $when_end;
		
		$output = 'Location: ' .  $location . '<br />Name: ' . $location_name . '<br />Address: ' . $address . '<br />City: ' . $city . '<br />State: ' . $state . '<br />Zip: ' . $zip;
		
		echo  $output . "\r\n";
		echo '<hr />';


		$new_post = array(
			'title' => $title, 
			'dates' => $dates,
			'when_start' => $when_start,
			'when_end' => $when_end,			
			'location' => $location,	
			'description' => $description,
			'name' => $name,
			'phone' => $phone,
			'email' => $email,
			'web' => $web		
		);
		add_event_posts( $new_post );
		update_option( 'latest_event_id', $post_id );
		$posted = true;
		return $status[] = array( $post_id, $posted);
		
		} else { // for posts taht are not displayed
			$posted = false;
			return $status[] = array( $post_id, $posted);
		} // if display
		} // end if not library
		}  // end if not city meetings
		}  // end if start
    curl_close ($ch); 
		
}

function add_event_posts( $new_post ) {

echo 'adding post+start<br />';

	// Setup variables

	$title = $new_post['title'];
	$dates = $new_post['dates'];
	$location = $new_post['location'];
	$location_name = $new_post['location_name'];
	$address = $new_post['address'];
	$city = $new_post['city'];
	$state = $new_post['state'];
	$zip = $new_post['zip'];
	$description = $new_post['description'];
	$name = $new_post['name'];
	$when_start = $new_post['when_start'];
	$when_end = $new_post['when_end'];	
	$phone = $new_post['phone'];
	$email = $new_post['email'];
	$web = $new_post['web'];
	
	// Check if venue and organizer match
	
	$match = '';
	if ( $location_name == $name ) { 
		$match = true;
	}	
	


		// Check if venue already exists
	$repeat = get_page_by_title( $location_name, OBJECT, 'tribe_venue' );
	if ( $repeat ) { 
		echo 'This is a venue repeat<br />';
		$venue_id = $repeat->ID;
	} else {
	
		// Create post object
		$args = array(
			'post_title'    => $location_name,
			'post_content'  => '',
			'post_status'   => 'pending',
			'post_author'   => 1,
			'post_type'			=> 'tribe_venue'
		);

		// Insert the post into the database
		$venue_id = wp_insert_post( $args );
		
		add_post_meta( $venue_id, '_VenueAddress', $address, true );
		add_post_meta( $venue_id, '_VenueCity', $city, true );
		add_post_meta( $venue_id, '_VenueState', $state, true );
		add_post_meta( $venue_id, '_VenueZip', $zip, true );
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
		$repeat = get_page_by_title( $name, OBJECT, 'tribe_organizer' );
		if ( $repeat ) { 
			echo 'This is a organizer repeat<br />';
			$organizer_id = $repeat->ID;
		} else {
		
			// Create post object
			$args = array(
				'post_title'    => $name,
				'post_content'  => '',
				'post_status'   => 'pending',
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
		'post_content'  => $description,
		'post_status'   => 'pending',
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
	//add_post_meta( $post_id, '_EventCost', $cost, true );
	//add_post_meta( $post_id, '_EventVenueID', $venue_id, true );
	if ( $name ) {
		add_post_meta( $post_id, '_EventOrganizerID', $organizer_id, true );
	}
	
}
?>