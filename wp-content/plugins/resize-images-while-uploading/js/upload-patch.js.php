<?php
Header('Content-type: text/javascript');
$resize_options = Array_Merge(Array(
  'width' => False,
  'height' => False,
  'quality' => False
), $_GET);
?>
var uploader, wp;
jQuery(document).ready(function($){

  if (window.setResize) setResize(false);

  var max_file_size = 2 * 1024 * 1024 * 1024;

  if (typeof uploader != 'undefined'){
    uploader.settings.resize = <?php Echo JSON_Encode($resize_options) ?>;
    uploader.settings.max_file_size = max_file_size;
  }

  if(typeof wp != 'undefined' && typeof wp.Uploader != 'undefined') {
    wp.Uploader.defaults.resize = <?php Echo JSON_Encode($resize_options) ?>;
    wp.Uploader.defaults.max_file_size = max_file_size;
  }

});