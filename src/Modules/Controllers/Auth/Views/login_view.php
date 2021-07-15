<h1 class="flex justify-content-center my-1">BinksBeats</h1>
<div class="bb-card-login">
    <div class="bb-card-bis">
        <?php if (isset($errors)) : ?>
            <ul class="alert alert--danger bb-margin-medium-top-bottom">
                <?php foreach ($errors as $error) : ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h1 class="title-connexion">Connexion</h1>

        <?php $form->render() ?>

        <?php if (isset($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <li style="color:white"><strong><?= $error; ?></strong></li>
            <?php endforeach; ?>
        <?php endif; ?>

        <a href="/register" class="my-4 underlined bb-orange">S'inscrire ? </a>
    </div>
</div>