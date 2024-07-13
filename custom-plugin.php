<?php
/*
* Plugin Name: Custom Plugin
* Author: WebShooters
* Plugin URI: https://wordpress.org/plugins/
* Description: This is my first plugin!
* Version: 1.0
*/

// Hook to activate the plugin
register_activation_hook(__FILE__, 'myfirstplugin_create_table');

// Function to create the table
function myfirstplugin_create_table() {
    global $wpdb;

    // Use the specific table name
    $table_name = $wpdb->prefix . 'register';
    // Uncomment the line below for debugging purposes, then comment or remove it after debugging
    // echo 'Creating table: ' . $table_name; 

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email text NOT NULL,
        mobile text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Hook to admin menu action
add_action('admin_menu', 'myfirstplugin');

// Function to add menu and sub-menu pages
function myfirstplugin() {
    add_menu_page(
        'Websitemakerking', // Page title
        'WMK My First Plugin', // Menu title
        'administrator', // Capability
        'ankit', // Menu slug
        'custom_plugin_page', // Function to display the page content
        'dashicons-admin-tools', // Menu icon
        10 // Position
    );

    add_submenu_page(
        'ankit', // Parent slug
        'Sub Menu Page', // Page title
        'Sub Menu', // Sub-menu title
        'administrator', // Capability
        'sub-menu-slug', // Sub-menu slug
        'custom_sub_menu_page' // Function to display the sub-menu page content
    );
}

// Function to display the content of the main admin page
function custom_plugin_page() {
    echo '<div class="wrap">';
    echo '<h1>Thank you for making a custom plugin. Please add some more features.</h1>';
    echo '<h1>My email ID: ankit.pan99@gmail.com</h1>';
    
    global $wpdb;
    // Use the specific table name
    $table_name =  'register';
    echo '<h3>Table Name: ' . htmlspecialchars($table_name) . '</h3>'; // Echo the table name for debugging
    
    echo <<<HTML
    <div class="formset">
        <form method="post">
            <label>Name:</label><br>
            <input type="text" name="name" required><br>
            <label>Email ID:</label><br>
            <input type="email" name="email" required><br>
            <label>Mobile No.:</label><br>
            <input type="text" name="Mobile" required><br>
            <input type="submit" name="save" value="Submit">
        </form>
    </div>
HTML;

    if (isset($_POST['save'])) {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $mobile = sanitize_text_field($_POST['Mobile']);

        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
            )
        );

        echo "<script>alert('Data inserted into wpdb');</script>";
    }

    echo '</div>';

    // Fetch data from the database
    $results = $wpdb->get_results("SELECT * FROM $table_name");

    echo "<table border='2'>
          <tr>
          <th>uid</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile</th>
          <th>Edit</th>
          <th>Delete</th>
          </tr>";

    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row->uid) . "</td>";
        echo "<td>" . htmlspecialchars($row->name) . "</td>";
        echo "<td>" . htmlspecialchars($row->email) . "</td>";
        echo "<td>" . htmlspecialchars($row->mobile) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Function to display the content of the sub-menu page
function custom_sub_menu_page() {
    echo '<div class="wrap">';
    echo '<h1>This is the Sub Menu Page</h1>';
    echo '<p>Here you can add more features and options.</p>';
    echo '</div>';




    echo <<<HTML
    <div class="formset">
        <form method="post">
            <label>Name:</label><br>
            <input type="text" name="name" required><br>
            <label>Email ID:</label><br>
            <input type="email" name="email" required><br>
            <label>Mobile No.:</label><br>
            <input type="text" name="Mobile" required><br>
            <input type="submit" name="save" value="Submit">
        </form>
    </div>
HTML;
}

?>
