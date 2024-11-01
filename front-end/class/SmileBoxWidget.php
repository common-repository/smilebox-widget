<?php
/**
 * @package Wordpress SmileBox Widget
 * @author Igor Karpov <mail@noxls.net>
 * @link https://noxls.net
 *
 */

class SmileBoxWidget extends WP_Widget
{

    public function __construct()
    {

        parent::__construct(
            'smile_box_widget',
            'SmileBox Widget',
            array('description' => __('A widget to display comments, trackbacks and pingbacks of the site in the SmileBox.', 'smile-box-widget'))
        );

    }

    static public function registerWidget()
    {
        wp_register_style('style.css', NXIK_SMILE_BOX__PLUGIN_URL . 'assets/css/style.css', array(), NXIK_SMILE_BOX__VERSION);
        wp_enqueue_style('style.css');

        function load_js_script()
        {
            wp_register_script('smile-pingback.js', NXIK_SMILE_BOX__PLUGIN_URL . 'assets/js/smile-pingback.js', array(), NXIK_SMILE_BOX__VERSION);
            wp_enqueue_script('smile-pingback.js');
        }

        add_action('wp_enqueue_scripts', 'load_js_script');

        add_action('admin_enqueue_scripts', 'wp_enqueue_color_picker');
        function wp_enqueue_color_picker($hook_suffix)
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_script('wp-color-picker-script-handle', '/wp-admin/js/color-picker.js', array('wp-color-picker'), false, true);
        }

