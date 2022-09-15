<?php
if (! defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Shortcode Class
 *
 * @since      1.0.0
 * @package    btn-media
 * @subpackage btn-media/classes
 * @author     Augustus Villanueva <augustus@businesstechninjas.com>
 */
final class btn_media_shortcodes {
		static function list($atts, $content, $tag) {
				$args = shortcode_atts( [
					'class_name' => '',
					'type'		 => 'podcast',
					'posts_per_page'  => '8',
					'read_more'   => 'Read More',
				], $atts );
				$html = '';
				$type = $args['type'];
				$readmore =  $args['read_more'];
				$post_type =   btn_media()->post()->get_post_slug();
				$posts_per_page = $args['posts_per_page'];
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$page_url = get_permalink();

				$args_post = [
					'post_type' => $post_type,
					'posts_per_page'=> $posts_per_page,
					'paged' 		=> $paged,
				];
				if($type == "podcast"){
					$template = btn_media()->template_part_path( 'media-podcast.php' );
					$podcast_key = btn_media()->post_screen()::PODCAST_AUDIO;
					$args_post['meta_query'] =  [
			            //'relation' => 'OR',
			            [
			                'key'       => $podcast_key,
			                'value'     => '',
			                'compare'   => '!='
			            ]

			        ];
				}
				else if($type == "resources"){
					$template = btn_media()->template_part_path( 'media-resources.php' );
				}
				else{
					$template = btn_media()->template_part_path( 'media-blog.php' );
				}

			$loop = new WP_Query( $args_post );
			if($template){
				include $template;
			}
			btn_media()->frontend()->set_json('btn-media-shortcode', $args);
			return $html;
		}
		static function podcast($atts, $content, $tag) {
				$args = shortcode_atts( [
					'class_name' => '',
				], $atts );
				$html = '';
				$post_type =   btn_media()->post()->get_post_slug();
				$id = get_the_ID();
				$args_post = [
					'post_type' => $post_type,
					'p' => $id,
				];
				$podcast_key = btn_media()->post_screen()::PODCAST_AUDIO;
				$args_post['meta_query'] =  [
					//'relation' => 'OR',
					[
						'key'       => $podcast_key,
						'value'     => '',
						'compare'   => '!='
					]

				];


			$loop = new WP_Query( $args_post );
			$ns = "btn-media";
			$podcast_audio_key = btn_media()->post_screen()::PODCAST_AUDIO;
			$podcast_desc_key = btn_media()->post_screen()::PODCAST_DESC;
			$column = 1;
			if( btn_media()->get_repeater('downloads')){ 
				if( have_rows('downloads') ) {
					$column = 2;
				}
			}
			$html .= "<div class=\"{$ns}-wrapper-podcast-individual {$ns}-wrapper-podcast-individual-{$column}\"  id=\"resources\">";
			if ( $loop->have_posts() ) {
				$html .= "<div class=\"{$ns}-wrapper-podcast\">";
				$html .="<h2 class=\"{$ns}-podcast-heading\">Podcast</h2>";
			        while ( $loop->have_posts() ) : $loop->the_post();
			            $id = get_the_ID();
			            $title = get_the_title();
			            $link = get_the_permalink();
			            //Get Meta
			            $podcast_audio = get_post_meta( $id,$podcast_audio_key, true );
			            $podcast_desc  = get_post_meta( $id,$podcast_desc_key, true );
			            $iframe = (!empty($podcast_audio))? '<iframe loading="lazy" style="border: none;" src="'.$podcast_audio.'" width="100%" height="90" scrolling="no" allowfullscreen="allowfullscreen"></iframe>':'';
			            $html .= "<div class=\"{$ns}-podcast-item\">";
			                    $html .= "<div class=\"{$ns}-podcast-item-audio\">{$iframe}</div>";
			                    $html .= "<div class=\"{$ns}-podcast-item-description\">{$podcast_desc}</div>";
			            $html .= "</div>";
			        endwhile;
			    $html .="</div>";
			}
				$html .= do_shortcode('[btn_media_downloads]');
			$html .="</div>";
			btn_media()->frontend()->set_json('btn-media-shortcode', $args);
			return $html;
		}
	
		static function downloads($atts, $content, $tag) {
				$args = shortcode_atts( [
					'post_id' => '',
					'repeater'  => 'downloads',
					'title' => 'Resources',
				], $atts );
				$html = '';
				$post_type = btn_media()->post()->get_post_slug();
				$id = (!empty($args['post_id']))? $args['post_id'] : get_the_ID();
				$repeater = $args['repeater'];

				$title = $args['title'];
				$template = btn_media()->template_part_path( 'downloads.php' );
				if($template){
					include $template;
				}
				btn_media()->frontend()->set_json('btn-call-shortcode', $args);
				return $html;
			}
    function __construct(){}
}
