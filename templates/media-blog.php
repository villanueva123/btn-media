<?php
$ns = "btn-media";
$html .= "<div class=\"{$ns}-wrapper-blog\">";
if ( $loop->have_posts() ) {
    while ( $loop->have_posts() ) : $loop->the_post();
    $id = get_the_ID();
    $title = get_the_title();
    $excerpt = get_the_excerpt();
    $link = get_the_permalink();
    $date = get_the_date();
    $html .= "<div class=\"{$ns}-blog-item\">";
    $html .= $title;
    endwhile;
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
