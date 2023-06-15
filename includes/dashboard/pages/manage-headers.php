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
require_once ELEMENTOR_ADDON_PLUGIN_PATH .
    "/includes/classes/HeaderListTable.php";

$table = new \Elementor_Addon\Header_List_Table();
?>
  <div class="wrap">
      <div id="icon-users" class="icon32"></div>
      <h2>Headers</h2>
      <?php $table->display(); ?>
  </div>