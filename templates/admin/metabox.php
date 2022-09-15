<div class="form-field btn-media-wrapper-metabox postbox">
    <table id="btn-media-video"  class="form-table">
        <tbody>
            <tr>
                <th>
                     <label for="<?php echo $vide_url_key?>"><?php _e('Video URL', 'btn-media'); ?></label>
                </th>
                <th class="field-right">

                  <input type="url" name="<?php echo $vide_url_key?>" value="<?php echo $vide_url ?>" id="url" placeholder="" size="30">
                </th>
            </tr>
        </tbody>
    </table>
</div>
<div class="form-field btn-media-wrapper-metabox postbox">
    <table id="btn-media-podcast"  class="form-table">
        <tbody>
            <tr>
                <th>
                    <label for="<?php echo $podcast_audio_key ?>"><?php _e('Podcast Audio URL', 'btn-media'); ?></label>
                </th>
                <th class="field-right">
                    <input type="text" name="<?php echo $podcast_audio_key ?>" value="<?php echo $podcast_audio ?>" id="url" placeholder="" size="30">
                </th>
            </tr>
            <tr>
                <th>
                     <label for="<?php echo $podcast_desc_key ?>"><?php _e('Podcast Description', 'btn-media'); ?></label>
                </th>
                <th class="field-right">

                   <?php
                       $args = array(
                             'tinymce'       => array(
                                 'toolbar1'      => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                                 'toolbar2'      => '',
                                 'toolbar3'      => '',
                             ),
                             'media_buttons' => FALSE,
                              'textarea_rows' => 5,
                         );
                     wp_editor( $podcast_desc, $podcast_desc_key, $args );  ?>
                </th>
            </tr>
        </tbody>
    </table>
</div>
<!--
<div class="form-field btn-media-wrapper-metabox postbox">
    <table id="btn-media-resources"  class="form-table">
        <tbody>
            <tr>
                <th>
                    <label for="<?php //echo //$resources_type_key; ?>"><?php //_e('Resource Type', 'btn-media'); ?></label>
                </th>
                <th class="field-right">
                  <select class="btn-media-resources-type" name="<?php //echo $resources_type_key;?>">
                  <option value="0">Select Toolbox File Type</option>
                  <?php
                    //foreach( $file_type_options as $option ){
                        //  $selected = ($option == $file_type)? 'selected': '';
                         // echo "<option value=\"{$option}\" {$selected}>{$option}</option>";
                    }
                  ?>
                </select>
                </th>
            </tr>
            <tr>
                <th>
                    <label for="<?php //echo $resources_url_key  ?>"><?php //_e('Resources URL', 'btn-media'); ?></label>
                </th>
                <th class="field-right">
                    <input type="url" name="<?php //echo $resources_url_key ?>" value="<?php //echo $resources_url ?>" id="url" placeholder="" size="30">
                </th>
            </tr>
        </tbody>
    </table>
</div>-->