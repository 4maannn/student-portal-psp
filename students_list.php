<?php

require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';

$model    = new StudentModel();
$students = $model->getAll();

include 'views/students/list.php';