        return register_widget('SmileBoxWidget');
    }


    function form($aInstance)
    {

        $title = esc_attr(isset($aInstance['title']) ? $aInstance['title'] : ':)');
        $numitems = empty($aInstance['numitems']) ? 5 : esc_attr($aInstance['numitems']);
        $box_width = empty($aInstance['box_width']) ? '100%' : esc_attr($aInstance['box_width']);
        $smile_color = empty($aInstance['smile_color']) ? '#cc0000' : esc_attr($aInstance['smile_color']);
        $box_background_color = empty($aInstance['box_background_color']) ? '#fff' : esc_attr($aInstance['box_background_color']);
        $box_comment_color = empty($aInstance['box_comment_color']) ? '#000' : esc_attr($aInstance['box_comment_color']);
        $box_comment_title_color = empty($aInstance['box_comment_title_color']) ? '#cc0000' : esc_attr($aInstance['box_comment_title_color']);
        $order = empty($aInstance['order']) ? 1 : esc_attr($aInstance['order']);
        $arrOrders = array(array('label' => __('Newest First', 'smile-box-widget'), 'value' => 1),
            array('label' => __('Oldest First', 'smile-box-widget'), 'value' => 2),
        );
        $renderdate = empty($aInstance['renderdate']) ? 0 : esc_attr($aInstance['renderdate']);
        $render_author = empty($aInstance['render_author']) ? 0 : esc_attr($aInstance['render_author']);
        $style = empty($aInstance['style']) ? 'ol' : esc_attr($aInstance['style']);
        $arrStyles = array(array('label' => 'ol', 'value' => 'ol'),
            array('label' => 'ul', 'value' => 'ul'),
            array('label' => 'div', 'value' => 'div')
        );
        $type = empty($aInstance['type']) ? 'all' : esc_attr($aInstance['type']);
        $arrTypes = array(
            array('label' => __('Trackbacks and Pingbacks', 'smile-box-widget'), 'value' => 'pings'),    // 'all', 'comment', 'trackback', 'pingback', or 'pings'.
            array('label' => __('Comments', 'smile-box-widget'), 'value' => 'comment'),
            array('label' => __('Trackbacks', 'smile-box-widget'), 'value' => 'trackback'),
            array('label' => __('Pingbacks', 'smile-box-widget'), 'value' => 'pingback'),
            array('label' => __('All', 'smile-box-widget'), 'value' => 'all')
        );

        $show_not_found_message = !isset($aInstance['show_not_found_message']) ? 1 : esc_attr($aInstance['show_not_found_message']);

        ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                jQuery('.color-picker').on('focus', function () {
                    var parent = jQuery(this).parent();
                    jQuery(this).wpColorPicker()
                    parent.find('.wp-color-result').click();
                });
            });
        </script>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'smile-box-widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
        </p>

        <p>
            <label
                for="<?php echo $this->get_field_id('numitems'); ?>"><?php _e('Number of records to show ( set 0 to show all) :', 'smile-box-widget'); ?></label>
            <input class="" id="<?php echo $this->get_field_id('numitems'); ?>"
                   name="<?php echo $this->get_field_name('numitems'); ?>" type="text" size="5"
                   value="<?php echo $numitems; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('box_width'); ?>">
                <?php _e('Width (e.g. 100%, 250px):'); ?>
            </label>
            <input class="" id="<?php echo $this->get_field_id('box_width'); ?>"
                   name="<?php echo $this->get_field_name('box_width'); ?>" type="text" size="10"
                   value="<?php echo $box_width; ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('smile_color'); ?>"
                   style="display:block;"><?php _e('Smile Color:'); ?></label>
            <input class="widefat color-picker" id="<?php echo $this->get_field_id('smile_color'); ?>"
                   name="<?php echo $this->get_field_name('smile_color'); ?>" type="text"
                   value="<?php echo esc_attr($smile_color); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('box_background_color'); ?>"
                   style="display:block;"><?php _e('Box Background Color:'); ?></label>
            <input class="widefat color-picker" id="<?php echo $this->get_field_id('box_background_color'); ?>"
                   name="<?php echo $this->get_field_name('box_background_color'); ?>" type="text"
                   value="<?php echo esc_attr($box_background_color); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('box_comment_title_color'); ?>"
                   style="display:block;"><?php _e('Box Comment Title Color:'); ?></label>
            <input class="widefat color-picker" id="<?php echo $this->get_field_id('box_comment_title_color'); ?>"
                   name="<?php echo $this->get_field_name('box_comment_title_color'); ?>" type="text"
                   value="<?php echo esc_attr($box_comment_title_color); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('box_comment_color'); ?>"
                   style="display:block;"><?php _e('Box Comment Color:'); ?></label>
            <input class="widefat color-picker" id="<?php echo $this->get_field_id('box_comment_color'); ?>"
                   name="<?php echo $this->get_field_name('box_comment_color'); ?>" type="text"
                   value="<?php echo esc_attr($box_comment_color); ?>"/>
        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Select Order:', 'smile-box-widget'); ?></label><br/>
            <select name="<?php echo $this->get_field_name('order'); ?>"
                    id="<?php echo $this->get_field_id('order'); ?>">
                <?php
                foreach ($arrOrders as $arrOrder)
                    echo '<option value="' . esc_attr($arrOrder['value']) . '" ' . ($arrOrder['value'] == $order ? 'selected="Selected"' : '') . '>'
                        . $arrOrder['label']
                        . '</option>';
                ?>
            </select>
        </p>

        <p>
            <input name="<?php echo $this->get_field_name('show_not_found_message'); ?>" type="hidden" value="0"/>
            <input id="<?php echo $this->get_field_id('show_not_found_message'); ?>"
                   name="<?php echo $this->get_field_name('show_not_found_message'); ?>" type="checkbox"
                   value="1" <?php if ($show_not_found_message) echo 'checked="checked"'; ?>/>
            <label
                for="<?php echo $this->get_field_id('show_not_found_message'); ?>"><?php _e('Display the Not Found message?', 'smile-box-widget'); ?></label>
        </p>

        <p>
            <input id="<?php echo $this->get_field_id('renderdate'); ?>"
                   name="<?php echo $this->get_field_name('renderdate'); ?>" type="checkbox"
                   value="1" <?php if ($renderdate) echo 'checked="checked"'; ?>/>
            <label
                for="<?php echo $this->get_field_id('renderdate'); ?>"><?php _e('Display item date?', 'smile-box-widget'); ?></label>
        </p>
        <p>
            <input id="<?php echo $this->get_field_id('render_author'); ?>"
                   name="<?php echo $this->get_field_name('render_author'); ?>" type="checkbox"
                   value="1" <?php if ($render_author) echo 'checked="checked"'; ?>/>
            <label
                for="<?php echo $this->get_field_id('render_author'); ?>"><?php _e('Display comment Author?', 'smile-box-widget'); ?></label>
        </p>
        <p>

        </p>
        <p>
            <label
                for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Enclosing HTML Tag:', 'smile-box-widget'); ?></label><br/>
            <select name="<?php echo $this->get_field_name('style'); ?>"
                    id="<?php echo $this->get_field_id('style'); ?>">
                <?php
                foreach ($arrStyles as $arrStyle)
                    echo '<option value="' . esc_attr($arrStyle['value']) . '" ' . ($arrStyle['value'] == $style ? 'selected="Selected"' : '') . '>'
                        . $arrStyle['label']
                        . '</option>';
                ?>
            </select>
        </p>

        <p>
            <label
                for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type:', 'smile-box-widget'); ?></label><br/>
            <select name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>">
                <?php
                foreach ($arrTypes as $arrType)
                    echo '<option value="' . esc_attr($arrType['value']) . '" ' . ($arrType['value'] == $type ? 'selected="Selected"' : '') . '>'
                        . $arrType['label']
                        . '</option>';
                ?>
            </select>
        </p>
    <?php
    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] = strip_tags($new_instance['title']);
        $new_instance['numitems'] = strip_tags($new_instance['numitems']);
        $new_instance['order'] = strip_tags($new_instance['order']);
        $new_instance['renderdate'] = strip_tags($new_instance['renderdate']);
        $new_instance['render_author'] = strip_tags($new_instance['render_author']);
        $new_instance['style'] = strip_tags($new_instance['style']);
        $new_instance['type'] = strip_tags($new_instance['type']);
        $new_instance['box_width'] = strip_tags($new_instance['box_width']);
        $new_instance['smile_color'] = strip_tags($new_instance['smile_color']);
        $new_instance['box_background_color'] = strip_tags($new_instance['box_background_color']);
        $new_instance['box_comment_color'] = strip_tags($new_instance['box_comment_color']);
        $new_instance['box_comment_title_color'] = strip_tags($new_instance['box_comment_title_color']);
        return $new_instance;
    }

    /**
     * The method which actually outputs the widget contents
     */
    function widget($aArgs, $aInstance)
    {
        /*
         * If the current post is protected by a password and
         * the visitor has not yet entered the password we will
         * return early without loading the comments.
         */
        if (post_password_required()) {
            return;
        }

        // Check the number of comments
        $style_css = <<<EOD
<style>
.nxIK-smile-block {
    width: %s;
}
#nxik-smile {
    color: %s;
}
.nxIK-commentlist {
    background-color: %s;
}
.nxIK-smile-comment-item {
    color: %s;
}
.nxIK-commentlist {
    color: %s;
}
.nxIK-smile-comment-title {
    color: %s !important;;
}
</style>
EOD;
        echo sprintf(
            $style_css,
            $aInstance['box_width'],
            $aInstance['smile_color'],
            $aInstance['box_background_color'],
            $aInstance['box_comment_color'],
            $aInstance['box_comment_color'],
            $aInstance['box_comment_title_color']
        );

        $aInstance['type'] = ($aInstance['type'] == 'all'?'':$aInstance['type']);
        $iCount = $this->getCountComment(get_the_ID(), $aInstance['type']);
        if ($iCount == 0 && !$aInstance['show_not_found_message']) {
            return;
        }


        echo $this->getCommentOutput($aInstance, $iCount);

    }

    /**
     * Count the number of comments.
     *
     */
    protected function getCountComment($iPostID = null, $type = '')
    {

        $type = apply_filters('widget_title', $type);
        $iCount = 0;
        $aComments = array();
        if ($iPostID) {
            $aComments = get_comments(
                array(
                    'status' => 'approve',
                    'type' => $type
                )
            );
        } else if (!empty ($GLOBALS['wp_query']->comments)) {
            $aComments = $GLOBALS['wp_query']->comments;
        }
        $iCount = sizeof($aComments);
        return $iCount;

    }

    protected function getCommentOutput($aInstance, $iCount)
    {


        $aInstance['title'] = "<div class='smile'><a href='#' id='nxik-smile'>" . apply_filters('widget_title', $aInstance['title']) . "</a></div>";
        $aInstance['style'] = apply_filters('widget_title', $aInstance['style']);    // added since 1.0.1
        $aInstance['style'] = empty ($aInstance['style']) ? 'div' : $aInstance['style'];
        $sTag = $aInstance['style'];

        // Start storing the output
        $sTitle = "<div class='widget nxIK-smile-block'><h2 class='widget-title'>{$aInstance['title']}</h2>";
        $sOpeningTag = "<{$sTag} class='nxIK-commentlist'>";
        $sClosingTag = "</{$sTag}><!-- .commentlist --></div>";
        if ($iCount == 0)
            return $sTitle
            . $sOpeningTag
            . "<p>" . __('No Comments is Found.', 'smile-box-widget') . "</p>"
            . $sClosingTag;

        $sOutput = $this->getCommentBuffer($aInstance);

        return $sTitle
        . $sOpeningTag
        . balanceTags($sOutput)
        . $sClosingTag;

    }

    protected function getCommentBuffer($aInstance)
    {

        $numitems = apply_filters('widget_title', $aInstance['numitems']);
        $order = apply_filters('widget_title', $aInstance['order']);
        $renderdate = apply_filters('widget_title', $aInstance['renderdate']);
        $render_author = apply_filters('widget_title', $aInstance['render_author']);
        $type = apply_filters('widget_title', $aInstance['type']);
        ob_start(); // start buffer

        $this->wp_list_comments(
            array(
                'type' => $type,
                'style' => $aInstance['style'],
            ),
            null,
            array(
                'order' => $order,
                'numitems' => $numitems,
                'renderdate' => $renderdate,
                'render_author' => $render_author,

            )
        );

        $sContent = ob_get_contents();
        ob_end_clean();
        return $sContent;

    }

    function wp_list_comments($args = array(), $comments = null, $arrArgs = array())
    {

        global $comment_alt, $comment_depth, $comment_thread_alt, $overridden_cpage, $in_comment_loop;
        $in_comment_loop = true;
        $comment_alt = $comment_thread_alt = 0;
        $comment_depth = 1;

        $defaults = array('walker' => null, 'max_depth' => '', 'style' => 'ul', 'callback' => null, 'end-callback' => null, 'type' => 'all',
            'page' => '', 'per_page' => '', 'avatar_size' => 32, 'reverse_top_level' => null, 'reverse_children' => '');

        $r = wp_parse_args($args, $defaults);
        // Figure out what comments we'll be looping through ($_comments)
        $comment_type = ($r['type'] == 'all' ? '' : $r['type']);
        $_comments = get_comments(
            array(
                'status' => 'approve',
                'type' => $comment_type,
                'number' => $arrArgs['numitems'] == 0 ? null : $arrArgs['numitems'],
                'order' => $arrArgs['order'] == 1 ? 'DESC' : 'ASC'
            ));

        extract($r, EXTR_SKIP);

        if (empty($walker)) {
            $walker = new Walker_SmileBox($arrArgs);
        }

        // render the elements
        echo $walker->paged_walk($_comments);
        return;

    }
}

