<?php

use App\Core\Router\Router;

?>
<main class="row">
    <div class="sidebar">
        <ul class="row flex-column sidebar-content">
            <a href="<?php Router::go("~/projects"); ?>">Mes Projets</a>
            <a href="<?php Router::go("~/community"); ?>">Communauté</a>
        </ul>
    </div>
    <div id="content">
        <?php include $this->view ?>
    </div>
</main>