<?php if ( post_password_required() ) { return; } ?>

<?php if ( comments_open() || get_comments_number() ) : ?>



                <div class="kbg-comments-form kbg-card kbg-card-single mb--xxl">
                <?php
                comment_form( array(
                    'title_reply_before' => '<div class="section-head row justify-content-center"><div class="col-12"><h5 id="reply-title" class="h2 mb--xs align-items-start">',
                    'title_reply'        => esc_html(__kbg( 'leave_a_reply' )),
                    'label_submit' => esc_html(__kbg( 'comment_submit' )),
                    'cancel_reply_link' => esc_html(__kbg( 'comment_cancel_reply' )),
                    'title_reply_after'  => '</h5></div></div>',
                    'comment_notes_before' => '',
                    'comment_notes_after' => '',
                    'submit_button' => '<p class="form-submit"><button name="%1$s" type="submit" id="%2$s" class="%3$s kbg-button-arrow" value="%4$s">'.esc_html(__kbg( 'comment_submit' )).'</button></p>',
                    'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . kbg_wp_kses(__kbg( 'comment_text' )) .'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .'</textarea></p>',
                ) );
                ?>
               
                <?php if ( have_comments() ) : ?>

                    <h5 id="comments" class="mt--xxl section-title text-left align-items-start">
                        <?php comments_number( esc_html(__kbg( 'no_comments' )), esc_html(__kbg( 'one_comment' )), esc_html(__kbg( 'multiple_comments' )) ); ?>
                    </h5>

                    <ul class="comment-list">
                        <?php $args = array(
                            'avatar_size' => 60,
                            'reply_text' => kbg_wp_kses(__kbg( 'comment_reply' )),
                            'format' => 'html5'
                        ); ?>
                        <?php wp_list_comments( $args ); ?>
                    </ul>

                    <?php paginate_comments_links( array(  'prev_text' => '<i class="kg kg-left"></i>', 'next_text' => '<i class="kg kg-right"></i>', 'type' => 'list' ) ); ?>

                <?php endif; ?>
                </div>

<?php endif; ?>