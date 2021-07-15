<?php

use App\Modules\Controllers\Projects\UseCases\ProjectUseCases;
use App\Modules\BinksBeatHelper;

["email" => $email] = $_SESSION['user'];
$invitations = ProjectUseCases::getInvitationsByEmailPopulateProjects($email);
?>


<header class="row--no-width justify-content-space-between align-items-center">
    <h1>
        <a href="/projects">Binks Beats</a>
    </h1>
    <div class="row--no-width align-items-center">
        <?php if ($_SESSION['user']['role'] === 'admin') : ?>
            <a href="/admin/reports">
                <div class="row align-items-center admin">
                    <p></p>
                    <p>Admin</p>
                </div>
            </a>
        <?php endif; ?>
        <a class="bb-margin-medium-right" href="/profile">Profil</a>
        <div class="row align-items-center notification">
            <p></p>
            <?php if (isset($invitations) && count($invitations) > 0) : ?>
                <p><?= count($invitations) ?></p>
                <div class="notification-box">
                    <?php foreach ($invitations as $invitation) : ?>
                        <div class="row-notification">
                            <div class="picture" style="background-color: <?php echo $invitation['projectPicture'] ?>"></div>
                            <div class="request-project">
                                <p>Vous êtes invité à rejoindre le projet : <?= $invitation['projectName'] ?></p>
                                <div class="row">
                                    <button onclick='sendResponseToInvitation(<?php BinksBeatHelper::toJson($invitation); ?>, true)' class="button button--success">Accepter</button>
                                    <button onclick='sendResponseToInvitation(<?php BinksBeatHelper::toJson($invitation); ?>, false)' class="button button--danger">Refuser</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<script type="text/javascript">
    const csrf = <?php echo json_encode($_SESSION["csrf"]); ?>

    function sendResponseToInvitation(invitation, response) {
        const {
            projectId,
            invitationId
        } = invitation
        fetch(`/projects/${projectId}/invitations/${invitationId}/status`, {
                method: 'POST',
                body: JSON.stringify({
                    response,
                    csrf
                })
            }).then(() => location.reload())
            .catch((err) => location.reload())
    }
</script>