<h1>Help</h1>

<h2>Post Requirements</h2>
<p>Every post needs to have an image atatched to the post as a featured image. If you do not have an image, save it as a draft. Do not publish it.</p>
<p>Every post needs to be finished. If it is a work in progress, save it as a draft and only publish when finished.</p>

<h2>Photo / Image Requirements</h2>
<h3>Page Banners</h3>
<p>All pages have a long banner image on the top of the page. The image selected needs to have a minimum width of 640px. Save it as the featured image and the the image will be displayed correctly.</p>

<h3>Post Featured Images</h3>
<p>Every post needs a featured image. The minimun size requirement is a width of 500 pixels. Other images that are inserted into posts but are not the featured image can be any size you wish.</p>
<p>The featured image will be displayed in your post, in the archives listing or your posts, and in the post section of the homepage. The large image in the homepage section is the reason that the photo needs to be 500 px wide.</p>
<h2>Featured Destination</h2>
<p>The featured destination can be changed at <a href="<?php echo get_bloginfo ( 'url'); ?>/wp-admin/themes.php?page=options-framework">Appearance >> Theme Options</a> under the "Featured Destination" tab.</p>
<p>Two fields need to be filled out for this section to work
<ul>
	<li>The url of the destination page you want to link to</li>
	<li>In the "Uploader Test" field
		<ul>
			<li>first click the remove button</li>
			<li>then click the upload button and choose a photo(if it a new photo, click on the upload files tab and follow the prompts)</li>
			<li>finally, click the select button.</li>
		</ul>
	</li>
</ul>
* Make sure to click the "Save Options" button.
</p>

<h2>Spotlight Section</h2>
<p>The spotlights can be changed at <a href="<?php echo get_bloginfo ( 'url'); ?>/wp-admin/themes.php?page=options-framework">Appearance >> Theme Options</a> under the "Front Page Spotlights" tab.</p>
<p>There are four spotlights that can be changed. Each spotlight requires two fields:
	<ul>
		<li>Spotlight Text</li>
		<li>Spotlight Url</li>
	</ul>
Each spotlight has a number that corrsponds to it's position on the front page from left to right.	
</p>

<h2>Construction Projects</h2>
<p>Construction Projects are displayed at <a href ="<?php echo get_bloginfo ( 'url'); ?>/construction/"><?php echo get_bloginfo ( 'url'); ?>/construction/</a></p>
<p>Construction Projects can be accessed in the admin section on the side bar under "Posts" titled "Construction Projects". This will function similiar to a regular post or page. The key differences are the Project Status module and the Connected Posts module.</p> <p>Clicking on a construction project will go to a page about that individual construction project. This page will provide more information such as related documents and related posts.</p>
<p>* NOTE: There should only be 1 project added per actual project. If you add an update about a project, that should go in the post section and then associated with the Construction project.</p>
<h3>Project Status</h3>
<p>The page displays a list of individual construction projects sorted by Upcoming, Active, or Completed.</p>
<p>You must select a status for each Construction Project (Upcoming, Active, or Completed). As the project moves through the status in reality, you should change its staus on the site. These statuses will effect where the post are displayed on the Construction Project page.</p>
<h3>Connected Posts</h3>
<p>If there are posts or updates about the Construction Project you can assotiate those posts with a specific project. To do so, click on "Create connections" in the the Connected Posts module. Find the post you are looking for and select it. Your selection can be added or removed by clicking on the plus or minus icons.</p>
<p>This can also be done in the opposite direction. A post can be associated with a specific Construction Project. To do so, click on "Create connections" in the the Connected Constuction Projects module. Find the project you are looking for and select it.</p>

<h2>Adding Documents</h2>
<p>Adding documents is different than adding images.</p>
<h3>Adding documents to the Media Library</h3>
<ul>
	<li>Click on "Media" then "Add New"</li>
	<li>Select your file and upload it</li>
	<li>Click the edit link to the right of your file</li>
	<li>Change the name to the title you want to give it</li>
	<li>In the "Documents" module on the right sidebar, check the boxes that you want to associate your doucment with
		<ul>
			<li>If none of the document categories should be associated with your document, click "+ Add New Document" to create your own.</li>
		</ul>	
	</li>		
</ul>

<h3>Adding documents to a post or page</h3>
<ul>
	<li>In the text editor, move your cursor to where you want your document or documents to appear</li>
	<li>On the first row of the text editor to the far right is an icon that looks like a document with a green plus sign. Click the icon</li>
	<li>[doc_list cat_name="ENTER CATEGORY HERE"] will appear.</li>
	<li>Replace "ENTER CATEGORY HERE" with the document category that is associated with the documents. *Leave the quotes</li>
	<li>Save your post.</li>
</ul>
