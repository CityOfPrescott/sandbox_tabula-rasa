<?php
/**
 * Single Event Meta Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta.php
 *
 * @package TribeEventsCalendar
 */

do_action( 'tribe_events_single_meta_before' );

// Check for skeleton mode (no outer wrappers per section)
$not_skeleton = ! apply_filters( 'tribe_events_single_event_the_meta_skeleton', false, get_the_ID() );

// Do we want to group venue meta separately?
$set_venue_apart = apply_filters( 'tribe_events_single_event_the_meta_group_venue', false, get_the_ID() );
?>
	
<?php if ( $not_skeleton ) : ?>
	<div class="tribe-events-single-section tribe-events-event-meta primary tribe-clearfix">
<?php endif; ?>

<?php
do_action( 'tribe_events_single_event_meta_primary_section_start' );
?>

<div class="meta-section">
<?php
tribe_get_template_part( 'modules/meta/venue' );

if ( tribe_get_cost() ) : ?>
	<div class="tribe-events-meta-group">
		<h3 class="tribe-events-single-section-title"><?php echo 'COST: '; ?></h3>
		<dl>
			<dd class="tribe-events-event-cost"> <?php echo tribe_get_cost( null, true ) ?> </dd>
		</dl>
	</div>
<?php endif; 
		
if ( tribe_has_organizer() ) {
	tribe_get_template_part( 'modules/meta/organizer' );
} else {
	tribe_get_template_part( 'modules/meta/contact2' );
}
	
tribe_get_template_part( 'modules/meta/details' );
?>
</div>
<div class="meta-section">
<?php 
	echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
	tribe_get_template_part( 'modules/meta/map' );
	echo '</div>';
?>
</div>
<?php	
/*
// If we have no map to embed and no need to keep the venue separate...
if ( ! $set_venue_apart && ! tribe_embed_google_map() ) {
	tribe_get_template_part( 'modules/meta/venue' );
} elseif ( ! $set_venue_apart && ! tribe_has_organizer() && tribe_embed_google_map() ) {
	// If we have no organizer, no need to separate the venue but we have a map to embed...
	tribe_get_template_part( 'modules/meta/venue' );
	echo '<div class="tribe-events-meta-group tribe-events-meta-group-gmap">';
	tribe_get_template_part( 'modules/meta/map' );
	echo '</div>';
} else {
	// If the venue meta has not already been displayed then it will be printed separately by default
	$set_venue_apart = true;
}
*/
do_action( 'tribe_events_single_event_meta_primary_section_end' );
?>

<?php if ( $not_skeleton ) : ?>
	</div>
<?php endif; ?>


<?php if ( $set_venue_apart ) : ?>
	<?php if ( $not_skeleton ) : ?>
		<div class="tribe-events-single-section tribe-events-event-meta secondary tribe-clearfix">
	<?php endif; ?>
	<?php
	do_action( 'tribe_events_single_event_meta_secondary_section_start' );

	tribe_get_template_part( 'modules/meta/venue' );
	tribe_get_template_part( 'modules/meta/map' );

	do_action( 'tribe_events_single_event_meta_secondary_section_end' );
	?>
	<?php
	if ( $not_skeleton ) : ?>
		</div>
	<?php endif; ?>
<?php
endif;
do_action( 'tribe_events_single_meta_after' );
