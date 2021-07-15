<div class="bb-card-register">
    <div class="bb-card-bis">
        <h1 class="title-register">Rejoindre BinksBeat</h1>
        <?php if (isset($_GET['errors'])) : ?>
            <ul class="alert alert--danger bb-margin-medium-top-bottom">
                <li><?= $_GET['errors'] ?></li>
            </ul>
        <?php endif; ?>
        <?php $form->render() ?>

        <a href="/login" class="my-4 underlined bb-orange">Déjà un compte ? Se connecter </a>

    </div>
</div>