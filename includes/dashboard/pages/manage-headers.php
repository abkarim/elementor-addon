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

$new_post = [
    "post_title" => "created with code",
    "post_content" => "",
    "post_status" => "publish", // Set the post status to 'publish' or 'draft' as needed
    "post_type" => \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN . "-post", // Set the post type to 'post' or any other custom post type you have defined
];

$post_id = wp_insert_post($new_post); // Insert the post into the database

if ($post_id) {
    // Post created successfully
    // You can perform additional tasks here, like setting categories or tags
    echo $post_id;
} else {
    echo "failed";
    // Error in creating the post
}
?>

<h1 class="<?php echo \Elementor_Addon\Plugin::PLUGIN_TEXT_DOMAIN .
    "--inline-block"; ?>">
    <?php echo get_admin_page_title(); ?> 
</h1>&nbsp;
<button type="button" role="button">add new</button>
<hr>

<?php require_once ELEMENTOR_ADDON_PLUGIN_PATH .
    "/includes/classes/HeaderListTable.php"; ?>
  <div class="wrap">
      <div id="icon-users" class="icon32"></div>
      <h2>Headers</h2>
  </div>