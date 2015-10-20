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

$phone = tribe_get_organizer_phone();
$email = tribe_get_organizer_email();
$o_website = tribe_get_organizer_website_link( null, '<i class="fa fa-link"></i>Event Website<i class="fa fa-external-link"></i>');
$e_website = tribe_get_event_website_link( null, '<i class="fa fa-link"></i>Event Website<i class="fa fa-external-link"></i>');
?>

<div class="tribe-events-meta-group tribe-events-meta-group-organizer">
	<h3 class="tribe-events-single-section-title"><?php echo 'CONTACT: '; ?></h3>
	<dl>
		<?php
		do_action( 'tribe_events_single_meta_organizer_section_start' );

		foreach ( $organizer_ids as $organizer ) {
			if ( ! $organizer ) {
				continue;


			?>
			<i class="fa fa-user"></i>
			<dd class="fn org">
				<?php echo strip_tags(tribe_get_organizer( $organizer ) ) ?>
			</dd>
			<?php
                
            }
		}

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

			if ( ! empty( $email ) ) {
				?>
				<dt>
					<i class="fa fa-envelope"></i>
					<?php //esc_html_e( 'Email:', 'the-events-calendar' ) ?>
				</dt>
				<dd class="email">
					<?php echo esc_html( $email ); ?>
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
/*
		<?php if ( ! empty( $phone ) ): ?>
			<dt> <?php esc_html_e( 'Phone:', 'the-events-calendar' ) ?> </dt>
			<dd class="tel"> <?php echo $phone ?> </dd>
		<?php endif ?>

		<?php if ( ! empty( $website ) ): ?>
			<dt> <?php esc_html_e( 'Website:', 'the-events-calendar' ) ?> </dt>
			<dd class="url"> <?php echo $website ?> </dd>
		<?php endif ?>
	*/	
		do_action( 'tribe_events_single_meta_organizer_section_end' );
		?>
	</dl>
</div>
