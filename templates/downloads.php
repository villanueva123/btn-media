<?php
$ns = "btn-media";
if( btn_media()->get_repeater($repeater)){
  if( have_rows($repeater) ) {
	  $html .= "<div class=\"{$ns}-wrapper-downloads-wrapper\">";
            $html .= "<div class=\"{$ns}-download-title\"><h3>{$title}</h3></div>";
            $image_base = BTN_MEDIA_ASSETS_URL . "images/";
            $download = BTN_MEDIA_ASSETS_URL . "images/download.svg";
            $html .= "<div class=\"{$ns}-wrapper-downloads-wrapper-inner\">";
			while (have_rows($repeater) ){
				the_row();
                $type = get_sub_field('type');
                $url = get_sub_field('download_url');
                $name = get_sub_field('file_name');
                $html .= "<div class=\"{$ns}-download-item\">";
                    $html .="<a href=\"{$url}\" target=\"_blank\" download>";
                        $html .= "<div class=\"{$ns}-download-item-{$type}\"><img src=\"{$image_base}{$type}.png\"></div>";
                        $html .= "<div class=\"{$ns}-download-item-name\">{$name}</div>";
                        $html .= "<div class=\"{$ns}-download-item-svg\"><img src=\"{$download}\"></div>";
                    $html .="</a>";
                $html .="</div>";
            }
            $html .="</div>";
     $html .="</div>";
    }
}

?>
