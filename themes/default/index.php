<div class="container"><!-- Start of Main Container -->
    <?php
    echo theme_view('_sitenav');

    echo Template::message();
    echo isset($content) ? $content : Template::content();

    ?>