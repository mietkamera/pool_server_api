<?php

require 'config/dbconfig.php';
require 'config/globals.php';
require 'config/personal.php';

require 'libs/database.php';
require 'libs/clientsession.php';

require 'libs/bootstrap.php';
require 'libs/controller.php';
require 'libs/model.php';
require 'libs/view.php';
require 'libs/helpers.php';

$app = new Bootstrap;