<?php
function register_je_menu_page(){
    add_menu_page( 'JE Theme', 'JE Theme', 'manage_options', 'je_theme', 'je_theme_setting', get_template_directory_uri() . '/img/wvi-logo.png', 6 );
}
add_action( 'admin_menu', 'register_je_menu_page' );

function register_je_theme_setting(){
    register_setting('je_theme_setting', 'hot_items_1');
}
add_action('admin_init', 'register_je_theme_setting');


function je_theme_setting(){
?>

    <form id="jeThemeSetting" method="post" action="options.php">
        <table class="form-table">

            <tr valign="top">
                <th scope="row">Maximum 'Item Left in Stock' to display information:</th>
                <td><input type="text" name="maximumItemLeftInStock"></td>
            </tr>
        </table>
        <div class="submit" style="float:left;">
            <input name="submit" id="submit" class="button button-primary" value="Save Changes" type="button"/>
            <div class="spinner"></div>
        </div>
    </form>
    <script src="<?php echo get_template_directory_uri() . '/js/admin-menu.js'?>"></script>

<?php

}

//START ajax call
function update_je_theme_setting(){
    $maximumItemLeftInStock = $_GET['maximumItemLeftInStock'];
    update_option( 'maximumItemLeftInStock', $maximumItemLeftInStock );
};
add_action('wp_ajax_update_je_theme_setting', 'update_je_theme_setting');
