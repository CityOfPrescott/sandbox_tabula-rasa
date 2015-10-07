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

?>