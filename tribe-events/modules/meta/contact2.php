<?php
/**
 * Single Event Meta (Organizer) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @package TribeEventsCalendar
 */

$organizer_ids = tribe_get_organizer_ids();
$multiple = count( $organizer_ids ) > 1;

$phone = tribe_get_phone();
$o_website = tribe_get_organizer_website_link( null, '<i class="fa fa-link"></i>Event Website<i class="fa fa-external-link"></i>');
$e_website = tribe_get_event_website_link( null, '<i class="fa fa-link"></i>Event Website<i class="fa fa-external-link"></i>');
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title"><?php echo 'CONTACT: '; ?></h3>
	<dl>
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );
		?>
			<i class="fa fa-user"></i>
			<dd class="fn org">
				<?php echo tribe_get_venue(); ?>
			</dd>
			<?php

		if ( ! $multiple ) { // only show organizer details if there is one
			if ( ! empty( $phone ) ) {
				?>
				<dt>
					<i class="fa fa-phone"></i>
					<?php //esc_html_e( 'Phone:', 'the-events-calendar' ) ?>
				</dt>
				<dd class="tel">
					<?php echo esc_html( $phone ); ?>
				</dd>
				<?php
			}//end if

			// Event Website
            if ( !empty($e_website ) ) { ?>
		

                <dt> <?php //esc_html_e( 'Website:', 'the-events-calendar' ) ?> </dt>
                <dd class="tribe-events-event-url"> <?php echo $e_website; ?> </dd>     

        <?php
            } elseif( ! empty( $o_website ) ) {  ?>
                <dt> <?php //esc_html_e( 'Website:', 'the-events-calendar' ) ?> </dt>
                <dd class="tribe-events-event-url"> <?php echo $o_website; ?> </dd>    
        <?php
			}
}
		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
	</dl>
</div>