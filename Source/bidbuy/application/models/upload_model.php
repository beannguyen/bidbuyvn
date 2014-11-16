<?php

class Upload_Model extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->connect();
    }

    function saveAttachedFile($file, $post_id)
    {
        $sql = "INSERT INTO ".DB_PRE."postmeta (post_id, meta_key, meta_value) VALUES (".$post_id.", 'attached_file', '".$file."')";
        $this->db->query($sql);
    }

    function addImageToGalleryList( $fileSrc )
    {
    }
}