<?php
namespace GrassrootsSelect\Models;

class AbstractModel {
  public $post;
  public $featuredImage;

  public function __construct($post) {
    if (is_object($post)) {
      $this->post = $post;
    } else {
      $this->post = get_post($post);
    }

    if (has_post_thumbnail($this->post->ID)) {
      $image = wp_get_attachment_image_src(get_post_thumbnail_id($this->post->ID));
      $this->featuredImage = $image[0];
    }
  }

  public function getTitle() {
    return apply_filters('the_title', $this->post->post_title);
  }

  public function getContent(){
    return apply_filters('the_content', $this->post->post_content);
  }

  public function getPermalink() {
    return get_permalink($this->post->ID);
  }

  public function getID() {
    return $this->post->ID;
  }
}
