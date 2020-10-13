$(function() {
    $('#variables a').on('click', function(ev) {
        ev.preventDefault();        
        var editor = CKEDITOR.instances['content'];
        editor.insertText($(this).text());
        return false;
    });
});