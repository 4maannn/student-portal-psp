<?php

require_once 'includes/session_check.php';
require_once 'models/StudentModel.php';
require_once 'includes/functions.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $model = new StudentModel();
    $model->delete($id);
}

redirect('students_list.php?deleted=1');
