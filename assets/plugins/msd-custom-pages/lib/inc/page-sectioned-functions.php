<?php
class MSDSectionedPage{
    /**
         * A reference to an instance of this class.
         */
        private static $instance;


        /**
         * Returns an instance of this class. 
         */
        public static function get_instance() {

                if( null == self::$instance ) {
                        self::$instance = new MSDSectionedPage();
                } 

                return self::$instance;

        } 
        
        /**
         * Initializes the plugin by setting filters and administration functions.
         */
   function __construct() {      
        }
        
    function add_metaboxes(){
        global $post,$sectioned_page_metabox,$wpalchemy_media_access;
        $sectioned_page_metabox = new WPAlchemy_MetaBox(array
        (
            'id' => '_sectioned_page',
            'title' => 'Page Sections',
            'types' => array('page'),
            'context' => 'normal', // same as above, defaults to "normal"
            'priority' => 'high', // same as above, defaults to "high"
            'template' => WP_PLUGIN_DIR.'/'.plugin_dir_path('msd-custom-pages/msd-custom-pages.php'). '/lib/template/metabox-sectioned-page.php',
            'autosave' => TRUE,
            'mode' => WPALCHEMY_MODE_EXTRACT, // defaults to WPALCHEMY_MODE_ARRAY
            'prefix' => '_msdlab_', // defaults to NULL
            //'include_template' => 'sectioned-page.php',
        ));
    }
    
    function default_output($section,$i){
        $eo = ($i+1)%2==0?'even':'odd';
        $background = '';
        if($section['background-color'] || $section['background-image']){
            if($section['background-color'] && $section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');background-color: '.$section['background-color'].';"';
            } elseif($section['background-image']){
               $background = 'style="background-image: url('.$section['background-image'].');"';
            } else{
               $background = 'style="background-color: '.$section['background-color'].';"';
            }
        }
        $title = apply_filters('the_title',$section['content-area-title']);
        $wrapped_title = trim($title) != ''?'<div class="section-title">
            <h3 class="wrap">
                '.$title.'
            </h3>
        </div>':'';
        $slug = sanitize_title_with_dashes(str_replace('/', '-', $title));
        $subtitle = $section['content-area-subtitle'] !=''?'<h4 class="section-subtitle">'.apply_filters('the_content',$section['content-area-subtitle']).'</h4>':'';
        $content = apply_filters('the_content',$section['content-area-content']);
        $featured_image = $section['content-area-image'] !=''?'<img src="'.$section['content-area-image'].'">':'';
        $ret = '
        <div id="'.$slug.'" class="section section-'.$eo.' section-'.$slug.' clearfix"'.$background.'>
            '.$wrapped_title.'
            <div class="section-body">
                <div class="wrap">
                    '.$featured_image.'
                    '.$subtitle.'
                    '.$content.'
                </div>
            </div>
        </div>
        ';
        return $ret;
    }
    
    function sectioned_page_output(){
        wp_enqueue_script('sticky',WP_PLUGIN_URL.'/'.plugin_dir_path('msd-custom-pages/msd-custom-pages.php'). '/lib/js/jquery.sticky.js',array('jquery'),FALSE,TRUE);
        wp_enqueue_script('jquery-path',WP_PLUGIN_URL.'/'.plugin_dir_path('msd-custom-pages/msd-custom-pages.php'). '/lib/js/jquery.path.js',array('jquery','bootstrap-jquery'));
        
        global $post,$subtitle_metabox,$sectioned_page_metabox,$nav_ids;
        $i = 0;
        $meta = $sectioned_page_metabox->the_meta();
        if(is_object($sectioned_page_metabox)){
        while($sectioned_page_metabox->have_fields('sections')){
            $layout = $sectioned_page_metabox->get_the_value('layout');
            switch($layout){
                case "three-boxes":
                    break;
                default:
                    $sections[] = self::default_output($meta['sections'][$i],$i);
                    break;
            }
            $i++;
        }//close while
        print implode("\n",$sections);
        }//clsoe if
    }

    function sectioned_page_floating_nav(){
        global $nav_ids; //http://julian.com/research/velocity/ llook at this to speed up animations
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $("#floating_nav").sticky({ topSpacing: 0 });
            /*$("#billboard_nav .fuzzybubble").blurjs({
                radius: 10,
                source: $('.image-widget-background'), 
                });*/
            var arc_params = function(i) {
              var arc_positions = [240,270,300,60,90,120];
              return new $.path.arc({
                center: [230,100],  
                    radius: 320,    
                    start: 180,
                    end: arc_positions[i],
                    dir: -1
              });
            }
            <?php
            $i = 0;
            foreach($nav_ids AS $nav_id){
                print '$("#billboard_nav #'.$nav_id.'_bb_nav").delay('.($i*500).').animate({opacity: 1,path : arc_params('.$i.')},4000);
                ';
                $i++;
            }
            ?>
        });
        </script>
        <?php
    }
        function info_footer_hook()
        {
            global $current_screen;
            ?><script type="text/javascript">
                jQuery(function($){
                    $("#wpa_loop-sections").sortable({
                        change: function(){
                            $("#warning").show();
                        }
                    });
                    $("#postdivrich").after($("#_page_sectioned_metabox"));
                    $(".colorpicker").spectrum({
                        showAlpha: true,
                        showInput: true,
                        allowEmpty: true,
                    });
                });
                </script><?php
            
        }
        
        function enqueue_admin(){
            wp_enqueue_script('spectrum',WP_PLUGIN_URL.'/msd-custom-pages/lib/js/spectrum.js',array('jquery'));
            wp_enqueue_style('sectioned-admin',WP_PLUGIN_URL.'/msd-custom-pages/lib/css/sectioned.css');
            wp_enqueue_style('spectrum',WP_PLUGIN_URL.'/msd-custom-pages/lib/css/spectrum.css');
        }
}