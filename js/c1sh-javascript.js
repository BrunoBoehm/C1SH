/**
 * General functions
 */

function c1shRedirectToPath() {
    var target = document.getElementById("join-us-select").value;
    // debugger;
    // alert('about to redirect to ' + target);
    if ( target != '' ) {
        window.location.href=target;
    } else {
        window.location.href=c1sh_dropdown_data.dropdown_default_url;
    }
}

function c1shRefreshSignatures() {
    jQuery(window).ready(function($) {
        var refreshGallery = function() {
            jQuery.get( ajax_request_url,
                {	
                    'action' : 'cush_refresh_grille_from_ajax'
                }, 
                function( response ){
                    if ( !response.error ) {
                        if (Array.isArray(response.result)) {
                            for (var i in response.result) {
    
                                // cluser to preserve value of "i"
                                // https://scottiestech.info/2014/07/01/javascript-fun-looping-with-a-delay/
                                (function(i){
                                    var selected = $('.signatures-list .list-single-signature')[i];
                                    var $selected = $(selected);
    
                                    window.setTimeout(function(){
                                        $avatar = $selected.find(".single-user-avatar img");
                                        // $avatar.fadeOut(200);
                                        $avatar.attr('src', response.result[i].url_featured_img_big);
                                        // $avatar.fadeIn(1000);
                                        $selected.find(".single-user-meta h5").html(response.result[i].author);
                                    }, i * 500);
                                }(i));
                            }
                        } else {
                            console.log(response.result);
                        }
                    } else {
                        console.log('error: ' + response.error );
                    }
                },
                "json" 
            );
            return false;
        }
    
        var refreshTimeout = window.setInterval(refreshGallery, 10000);
        jQuery('.signatures-list').mouseenter(function(){
              window.clearTimeout(refreshTimeout);
        }).mouseleave(function(){
            refreshTimeout = window.setInterval(refreshGallery, 10000);
        });
    });
}

// function emailUpdate( jQuery ) {
//     var first_name = jQuery(".origin-name-surname input:first-of-type"),
//     last_name = jQuery(".origin-name-surname input:nth-of-type(2)"),
//     custom_message = jQuery(".custom-message textarea");

//     custom_message.prepend('Cher ,\n');

//     first_name.on("change", function(){
//         // find first space in message
//         var inside_textarea = custom_message.val();
//         var position = inside_textarea.search(' ');
//         custom_message.val([inside_textarea.slice(0, position), this.value, inside_textarea.slice(position)].join(''));
//     });
// }
// jQuery( document ).ready( emailUpdate );