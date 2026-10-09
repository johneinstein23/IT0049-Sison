<?php

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

use CodeIgniter\Boot;
use Config\Paths;

require FCPATH . '../vendor/autoload.php';

// Location of the framework's Paths config file.
$paths = new Paths();

require rtrim($paths->systemDirectory, '\\/') . DIRECTORY_SEPARATOR . 'Boot.php';

exit(Boot::bootWeb($paths));
