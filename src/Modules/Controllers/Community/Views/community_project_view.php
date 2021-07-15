<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;
use App\Config\Constants;

["name" => $name, "description" => $description, "owner_firstname" => $ownerFirstname, "slug" => $slug, "picture" => $picture] = $project;

?>
<section class="padding-section row flex-column full-height">
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
    <div class="row justify-content-start bb-header">
        <div class="exit">
            <a href="<?php Router::go('..'); ?>">
                <div>
                    <p></p>
                </div>
            </a>
        </div>
    </div>
    <div class="flex-1-1-auto overflow-y-auto">
        <div class="row project-card bb-margin-medium-bottom">
            <div style="background-color: <?php echo $picture ?>" class="profile-picture">

            </div>
            <div class="flex-8 flex flex-column left-content">
                <div class="title"><?= $name ?></div>
                <div class="stars">
                    <div class="flex btn-star">
                        <p class="nb-stars">60</p>
                        <p class="star"></p>
                    </div>
                </div>
            </div>
            <div class="flex-2 flex flex-column right-content">
                <div class="flex align-items-center justify-content-center link-to-project">
                    <a href="<?php Router::go("~/$slug") ?>">
                        <button class="button-underlined button-underlined--blue">Voir le projet</button>
                    </a>
                </div>
                <div class="flex align-items-center justify-content-center owner">
                    <p><?= $ownerFirstname ?></p>
                </div>
            </div>
        </div>
        <div class="bb-card bb-margin-medium-top-bottom">
            <div class="bb-card-header">
                <h3>Description du projet</h3>
            </div>
            <div class="row bb-padding">
                <?= $project['description'] ?>
            </div>
        </div>
        <div class="bb-card bb-margin-medium-top-bottom">
            <div class="bb-card-header">
                <h3>Commentaires du projet</h3>
                <button onclick='showModalForCreateComment()' class="button-light button-light--primary bb-padding-btn-8-12 bold">Ajouter un commentaire</button>
            </div>
            <div class="row flex-column bb-padding">
                <?php if (isset($comments) && count($comments) > 0) : ?>
                    <?php foreach ($comments as $comment) : ?>
                        <?php ["userId" => $userId, "firstname" => $firstname, "createdAt" => $createdAt, "picture" => $picture] = $comment; ?>
                        <div class="row comment bb-padding bb-margin-medium-bottom">
                            <div class="user">
                                <div style="background-color: <?php echo $picture ?>" class="profile-picture">

                                </div>
                                <p class="name"><?= $firstname ?></p>
                                <p class="created-at"><?= (new DateTimeImmutable($createdAt))->format('Y-m-d') ?></p>
                            </div>
                            <div class="flex-8 flex flex-column comment-content">
                                <?= $comment['content'] ?>
                            </div>
                            <div class="flex-2">
                                <div class="flex flex-column justify-content-center">
                                    <?php if ($comment['userId'] !== $_SESSION['user']['id']) : ?>
                                        <button onclick='showModalForCreateReport(<?php BinksBeatHelper::toJson($comment) ?>)' class="button-underlined button-underlined--yellow">Signaler</button>
                                    <?php endif; ?>
                                    <?php if ($comment['userId'] === $_SESSION['user']['id']) : ?>
                                        <button onclick='showModalForDeleteComment(<?php BinksBeatHelper::toJson($comment) ?>)' class="button-underlined button-underlined--blue">Supprimer</button>
                                    <?php elseif ($_SESSION['user']['role'] === Constants::get()['users']['roles']['admin']) : ?>
                                        <button onclick='showModalForDeactivateComment(<?php BinksBeatHelper::toJson($comment) ?>)' class="button-underlined button-underlined--blue">Désactiver</button>
                                    <?php else : ?>
                                    <?php endif; ?>
                                    <?php if ($_SESSION['user']['role'] === Constants::get()['users']['roles']['admin']) : ?>
                                        <button onclick='showModalForBanUser(<?php BinksBeatHelper::toJson($userId) ?>,<?php BinksBeatHelper::toJson($firstname) ?>)' class="button-underlined button-underlined--red">Sanctionner</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    const {
        projectId
    } = <?php BinksBeatHelper::toJson($project); ?>;

    function showModalForCreateComment() {
        const modal = new FormModal({
            title: 'Poster un commentaire',
            form: {
                method: 'POST',
                action: `/comments/projects/${projectId}`,
                inputs: [{
                        label: 'Commentaire',
                        type: 'text',
                        name: 'content'
                    },
                    {
                        type: 'hidden',
                        name: 'csrf',
                        value: csrf
                    }
                ],
                submit: 'Poster'
            }
        })
        modal.open();
    }

    function showModalForCreateReport(comment) {
        const {
            commentId
        } = comment
        const modal = new FormModal({
            title: 'Signaler le commentaire',
            form: {
                method: 'POST',
                action: `/reports/comments/${commentId}`,
                inputs: [{
                        label: 'Contenu commercial indésirable ou spam',
                        type: 'radio',
                        name: 'metric',
                        value: 'insult',
                        checked: true
                    },
                    {
                        label: 'Incitation à la haine',
                        type: 'radio',
                        name: 'metric',
                        value: 'violence'
                    },
                    {
                        label: 'Harcèlement ou intimidation',
                        type: 'radio',
                        name: 'metric',
                        value: 'bullying'
                    },
                    {
                        type: 'hidden',
                        name: 'csrf',
                        value: csrf
                    }
                ],
                submit: 'Envoyer'
            }
        })
        modal.open();
    }

    function showModalForDeleteComment(comment) {
        const {
            commentId,
        } = comment
        const modal = new YesNoModal({
            title: `Voulez supprimer votre commentaire ?`,
            form: {
                method: 'POST',
                action: `/comments/${commentId}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

    function showModalForDeactivateComment(comment) {
        const {
            commentId
        } = comment
        const modal = new YesNoModal({
            title: `Voulez vous désactiver ce commentaire ?`,
            form: {
                method: 'POST',
                action: `/comments/${commentId}/disable`,
                input: {
                    name: 'disabled',
                    value: 1
                },
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

    function showModalForBanUser(userId, username) {
        const modal = new FormModal({
            title: `Sanctionner ${username} ?`,
            form: {
                method: 'POST',
                action: `/bans/users/${userId}`,
                inputs: [{
                        label: 'Motif (optionnel)',
                        type: 'text',
                        name: 'reason'
                    },
                    {
                        label: 'Durée du bannissement',
                        type: 'date',
                        name: 'until',
                        min: (addDays(new Date(), 1)).toISOString().split("T")[0]
                    },
                    {
                        type: 'hidden',
                        name: 'csrf',
                        value: csrf
                    }
                ],
                submit: 'Sanctionner'
            }
        })
        modal.open()
    }
</script>