<?php
/**
 * Photo View Single Event
 * This file contains one event in the photo view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/pro/photo/single_event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

<?php

global $post;
$cat_slug = get_tourism_terms();
?>

<div class="tribe-events-photo-event-wrap">

	

	<div class="tribe-events-event-details tribe-clearfix">
        
        <?php 
            //tribe_get_start_date ( int $event = null, bool $displayTime = true, string $dateFormat = ’’, string $timezone = null ); 
            echo '<div class="calendar-icon ' . $cat_slug . '">';
            echo '<span class="month ' . $cat_slug . '">' . tribe_get_start_date (null, false, 'M', null) . '<span>'; 
            echo '<span class="date ' . $cat_slug . '">' .tribe_get_start_date (null, false, 'd', null) . '<span>'; 
            echo '</div>';
        ?>
        
		<!-- Event Title -->
		<?php do_action( 'tribe_events_before_the_event_title' ); ?>
		<h2 class="tribe-events-list-event-title entry-title summary">
			<a class="url <?php echo $cat_slug; ?>" href="<?php echo esc_url( tribe_get_event_link() ); ?>" title="<?php the_title() ?>" rel="bookmark">
				<?php the_title(); ?>
			</a>
		</h2>
		
		<?php do_action( 'tribe_events_after_the_event_title' ); ?>

		<!-- Event Meta -->
		<?php do_action( 'tribe_events_before_the_meta' ); ?>
		<div class="tribe-events-event-meta">
			<div class="updated published time-details">
				<?php if ( ! empty( $post->distance ) ) : ?>
					<strong>[<?php echo tribe_get_distance_with_unit( $post->distance ); ?>]</strong>
				<?php endif; ?>
				<?php echo tribe_events_event_schedule_details(); ?>
			</div>
		</div><!-- .tribe-events-event-meta -->
		<?php do_action( 'tribe_events_after_the_meta' ); ?>
        
        <?php echo tribe_event_featured_image( null, 'photo-thumb' ); ?>
        
		<!-- Event Content -->
		<?php do_action( 'tribe_events_before_the_content' ); ?>
		<div class="tribe-events-list-photo-description tribe-events-content entry-summary description">
			<?php echo tribe_events_get_the_excerpt() ?>
		</div>
		<?php do_action( 'tribe_events_after_the_content' ) ?>
        
	</div><!-- /.tribe-events-event-details -->

</div><!-- /.tribe-events-photo-event-wrap -->

<div class="tribe-events-event-categories-wrap">
		<?php
		$cats =  tribe_get_event_categories(
			get_the_id(), array(
				'before'       => '',
				'sep'          => '',
				'after'        => '',
				'label'        => '', // An appropriate plural/singular label will be provided
				'label_before' => '<dt>',
				'label_after'  => '</dt>',
				'wrap_before'  => '<dd class="tribe-events-event-categories">',
				'wrap_after'   => '</dd>',
			)
		);
		echo str_replace(':', '', $cats);
		?>   
</div>
