<?php
  function bodyClass(){
    $type = get_post_type();
    $class = '';
    if($type === 'page' && is_front_page()){
      $class = 'top';
    }
    if($type === 'page' && is_page('expert')){
      $class = 'p-expert';
    }
    if($type === 'page' && is_page('company')){
      $class = 'p-company';
    }
    if($type === 'page' && is_page('kickoff')){
      $class = 'p-kickoff';
    }
    if($type === 'page' && is_page('experience')){
      $class = 'p-experience';
    }
    if($type === 'page' && is_page('sustainability')){
      $class = 'p-sustainability';
    }
    if($type === 'page' && is_page('measures')){
      $class = 'p-measures';
    }
    return body_class($class);
  }