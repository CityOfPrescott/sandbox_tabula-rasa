<?php
// Template Name: Get Events
//include 'get_events_list.php';

define('WP_USE_THEMES', false);
require('../wp-blog-header.php');

	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );


if ( isset($_POST['Submit']) ) {
	set_time_limit(0);
	echo $submitted_time = $_POST['year'] . '-' . $_POST['month'] . '-' . '01';
	echo '<br />';
	echo $timestamp = strtotime($submitted_time);
	echo '<br />';
	include 'curl_scrape_events.php';

	$stop = 1483383093; //Jan 2 2017
	while ( $timestamp < $stop ) {
		$events_list_array = curl_download_first('http://visit-prescott.com/wordpress/calendar-2/?ai1ec=time_limit:' . $timestamp, 1);
		print_r($events_list_array);
		$timestamp = $timestamp + 1210000; // 2 weeks

		foreach ( $events_list_array as $event ) {
			print curl_download($event, 1);	
		}
		echo '<strong>COMPLETED!!!!-----------------------------------------></strong>';		
	}
	
  } else { // If Not submitted ?>
	<?php
    global $network_admin, $form_action;
    $network_admin = 0;
    $form_action = 'http://localhost/sandbox/get-events/';	
	?>	
    <form name="export" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="selection_criteria" >
        <div class="popupmain" style="float:left;">
          <div class="formfield">
            <p class="row1">
              <label>&nbsp;</label>
<select name="year">
  <option value=2014>2014</option>
  <option value=2015>2015</option>
  <option value=2016>2016</option>
</select>	
<select name="month">
  <option value=01>Jan</option>
  <option value=02>Feb</option>
  <option value=03>Mar</option>
  <option value=04>Apr</option>
  <option value=05>May</option>
  <option value=06>Jun</option>
  <option value=07>Jul</option>
  <option value=08>Aug</option>
  <option value=09>Sep</option>
  <option value=10>Oct</option>
  <option value=11>Nov</option>
  <option value=12>Dec</option>	
</select>							
              <em>
                <input type="submit" class="button-primary" name="Submit" value="Scrape Tourism Calendar" />
              </em>
            </p>
          </div>
        </div>
      </div>
    </form> <?php
  } 

?>