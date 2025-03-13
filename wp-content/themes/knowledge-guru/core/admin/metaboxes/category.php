<?php

/**
 * Save category meta
 *
 * Callback function to save category meta data
 *
 * @since  1.0
 */

add_action( 'edited_category', 'kbg_save_category_meta_fields', 10, 2 );
add_action( 'create_category', 'kbg_save_category_meta_fields', 10, 2 );

if ( !function_exists( 'kbg_save_category_meta_fields' ) ) :
	function kbg_save_category_meta_fields( $term_id ) {

		if ( isset( $_POST['kbg'] ) ) {

			$meta = array();

			if ( isset( $_POST['kbg']['image'] ) ) {
				$meta['image'] = $_POST['kbg']['image'];
			}

			if ( isset( $_POST['kbg']['settings'] ) ) {
				$meta['settings'] = $_POST['kbg']['settings'];

				if ( $_POST['kbg']['settings'] == 'custom' ) {

					if ( isset( $_POST['kbg']['layout'] ) ) {
						$meta['layout'] = $_POST['kbg']['layout'];
					}

					if ( isset( $_POST['kbg']['loop'] ) ) {
						$meta['loop'] = $_POST['kbg']['loop'];
					}

					if ( isset( $_POST['kbg']['pagination'] ) ) {
						$meta['pagination'] = $_POST['kbg']['pagination'];
					}

					if ( isset( $_POST['kbg']['ppp_num'] ) ) {
						$meta['ppp_num'] = absint( $_POST['kbg']['ppp_num'] );
					}

					if ( isset( $_POST['kbg']['sidebar'] ) ) {
						$meta['sidebar'] = $_POST['kbg']['sidebar'];
					}

					if ( isset( $_POST['kbg']['sidebar_enabled'] ) ) {
						$meta['sidebar_enabled'] = $_POST['kbg']['sidebar_enabled'];
					}
				}

			}


			if ( !empty( $meta ) ) {
				update_term_meta( $term_id, '_kbg_meta', $meta );
			} else {
				delete_term_meta( $term_id, '_kbg_meta' );
			}

		}

	}
endif;


/**
 * Add category meta
 *
 * Callback function to load category meta fields on "new category" screen
 *
 * @since  1.0
 */

add_action( 'category_add_form_fields', 'kbg_category_add_meta_fields', 10, 2 );

