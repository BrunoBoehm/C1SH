/**
 * General functions
 */

function c1shRedirectToPath() {
    var target = document.getElementById("join-us-select").value;
    debugger;
    // alert('about to redirect to ' + target);
    if ( target != '' ) {
        window.location.href=target;
    } else {
        window.location.href=c1sh_dropdown_data.dropdown_default_url;
    }
}