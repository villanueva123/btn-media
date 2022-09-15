<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Modules
 *
 * @since      1.0.0
 * @package    btn-post
 * @subpackage btn-post/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
class btn_media_screen {

  private $post_type;

	// Init Class
	function add_wp_hooks(){
    $this->post_type = btn_media()->post()->get_post_slug();
    add_action("save_post_{$this->post_type}", [$this, 'save_post'] );
    add_action( 'admin_enqueue_scripts', [$this, 'enqueue'] , 10, 1 );
	add_action( 'edit_form_after_title', [$this,'edit_form_after_title']);
	}



	// Hook into Post Type after Title
	function edit_form_after_title($post){
		if( $post->post_type === $this->post_type ){
			$this->show_article_metabox($post);
		}

	}

  // Show Meta Box
  function show_article_metabox($post){

    $post_id = $post->ID;
	//Key
    $vide_url_key = self::VIDEO_URL;
	$podcast_audio_key = self::PODCAST_AUDIO;
	$podcast_desc_key = self::PODCAST_DESC;
	$resources_type_key = self::RESOURCES_TYPE;
	$resources_url_key = self::RESOURCES_URL;

	//Get Meta
	$vide_url = get_post_meta( $post_id,$vide_url_key, true );
	$podcast_audio = get_post_meta( $post_id,$podcast_audio_key, true );
	$podcast_desc  = get_post_meta( $post_id,$podcast_desc_key, true );
	$resources_type = get_post_meta( $post_id,$resources_type_key, true );
	$resources_url = get_post_meta( $post_id,$resources_url_key, true );
	$file_type_options = btn_media()->post()->get_file_type();

	//Nonce
	wp_nonce_field( $vide_url_key."_nonce", $vide_url."_nonce" );
	wp_nonce_field( $podcast_audio_key."_nonce", $podcast_audio_key."_nonce" );
	wp_nonce_field( $podcast_desc_key."_nonce", $podcast_desc_key."_nonce" );
	wp_nonce_field( $resources_type_key."_nonce", $resources_type_key."_nonce" );
	wp_nonce_field( $resources_url_key."_nonce", $resources_url_key."_nonce" );
    $args = [
      'class_name'	=> '',
      'template'		=> 'admin/metabox.php',
    ];
	$template = btn_media()->template_part_path($args['template']);
    include $template;
  }

  //Render TextField
  function render_field_setting($args){
    $html = "";
    if($args['wp_data'] == 'option'){
			$wp_data_value = get_option($args['name']);
		} elseif($args['wp_data'] == 'post_meta'){
			$wp_data_value = get_post_meta($args['post_id'], $args['name'], true );
		}
		switch ($args['type']) {
			case 'input':
				$value = ($args['value_type'] == 'serialized') ? serialize($wp_data_value) : $wp_data_value;
				if($args['subtype'] != 'checkbox'){
					$prependStart = (isset($args['prepend_value'])) ? '<div class="input-prepend"> <span class="add-on">'.$args['prepend_value'].'</span>' : '';
					$prependEnd = (isset($args['prepend_value'])) ? '</div>' : '';
					$step = (isset($args['step'])) ? 'step="'.$args['step'].'"' : '';
					$min = (isset($args['min'])) ? 'min="'.$args['min'].'"' : '';
					$max = (isset($args['max'])) ? 'max="'.$args['max'].'"' : '';
					if(isset($args['disabled'])){
						$html .='<input type="'.$args['subtype'].'" id="'.$args['id'].'_disabled" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'_disabled" size="40" disabled value="' . esc_attr($value) . '" /><input type="hidden" id="'.$args['id'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
					} else {
						$html .='<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" '.$step.' '.$max.' '.$min.' name="'.$args['name'].'" size="40" value="' . esc_attr($value) . '" />'.$prependEnd;
					}
				} else {
					$checked = ($value) ? 'checked' : '';
					$html .= '<input type="'.$args['subtype'].'" id="'.$args['id'].'" "'.$args['required'].'" name="'.$args['name'].'" size="40" value="1" '.$checked.' />';
				}
				break;
			  post:
				break;
		}
    return $html;
  }


  function enqueue( $hook ) {
   global $post;
   if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
     if ( $this->post_type === $post->post_type ) {
       wp_enqueue_script('btn-post-js', BTN_MEDIA_ASSETS_URL.'js/btn-post-admin.js',['jquery'], BTN_MEDIA_VERSION, false  );
     }
   }
  }


  function save_post( $post_id ) {


    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return;
		}
		// Check permissions
		if (! empty($_POST['post_type']) && 'page' == $_POST['post_type']) {
			if (! current_user_can('edit_pages', $post_id)) {
				return;
			}
		}
		else {
			if (! current_user_can('edit_posts', $post_id)) {
				return;
			}
		}

		$data = [self::RESOURCES_TYPE,self::RESOURCES_URL, self::PODCAST_DESC, self::PODCAST_AUDIO, self::VIDEO_URL];
		foreach($data as $meta_field){
			$new_data = (isset($_POST[$meta_field])) ? $_POST[$meta_field] : false;
			$existing_data = get_post_meta($post_id, $meta_field, true);
			if($new_data  || $new_data=== ""){
			 // Updated
			  if($existing_data != $new_data){
				 update_post_meta($post_id,$meta_field,$new_data);
			  }
			}

		}



	}


	function __construct(){}

  const VIDEO_URL = 'btn/media/video/';
  const PODCAST_AUDIO = 'btn/media/podcast/audio';
  const PODCAST_DESC = 'podcast_description';
  const RESOURCES_TYPE = 'btn/media/resources/type';
  const RESOURCES_URL = 'btn/media/resources/url';
}
