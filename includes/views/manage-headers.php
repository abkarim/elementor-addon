<?php
/**
 * !Prevent direct access
 */
if (!defined("ABSPATH")) {
    exit();
}

/**
 * Manage access
 */
if (!current_user_can("manage_options")) {
    exit("sorry, you don't have permission to access this page");
}
