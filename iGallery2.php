<?php
/* function:  generates thumbnail */
function make_thumb($src,$dest,$desired_width) {
	/* read the source image */
	$info = getimagesize($src);
    $mime = $info['mime'];
	$width = $info[0];
	$height = $info[1];
	/* find the "desired height" of this thumbnail, relative to the desired width  */
	$desired_height = floor($height*($desired_width/$width));
	/* create a new, "virtual" image */
	$virtual_image = imagecreatetruecolor($desired_width,$desired_height);
	/* copy source image at a resized size */
	    // APPENDED RESIZE CODE //
    switch ($mime) {
            case 'image/jpeg':
imagealphablending($virtual_image, false);
imagesavealpha($virtual_image, true);			
			
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;

            case 'image/png':	
imagealphablending($virtual_image, false);
imagesavealpha($virtual_image, true);			
			
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;

            case 'image/gif':
imagealphablending($virtual_image, false);
imagesavealpha($virtual_image, true);			
 	                $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;

            default: 
                    throw Exception('Unknown image type.');
    }
    $img = $image_create_func($src);

	imagecopyresampled($virtual_image,$img,0,0,0,0,$desired_width,$desired_height,$width,$height);
    
    $image_save_func($virtual_image, $dest);
	/* create the physical thumbnail image to its destination
	imagejpeg($virtual_image,$dest); */
}

/* function:  returns files from dir */
function get_files($images_dir,$exts = array('jpg','gif','png','jpeg')) {
	$files = array();
	if($handle = opendir($images_dir)) {
		while(false !== ($file = readdir($handle))) {
			$extension = strtolower(get_file_extension($file));
			if($extension && in_array($extension,$exts)) {
				$files[] = $file;
			}
		}
		closedir($handle);
	}
	return $files;
}

/* function:  returns a file's extension */
function get_file_extension($file_name) {
	return substr(strrchr($file_name,'.'),1);
}
?>
<!DOCTYPE html>
<head>
<script type="text/javascript" src="Foundation/js/vendor/modernizr.js"></script>
  <!-- // LOAD MODERNIZR FIRST for legacy browser interaction -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">  
<script type="text/javascript" src="jQuery/jquery-2.0.0.js"></script> 
<script type="text/javascript" src="js/ZeroClipboard.js"></script>
<link rel="icon" href="http://tac-alert01/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="Foundation/css/foundation.min.css" type="text/css">
<title>Recent Image Uploads</title>
<style>
body{
background: #f1f7f9;
color: #212121;
}

#imgg{
    text-align: center;
    vertical-align:middle;
}

#imgg p{
    display:inline-block;
    overflow:auto!important;
    background-color:white;
    padding:5px;
}

.zclip*{
min-height: 100px !important;
min-width: 100px !important;
}

</style>
</head>
<body>

  <div class="panel clearfix"> <h1> Recent Attachments: </h1>
<h4 class="subheader">Click the thumbnail to copy the image location. </h4>
  </div>
  
<ul class="large-block-grid-5" >
<?
/** settings **/
$images_dir = 'tmp/';
$thumbs_dir = 'tmp-thumbs/';
$thumbs_width = 120;
$images_per_row = 5;

/** generate photo gallery **/
$image_files = get_files($images_dir);
if(count($image_files)) {
	$index = 0;
	foreach($image_files as $index=>$file) {
		$index++;
		$thumbnail_image = $thumbs_dir.$file;
		if(!file_exists($thumbnail_image)) {
			$extension = get_file_extension($thumbnail_image);
			if($extension) {
				make_thumb($images_dir.$file,$thumbnail_image,$thumbs_width);
			}
		}
		echo '<li ><a href="#" id="rel" data-clipboard-text="',$images_dir.$file,'" filename="',$images_dir.$file,'" data-reveal-id="imgLarge" class="th" data-reveal title="',$file,'"><img  src="',$thumbnail_image,'" /></a></li>';
		// if($index % $images_per_row == 0) { echo '<hr>'; }
	}
}
else {
	echo '<p>There are no images in this gallery.</p>';
}

?>
</ul>

<div id="imgLarge" class="large reveal-modal" data-reveal>
  <div id="imgg"><p></p> </div>
  <a class="close-reveal-modal">&#215;</a>
</div>
<script type="text/javascript" src="Foundation/js/foundation.min.js"></script>
  <!-- // jQuery and Foundation frameworks apply before DOM load -->
<script type="text/javascript" src="jQuery/jquery-ui-1.10.3/ui/jquery-ui.js"></script>
  <!-- // Load Foundation vendor-specific library additions -->
<script type="text/javascript" src="js/jQuery_Plugins.js"></script>
<!-- // Compressed version of all related vendor plug-ins used in jQuery -->    

<script type="text/javascript">
 var client = new ZeroClipboard( $(".th") );
client.clip( document.getElementById('rel') );
$(document).foundation();



$(document).ready(function() {

  client.on("copy", function(event) { 
    var img = "http://tac-alert01/"+ $(this).attr('filename');		
    event.clipboardData.setData( img);
  });
    client.on("aftercopy", function() {
        var img = $(this).attr('filename');
        $('#imgg p').html('<span class="row"><u>'+ img +'</u> copied to clipboard!</span><br> <img src="'+ img + '" />').addClass('centered');
        console.log(img +'  copied.');
    });
});
</script>
</body>
</html>

