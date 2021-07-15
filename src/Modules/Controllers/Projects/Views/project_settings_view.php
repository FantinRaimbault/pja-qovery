<?php

use App\Modules\Controllers\Auth\Models\Contributor;
use App\Modules\BinksBeatHelper;

["id" => $currentUserId] = $_SESSION['user'];

$indexContributor = array_search($currentUserId, array_column($contributors, 'userId'));

$currentContributor = new Contributor($contributors[$indexContributor]);
?>

<section class="padding-section row flex-column full-height">
    <div class="row justify-content-start bb-header">
        <h2>
            Paramètres
        </h2>
    </div>
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
    <div id="contributors-box" class="bb-card">
        <div class="bb-card-header">
            <h3>Collaborateurs</h3>
        </div>
        <?php if ($currentContributor->isOwnerOfProject($currentProject['owner'])) : ?>
            <div class="row bb-padding justify-content-end">
                <button onclick='showModalForAddContributor()' class="button button--secondary">
                    Ajouter un collaborateur
                </button>
            </div>
        <?php endif; ?>
        <div id="contributors">
            <?php foreach ($contributors as $contributor) : ?>
                <?php $contrib =  new Contributor($contributor) ?>
                <div class="row-contributor">
                    <div class="content">
                        <div class="firstname">
                            <p style="color: <?php echo ($currentContributor->getUserId() === $contrib->getUserId()) ? '#838383' : ''; ?>"><?= $contributor['lastname'] ?></p>
                            <?php if ($currentProject['owner'] === $contributor['userId']) : ?>
                                <p class="star"></p>
                            <?php endif; ?>
                        </div>
                        <div style="color: <?php echo ($currentContributor->getUserId() === $contrib->getUserId()) ? '#838383' : ''; ?>"><?= $contributor['firstname'] ?></div>
                        <div style="color: <?php echo ($currentContributor->getUserId() === $contrib->getUserId()) ? '#838383' : ''; ?>"><?= $contributor['email'] ?></div>
                        <div style="color: <?php echo ($currentContributor->getUserId() === $contrib->getUserId()) ? '#838383' : ''; ?>"><?= $contrib->displayRole() ?></div>
                    </div>
                    <div class="options">
                        <?php if ($currentContributor->isOwnerOfProject($currentProject['owner']) && $currentContributor->getUserId() !== $contrib->getUserId()) : ?>
                            <div onclick='showModalForEditContributor(<?php BinksBeatHelper::toJson($contributor) ?>)' class="edit"></div>
                            <div onclick='showModalForDeleteContributor(<?php BinksBeatHelper::toJson($contributor) ?>)' class="delete"></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="danger-zone-box" class="bb-card bb-margin-medium-top">
        <div class="bb-card-header">
            <h3>Danger Zone</h3>
        </div>
        <div class="row bb-padding">
            <?php if ($_SESSION['user']['id'] === $currentProject['owner']) : ?>
                <button onclick='showModalForDeleteProject()' class="button button--danger">Supprimer le projet</button>
            <?php else : ?>
                <button onclick='showModalForLeaveProject()' class="button button--danger">Quitter le projet</button>
            <?php endif; ?>
        </div>
    </div>
</section>

<script type="text/javascript">
    const {
        id: projectId,
        name: projectName
    } = <?php echo json_encode($currentProject); ?>;
    const {
        id: currentUserId,
    } = <?php echo json_encode($_SESSION['user']); ?>;

    const roles = [{
            name: 'Administrateur',
            value: 'admin',
        },
        {
            name: 'Editeur de Page',
            value: 'editor'
        },
        {
            name: 'Producteur de Musique',
            value: 'producer'
        }
    ]

    function showModalForAddContributor() {
        const modal = new FormModal({
            title: 'Ajouter un collaborateur',
            form: {
                method: 'POST',
                action: `/projects/${projectId}/invitations`,
                inputs: [{
                        label: 'Email',
                        type: 'text',
                        name: 'email'
                    },
                    {
                        label: 'En tant que',
                        type: 'select',
                        name: 'role',
                        options: roles
                    },
                    {
                        type: 'hidden',
                        name: 'csrf',
                        value: csrf
                    }
                ],
                submit: 'Ajouter'
            }
        })
        modal.open();
    }

    function showModalForEditContributor(contributor) {
        const {
            firstname,
            role
        } = contributor
        const modal = new FormModal({
            title: `Modifier les droits de ${firstname}`,
            form: {
                method: 'POST',
                action: `/projects/${projectId}/users/${contributor['userId']}/update`,
                inputs: [{
                        label: 'En tant que',
                        type: 'select',
                        name: 'role',
                        value: role,
                        options: roles
                    },
                    {
                        type: 'hidden',
                        name: 'csrf',
                        value: csrf
                    }
                ],
                submit: 'Enregistrer'
            }
        })
        modal.open();
    }

    function showModalForDeleteContributor(contributor) {
        const modal = new YesNoModal({
            title: `Voulez vous supprimer ${contributor['firstname']} de votre projet ?`,
            form: {
                method: 'POST',
                action: `/projects/${projectId}/users/${contributor['userId']}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

    function showModalForDeleteProject() {
        const modal = new YesNoModal({
            title: `Êtes vous sûr de vouloir supprimer définitivement ${projectName} ?`,
            form: {
                method: 'POST',
                action: `/projects/${projectId}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

    function showModalForLeaveProject() {
        const modal = new YesNoModal({
            title: `Êtes vous sûr de vouloir quitter ${projectName} ?`,
            form: {
                method: 'POST',
                action: `/projects/${projectId}/users/${currentUserId}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }
</script>