if ( !function_exists( 'kbg_category_add_meta_fields' ) ) :
	function kbg_category_add_meta_fields() {
		$meta = kbg_get_category_meta();
		$loops = kbg_get_post_layouts();

		$layouts = kbg_get_archive_layouts();
		$paginations = kbg_get_pagination_layouts();
		$sidebar_layouts = kbg_get_sidebar_layouts();
		$sidebars = kbg_get_sidebars_list();
		?>
        <div class="form-field kbg-opt-display">
            <label><?php esc_html_e( 'Display settings', 'knowledge-guru' ); ?></label>
            <label>
                <input type="radio" class="kbg-settings-type" name="kbg[settings]" value="inherit" <?php checked( $meta['settings'], 'inherit' ); ?>>
				<?php esc_html_e( 'Inherit from Category theme options', 'knowledge-guru' ); ?>
            </label>
            <label>
                <input type="radio" name="kbg[settings]" value="custom" <?php checked( $meta['settings'], 'custom' ); ?>>
				<?php esc_html_e( 'Customize', 'knowledge-guru' ); ?>
            </label>

        </div>

        <?php $class = $meta['settings'] == 'custom' ? '' : 'kbg-hidden'; ?>

        <div class="form-field kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">

			<label><?php esc_html_e( 'Template layout', 'knowledge-guru' ); ?></label>

		    <p>
		    	<ul class="kbg-img-select-wrap">
				  	<?php foreach ( $layouts as $id => $layout ): ?>
				  		<li>
				  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['layout'], 'selected' ) ); ?>">
				  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
				  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[layout]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['layout'] );?>/>
				  		</li>
				  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'knowledge-guru' ); ?></small>
		    </p>

	    </div>

        <div class="form-field kbg-opt-layouts kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">

			<label><?php esc_html_e( 'Posts layout', 'knowledge-guru' ); ?></label>

		    <p>
		    	<ul class="kbg-img-select-wrap">
				  	<?php foreach ( $loops as $id => $layout ): ?>
				  		<li>
				  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['loop'], 'selected' ) ); ?>" data-sidebar="<?php echo absint( kbg_loop_has_sidebar($id, 'podcast' ) ); ?>">
				  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
				  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[loop]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['loop'] );?>/>
				  		</li>
				  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'knowledge-guru' ); ?></small>
		    </p>

	    </div>

	    <div class="form-field kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<label><?php esc_html_e( 'Post per page', 'knowledge-guru' ); ?></label>
		    <p>
		  		<input type="number" class="kbg-count-me small-text" name="kbg[ppp_num]" value="<?php echo absint( $meta['ppp_num'] ); ?>"/>
		    </p>
        </div>

		<?php $sidebar_class = kbg_loop_has_sidebar( $meta['loop'], 'podcast' ) ? '' : 'kbg-opt-disabled'; ?>
		
		<tr class="form-field kbg-opt-sidebar <?php echo esc_attr( $sidebar_class ); ?> kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
		
			<th scope="row" valign="top">
                <?php esc_html_e( 'Enable Sidebar', 'knowledge-guru' ); ?>
			</th>
			<td>
				<input type="hidden" class="kbg-hidden" name="kbg[sidebar_enabled]" value="0"/>
				<input type="checkbox" class="kbg-count-me" name="kbg[sidebar_enabled]" value="1" <?php checked( $meta['sidebar_enabled'], 1 );?>/>
			</td>

		</tr>

        <div class="form-field kbg-opt-sidebar <?php echo esc_attr( $sidebar_class ); ?> kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<label><?php esc_html_e( 'Sidebar', 'knowledge-guru' ); ?></label>
			    <p>
			    	<ul class="kbg-img-select-wrap">
					  	<?php foreach ( $sidebar_layouts as $id => $layout ): ?>
					  		<li>
					  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['sidebar']['position'], 'selected' ) ); ?>">
					  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
					  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[sidebar][position]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['sidebar']['position'] );?>/>
					  		</li>
					  	<?php endforeach; ?>
			    	</ul>
			    	<small class="howto"><?php esc_html_e( 'Choose sidebar position', 'knowledge-guru' ); ?></small>
			    	<br/>
			    </p>

			    <p>
				    <select name="kbg[sidebar][classic]" class="kbg-count-me">
					  	<?php foreach ( $sidebars as $id => $sidebar ): ?>
					  		<option class="kbg-count-me" value="<?php echo esc_attr( $id ); ?>" <?php selected( $id, $meta['sidebar']['classic'] );?>><?php echo esc_html( $sidebar ); ?></option>
					  	<?php endforeach; ?>
				  	</select>
			    	<small class="howto"><?php esc_html_e( 'Choose a regular sidebar to display', 'knowledge-guru' ); ?></small>
			    	<br/>
		    	</p>

		    	<p>
			    	<select name="kbg[sidebar][sticky]" class="kbg-count-me">
					  	<?php foreach ( $sidebars as $id => $sidebar ): ?>
					  		<option class="kbg-count-me" value="<?php echo esc_attr( $id ); ?>" <?php selected( $id, $meta['sidebar']['sticky'] );?>><?php echo esc_html( $sidebar ); ?></option>
					  	<?php endforeach; ?>
				  	</select>
			    	<small class="howto"><?php esc_html_e( 'Choose a sticky sidebar to display', 'knowledge-guru' ); ?></small>
			    	<br/>
		    	</p>
        </div>

       
        <div class="form-field kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<label><?php esc_html_e( 'Pagination', 'knowledge-guru' ); ?></label>
		    <p>
		    	<ul class="kbg-img-select-wrap">
				  	<?php foreach ( $paginations as $id => $layout ): ?>
				  		<li>
				  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['pagination'], 'selected' ) ); ?>">
				  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
				  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[pagination]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['pagination'] );?>/>
				  		</li>
				  	<?php endforeach; ?>
			    </ul>
		    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'knowledge-guru' ); ?></small>
		    </p>
        </div>

        <div class="form-field">
            <label><?php esc_html_e( 'Image', 'knowledge-guru' ); ?></label>
			<?php $display = $meta['image'] ? 'initial' : 'none'; ?>
            <p>
                <img id="kbg-image-preview" src="<?php echo esc_url( $meta['image'] ); ?>" style="display:<?php echo esc_attr( $display ); ?>;">
            </p>

            <p>
                <input type="hidden" name="kbg[image]" id="kbg-image-url" value="<?php echo esc_attr( $meta['image'] ); ?>"/>
                <input type="button" id="kbg-image-upload" class="button-secondary" value="<?php esc_html_e( 'Upload', 'knowledge-guru' ); ?>"/>
                <input type="button" id="kbg-image-clear" class="button-secondary" value="<?php esc_html_e( 'Clear', 'knowledge-guru' ); ?>" style="display:<?php echo esc_attr( $display ); ?>"/>
            </p>

            <p class="description"><?php esc_html_e( 'Upload an image for this category', 'knowledge-guru' ); ?></p>
        </div>

		<?php
	}
