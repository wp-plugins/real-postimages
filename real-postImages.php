<?php
/*
Plugin Name: real.PostImages
Version: 1.1
Plugin URI:
Description: Дает возможность прикреплять дополнительные изображения к записям (в отдельной области, как дополнительное поле). <a href="https://wordpress.org/plugins/real-postimages/">English Description</a>
Author: Realist
Author URI:
Text Domain: realpostimages
Domain Path: /lng/
*/

$realpostimages = array(
  'plugin_file' => __FILE__,
  'plugin_path' => plugin_dir_path(__FILE__),
  'plugin_url'  => plugin_dir_url(__FILE__)
);

// Локализация
add_action('plugins_loaded', 'realpostimages_load_locale');
function realpostimages_load_locale() {
  if (defined('REALPOSTIMAGES_LOAD_LOCALE')) return;
  load_plugin_textdomain('realpostimages', false, dirname(plugin_basename(__FILE__)) . '/lng/');
  define('REALPOSTIMAGES_LOAD_LOCALE', true);
}

// Добавить дополнительную область картинок
add_action('admin_init', 'realpostimages_post_images');
function realpostimages_post_images()
{
  global $realpostimages;
  add_meta_box('realpostimages_post_images', __('Images', 'realpostimages'), 'realpostimages_post_images_content', 'post', 'normal', 'high');
}
function realpostimages_post_images_content()
{

  global $post, $realpostimages;

  wp_enqueue_media(array('post' => $post->ID));

  // CSS
  wp_register_style('realpostimages_images', $realpostimages['plugin_url'] . 'css/images.css');
  wp_enqueue_style('realpostimages_images');

  // JS
  wp_register_script('realpostimages_images', $realpostimages['plugin_url'] . 'js/images.js', array('jquery'));
  wp_enqueue_script('realpostimages_images');

  require_once $realpostimages['plugin_path'] . 'tpl/images.php';

}

// Сохранить картинки
add_action('save_post', 'realpostimages_save_meta_images');
function realpostimages_save_meta_images($post_id) {
  $data = array();
  if (isset($_POST['realpostimages_images'])) {
    foreach ($_POST['realpostimages_images'] as $id => $str) {
      $json = json_decode(urldecode($str));
      $data[$id] = real_object_to_array($json);
    }
  }
  update_post_meta($post_id, 'realpostimages_post_images', $data);
}

// Формирует массив с информацией об изображениях записи
function get_post_images($post_id = false)
{
  global $post;
  $post_id = ($post_id) ? $post_id : $post->ID;
  $pre = get_post_meta($post_id, 'realpostimages_post_images');
  if ($pre !== false and isset($pre[0])) {
    foreach ($pre[0] as $id => $data) {
      $r[$id] = $data;
    }
  }
  return (isset($r)) ? $r : '';
}

// real.Donate
if (!function_exists('real_add_real_page')) {
  add_action('admin_menu', 'real_add_real_page');
  function real_add_real_page() {
    add_menu_page('real.', 'real.', 'manage_options', 'real', 'real_donate_page', 'dashicons-businessman');
  }
  function real_donate_page() {
    global $realkit;
    require_once $realkit['plugin_dir_path'] . 'tpl/real.php';
  }
}

if (!function_exists('real_object_to_array')) {
  function real_object_to_array($data)
  {
    if (is_array($data) || is_object($data)) {
      $result = array();
      foreach ($data as $key => $value) {
        $result[$key] = real_object_to_array($value);
      }
      return $result;
    }
    return $data;
  }
}