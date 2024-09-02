jQuery(document).ready(function($){
    $('#copy-text').click(function () {
        // Create a temporary textarea element
        var tempTextarea = $('<textarea>');
        // Append it to the body
        $('body').append(tempTextarea);

        // Set the value of the textarea to the text inside .se-scode
        tempTextarea.val($('.se-scode').text()).select();

        // Execute the copy command
        document.execCommand('copy');

        // Remove the temporary textarea
        tempTextarea.remove();

        $('.se-admin-das-wrap').append('<span class="text-success mt-4">Coppied!</span>');
        function seuccess(){
            $('.text-success').remove();
        }
        setTimeout(seuccess, 2000);
    });
});