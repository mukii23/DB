/***********
***** Start SQL Queries *****
***********/
global $wpdb, $table_prefix;
$table_name = $table_prefix . 'table_name';
$charset_collate = $wpdb->get_charset_collate();

$sql = "CREATE TABLE IF NOT EXISTS ".$table_name."(
                    id int(9) NOT NULL AUTO_INCREMENT,
                    name varchar(40) NOT NULL,
                    email varchar(50) NOT NULL,
                    search_term text NOT NULL,
                    PRIMARY KEY(id))
                    ".$charset_collate."";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql); //Use to create new table in database

$wpdb->get_results("sql_syntax"); //Use SQL query to get result

$wpdb->query(
                  'DELETE  FROM '.$table_name.'
                   WHERE id = "'.$delIds.'"'
                ); //Use SQL query to delete from particular table

$wpdb->update($table_name , array('user_name' => $user_name, 'post_id' =>$postID, 'time' => $visittime),array('%s','%d', '%d') ); //Use SQL query to update table

/***********
***** CREATE WP-Pagination using SQL Query *****
***********/
global $wpdb, $max_num_pages, $paged;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$post_per_page = 10;
$offset = ($paged - 1) * $post_per_page;

$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $table LIMIT $offset, $post_per_page";
$result = $wpdb->get_results($query);
$sql_posts_total = $wpdb->get_var( "SELECT FOUND_ROWS();" );
$max_num_pages = ceil($sql_posts_total / $post_per_page);

<div class="navigation">
     <div class="previous panel"><?php previous_posts_link('&laquo; Prev', $max_num_pages) ?></div>
     <div class="next panel"><?php next_posts_link('Next &raquo;', $max_num_pages) ?></div>
</div>



/**********
***** JOIN Query in wordpress. This was getting values based on 'tag id' and 'search item' *****
*********/

 $query2 = "SELECT * FROM wp_terms t"
            . " INNER JOIN wp_term_relationships r ON t.term_id = r.term_taxonomy_id "
            . " INNER JOIN wp_postmeta pm ON r.object_id = pm.post_id "
            . " WHERE ".$tagID." = t.term_id "
            . " AND pm.meta_key = 'wpcf-speciality' "
            . " AND t.name LIKE '%".$search_term."%' OR pm.meta_value LIKE '%".$search_term."%' ";


/***
***CREATE WORDPRESS-USER USING 'phpmyadmin'
***/

INSERT INTO `wp_users` (`user_login`, `user_pass`, `user_nicename`, `user_email`, `user_status`)
VALUES ('newadmin', MD5('pass123'), 'firstname lastname', 'email@example.com', '0');

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
VALUES (NULL, (Select max(id) FROM wp_users), 'wp_capabilities', 'a:1:{s:13:"administrator";s:1:"1";}');

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) 
VALUES (NULL, (Select max(id) FROM wp_users), 'wp_user_level', '10');
