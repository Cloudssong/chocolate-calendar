<?php
/**
 * trigger this file on Plugin uninstall
 * 
 * @package GetMeta
 */

 if (! defined('WP_UNINSTALL_PLUGIN')) {
     die;
 }

/*  // Clear database stored data
 $books = get_posts(array('post_type' => 'book', 'numberposts' => -1));

 foreach($books as $book) {
     wp_delete_posts($book->ID, true);
 } */

 //Access the database via SQL
 global $wpdb;
 $wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'book" );
 $wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" )
 $wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" )

 ?>
 <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolores, sit. Pariatur explicabo asperiores molestiae possimus quas impedit, ipsum dolore officiis neque omnis sequi, odio est quis aut magnam expedita distinctio, enim nesciunt praesentium? Veniam porro tempore voluptatem error quos illum debitis nisi numquam ex iusto optio ratione voluptates distinctio explicabo dolorum architecto, necessitatibus adipisci odit esse quas dolores maiores eveniet laboriosam? Repudiandae, quis possimus itaque nobis perferendis excepturi quia obcaecati assumenda soluta dolorum, facere fugiat dolore enim! Eum, mollitia? Voluptas debitis exercitationem nemo quia maiores inventore, aliquid facere saepe tempore culpa expedita dicta facilis voluptates in recusandae obcaecati laboriosam laborum.</p>