<?php

function sanitize($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Redirect helper
function redirect($url)
{
    header("Location: " . $url);
    exit();
}

// Server-side validation: marks must be numeric and within 0-100
function isValidMarks($marks)
{
    return is_numeric($marks) && $marks >= 0 && $marks <= 100;
}

// Server-side validation: basic Malaysian IC format check (12 digits)
function isValidIc($ic)
{
    return preg_match('/^\d{6}-?\d{2}-?\d{4}$/', $ic) === 1;
}

// ---------- Profile picture upload helpers (Mini Project 2) ----------

define('UPLOAD_DIR', __DIR__ . '/../uploads/profile/');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2MB

/**
 * Validate an uploaded profile picture.
 * Returns an error message string, or null when the file is valid.
 */
function validateProfilePicture($file)
{
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return "Please choose a picture to upload.";
    }
    if ($file['error'] === UPLOAD_ERR_INI_SIZE || $file['error'] === UPLOAD_ERR_FORM_SIZE) {
        return "File is too large. Maximum size is 2MB.";
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Upload failed. Please try again.";
    }
    if (!is_uploaded_file($file['tmp_name'])) {
        return "Invalid upload.";
    }

    // 1. File size: max 2MB
    if ($file['size'] > UPLOAD_MAX_SIZE) {
        return "File is too large. Maximum size is 2MB.";
    }

    // 2. File type: extension must be jpg / jpeg / png
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
        return "Only .jpg, .jpeg and .png files are allowed.";
    }

    // 3. Real content check: MIME type from file contents + must be a genuine image
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
    if (!in_array($mime, ['image/jpeg', 'image/png'], true) || @getimagesize($file['tmp_name']) === false) {
        return "The file is not a valid JPG or PNG image.";
    }

    return null;
}

/** Secure rename: unique name so files never overwrite each other and the original name is never trusted */
function generateUploadName($originalName)
{
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    return uniqid('pp_', true) . '.' . $ext;
}
