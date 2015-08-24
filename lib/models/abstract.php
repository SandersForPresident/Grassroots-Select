<?php
namespace GrassrootsSelect\Models;

class AbstractModel {
  public $post;

  public function __construct($post) {
    if (is_object($post)) {
      $this->post = $post;
    } else {
      $this->post = get_post($post);
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
}
