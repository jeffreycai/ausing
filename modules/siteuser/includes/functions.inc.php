<?php
function require_permission($permissions) {
  if (!is_login()) {
    HTML::forward('users');
  } else if (has_permission($permissions)) {
    return true;
  } else {
    unauthorised_action();
  }
}

function require_role($roles) {
  if (!is_login()) {
    HTML::forward('users');
  } else if (has_role($roles)) {
    return true;
  } else {
    unauthorised_action();
  }
}

function require_login() {
  if (!is_login()) {
    HTML::forward('users');
  }
}

function has_permission($permissions) {
  $user = SiteUser::getCurrentUser();
  return $user->hasPermission($permissions);
}

function has_role($roles) {
  $user = SiteUser::getCurrentUser();
  return $user->hasRole($roles);
}

function is_login() {
  $user = SiteUser::getCurrentUser();
  return $user->getId() != -1;
}


function unauthorised_action() {
  HTML::forward('users/unauthorised');
}