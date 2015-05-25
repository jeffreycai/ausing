<?php
  //-- Project:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "project") {
      echo " - Drop table 'project' ";
      echo Project::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Project:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "project") ) {
  //- create tables if not exits
  echo " - Create table 'project' ";
  echo Project::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  