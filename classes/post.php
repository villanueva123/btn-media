<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * CPT Class
 *
 * @since      1.0.0
 * @package    btn-media
 * @subpackage btn-media/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_media_post {

		function register() {
		//Taxonomy
	    $taxonomy_args = [
	        'labels'            	=>  [
	            'name'          =>  __( 'Categories', 'btn-media' ),
	            'singular_name' =>  __( 'Category', 'btn-media' ),
							'add_new' 				=> _x( 'Add New', 'Category post', 'btn-media' ),
		    			'add_new_item' 			=> __( 'Add New Category post', 'btn-media' ),
		    			'edit_item' 			=> __( 'Edit Category post', 'btn-media' ),
		    			'new_item' 				=> __( 'New Category post', 'btn-media' ),
		    			'view_item' 			=> __( 'View Category post', 'btn-media' ),
		    			'search_items' 			=> __( 'Search Category post', 'btn-media' ),
		    			'not_found' 			=> __( 'Nothing found', 'btn-media' ),
		    			'not_found_in_trash'	=> __( 'Nothing found in Trash', 'btn-media' ),
	        ],
				'hierarchical' => true,
			    'show_ui' => true,
			    'show_admin_column' => true,
			    'query_var' => true,
			    'rewrite' => [
						'slug' => self::TAX_SLUG,
					],
	    ];
		  register_taxonomy( self::TAX_SLUG, self::POST_SLUG, $taxonomy_args );

		    // post Post Type
		  $post_args = [
				'labels' 				=> [
						'name'								=> _x( 'SDR ','SDR', 'btn-media' ),
						'singular_name' 			=> _x( 'SDR', 'SDR', 'btn-media' ),
						'add_new' 						=> _x( 'Add New', 'SDR', 'btn-media' ),
						'add_new_item' 				=> __( 'Add New  SDR', 'btn-media' ),
						'edit_item' 					=> __( 'Edit  SDR', 'btn-media' ),
						'new_item' 						=> __( 'New  SDR', 'btn-media' ),
						'view_item' 					=> __( 'View SDR', 'btn-media' ),
						'search_items' 				=> __( 'Search SDR', 'btn-media' ),
						'not_found' 					=> __( 'Nothing found', 'btn-media' ),
						'not_found_in_trash'	=> __( 'Nothing found in Trash', 'btn-media' ),
					],
				'hierarchical'        => false,
         'public'              => true,
         'show_ui'             => true,
         'show_in_menu'        => true,
         'show_in_nav_menus'   => true,
         'show_in_admin_bar'   => true,
         'menu_position'       => 5,
         'can_export'          => true,
         'has_archive'         => true,
         'exclude_from_search' => false,
         'publicly_queryable'  => true,
         'capability_type'     => 'post',
				'menu_icon'					=> 'dashicons-microphone',
				'supports'          => ['title', 'excerpt', 'author', 'thumbnail', 'editor','comments', 'revisions' ],
			];
			register_post_type( self::POST_SLUG, $post_args );

		}


	function get_article_post_data(){
		$post_data = [];
		$posts = get_posts([
			 'post_type' => self::POST_SLUG,
			 'posts_per_page' => -1,
		 ]);
			if( $posts ){
				foreach( $posts as $post ){
					$post_data[] = [
						'value' => $post->ID,
						'title' => $post->post_title
					];
				}
			}
			return $post_data;
	}

	function get_article_related_data($posts_per_page = 1){
		$related_data = [];
		$id = get_the_ID();
		$posts = get_posts([
			 'post_type' => self::POST_SLUG,
			 'posts_per_page' => $posts_per_page,
			 'exclude' => [$id]
		 ]);
			if( $posts ){
				foreach( $posts as $post ){
					if($posts_per_page === 1){
						$related_data = $post;
					}else{
						$related_data[] = $post;
					}

				}
			}
			return $related_data;
	}

	function get_post_slug(){
	  return self::POST_SLUG;
	}
	function get_taxonomy_slug(){
		return self::TAX_SLUG;
	}
	function get_file_type(){
		$fileType = [ "CSV", "DOC", "XLS", "ZIP", "PDF" , "WMV", "OTHERS"];
		return $fileType;
	}


	function __construct(){}

    const POST_SLUG = 'sdr';
    const TAX_SLUG =  'sdr-categories';



}
