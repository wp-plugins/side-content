<?php
/*
Plugin Name: Side Content
Plugin URI: http://likemind.co.uk/wordpress-side-content-plugin
Description: Creates sidebar widgets specific to a page.
Author: Alfred Armstrong, Likemind Web Services

Version: 0.2
Author URI: http://likemind.co.uk
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
    add_action('admin_menu', array($this, 'register_admin_menu'));
    add_action('plugins_loaded', array($this, 'register_widgets'));
  }

  public function has_widgets($name=false) {
    if($name) {
      return isset($this->widgets[$name]);
    } else {
      return count($this->widgets) > 0;
    }
  }


  /**
   * If this is a page, process accordingly
   *
   * @param array $posts The posts to process
   * @return array
   */
  public function the_page($posts) {
    if(count($posts) == 1 && $posts[0]->post_type == 'page') {
      $post = $posts[0];
      foreach ($this->widget_names() as $name) {
        $data = get_post_custom_values($name, $post->ID);
        if($data) {
          $this->widgets[$name] = array_pop($data);
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
      wp_register_sidebar_widget($name, $name, array($this, 'widget'), array('description'=>__('Side content widget').': '.$name, 'classname'=>$clean_name));
    }
  }

  function widget_names() {
    $names_option = get_option('side_content_widgets');
    return preg_split('/[\n\r]+/s', $names_option);
  }


  public function register_admin_menu() {
    add_options_page('Side Content', 'Side Content', 'manage_options', __FILE__, array($this, 'admin_options'));
  }

  public function admin_options() {
?>
<div class="wrap">
<h2>Side Content Widgets</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>
<label ><p>Names for widgets (one per line)</p>
<textarea rows="4" cols="60" name="side_content_widgets"><?php echo get_option('side_content_widgets'); ?></textarea>
</label>
<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="side_content_widgets" />

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