<?php
/*
Plugin Name: Auto Image Resizer Lite
Description: The "Auto Image Resizer" is a state of the art WordPress Plugin which reduces your uploaded images to the maximal used image dimensions of your WordPress website.
Plugin URI: http://dennishoppe.de/wordpress-plugins/auto-image-resizer
Version: 1.0.8
Author: Dennis Hoppe
Author URI: http://DennisHoppe.de
*/

If (!Class_Exists('wp_plugin_auto_image_resizer')){
class wp_plugin_auto_image_resizer {
  var $base_url;
  var $arr_option_box;
  var $saved_options;

  function __construct(){
    // Read base
    $this->base_url = get_bloginfo('wpurl').'/'.SubStr(RealPath(DirName(__FILE__)), Strlen(ABSPATH));
    $this->base_url = Str_Replace("\\", '/', $this->base_url); // Windows workaround

    // Option boxes
    $this->arr_option_box = Array( 'main' => Array(), 'side' => Array() );

    // Add the CatchUpload Hook as early as possible
    Add_Action('widgets_init', Array($this, 'Load_TextDomain'));
    Add_Action('admin_menu', Array($this, 'Add_Options_Page'));
    Add_Action('add_attachment', Array($this, 'Catch_Upload'), 1, 1);
    Add_Action('admin_enqueue_scripts', Array($this, 'Enqueue_Backend_Scripts'));
    Add_Action('post-upload-ui', Array($this, 'Add_Plupload_Resize_Option'));

    // Set Globals link
    $GLOBALS[__CLASS__] = $this;
  }

  function Load_TextDomain(){
    $locale = Apply_Filters( 'plugin_locale', get_locale(), __CLASS__ );
    Load_TextDomain (__CLASS__, DirName(__FILE__).'/language/' . $locale . '.mo');
  }

  function t ($text, $context = ''){
    // Translates the string $text with context $context
    If ($context == '')
      return Translate ($text, __CLASS__);
    Else
      return Translate_With_GetText_Context ($text, $context, __CLASS__);
  }

  function Default_Options(){
    return Array(
      'jpeg_quality' => 90,
      'png_compression' => 9
    );
  }

  function Save_Options(){
    // Check if this is a post request
    If (Empty($_POST)) return False;

    // Clean the Post array
    $_POST = StripSlashes_Deep($_POST);
    ForEach ($_POST AS $option => $value)
      If (!$value) Unset ($_POST[$option]);

    // Save Options
    Update_Option (__CLASS__, $_POST);

    return True;
  }

  function Get_Option($key = Null, $default = False){
    // Read Options
    $options = get_option(__CLASS__);

    // Load Default Options
    If (Empty($options)) $arr_option = $this->Default_Options();
    Else $arr_option = Array_Merge ( $this->Default_Options(), $options );

    // Locate the option
    If ($key == Null)
      return $arr_option;
    ElseIf (IsSet ($arr_option[$key]))
      return $arr_option[$key];
    Else
      return $default;
  }

  function Add_Options_Page (){
    $handle = Add_Options_Page(
      $this->t('Auto Image Resizer Options'),
      $this->t('Auto Image Resizer'),
      'manage_options',
      __CLASS__,
      Array($this, 'Print_Options_Page')
    );

    // Add option boxes
    $options_page_dir = DirName(__FILE__).'/options-page';
    $this->Add_Option_Box ( $this->t('Image Size'), $options_page_dir . '/option-box-image-size.php' );
    $this->Add_Option_Box ( $this->t('Image quality'), $options_page_dir . '/option-box-image-quality.php' );
    $this->Add_Option_Box ( __('Update'), $options_page_dir . '/option-box-update.php', 'side' );

    // Add JavaScript to this handle
    Add_Action ('load-' . $handle, Array($this, 'Load_Options_Page'));
  }

  function Add_Option_Box($title, $include_file, $column = 'main', $state = 'opened'){
    // Check the input
    If (!Is_File($include_file)) return False;
    If ( $title == '' ) $title = '&nbsp;';

    // Column (can be 'side' or 'main')
    If ($column != '' && $column != Null && $column != 'main')
      $column = 'side';
    Else
      $column = 'main';

    // State (can be 'opened' or 'closed')
    If ($state != '' && $state != Null && $state != 'opened')
      $state = 'closed';
    Else
      $state = 'opened';

    // Add a new box
    $this->arr_option_box[$column][] = Array(
      'title' => $title,
      'file'  => $include_file,
      'state' => $state
    );
  }

  function Load_Options_Page(){
    // Does the user saves options?
    $this->saved_options = $this->Save_Options();

    // Include JS
    WP_Enqueue_Script('dashboard');
    WP_Enqueue_Script('options-page', $this->base_url . '/options-page/options-page.js');

    // Include CSS
    WP_Enqueue_Style('dashboard' );
    WP_Enqueue_Style('options-page', $this->base_url . '/options-page/options-page.css');

    // Remove incompatible JS Libs
    WP_Dequeue_Script('post');
  }

  function Print_Options_Page(){
    Include DirName(__FILE__) . '/options-page/options-page.php';
  }

  function Option_Page_Url($parameter = Array(), $htmlspecialchars = True){
    $url = Add_Query_Arg($parameter, Admin_URL('options-general.php?page=' . __CLASS__));
    If ($htmlspecialchars) $url = HTMLSpecialChars($url);
    return $url;
  }

  function Get_Max_Dimensions(){
		Static $max_dimensions;
		If (IsSet($max_dimensions)) return $max_dimensions;

		Global $_wp_additional_image_sizes; // We need to know the userdefined image sizes

		$arr_width = Array();
		$arr_height = Array();

		ForEach (Get_Intermediate_Image_Sizes() As $image_size){
			If (IsSet($_wp_additional_image_sizes[$image_size])){
				$arr_width[] = IntVal($_wp_additional_image_sizes[$image_size]['width']);
				$arr_height[] = IntVal($_wp_additional_image_sizes[$image_size]['height']);
			}
			Else {
				$arr_width[] = IntVal(Get_Option($image_size.'_size_w')); // A build-in image width
				$arr_height[] = IntVal(Get_Option($image_size.'_size_h')); // A build-in image height
			}
		}

		RSort($arr_width, SORT_NUMERIC);
		RSort($arr_height, SORT_NUMERIC);

		$max_dimensions = Array(
			'width' => $arr_width[0],
			'height' => $arr_height[0]
		);
		return $max_dimensions;
	}

  function Catch_Upload($attachment_id){
    // Check if it is an Image:
    If (!WP_Attachment_is_Image($attachment_id)) return;

    // Read the path:
    $file_path = Get_Attached_File($attachment_id);

    // New Size:
		$max_dimensions = $this->Get_Max_Dimensions();
    $width = $max_dimensions['width'];
    $height = $max_dimensions['height'];

    // Resize it!
    List ($current_width, $current_height) = GetImageSize($file_path);
    $width = Min($width, $current_width);
    $height = Min($height, $current_height);
    $this->Resize_Image ($file_path, $width, $height, $file_path);
  }

  function Enqueue_Backend_Scripts(){
		$max_dimensions = $this->Get_Max_Dimensions();
		$resize_options = Array(
			'width' => $max_dimensions['width'],
			'height' => $max_dimensions['height'],
			'quality' => IntVal($this->Get_Option('jpeg_quality'))
		);
    $patch_url = Add_Query_Arg($resize_options, $this->base_url . '/js/upload-patch.js.php');
    WP_Enqueue_Script('auto-image-resizer', $patch_url, Array('jquery'), Null, True);
  }

	function Add_Plupload_Resize_Option(){
		$max_dimensions = $this->Get_Max_Dimensions();
		$resize_options = Array(
			'width' => $max_dimensions['width'],
			'height' => $max_dimensions['height'],
			'quality' => IntVal($this->Get_Option('jpeg_quality'))
		);
		?>
		<p>
      <input type="checkbox" id="sepia" <?php Checked(True); Disabled(True) ?> >
      <label for="sepia" style="color:red"><?php Echo $this->t('Convert my images into grayscale.') ?></label>
      (<?php $this->Pro_Notice() ?>)
    </p>
    <?php
	}

  function Resize_Image($src, $width = 0, $height = 0, $dst) {
    if ( $height <= 0 && $width <= 0 ) return false;

    // Setting defaults and meta
    $image = Null;
    $final_width = 0;
    $final_height = 0;
    List ($width_old, $height_old, $image_type) = GetImageSize($src);

    // Calculating proportionality
    If     ($width  == 0) $factor = $height / $height_old;
    ElseIf ($height == 0) $factor = $width / $width_old;
    Else                  $factor = Min( $width / $width_old, $height / $height_old );

    // Facter limit
    $factor = Min($factor, 1);

    $final_width  = Round($width_old * $factor);
    $final_height = Round($height_old * $factor);

    // Loading image to memory according to type
    Switch ( $image_type ) {
      case IMAGETYPE_GIF:  $image = ImageCreateFromGIF($src);   Break;
      case IMAGETYPE_JPEG: $image = ImageCreateFromJPEG($src);  Break;
      case IMAGETYPE_PNG:  $image = ImageCreateFromPNG($src);   Break;
      default:             return False;
    }

    // This is the resizing/resampling/transparency-preserving magic
    $image_resized = ImageCreateTrueColor( $final_width, $final_height );
    If ( $image_type == IMAGETYPE_GIF || $image_type == IMAGETYPE_PNG ){
      $transparency = ImageColorTransparent($image);

      If ( $image_type == IMAGETYPE_GIF && $transparency >= 0 ){
        List($r, $g, $b) = Array_Values (ImageColorsForIndex($image, $transparency));
        $transparency = ImageColorAllocate($image_resized, $r, $g, $b);
        Imagefill($image_resized, 0, 0, $transparency);
        ImageColorTransparent($image_resized, $transparency);
      }
      ElseIf ($image_type == IMAGETYPE_PNG) {
        ImageAlphaBlending($image_resized, False);
        $color = ImageColorAllocateAlpha($image_resized, 0, 0, 0, 127);
        ImageFill($image_resized, 0, 0, $color);
        ImageSaveAlpha($image_resized, True);
      }
    }
    ImageCopyResampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
    ImageFilter($image_resized, 1);
    ImageDestroy($image);

    // Writing image
    Switch ( $image_type ) {
      Case IMAGETYPE_GIF:  ImageGIF($image_resized, $dst);                                        Break;
      Case IMAGETYPE_JPEG: ImageJPEG($image_resized, $dst, $this->Get_Option('jpeg_quality'));    Break;
      Case IMAGETYPE_PNG:  ImagePNG($image_resized, $dst, $this->Get_Option('png_compression'));  Break;
      default:             return False;
    }
    ImageDestroy($image_resized);
  }

  function Pro_Notice(){
    PrintF (
      $this->t('Sorry, this feature is only available in the <a href="%s" target="_blank">Pro Version of Auto Image Resizer</a>.'),
      $this->t('http://dennishoppe.de/en/wordpress-plugins/auto-image-resizer', 'Link to the authors website')
    );
  }

} /* End of the Class */
New wp_plugin_auto_image_resizer;
} /* End of the If-Class-Exists-Condition */
/* End of File */