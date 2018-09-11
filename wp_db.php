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
