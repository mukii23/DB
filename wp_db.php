/**********
***** JOIN Query in wordpress. This was getting values based on 'tag id' and 'search item' *****
*********/

 $query2 = "SELECT * FROM wp_terms t"
            . " INNER JOIN wp_term_relationships r ON t.term_id = r.term_taxonomy_id "
            . " INNER JOIN wp_postmeta pm ON r.object_id = pm.post_id "
            . " WHERE ".$tagID." = t.term_id "
            . " AND pm.meta_key = 'wpcf-speciality' "
            . " AND t.name LIKE '%".$search_term."%' OR pm.meta_value LIKE '%".$search_term."%' ";