class Walker_SmileBox extends Walker_comment
{

    function __construct($arrArgs)
    {
        $this->arrArgs = $arrArgs;
    }

    function SortByCommentDate($a, $b)
    {
        if ($a->comment_date == $b->comment_date) {
            return 0;
        }
        return ($a->comment_date > $b->comment_date) ? -1 : 1;

    }

    function paged_walk($elements, $max_depth = "", $page_num = "", $per_page = "")
    {

        if (empty($elements)) {
            return '';
        }
        $arrArgs = $this->arrArgs;
        $output = '';
        $i = 0;
        $numElements = sizeof($elements);

        foreach ($elements as $e) {
            $output .= "<div>";
            if ($arrArgs['render_author']) {
                $output .= "<b class='fn'>" . $e->comment_author . '</b>&nbsp;';
            }
            if ($arrArgs['renderdate']) {
                $comment_date = get_comment_date('', $e->comment_ID);
                $output .= sprintf('<time datetime="%1$s">%2$s</time>', $comment_date, sprintf(__('%1$s', 'smile-box-widget'), $comment_date));
            }
            if ($arrArgs['render_author'] || $arrArgs['renderdate']) {
                $output .= "<br>";
            }
            $output .= "<a class='nxIK-smile-comment-title' href='" . get_permalink($e->comment_post_ID) . "'>" . get_the_title($e->comment_post_ID) . "</a>";
            $output .= "<div class='nxIK-smile-comment-item'>" . $e->comment_content . "</div>";
            if (++$i !== $numElements) {
                $output .= "<hr>";
            }

            $output .= "</div>";
        }
        return $output;
    }
}