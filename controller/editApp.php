	<?php session_start();
    require_once "../modal/app.php";
    $app = new APP();
 if (!empty($_POST['tokenAdmin'])) {
    if (!hash_equals($_SESSION['userToken'], $_POST['tokenAdmin'])) {
        return false;
    } 
}else{
	echo 'Something wrong! Please try again';
	return false;
}
	function get_file_extension( $file )  {
		if( empty( $file ) )
			return;

		// if goes here then good so all clear and good to go
		$ext = end(explode( ".", $file ));

		// return file extension
		return $ext;
	}

	if(isset($_POST))
	{
		if($_POST['os'] === "Null"){
			echo 'Please select OS';
			return false;
		}
		// get uploaded file name
		$image = $_FILES["edit_file"]["name"];

		if( empty( $image ) ) {
			$status = isset($_POST['status']) ? "0" : "1";
			$checkboxHot = isset($_POST['edit_checkboxHot']) ? "ON" : "OFF";
			$end_tracking = "y";
			$app->editApp($_POST['id'],$_POST['name'],$_POST['os'],$_POST['size'],$_POST['version'],$status,$_POST['link_offer'],$_POST['edit_imgs'],$_POST['content_edit'],$_POST['producer'],$_POST['date_update'],$_POST['view'],$checkboxHot,$end_tracking);
			echo'successfully';
			return false;
		} else if($_FILES["edit_file"]["type"] == "application/msword") {
			echo 'Invalid image type, use (e.g. png, jpg, gif).';
		} else if( $_FILES["edit_file"]["error"] > 0 ) {
			echo 'Oops sorry, seems there is an error uploading your image, please try again later.';
		} else {

			// strip file slashes in uploaded file, although it will not happen but just in case 😉
			$filename = stripslashes( $_FILES['edit_file']['name'] );
			$ext = get_file_extension( $filename );
			$ext = strtolower( $ext );

			if(( $ext != "jpg" ) && ( $ext != "jpeg" ) && ( $ext != "png" ) && ( $ext != "gif" ) ) {
				echo 'Unknown Image extension.';
				return false;
			} else {
				// get uploaded file size
				$size = filesize( $_FILES['edit_file']['tmp_name'] );

				// get php ini settings for max uploaded file size
				$max_upload = ini_get( 'upload_max_filesize' );

				// check if we're able to upload lessthan the max size
				//if( $size > $max_upload )
				//	echo 'You have exceeded the upload file size.';

				// check uploaded file extension if it is jpg or jpeg, otherwise png and if not then it goes to gif image conversion
				$uploaded_file = $_FILES['edit_file']['tmp_name'];
				if( $ext == "jpg" || $ext == "jpeg" )
					$source = imagecreatefromjpeg( $uploaded_file );
				else if( $ext == "png" )
					$source = imagecreatefrompng( $uploaded_file );
				else
					$source = imagecreatefromgif( $uploaded_file );

				// getimagesize() function simply get the size of an image
				list( $width, $height) = getimagesize( $uploaded_file );
				$ratio = $height / $width;

				// new width 50(this is in pixel format)
				$nw = 300;
				$nh = ceil( $ratio * $nw );
				$dst = imagecreatetruecolor( $nw, $nh );

				/* new width 100 in pixel format too
				$nw1 = 100;
				$nh1 = ceil( $ratio * $nw1 );
				$dst1 = imagecreatetruecolor( $nw1, $nh1 );*/

				imagecopyresampled( $dst, $source, 0, 0, 0,0, $nw, $nh, $width, $height );
				//imagecopyresampled( $dst1, $source, 0, 0, 0, 0, $nw1, $nh1, $width, $height );

				// rename our upload image file name, this to avoid conflict in previous upload images
				// to easily get our uploaded images name we added image size to the suffix
				$rnd_name = 'photos_'.uniqid(mt_rand(10, 15)).'_'.time().'_300x300.'.$ext;
				//$rnd_name1 = 'photos_'.uniqid(mt_rand(10, 15)).'_'.time().'_100x100.'.$ext;

				// move it to uploads dir with full quality
				imagejpeg( $dst, '../uploads/'.$rnd_name, 100 );
				//imagejpeg( $dst1, '../uploads/'.$rnd_name1, 100 );

				// I think that's it we're good to clear our created images
				imagedestroy( $source );
				imagedestroy( $dst );
				//imagedestroy( $dst1 );

				
				/*check if it uploaded successfully, if so then display success message otherwise the erroror message in the else statement
				if( $is_uploaded )
					$success = 'Post shared successfully.';
				else
					$error = 'erroror uploading file.';*/
				//
					$status = isset($_POST['status']) ? "0" : "1";
					$checkboxHot = isset($_POST['edit_checkboxHot']) ? "ON" : "OFF";
					$end_tracking = "y";
					
					$app->editApp($_POST['id'],$_POST['name'],$_POST['os'],$_POST['size'],$_POST['version'],$status,$_POST['link_offer'],$rnd_name,$_POST['content_edit'],$_POST['producer'],$_POST['date_update'],$_POST['view'],$checkboxHot,$end_tracking);
					echo 'successfully';
					return false;
			}

		}
	}
