<?php

require 'config/dbconfig.php';
require 'config/globals.php';
require 'config/personal.php';

require 'libs/database.php';
require 'libs/session.php';

require 'libs/bootstrap.php';
require 'libs/controller.php';
require 'libs/model.php';
require 'libs/view.php';

$app = new Bootstrap;