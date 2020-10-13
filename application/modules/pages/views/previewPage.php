<html>
<head></head>
<body>
<?php if (isset($page) && !empty($page)) : ?>
    <h1><?php echo $page->page_title ?></h1><br/>
    <?php echo $page->page_content ?>
<?php else : ?>
    <h2>Page not found!</h2>
<?php endif; ?>
</body>
</html>