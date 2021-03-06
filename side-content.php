<?php
/*
Plugin Name: Side Content
Plugin URI: http://figure-w.co.uk/wordpress-side-content-plugin
Description: Creates sidebar widgets specific to a page.
Author: Alfred Armstrong, Figure W

Version: 1.0
Author URI: http://figure-w.co.uk
*/

/**
 * Object that stores the sidebar widgets for the current page
 *
 */
class side_content {

  private $widgets = array();

  public function __construct() {
    // register hooks
    add_filter('the_posts', array($this, 'the_page'));
    if($this->do_shortcodes()) {
      add_filter('side_content', 'do_shortcode');
    }
    global $wp_version;
    if(version_compare($wp_version, '2.7', '<')) {
      add_filter('whitelist_options',array($this,'alter_whitelist_options'));
    } else {
      add_action('admin_init', array($this, 'register_settings'));
    }
    add_action('admin_menu', array($this, 'register_admin_menu'));
    add_action('plugins_loaded', array($this, 'register_widgets'));
    add_action('add_meta_boxes', array($this, 'add_meta_boxes'));

    add_action('edit_post', array($this, 'save_widgets_value'));
    add_action('publish_post', array($this, 'save_widgets_value'));
    add_action('save_post', array($this, 'save_widgets_value'));
    add_action('edit_page_form', array($this, 'save_widgets_value'));
  }

  /*
  * WP 2.7+ settings registration
  */
  function register_settings() {
    register_setting('side_content-options', 'side_content_widgets');
    register_setting('side_content-options', 'side_content_for_posts', 'intval');
    register_setting('side_content-options', 'side_content_with_shortcodes', 'intval');
  }

  function alter_whitelist_options($whitelist) {
    if(is_array($whitelist)) {
      $option_array = array('side_content' => array('side_content_widgets','side_content_for_posts','side_content_with_shortcodes'));
      $whitelist = array_merge($whitelist,$option_array);
    }
    return $whitelist;
  }

  function add_meta_boxes() {
    add_meta_box('side-content', __ ('Side Content', 'side-content'),  array($this, 'show_editor'), 'page', 'normal', 'high');
    if($this->do_posts()) {
        add_meta_box('side-content', __ ('Side Content', 'side-content'),  array($this, 'show_editor'), 'post', 'normal', 'high');
    }
  }

  public function has_widgets($name=false) {
    if($name) {
      return isset($this->widgets[$name]);
    } else {
      return count($this->widgets) > 0;
    }
  }

  function do_posts() {
    return get_option('side_content_for_posts');
  }

  function do_shortcodes() {
    return get_option('side_content_with_shortcodes');
  }

  /**
   * If this is a page, process accordingly
   *
   * @param array $posts The posts to process
   * @return array
   */
  public function the_page($posts) {
    $do_posts = $this->do_posts();
    if(count($posts) == 1 && ($posts[0]->post_type == 'page' ||($do_posts && is_single()))) {
      $post = $posts[0];
      foreach ($this->widget_names() as $name) {
        $data = stripcslashes(get_post_meta($post->ID, $name, true));
        if($data) {
          $data = apply_filters('side_content', $data);
          $this->widgets[$name] = $data;
        }
      }
    }
    return $posts;
  }

  function widget($args) {
    extract($args);
    if(isset($this->widgets[$widget_name])) {
      print $before_widget;
      print $this->widgets[$widget_name];
      print $after_widget;
    }
  }

  function register_widgets() {
    $names = $this->widget_names();
    foreach ($names as $name) {
      $clean_name = sanitize_title_with_dashes($name);
      // because wp_list_widgets forces the callback to be unique
      $func = create_function('$args', '{the_side_content()->widget($args);}');
      wp_register_sidebar_widget($name, $name, $func, array('description'=>__('Side content widget').': '.$name, 'classname'=>$clean_name));
    }
  }

  function widget_names() {
    $names_option = get_option('side_content_widgets');
    return preg_split('/[\n\r]+/s', $names_option);
  }

  /**
   * Custom box on the post/page editor
   *
   */
  function show_editor() {
    global $post;
    if (is_object($post)) {
    	$id = $post->ID;
    } else {
      $id = false;
    }
    ?>

    <div id="side_content_editor">
    <table>
    <?php
    foreach ($this->widget_names() as $widget_name) {
      $clean_name = sanitize_title_with_dashes($widget_name);
      $input_id = 'side-content-'.$clean_name;
      $input_name = 'side-content['.htmlspecialchars($widget_name).']';
      $input_value = $id? stripcslashes(get_post_meta($id, $widget_name, true)):'';
      ?><tr>
      <th valign="top">
      <label for="<?php print $input_id ?>">Widget: <?php print $widget_name; ?></label>
      </th>
      <td valign="top">
      <textarea name="<?php print $input_name ?>" id="<?php print $input_id ?>" rows="7" cols="70"><?php print htmlspecialchars($input_value) ?></textarea>
      </td>
      </tr>
      <?php
    }
    ?>
    </table>
    </div>

<?php
  }

  function save_widgets_value($id) {
    if(isset($_POST['side-content']) && is_array($_POST['side-content']) ) {
      foreach ($this->widget_names() as $widget_name) {
        $value = $_POST['side-content'][$widget_name];
        delete_post_meta($id, $widget_name);
        if($value) {
          add_post_meta($id, $widget_name, $value);
        }
      }
    }
  }


  public function register_admin_menu() {
    add_options_page('Side Content', 'Side Content', 'manage_options', __FILE__, array($this, 'admin_options'));
  }

  public function admin_options() {
?>
<div class="wrap">
<h2>Side Content Widgets</h2>

<form method="post" action="options.php">
<?php
global $wp_version;
if(version_compare($wp_version, '2.7', '<')) {

  if(function_exists('wpmu_create_blog'))
  wp_nonce_field('side_content-options');
  else
  wp_nonce_field('update-options');
  ?>
  <input type="hidden" name="option_page" value="side_content" />
  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="page_options" value="side_content_widgets,side_content_for_posts,side_content_with_shortcodes" />
<?php
}
 else {
  settings_fields('side_content-options');
}
?>
<label ><p>Names for widgets (one per line)</p>
<textarea rows="4" cols="60" name="side_content_widgets"><?php echo get_option('side_content_widgets'); ?></textarea>
</label>
<label>
<p>Side content on posts as well as pages? <input type="checkbox" name="side_content_for_posts" value="1" <?php echo get_option('side_content_for_posts')? 'checked="checked"':''; ?>>
</p>
</label>
<label>
<p>Handle shortcodes in widgets? <input type="checkbox" name="side_content_with_shortcodes" value="1" <?php echo get_option('side_content_with_shortcodes')? 'checked="checked"':''; ?>>
</p>
</label>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>
<?php
  }
}

/**
 * Singleton access function for use elsewhere
 *
 * @return side_content
 */
function the_side_content() {
  static $instance = false;
  if(!$instance) {
    $instance = new side_content();
  }
  return $instance;
}

/**
 * Initialise
 */
the_side_content();