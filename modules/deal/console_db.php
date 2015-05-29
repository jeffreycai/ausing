<?php
  //-- Deal:Clear cache
  if ($command == "cc") {
    if ($arg1 == "all" || $arg1 == "deal") {
      echo " - Drop table 'deal' ";
      echo Deal::dropTable() ? "success\n" : "fail\n";
    }
  }

  //-- Deal:Import DB
  if ($command == "import" && $arg1 == "db" && (is_null($arg2) || $arg2 == "deal") ) {
  //- create tables if not exits
  echo " - Create table 'deal' ";
  echo Deal::createTableIfNotExist() ? "success\n" : "fail\n";
  }
  