<?php foreach($sitemap as $item): ?>
<?php
    echo '<url>' . PHP_EOL;
    echo '<loc xlink:type="simple" xlink:href="http://'. $_SERVER['HTTP_HOST'] .'/'.$item["ProSlug"].'/'.$item["PagSlug"].'">http://'. $_SERVER['HTTP_HOST'] .'/'.$item["ProSlug"].'/'.$item["PagSlug"].'/</loc>' . PHP_EOL;
    echo '<changefreq>'.$item["ProjectName"].'</changefreq>'. PHP_EOL;
    echo '</url>' . PHP_EOL;
?>

<?php endforeach; ?>
    
