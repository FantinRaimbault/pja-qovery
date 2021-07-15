<section class="middle">
    <div class="middle-screen">
        <?php if (isset($_GET['errors'])) : ?>
            <ul class="alert alert--danger bb-margin-medium-top-bottom width-80-p">
                <?php $errorsMessages = explode(',', $_GET['errors']) ?>
                <?php foreach ($errorsMessages as $message) : ?>
                    <li><?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (isset($_GET['success'])) : ?>
            <ul class="alert alert--success bb-margin-medium-top-bottom width-80-p">
                <?php $successMessages = explode(',', $_GET['success']) ?>
                <?php foreach ($successMessages as $message) : ?>
                    <li><?= htmlspecialchars($message) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="card--init">
            <div class="card bb-margin-high-bottom">
                <div class="card--header">
                    <span class="card--title">Votre profil</span>
                </div>
                <hr>
                <div class="card--body">
                    <div style="background-color: <?php echo $user['picture'] ?>" class="card-img"></div>
                </div>
                <div class="card--body my-2 ">
                    <?php $form->render() ?>
                </div>
                <div class="card--body my-4">
                    <a href="/logout" class="width-80-p bb-margin-5">
                        <button class="button button--secondary p-1 full-width">
                            Modifier mon adresse mail
                        </button>
                    </a>
                    <a href="/logout" class="width-80-p bb-margin-5">
                        <button class="button button--secondary p-1 full-width">
                            Modifier mon mot de passe
                        </button>
                    </a>
                    <a href="/logout" class="width-80-p bb-margin-5">
                        <button class="button button--primary p-1 full-width">
                            Se deconnecter
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>