endif;


/**
 * Edit category meta
 *
 * Callback function to load category meta fields on edit screen
 *
 * @since  1.0
 */

add_action( 'category_edit_form_fields', 'kbg_category_edit_meta_fields', 10, 2 );

if ( !function_exists( 'kbg_category_edit_meta_fields' ) ) :
	function kbg_category_edit_meta_fields( $term ) {
		$meta = kbg_get_category_meta( $term->term_id );
		$layouts = kbg_get_archive_layouts();
		$paginations = kbg_get_pagination_layouts();
		$sidebar_layouts = kbg_get_sidebar_layouts();
		$sidebars = kbg_get_sidebars_list();
		
		$exclude = kbg_get_archive_type( false, $term->term_id ) == 'post' ? array(10, 11) : array();
		$loops = kbg_get_post_layouts();

		?>
        <tr class="form-field kbg-opt-display">
            <th scope="row" valign="top">
                <?php esc_html_e( 'Display settings', 'knowledge-guru' ); ?>
            </th>
            <td>
                <label>
                    <input type="radio" name="kbg[settings]" value="inherit" <?php checked( $meta['settings'], 'inherit' ); ?>>
					<?php esc_html_e( 'Inherit from Category theme options', 'knowledge-guru' ); ?>
                </label>
                <br/>
                <label>
                    <input type="radio" name="kbg[settings]" value="custom" <?php checked( $meta['settings'], 'custom' ); ?>>
					<?php esc_html_e( 'Customize', 'knowledge-guru' ); ?>
                </label>
            </td>
        </tr>
        
        <?php $class = $meta['settings'] == 'custom' ? '' : 'kbg-hidden'; ?>

        <tr class="form-field kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<th scope="row" valign="top">
                <?php esc_html_e( 'Template layout', 'knowledge-guru' ); ?>
            </th>
            <td>
			    <p>
			    	<ul class="kbg-img-select-wrap">
					  	<?php foreach ( $layouts as $id => $layout ): ?>
					  		<li>
					  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['layout'], 'selected' ) ); ?>">
					  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
					  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[layout]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['layout'] );?>/>
					  		</li>
					  	<?php endforeach; ?>
				    </ul>
			    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'knowledge-guru' ); ?></small>
			    </p>
		    </td>
        </tr>

        <tr class="form-field kbg-opt-layouts kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<th scope="row" valign="top">
                <?php esc_html_e( 'Posts layout', 'knowledge-guru' ); ?>
            </th>
            <td>
			    <p>
			    	<ul class="kbg-img-select-wrap">
						  <?php foreach ( $loops as $id => $layout ): ?>
					  		<li>
					  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['loop'], 'selected' ) ); ?>" data-sidebar="<?php echo absint( kbg_loop_has_sidebar( $id,  'podcast' ) ); ?>">
					  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
					  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[loop]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['loop'] );?>/>
					  		</li>
					  	<?php endforeach; ?>
				    </ul>
			    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'knowledge-guru' ); ?></small>
			    </p>
		    </td>
        </tr>

        <tr class="form-field kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<th scope="row" valign="top">
                <?php esc_html_e( 'Post per page', 'knowledge-guru' ); ?>
            </th>
            <td>
			    <p>
			  		<input type="number" class="kbg-count-me small-text" name="kbg[ppp_num]" value="<?php echo absint( $meta['ppp_num'] ); ?>"/>
			    </p>
		    </td>
        </tr>

        <?php $sidebar_class = kbg_loop_has_sidebar( $meta['loop'], 'podcast' ) ? '' : 'kbg-opt-disabled'; ?>

		<tr class="form-field kbg-opt-sidebar <?php echo esc_attr( $sidebar_class ); ?> kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
		
			<th scope="row" valign="top">
                <?php esc_html_e( 'Enable Sidebar', 'knowledge-guru' ); ?>
			</th>
			<td>
				<input type="hidden" class="kbg-hidden" name="kbg[sidebar_enabled]" value="0"/>
				<input type="checkbox" class="kbg-count-me" name="kbg[sidebar_enabled]" value="1" <?php checked( $meta['sidebar_enabled'], 1 );?>/>
			</td>

		</tr>

		<tr class="form-field kbg-opt-sidebar <?php echo esc_attr( $sidebar_class ); ?> kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">

        	<th scope="row" valign="top">
                <?php esc_html_e( 'Sidebar', 'knowledge-guru' ); ?>
            </th>
            <td>
			    <p>
			    	<ul class="kbg-img-select-wrap">
					  	<?php foreach ( $sidebar_layouts as $id => $layout ): ?>
					  		<li>
					  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['sidebar']['position'], 'selected' ) ); ?>">
					  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
					  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[sidebar][position]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['sidebar']['position'] );?>/>
					  		</li>
					  	<?php endforeach; ?>
			    	</ul>
			    	<small class="howto"><?php esc_html_e( 'Choose sidebar position', 'knowledge-guru' ); ?></small>
			    	<br/>
			    </p>

			    <p>
				    <select name="kbg[sidebar][classic]" class="kbg-count-me">
					  	<?php foreach ( $sidebars as $id => $sidebar ): ?>
					  		<option class="kbg-count-me" value="<?php echo esc_attr( $id ); ?>" <?php selected( $id, $meta['sidebar']['classic'] );?>><?php echo esc_html( $sidebar ); ?></option>
					  	<?php endforeach; ?>
				  	</select>
			    	<small class="howto"><?php esc_html_e( 'Choose a regular sidebar to display', 'knowledge-guru' ); ?></small>
			    	<br/>
		    	</p>

		    	<p>
			    	<select name="kbg[sidebar][sticky]" class="kbg-count-me">
					  	<?php foreach ( $sidebars as $id => $sidebar ): ?>
					  		<option class="kbg-count-me" value="<?php echo esc_attr( $id ); ?>" <?php selected( $id, $meta['sidebar']['sticky'] );?>><?php echo esc_html( $sidebar ); ?></option>
					  	<?php endforeach; ?>
				  	</select>
			    	<small class="howto"><?php esc_html_e( 'Choose a sticky sidebar to display', 'knowledge-guru' ); ?></small>
			    	<br/>
		    	</p>
		    </td>
        </tr>

        

        <tr class="form-field kbg-opt-display-custom <?php echo esc_attr( $class ); ?>">
        	<th scope="row" valign="top">
                <?php esc_html_e( 'Pagination', 'knowledge-guru' ); ?>
            </th>
            <td>
			    <p>
			    	<ul class="kbg-img-select-wrap">
					  	<?php foreach ( $paginations as $id => $layout ): ?>
					  		<li>
					  			<img src="<?php echo esc_url( $layout['src'] ); ?>" title="<?php echo esc_attr( $layout['alt'] ); ?>" class="kbg-img-select <?php echo esc_attr( kbg_selected( $id, $meta['pagination'], 'selected' ) ); ?>">
					  			<br/><span><?php echo esc_attr( $layout['alt'] ); ?></span>
					  			<input type="radio" class="kbg-hidden kbg-count-me" name="kbg[pagination]" value="<?php echo esc_attr( $id ); ?>" <?php checked( $id, $meta['pagination'] );?>/>
					  		</li>
					  	<?php endforeach; ?>
				    </ul>
			    	<small class="howto"><?php esc_html_e( 'Choose a layout', 'knowledge-guru' ); ?></small>
			    </p>
		    </td>
        </tr>

        <tr class="form-field">
            <th scope="row" valign="top">
                <?php esc_html_e( 'Image', 'knowledge-guru' ); ?>
            </th>
            <td>
				<?php $display = $meta['image'] ? 'initial' : 'none'; ?>
                <p>
                    <img id="kbg-image-preview" src="<?php echo esc_url( $meta['image'] ); ?>" style="display:<?php echo esc_attr( $display ); ?>;">
                </p>

                <p>
                    <input type="hidden" name="kbg[image]" id="kbg-image-url" value="<?php echo esc_url( $meta['image'] ); ?>"/>
                    <input type="button" id="kbg-image-upload" class="button-secondary" value="<?php esc_html_e( 'Upload', 'knowledge-guru' ); ?>"/>
                    <input type="button" id="kbg-image-clear" class="button-secondary" value="<?php esc_html_e( 'Clear', 'knowledge-guru' ); ?>" style="display:<?php echo esc_attr( $display ); ?>"/>
                </p>

                <p class="description"><?php esc_html_e( 'Upload an image for this category', 'knowledge-guru' ); ?></p>
            </td>
        </tr>
		<?php
	}
endif;