<header class="row--no-width justify-content-space-between align-items-center">
    <h1>
        <a href="/projects">Template Back</a>
    </h1>
    <div class="">
        <p></p>
        <a href="/profile" class="p-1"><?= $user['firstname'] ?> <?= $user['lastname'] ?> | <?= $user['role'] ?></a>
    </div>
</header>

<?php include $this->view ?>