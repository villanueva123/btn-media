<?php
$ns = "btn-media";
$podcast_audio_key = btn_media()->post_screen()::PODCAST_AUDIO;
$podcast_desc_key = btn_media()->post_screen()::PODCAST_DESC;
$html .= "<div class=\"{$ns}-wrapper-podcast\">";
if ( $loop->have_posts() ) {
    $html .= "<div class=\"{$ns}-inner-wrapper-podcast\">";
    while ( $loop->have_posts() ) : $loop->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    $link = get_the_permalink();
    //Get Meta
    $podcast_audio = get_post_meta( $id,$podcast_audio_key, true );
    $podcast_desc  = get_post_meta( $id,$podcast_desc_key, true );
    $iframe = (!empty($podcast_audio))? '<iframe loading="lazy" style="border: none;" src="'.$podcast_audio.'" width="100%" height="90" scrolling="no" allowfullscreen="allowfullscreen"></iframe>':'';
    $html .= "<div class=\"{$ns}-podcast-item\">";
            $html .= "<div class=\"{$ns}-podcast-item-title\"><h3>{$title}</h3></div>";
            $html .= "<div class=\"{$ns}-podcast-item-audio\">{$iframe}</div>";
            $html .= "<div class=\"{$ns}-podcast-item-description\">{$podcast_desc}</div>";
            $html .= "<div class=\"{$ns}-podcast-item-link\"><a href=\"{$link}\">Read full Post Option</a></div>";
    $html .= "</div>";
    endwhile;
    $html .="</div>";
	$total_rows = max( 0, $loop->found_posts  );
	$total_pages = ceil( $total_rows / $posts_per_page );
    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));
        $html .= paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '/page/%#%',
            'current' => $current_page,
            'total' => $total_pages,
            'prev_text'    => __('«'),
            'next_text'    => __('»'),
        ));
    }
}else{
	if(isset($_GET['s'])){
		$html .="No article Found";
	}
}
$html .="</div>";
wp_reset_postdata();
?>
