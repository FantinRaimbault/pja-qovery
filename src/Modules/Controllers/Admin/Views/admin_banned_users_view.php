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
                <h3 class="bb-margin-medium-right can-activate can-activate--orange">Commentaires Désactivés</h3>
            </a>
            <a href="<?php Router::go('../banned-users') ?>">
                <h3 class="underlined bb-orange can-activate can-activate--orange">Utilisateurs Sanctionnés</h3>
            </a>
        </div>
        <div class="row flex-column bb-padding">
            <?php if (isset($bannedUsers) && count($bannedUsers) > 0) : ?>
                <div class="row-banned-user">
                    <div class="username bold">
                        Prénom
                    </div>
                    <div class="email bold">
                        Email
                    </div>
                    <div class="reason bold">
                        Motif
                    </div>
                    <div class="start-ban bold">
                        Date de début
                    </div>
                    <div class="end-ban bold">
                        Date de fin
                    </div>
                </div>
                <?php foreach ($bannedUsers as $bannedUser) : ?>
                    <div class="row-banned-user">
                        <div class="username">
                            <?= $bannedUser['username'] ?>
                        </div>
                        <div class="email">
                            <?= $bannedUser['email'] ?>
                        </div>
                        <div class="reason">
                            <?= empty($bannedUser['reason']) ? 'Raison inconnue' : $bannedUser['reason'] ?>
                        </div>
                        <div class="start-ban">
                            <?= explode(' ', $bannedUser['createdAt'])[0] ?>
                        </div>
                        <div class="end-ban">
                            <p><?= explode(' ', $bannedUser['until'])[0] ?></p>
                            <div class="options">
                                <div onclick='showModalForDeleteBannedUser(<?php BinksBeatHelper::toJson($bannedUser) ?>)' class="delete">
                                    <div>
                                        <p></p>
                                    </div>
                                </div>
                                <div onclick='showModalForEditBannedUser(<?php BinksBeatHelper::toJson($bannedUser) ?>)' class="edit">
                                    <div>
                                        <p></p>
                                    </div>
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
    function showModalForDeleteBannedUser(bannedUser) {
        const {
            userId,
            username
        } = bannedUser
        const modal = new YesNoModal({
            title: `Voulez vous débannir ${username} ?`,
            form: {
                method: 'POST',
                action: `/bans/users/${userId}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

    function showModalForEditBannedUser(bannedUser) {
        console.log(bannedUser)
        const {
            username,
            banId,
            until,
            reason
        } = bannedUser
        const modal = new FormModal({
            title: `Modifier la sanction de ${username}`,
            form: {
                method: 'POST',
                action: `/bans/${banId}`,
                inputs: [{
                        label: 'Motif (optionnel)',
                        type: 'text',
                        name: 'reason',
                        value: reason
                    },
                    {
                        label: 'Durée du bannissement',
                        type: 'date',
                        name: 'until',
                        min: (addDays(new Date(), 1)).toISOString().split("T")[0],
                        value: until.split(' ')[0]
                    },
                    {
                        type: 'hidden',
                        name: 'csrf',
                        value: csrf
                    }
                ],
                submit: 'Modifier la sanction'
            }
        })
        modal.open()
    }
</script>