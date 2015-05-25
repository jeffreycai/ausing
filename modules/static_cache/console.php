<?php

//-- Clear static cache
if ($command == 'cc') {
  shell_exec("rm -rf " . STATIC_CACHE_ROOT . DS . "*" );
  echo " - static cache clear excecuted\n";
}