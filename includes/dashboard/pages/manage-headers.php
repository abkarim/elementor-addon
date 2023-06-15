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
?>

<h1 class="<?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
    "--inline-block"; ?>">
    <?php echo get_admin_page_title(); ?> 
</h1>&nbsp;
<button type="button" role="button">add new</button>
<hr>

<?php
require_once ELEMENTOR_ADDON_PLUGIN_PATH . "/includes/classes/ListTable.php";

$headers_list = new \Elementor_Addon\List_Table();

