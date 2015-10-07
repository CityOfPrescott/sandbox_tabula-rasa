<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue microformats
$has_venue_address = ( ! empty( $venue_details['address'] ) ) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<div class="list-sections">
    <!-- Event Image -->
    <?php echo tribe_event_featured_image( null, 'list-thumb' ) ?>
</div>
<div class="list-sections">
    <!-- Event Title -->
    <?php do_action( 'tribe_events_before_the_event_title' ) ?>
    <h2 class="tribe-events-list-event-title entry-title summary">
        <a class="url" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title_attribute() ?>" rel="bookmark">
            <?php the_title() ?>
        </a>
    </h2>
    <?php do_action( 'tribe_events_after_the_event_title' ) ?>

    <!-- Event Meta -->
    <?php do_action( 'tribe_events_before_the_meta' ) ?>
    <div class="tribe-events-event-meta vcard">
        <div class="author <?php echo esc_attr( $has_venue_address ); ?>">

            <!-- Schedule & Recurrence Details -->
            <div class="updated published time-details">
                <?php echo tribe_events_event_schedule_details() ?>
            </div>
        </div>
        <?php
        $cats =  tribe_get_event_categories(
            get_the_id(), array(
                'before'       => '',
                'sep'          => '',
                'after'        => '',
                'label'        => '', // An appropriate plural/singular label will be provided
                'label_before' => '',
                'label_after'  => '',
                'wrap_before'  => '<div class="tribe-events-list-categories"> | <i class="fa fa-folder-open"></i>',
                'wrap_after'   => '</div>',
            )
        );
        echo str_replace(':', '', $cats);
        ?>           
    </div><!-- .tribe-events-event-meta -->
    <?php do_action( 'tribe_events_after_the_meta' ) ?>

    <!-- Event Content -->
    <?php do_action( 'tribe_events_before_the_content' ) ?>
    <div class="tribe-events-list-event-description tribe-events-content description entry-summary">
        <?php the_excerpt() ?>
        <a href="<?php echo esc_url( tribe_get_event_link() ); ?>" class="tribe-events-read-more" rel="bookmark"></a>
    </div><!-- .tribe-events-list-event-description -->
    <?php
    do_action( 'tribe_events_after_the_content' );
    ?>
</div>