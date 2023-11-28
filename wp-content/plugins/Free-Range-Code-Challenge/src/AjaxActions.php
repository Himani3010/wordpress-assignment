<?php
namespace CODE_CHALLENGE;
use CODE_CHALLENGE\Traits\Ajax;
/**
 *  Core AjaxActions
 *
 *  Core functioanlity for ACF Book Listing Block
 *
 *  @since 1.0.0
 *
 */
class AjaxActions {
    use Ajax;

    public function __construct() {
        //For Authenticated Users
        add_action( 'wp_ajax_book_filter_results', [ $this, 'render_book_filter_results' ] );
        //For Not Loggedin Users
        add_action( 'wp_ajax_nopriv_book_filter_results', [ $this, 'render_book_filter_results' ] );

    }

    /**
     * Process Filters and Render Book Results
     * 
     * @since v1.0.0
     */
    public function render_book_filter_results() {
        
        $action = isset( $_GET["action"] ) ? sanitize_text_field( $_GET["action"] ) : "";
        //Verifying the nonce 
        $this->verify_nonce( $action );
        $args = array(
            'post_type'         => 'books',
            'posts_per_page'    =>   -1,
            'post_status'       =>  'publish'
            
        );
        $search = isset( $_GET["search"] ) ? sanitize_text_field( $_GET["search"] ) : "";
        $category = isset( $_GET["category"] ) ? sanitize_text_field( $_GET["category"] ) : "";
        if( $search ) {
            $args['s']          = $search;
        }
        
        if( $category && $category != -1 ) {
            $args['tax_query']  =   array(
                array(
                    'taxonomy'  =>  'book-category',
                    'field'     =>  'term_id',
                    'operator'  =>  'IN',
                    'terms'     =>  array($category)
                )
            );
        }
        /**
         * Fetching the Books that matches the Search term in title, 
         * post_content or post_excer[t and Category]
         */
        $query1 = new \WP_Query( $args );

        $merge = false;
        if( $search ) {
            $merge = true;
            unset($args['s']);
            
            /**
             * Fetches the Books that matches the search term 
             * in custom field book_description
             */

            $args['meta_query'] = array(
                array(
                    'key'       =>  'book_description',
                    'value'     =>  $search,
                    'compare'   =>  'LIKE'
                )
            );
            $query2 = new \WP_Query($args);
        }
        if( $merge) {
        $loop = new \WP_Query();
        $loop->posts = array_merge( $query1->posts, $query2->posts );
        $loop->post_count = $query1->post_count + $query2->post_count;
        } else {
            $loop = new \WP_Query();
            $loop->posts = $query1->posts;
            $loop->post_count = $query1->post_count;
        }
        if( $loop->have_posts() ) :
        ob_start();
        while ( $loop->have_posts() ) : $loop->the_post(); 
        
        include RCC_PLUGIN_PATH."templates/partials/book-single-row.php";
        
        endwhile;
        $return = ob_get_clean();
        else:
        $return = '<tr colspan="2"><td>'.__( 'No results found', 'code-challenge' ).'</td></tr>';
        endif;
        
        $this->send_success($return);
        wp_die();
    }
}
