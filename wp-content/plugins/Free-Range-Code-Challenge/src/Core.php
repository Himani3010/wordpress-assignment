<?php
namespace CODE_CHALLENGE;
/**
 *  Core Class
 *
 *  Core functioanlity for ACF Book Listing Block
 *
 *  @since 1.0.0
 *
 */
class Core {
   
   public function __construct() {

		//Saves the ACF json into custom path.
		add_filter( 'acf/settings/save_json', [ $this, 'rcc_acf_field_group_save_folder' ] );
		//Custom Load Point for ACF JSON files
		add_filter( 'acf/settings/load_json', [ $this, 'rcc_acf_load_point' ] );
		//Creates CPT and Custom Taxonomy
		add_action( 'init', [ $this, 'initialize' ], 10 );
		//Registers Book Listing ACF Block
		add_action( 'init', [ $this, 'register_acf_blocks' ] );
		//Enqueue JS file to achieve filter and search results
		add_action( 'enqueue_block_assets', [ $this, 'render_frontend_assets' ] );

   }

   /**
	* Saves ACF JSON Files inside Plugin folders so that it can be used across multiple instances
	*
	* @since v1.0.0
	*/
   public function rcc_acf_field_group_save_folder( $path ) {
		return RCC_PLUGIN_PATH.'acf-json';
   }

   /**
	* Render Custom ACF JSON Point
	*
	* @param array $paths
	* @return array
	* @since v1.0.0
	*/
	public function rcc_acf_load_point( $paths ){
		//Resetting the existing Path Array
		unset( $paths );
		$paths[] = RCC_PLUGIN_PATH.'acf-json';
		return $paths;
	} 


   /**
	* Creates Custom Post Type Books & Custom Taxonomy Boo Category
	*
	* @since v1.0.0
	*/
   public function initialize() {
	  // set up product labels
	  $labels = array(
		 'name' => __( 'Books', 'code-challenge'),
		 'singular_name' => __( 'Book', 'code-challenge'),
		 'add_new' => __( 'Add New Book', 'code-challenge'),
		 'add_new_item' => __( 'Add New Book', 'code-challenge'),
		 'edit_item' => __( 'Edit Book', 'code-challenge'),
		 'new_item' => __( 'New Book', 'code-challenge'),
		 'all_items' => 'All Books',
		 'view_item' => 'View Book',
		 'search_items' => 'Search Books',
		 'not_found' =>  'No Books Found',
		 'not_found_in_trash' => 'No Books found in Trash', 
		 'parent_item_colon' => '',
		 'menu_name' => 'Books',
	  );
   
	  // register post type
	  $args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => 'books'),
			'query_var' => true,
			'menu_icon' => 'dashicons-book',
			'supports' => array(
			   'title',
			   'editor',
			   'excerpt',
			   'trackbacks',
			   'custom-fields',
			   'comments',
			   'revisions',
			   'thumbnail',
			   'author',
			   'page-attributes'
			)
	  );
	  register_post_type( 'books', $args );
	  
	  // register taxonomy Book Category
	  register_taxonomy('book-category', 'books', array('hierarchical' => true, 'label' => 'Book Category', 'query_var' => true, 'rewrite' => array( 'slug' => 'book-category' )));

   }

   /**
	* [Not Recommended since 6.0]
	* Register Book Listing ACF Block 
	*/
	public function register_acf_book_list_block() {

	  if( function_exists( 'acf_register_block_type' ) ) {
		 acf_register_block_type(array(
			'name'              => 'books listing',
			'title'             => __(' Books Listing', 'code-challenge' ),
			'description'       => __('A custom block that displays list of books with Category and Search Filter.'),
			'render_template'   => RCC_PLUGIN_PATH . 'blocks/book-listing/render.php', // a template file for the block code
			'category'          => 'theme',
			'icon'              => 'book',
			'keywords'          => array( 'book lists', 'books' ),
		  ));
	  }
	}

	/**
	 * Register ACF Blocks with the new block.json syntax rather than the legacy acf_register_block_type
	 * 
	 * @since verion 1.0
	 */
	public function register_acf_blocks() {
		register_block_type( RCC_PLUGIN_PATH.'blocks/book-listing' );
	}

	/**
	 * Load Assets in Frontend
	 * 
	 * @since v1.0.0 
	 *
	 */ 
	public function render_frontend_assets() {
		//Load JS and Local variable data only if Book Listing Block is present
		if( has_block( 'acf/book-listing' ) ) {
			wp_enqueue_script('jquery');
			wp_enqueue_script(
				'book-listing',
				RCC_PLUGIN_URL.'/blocks/book-listing/script.js',
				array('jquery'),
				'1.0',
				false
			);
			wp_localize_script(
				'book-listing',
				'rcc',
				[
					'ajaxUrl'	=>	admin_url('admin-ajax.php'),
					'loaderUrl'=>  RCC_PLUGIN_URL.'/assets/loader.gif'
				]
			);
		}
	}


}