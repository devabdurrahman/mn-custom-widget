jQuery(document).ready(function(){

    jQuery(".mn_dd_options").on("change", function(){

        let mn_option_value = jQuery(this).val(); // Get the value of the selected option

        if(mn_option_value == "recent_posts"){
            jQuery("p#widget-mn_custom_widget-2-message").addClass('hide_element'); // Hide message field
            jQuery("p#widget-mn_custom_widget-2-posts_number").removeClass('hide_element'); // Show posts number field

        } else if (mn_option_value == "static_message"){
            jQuery("p#widget-mn_custom_widget-2-message").removeClass('hide_element'); // Show message field
            jQuery("p#widget-mn_custom_widget-2-posts_number").addClass('hide_element'); // Hide posts number field
        }
    });
});
