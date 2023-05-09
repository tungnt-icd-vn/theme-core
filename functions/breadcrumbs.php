<?php
/**
 * Generate HTML for a breadcrumb navigation
 *
 * @return void Outputs HTML directly to the page
 */
function get_breadcrumbs() {
  $breadcrumbs = [];
  $breadcrumbs[] = '<a href="'.home_url().'">学生インターンシップ2023 TOP</a>';
  if(is_singular('post')){
     $breadcrumbs[] = '<a href="'. home_url('news'). '">ニュースリリース</a>';
     $breadcrumbs[] = '<span>'. get_the_title() .'</span>';
    }
  else {
      $breadcrumbs[] = '<span>'. get_the_title() .'</span>';
    }

  $breadcrumb_list = '<li>' . implode('</li><li>', $breadcrumbs) . '</li>';

  echo '<ul class="breadcrumb">' . $breadcrumb_list . '</ul>';
}