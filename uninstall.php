<?php



if (!defined('WP_UNINSTALL_PLUGIN'))
{
    die;
}

if (!defined('ABSPATH'))
{
    die;
}

if (! function_exists('add_action'))
{
    die;
}
// Clear database stored date. Wow I am against this but if the user is uninstalling
//$books = get_posts(array('post_type'=>'book', 'numberposts' => -1));
//foreach($books as $book)
//{
//    wp_delete_post($book->ID,true);
//}


//access the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE post_id NOT IN (SELECT id FROM wp_posts)");

//test

