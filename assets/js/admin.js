//App reference
var btnPOST,
  curPage,
  btnPOSTError = false;

(function ($) {
  "use strict";

  $(function () {
    btnPOST = wpAdminTemplater(btn_post_data);

    console.log({
        btn_post_data:btn_post_data
    });
    curPage = btnPOST.page;
    if (btn_post_data.hasOwnProperty("save_error")) {
      btnPOSTError = {
        params: btn_post_data.save_error,
        $wrap: document.getElementById("post"),
      };
    }

    if (curPage === "btn-post") {
              // Add Notice Area to top of form
              var $wrap = document.getElementById('wpwrap'),
                  $notice = document.createElement("div");


              //var module_tabs = btn_post_data.module_tabs;
              btnPOST.registerFilters('btn_post_tabs_callback', function(data){
                  if( data.url ){
                      btnPOST.renderLoading(data.message, $wrap);
                      window.location.href = data.url;
                  }
              });

              // Activities
              btnPOST.registerFilters( 'btn_post_taxonomy_init', function( $section ){
        			var $legend = $section.previousElementSibling;
        			$legend.insertAdjacentHTML('beforeend', wpAdminTmpls.button( {
        				label :  btnPOST.I18n.add_new_post,
        				attrs : [
        					{ prop: 'id', value : 'btn_post_taxonomy-toggle' },
        					{ prop: 'class', value : 'button button-add-new button-primary' },
        				]
        			} ) );
        		});


              // Dummy Tabs
              btnPOST.registerFilters('render_dummy_sub_tab', function( $section ){
                  var $settings_table = document.getElementById('module-settings-table'),
                      $tabs = $settings_table.querySelector('.wpat_data_tabs'),
                      $panel = $section.closest('.wpat_option_panel'),
                      id = $panel.id,
                      btnSelector = id.replace('_data', ''),
                      tabId = btnPOSTextractTabIdFromPanelId(id),
                      selector = 'dummy-sub-tab-'+tabId,
                      $check = $settings_table.querySelector('#has_dummy_sub_tab-'+tabId),
                      style = ( $check.checked ) ? '' : ' style="display:none;"',
                      $title = $settings_table.querySelector('#sub_tab_title-'+tabId),
                      title = bntmPOSTDummyTitle( $title.value ),
                      $mainTab = $tabs.querySelector('.'+btnSelector),
                      href = $mainTab.querySelector('a').href;
                  // Build Button
                  var li = '<li class="'+selector+'"'+style+'>';
                  li += '<a href="'+href+'" data-id="'+tabId+'">';
                  li += '<i class="dashicons dashicons-controls-play"></i>';
                  li += '<span>'+title+'</span></a></li>';
                  $mainTab.insertAdjacentHTML('afterend', li);
                  var $li = $tabs.querySelector('li.'+selector);
                  // Button Click
                  $li.querySelector('a').onclick = function (e){
                      e.preventDefault();
                      if( !wpatAdminHasClass($mainTab, 'active') ){
                          $mainTab.querySelector('a').click();
                          $section.scrollIntoView();
                      }
                      return false;
                  };
                  // Checkbox Checked
                  $check.addEventListener("change", function(e) {
                      $li.style.display = ( $check.checked ) ? 'block' : 'none';
                  });
                  // Title Change
                  $title.addEventListener("change", function(e) {
                      $li.querySelector('a span').innerHTML = bntmPOSTDummyTitle($title.value);
                  });
              });

            btnPOST.init();
            if (btnPOSTError) {
              btnPOST.renderNotice(btnPOSTError.params, btnPOSTError.$wrap);
            }
    }
    else if (curPage === "btn_post_modules") {

    }
    // Default Init
    else {
      btnPOST.init();
      if (btnPOSTError) {
        btnPOST.renderNotice(btnPOSTError.params, btnPOSTError.$wrap);
      }
    }
  });

  var btnPOSTextractTabIdFromPanelId = function( id ){
      var cleansedId = id.replace('_options_data', ''),
        elArray = cleansedId.split("-");
    return elArray[elArray.length - 1];
  };

  var bntmPOSTDummyTitle = function( value ){
     return ( value > '' ) ? ' - ' + value : ' - Dummy';
  };

})(jQuery);
