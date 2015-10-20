<?php
// Changes the text labels for Google Calendar and iCal buttons on a single event page
// https://theeventscalendar.com/knowledgebase/change-the-text-for-ical-and-google-calendar-export-buttons/
remove_action('tribe_events_single_event_after_the_content', array('Tribe__Events__iCal', 'single_event_links'));
add_action('tribe_events_single_event_after_the_content', 'customized_tribe_single_event_links');
 
function customized_tribe_single_event_links()    {
    if (is_single() && post_password_required()) {
        return;
    }
 
    echo '<div class="tribe-events-cal-links">';
    echo '<a class="tribe-events-ical tribe-events-button button" href="' . tribe_get_single_ical_link() . '">+ Add to Calendar </a>';
    echo '<a class="tribe-events-gcal tribe-events-button button" href="' . tribe_get_gcal_link() . '" title="' . __( 'Add to Google', 'tribe-events-calendar-pro' ) . '"><i class="fa fa-google-plus"></i> Add to Google </a>';
    echo '</div><!-- .tribe-events-cal-links -->';
}

function add_date_to_events_calendar($html){
$html = '';
global $post, $wp_query;
$event_year = tribe_get_start_date( $post, false, 'Y' );
$event_month = tribe_get_start_date( $post, false, 'm' );
$event_day = tribe_get_start_date( $post, false, 'j' );

if ($wp_query->current_post > 0) {
$prev_post = $wp_query->posts[$wp_query->current_post - 1];
$prev_event_year = tribe_get_start_date( $prev_post, false, 'Y' );
$prev_event_month = tribe_get_start_date( $prev_post, false, 'm' );
$prev_event_day = tribe_get_start_date( $prev_post, false, 'j' );
}
/*
* If the event month changed since the last event in the loop,
* or is the same month but the year changed.
*
*/
if ( $wp_query->current_post === 0 || ( $prev_event_month != $event_month || ( $prev_event_month == $event_month && $prev_event_year != $event_year ) ) ) {
$html .= sprintf( "<div class='tribe-events-list-separator-month'><span>%s</span></div>", tribe_get_start_date( $post, false, 'F Y' ) );
}
/*
* If this event year is different to the year of the previous event in the loop,
* and it’s not it’s not the first event in the loop (we don’t want to start the loop with a year separator)
*/
if ( $wp_query->current_post > 0 && $prev_event_year != $event_year ) {
$html .= sprintf( "<span class='tribe-events-list-separator-year'>%s</span>", $event_year );
}
/*
* If the event day changed since the last event in the loop,
* or is the same day but the month changed.
*
*/
if ( $wp_query->current_post === 0 || ( $prev_event_day != $event_day || ( $prev_event_day == $event_day && $prev_event_month != $event_month ) ) ) {
$html .= sprintf( "<div class='tribe-events-list-separator-month'><span>%s</span></div>", tribe_get_start_date( $post, false, 'F j (l)' ) );
}
return $html;
}
add_filter( 'tribe_events_list_the_date_headers', 'add_date_to_events_calendar' );


//***************************
// 
function get_tourism_terms() {
    $terms = wp_get_post_terms( get_the_id(), 'tribe_events_cat' );
    $cat_slug = '';
    if ( $terms ) {
        $get_parent = $terms[0]->parent;
        if ($get_parent == 0 ) {
            $cat_slug = $terms[0]->slug;
        } else {
            $parent_cat = get_term_by('id', $terms[0]->parent, 'tribe_events_cat' );
            $cat_slug = $parent_cat->slug;
        }

    }
    return $cat_slug;
}

//**************************************
// Scrape City of Prescott Events

add_action('init', 'get_cop_events_schedule');
add_action('get_cop_events_hourly', 'get_cop_events');

function get_cop_events() {

	include 'scrape-events/curl_new_events.php';

//Check thru the ones that were previosly not displayed
	$not_displayed_posts = get_option( 'posts_not_displayed' );
		if ( !empty($not_displayed_posts) ) {
		
		//$not_displayed_posts = '';
		//print_r($not_displayed_posts);
		$posts_not_displayed = '';
		
		foreach($not_displayed_posts as $not_displayed_post ) {
			$post_id = $not_displayed_post;
			//echo '<br />ID: ' . $post_id;
			$url = 'http://www.prescott-az.gov/events/index.php?id=' . $post_id;
			$status = curl_download($url, $post_id);	
			//print_r($status);
			if ( $status[1] == true ) {
				//echo $status[0] . ' was posted';
			}
			if ( $status[1] == false && !empty($status[0]) ) {
				//echo $status[0] . ' was NOT posted';
				$posts_not_displayed[] = $status[0];
				//print_r($posts_not_displayed);
			}	
		}
	}
	if ( empty($posts_not_displayed) ) {
		$posts_not_displayed = array();
	}
	
	
	$post_id = get_option( 'latest_event_id' );
	$post_id = $post_id + 1;
	$post_end = $post_id + 20;

	
	while ( $post_id < $post_end  ) {
		if ( in_array( $post_id, $posts_not_displayed )) { $post_id++;  continue; }
		//echo '<br />ID: ' . $post_id;
		$url = 'http://www.prescott-az.gov/events/index.php?id=' . $post_id;
		$status = curl_download($url, $post_id);	
		//print_r($status);
		if ( $status[1] == true ) {
			//echo $status[0] . ' was posted';
		}
		if ( $status[1] == false && !empty($status[0]) ) {
			//echo $status[0] . ' was NOT posted';
			$posts_not_displayed[] = $status[0];
			//print_r($posts_not_displayed);
		}
		$post_id++;
	} 
	//print_r($posts_not_displayed);
	update_option( 'posts_not_displayed', $posts_not_displayed );

$file = 'people.txt';
// Open the file to get existing content
$current = '';
// Append a new person to the file
$current .= $post_id;
// Write the contents back to the file
file_put_contents($file, $current);	
    
    $file = 'display.txt';
// Write the contents back to the file
file_put_contents($file, $test_output);	
	
}

// Add custom cron interval
add_filter( 'cron_schedules', 'add_custom_cron_intervals', 10, 1 );

function add_custom_cron_intervals( $schedules ) {
	// $schedules stores all recurrence schedules within WordPress
	$schedules['minutes'] = array(
		'interval'	=> 60,	// Number of seconds, 600 in 10 minutes
		'display'	=> 'Once Every 10 Minutes'
	);

	// Return our newly added schedule to be merged into the others
	return (array)$schedules; 
}

function get_cop_events_schedule() {
	if ( !wp_next_scheduled( 'get_cop_events_minutese' ) ) {
		wp_schedule_event(time(), 'hourly', 'get_cop_events_hourly');
	}
}
?>