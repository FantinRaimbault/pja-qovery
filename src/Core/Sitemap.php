<?php 
    header("Content-Type: application/xml; charset=UTF-8");
    echo '<!--?xml version="1.0" encoding="UTF-8"?-->'.PHP_EOL;
    echo '<urlset xmlns:xlink="http://'.$_SERVER['HTTP_HOST'].'">' . PHP_EOL;
    if (!empty($this->templates)) {
        foreach ($this->templates as $template) {
            include $template;
        }
    } else {
        include $this->view;
    }
    if(!$this->isTemplatesIncludeView) {
        include $this->view;
    }
?>
<?php
    echo '</urlset>' . PHP_EOL;
?>    