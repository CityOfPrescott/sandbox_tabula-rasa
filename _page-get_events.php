<?php
// Template Name: Get Events
//include 'get_events_list.php';
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
if ( isset($_POST['Submit']) ) {
echo 'scott';
echo $submitted_time = $_POST['year'] . '-' . $_POST['month'] . '-' . '01';
echo '<br />';
echo $timestamp = strtotime($submitted_time);
include 'curl_scrape_events.php';

$events_list_array = curl_download_first('http://visit-prescott.com/wordpress/calendar-2/?ai1ec=time_limit:' . $timestamp, 1);

print_r($events_list_array);
$i = 1;

foreach ( $events_list_array as $event ) {
//if ($i == 100) { return; }
print curl_download($event, 1);
		/*
		//$filename = sanitize_file_name(get_bloginfo('name') ) . '.' . $ext;
		$filename = 'test.txt';
		header("Content-type: application/vnd.ms-excel;");
		header("Content-Disposition: attachment; filename=" . $filename);
		//print $str;//$str variable is used in loop.php
		//exit();
		*/
$i++;
}

/*
  ini_set('memory_limit', '256M');
  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  $extensions = array('xls' => '.xls', 'xlsx' => '.xlsx');
  $args = array (
      'public'   => true
  );
  $output = 'objects';
*/



  } else { // If Not submitted ?>
	<?php
    global $network_admin, $form_action;
    $network_admin = 0;
    $form_action = 'http://localhost/sandbox/get-events/';	
	?>
kenny	
    <form name="export" action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="post">
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

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>