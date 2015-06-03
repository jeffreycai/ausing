<?php
/**
 * function to cache the page as static file when php execution ends
 */
register_shutdown_function('buffer_flush');
function buffer_flush() {
  global $static_cache_enabled;
  $settings = Vars::getSettings();
  
  if (ENV == 'prod' && $static_cache_enabled && PHP_SAPI != 'cli') {

    $content = ob_get_clean();
    

    $relative_uri;
    if ($settings['i18n']) {
      $relative_uri = get_request_uri_relative();
    } else {
      $relative_uri = str_replace(get_sub_root(), '', get_request_uri());
    }
    foreach ($settings['routing'] as $route) {
      $path = $route['path'];
      $isSecure = $route['isSecure'];
      $controller = $route['controller'];
      $i18n = $route['i18n'];
      $cache_time = isset($route['static_cache']) ? $route['static_cache'] : null;

      $user = User::getInstance();
      if (preg_match('/'.$path.'/', $relative_uri)) {
        // redirect to lang url if lang code is not here
        if ($i18n && $settings['i18n']) {
          HTML::redirectToI18nUrl();
        }

        if ($isSecure && !$user->isLogin()) {
          dispatch('core/login');
          echo $content;
          exit;
        } else {

          // we only cache content that is not empty and set to be cached
          if (!empty($content) && $cache_time) {
            $url = get_request_uri(false);
            $filename = make_cache_filename($url);
            file_put_contents(STATIC_CACHE_ROOT . DS . $filename . '_' . (time() + $cache_time) . ".php", $content);
            echo $content;
          } else if (!empty($content)) {
            echo $content;
          }
          
        }
        exit;
      } else {
        echo $content;
      }
    }
    

  }
}

function make_cache_filename($name) {
  return md5($name);
}
