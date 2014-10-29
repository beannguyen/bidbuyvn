<?php

class uploadController extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->loadModel('upload');
    }

    function addGallery()
    {
        // process to upload file
        $imageSrc = $this->process( 'gallery' );
        if ( $imageSrc == false ) {

            return false;
        } else {

            // create image 100x100 to response text
            $image100 = parent::getFileNameWithImageSize( $imageSrc, 100, 100 );
            // response
            $img = array(
                'url' => $imageSrc,
                'src' => $image100
            );

            echo json_encode( $img );
        }
    }

    function process( $flag = false )
    {
        $generic = new Generic();
        $ds = DIRECTORY_SEPARATOR;

        // create folder to store file
        $today = getdate();
        $storeFolder = 'public/uploads/';
        $storeFolder .= $today["year"] . '/' . $today['mon'] . '/' . $today['mday'] . '/';
        $generic->rmkdir($storeFolder);

        if (!empty($_FILES)) {

            $tempFile = $_FILES['file']['tmp_name']; //3
            $targetPath = URL::getPath() . $ds . $storeFolder . $ds; //4
            $targetFile = $targetPath . '/' . $_FILES['file']['name']; //5
            $allowext = array("jpg", "jpeg", "png");

            //get image extension
            $file = strtolower($_FILES['file']['name']);
            $f = pathinfo($file);
            $fname = $f['filename'];
            $exts = $f['extension'];
            // make sure file is allow to upload
            if ( !in_array( $exts, $allowext ) )
            {
                echo 'error';
                return false;
            }
            // make sure file is existed
            $src = '';
            $filename = '';
            if (file_exists($targetFile)) {

                $files_array = $generic->scanDirectories($targetPath, $allowext);

                foreach ( $files_array as $k => $v ) {

                    if ($targetFile === $v) {
                        rename:
                        // create unique file name using time()
                        $file = $fname.'-'.time();
                        $filename = $file.'.'.$exts;
                        $targetFile = $targetPath . '/' . $filename;
                        // check unique filename again
                        if(file_exists($targetFile))
                            goto rename; // create again
                        else
                        {
                            // load image url
                            $src = URL::get_site_url().'/'.$storeFolder.$filename;
                        }
                        break;
                    }
                }
            } else
                $src = URL::get_site_url().'/'.$storeFolder.$_FILES['file']['name'];
            if ( $flag != 'gallery' )
                echo $src;
            // if files are stored
            if(move_uploaded_file($tempFile, $targetFile))
            {
                // save to database
                //$this->model->saveAttachedFile($storeFolder.$_FILES['file']['name'], $_POST['post-id']);
                //phpthumb resizing - get the php class and start it up
                require_once(URL::getPath().'/library/phpthumb/phpthumb.class.php');
                $phpThumb = new phpThumb();
                //set the output format. We will save the images as jpg.
                $output_format = 'jpeg';
                // set height for image sizes
                $thumbnail_heights = array(100, 112, 82, 60, 158, 100, 219, 53);
                $thumbnail_widths = array(100, 153, 82, 60, 222, 132, 247, 70);
                //loop through the heights array above and create the different size image
                $count = 0;
                foreach ($thumbnail_heights as $thumbnail_height) {

                    //get image extension
                    if ( $filename !== '' ) {

                        $file = strtolower($filename);
                        $f = pathinfo($file);
                        $fname = $f['filename'];
                        $exts = $f['extension'];
                    }
                    // resize image
                    $phpThumb->resetObject();
                    $phpThumb->setSourceFilename($targetFile);
                    $phpThumb->setParameter('h', $thumbnail_height);
                    $phpThumb->setParameter('w', $thumbnail_widths[$count]);
                    $phpThumb->setParameter('config_output_format', $output_format);

                    //pass for xsmall, square pics
                    //q (quality) is set to 92
                    $phpThumb->setParameter('q', 92);
                    //zc (zoom-crop) is on (off by default), so the smaller of the width/height will be used to make a square cropped thumbnail.
                    $phpThumb->setParameter('zc', 1);
                    //set image thumbnail destination
                    $thumb_name = $fname . '-' . $thumbnail_widths[$count].'x'.$thumbnail_height . '.' . $exts;
                    $store_filename = $targetPath . '/' . $thumb_name;

                    if ($phpThumb->GenerateThumbnail()) {
                        if ($phpThumb->RenderToFile($store_filename)) {
                            //image uploaded - you will probably need to put image info into a database at this point
                            $message="Image uploaded successfully.";
                        } else {
                            //unable to write file to final destination directory - check folder permissions
                            $message= "Error! Please try again (render).";
                        }
                    } else {
                        //unable to generate the image
                        $message= "Error! Please try again (generate).";
                    }
                    $count++;
                }
            }

            return $src;
        }
    }
}