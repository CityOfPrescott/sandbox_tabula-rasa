<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

?>

<div id="tribe-events-content" class="tribe-events-single vevent hentry">

	<p class="tribe-events-back">
		<a href="<?php echo esc_url( tribe_get_events_link() ); ?>" class="button"><i class="fa fa-arrow-left"></i> <?php 
		//printf( __( '&laquo; All %s', 'the-events-calendar' ), $events_label_plural );
		printf( __( ' Back to Calendar', 'the-events-calendar' ), $events_label_plural );
		?></a>
	</p>

	<!-- Notices -->
	<?php //tribe_events_the_notices() ?>

	<?php //the_title( '<h2 class="tribe-events-single-event-title summary entry-title">', '</h2>' ); ?>

	<div class="tribe-events-schedule updated published tribe-clearfix">
		<h3>WHEN: 		</h3>
		<?php echo tribe_events_event_schedule_details( $event_id, '', '' ); ?>
	</div>

	<!-- Event meta -->
	<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
	<?php tribe_get_template_part( 'modules/meta' ); ?>
	<?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
	<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>
			

	<!-- #tribe-events-header -->

	<?php while ( have_posts() ) :  the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<!-- Event featured image, but exclude link -->
			<?php echo tribe_event_featured_image( $event_id, 'thumb', false ); ?>

			<!-- Event content -->
			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
			<div class="tribe-events-single-event-description tribe-events-content entry-content description">
				<?php the_content(); ?>
			</div>
			<!-- .tribe-events-single-event-description -->
			<?php //do_action( 'tribe_events_single_event_after_the_content' ) ?>


		</div> <!-- #post-x -->
		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
	<?php endwhile; ?>

	<!-- Event footer -->
	<div id="tribe-events-footer">
		<!-- Navigation -->
		<h3 class="tribe-events-visuallyhidden"><?php printf( __( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?></h3>
		<ul class="tribe-events-sub-nav">
			<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
			<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
		</ul>
		<!-- .tribe-events-sub-nav -->
	</div>
	<!-- #tribe-events-footer -->

</div><!-- #tribe-events-content -->
