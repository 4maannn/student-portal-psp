-- Run this on an existing psp_portal database (local or live) to add profile picture support
ALTER TABLE students ADD COLUMN profile_picture VARCHAR(255) NULL DEFAULT NULL AFTER marks;
