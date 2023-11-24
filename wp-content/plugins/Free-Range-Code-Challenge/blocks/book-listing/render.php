<?php
/**
 * Render the Book Listing Blocks.
 *
 * @package acf/book-listing
 */
//Retrieving all ACF fields for the current Post/Page ID
$fields = get_fields();
$heading = isset( $fields['heading'] ) ? sanitize_text_field($fields['heading']) : "";
$description = isset( $fields['description'] ) ? sanitize_text_field($fields['description']) : "";
$display_category = isset( $fields['display_categories']) ? sanitize_text_field($fields['display_categories']) : "";
$enable_search = isset( $fields['enable_search'] ) ? sanitize_text_field($fields['enable_search']) : "";
?>
<div class="book-list-section">
<?php
if( !empty( $heading ) ) {
    echo '<h3>'.esc_attr($heading).'</h3>';
}
if( !empty( $description ) ) {
    echo '<p>'.esc_attr($description).'</p>';
}
?>
    <div class="book-list-filters">
        <div class="book-list-search-section">
        <?php if( $enable_search || $display_category ) : ?>
        <form id="book-list-filters" method="POST">
            <input type="hidden" name="action" value="book_filter_results"  />
            <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('book_filter_results'); ?>" />
            <?php
            if( $enable_search ) {
                echo '<input class="rcc-text-input" type="text" name="search" value="" placeholder="Please enter 3 or more chars..."/>';
            }
            if( $display_category ) {
                //Feth the Book Categories
                $categories = get_categories('taxonomy=book-category&post_type=books');
                ?>
                <select id="rcc-book-categories" name="category" class="rcc-select">
                    <option value="-1">Select Category</option>
                    <?php foreach( $categories as $category ) : ?>
                        <option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            }
            ?>
            <input class="rcc-button" type="submit" id="book-filter" value="<?php _e( 'Filter', 'code-challenge' )?>" class="button" />
        </form>
        <?php endif; ?>
    </div>
    <div id="books-list" class="books-list">
    <table id="books-list-table">
        <thead>
            <tr>
                <th><?php _e( 'Book Name', 'code-challenge' ); ?></th>
                <th><?php _e( 'BookDescription', 'code-challenge' ); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $loop = new \WP_Query( array( 'post_type' => 'books', 'posts_per_page' => -1 ) ); ?>
        
        <?php while ( $loop->have_posts() ) : $loop->the_post(); 
            //Renders the Single Row with Book Title and ACF Book Description Data
            include RCC_PLUGIN_PATH."templates/partials/book-single-row.php";
        endwhile; ?>
        </tbody>
        
    </table>
    </div>
</div>
 
