<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;

?>

<main class="row flex-column padding-section">
    <?php if (isset($_GET['errors'])) : ?>
        <ul class="alert alert--danger bb-margin-medium-top-bottom">
            <?php $errorsMessages = explode(',', $_GET['errors']) ?>
            <?php foreach ($errorsMessages as $message) : ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if (isset($_GET['success'])) : ?>
        <ul class="alert alert--success bb-margin-medium-top-bottom">
            <?php $successMessages = explode(',', $_GET['success']) ?>
            <?php foreach ($successMessages as $message) : ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <div class="bb-card">
        <div class="bb-card-header" style="justify-content: flex-start">
            <a href="<?php Router::go('../reports') ?>">
                <h3 class="bb-margin-medium-right can-activate can-activate--orange">Signalements</h3>
            </a>
            <a href="<?php Router::go('../disabled-comments') ?>">
                <h3 class="underlined bb-orange bb-margin-medium-right can-activate can-activate--orange">Commentaires Désactivés</h3>
            </a>
            <a href="<?php Router::go('../banned-users') ?>">
                <h3 class="can-activate can-activate--orange">Utilisateurs Sanctionnés</h3>
            </a>
        </div>
        <div class="row flex-column bb-padding">
            <?php if (isset($reportedComments) && count($reportedComments) > 0) : ?>
                <?php foreach ($reportedComments as $reportedComment) : ?>
                    <div class="row comment bb-padding bb-margin-medium-bottom">
                        <div class="user">
                            <div class="profile-picture">

                            </div>
                            <p class="name"><?= $reportedComment['username'] ?></p>
                            <p class="created-at"><?= $reportedComment['createdAt'] ?></p>
                        </div>
                        <div class="flex-8 flex flex-column comment-content">
                            <?= $reportedComment['content'] ?>
                        </div>
                        <div class="flex-2">
                            <div class="flex flex-column justify-content-center">
                                <button onclick='showModalForDeletePage(<?php BinksBeatHelper::toJson($reportedComment) ?>)' class="button-underlined button-underlined--blue">Réactiver le commentaire</button>
                            </div>
                        </div>
                        <div class="flex-2">
                            <div class="flex flex-column full-height">
                                <p>Nombre de signalements :</p>
                                <div class="flex flex-1 justify-content-center align-items-center">
                                    <p class="nb-reports"><?= $reportedComment['nbReports'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<script type="text/javascript">
    function showModalForDeletePage(comment) {
        const {
            commentId
        } = comment
        const modal = new YesNoModal({
            title: `Voulez vous réactiver ce commentaire ?`,
            form: {
                method: 'POST',
                action: `/comments/${commentId}/disable`,
                input: {
                    name: 'disabled',
                    value: 0
                },
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }
</script>