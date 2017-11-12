<?php 

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action("genesis_after_content", "cush_display_signatures_listing");

function cush_display_signatures_listing() {
	$letter1 = $letter2 = "";
	if (isset($_GET['lettre1'])) $letter1 = $_GET['lettre1'];
	if (isset($_GET['lettre2'])) $letter2 = $_GET['lettre2'];
	$signatures = cush_get_signatures_by_author($letter1, $letter2);

    echo '<div class="wrap">';
	echo '<div class="nav-listing-signatures">';
    echo     '<ol class="nav">
                <li><a href="' . home_url() . '/signatures/" class="active">Tous</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=A&lettre2=B">A</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=B&lettre2=C">B</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=C&lettre2=D">C</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=D&lettre2=E">D</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=E&lettre2=F">E</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=F&lettre2=G">F</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=G&lettre2=H">G</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=H&lettre2=I">H</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=I&lettre2=J">I</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=J&lettre2=K">J</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=K&lettre2=L">K</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=L&lettre2=M">L</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=M&lettre2=N">M</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=N&lettre2=O">N</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=O&lettre2=P">O</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=P&lettre2=Q">P</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=Q&lettre2=R">Q</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=R&lettre2=S">R</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=S&lettre2=T">S</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=T&lettre2=U">T</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=U&lettre2=V">U</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=V&lettre2=W">V</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=W&lettre2=X">W</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=X&lettre2=Y">X</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=Y&lettre2=Z">Y</a></li>
                <li><a href="' . home_url() . '/signatures/?lettre1=Z&lettre2=A">Z</a></li>
            </ol>';
    echo '</div>';  // end of nav-listing-signatures    

	// echo    '<ul class="listing-signatures">';
	// foreach ( $signatures as $signature ) {
    // echo        '<li>';
    // echo            '<span class="first">' . get_post_meta($signature->ID, 'txt_first_name', true) . '</span>';
    // echo            '<span class="last"> ' . get_post_meta($signature->ID, 'txt_last_name', true) . '</span>';
    // echo        '</li>'; // end .single-signature
    // }
    // echo    '</ul>'; // end .listing-signatures
    
    echo '<div class="signatures-list">';
    $i = 0;
    foreach ( $signatures as $signature ) {
        setup_postdata( $signature );
        $img_url = wp_get_attachment_image_src( get_post_thumbnail_id( $signature->ID ), 'small-size' )[0];
        if ( $i == 0 || $i % 6 == 0 ){ echo '<div class="one-sixth first">'; } else { echo '<div class="one-sixth">'; }
        echo    '<div class="list-single-signature">';
        echo        '<div class="single-user-avatar"><img src="' . $img_url . '"></div>';
        echo        '<div class="single-user-meta">';
        echo            '<h5>' . $signature->post_title . '</h5>';
        echo        '</div>';
        echo    '</div>'; // end of .list-single-signature
        echo '</div>'; // end of column
        $i++;
    }
    wp_reset_postdata();
    echo    '<div class="clearfix"></div>';
    echo '</div>'; // end of signatures-list

    echo '</div>'; // end of wrap
}

genesis();