<?php
// Template Name: Get Events
//include 'get_events_list.php';

define('WP_USE_THEMES', false);
require('../wp-blog-header.php');

	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );


if ( isset($_POST['Submit']) ) {
	$post_id = $_POST['post_id'];
	$post_end = $post_id + 20;
	include 'curl_new_events.php';
	
	while ( $post_id < $post_end  ) {
		$url = 'http://www.prescott-az.gov/events/index.php?id=' . $post_id;
		print curl_download($url, $post_id);	
		$post_id++;
	} 
	
} else { // If Not submitted ?>
	<?php
    global $network_admin, $form_action;
    $network_admin = 0;
    //$form_action = 'http://localhost/sandbox/get-events/';	
	?>	
    <form name="export" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <div class="selection_criteria" >
        <div class="popupmain" style="float:left;">
          <div class="formfield">
            <p class="row1">
              <label>&nbsp;</label>		
							<input type="text" name="post_id">
              <em>
                <input type="submit" class="button-primary" name="Submit" value="Get New Events" />
              </em>
            </p>
          </div>
        </div>
      </div>
    </form> <?php
  } 

?>