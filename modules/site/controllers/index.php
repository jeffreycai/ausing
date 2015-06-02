<?php
// mobile redirect
if (!is_mobile()) {
  dispatch('site/desktop/index');
  exit;
} else {
  HTML::forward('m');
}

