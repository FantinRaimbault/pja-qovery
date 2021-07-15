<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Public/Dist/main.css"/>
    <script src="/Public/Dist/main.js"></script>
    <title>Binks-Beats</title>
</head>

<body>

    <?php

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

</body>

<script type="text/javascript">
    // clear queryParams for a clean url
    window.history.pushState("", "", window.location.pathname);
</script>

</html>