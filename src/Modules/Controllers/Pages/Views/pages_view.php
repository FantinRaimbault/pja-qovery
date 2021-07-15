<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;

?>


<section class="padding-section">
    <div class="row justify-content-start bb-header">
        <h2>
            Pages
        </h2>
    </div>
    <div class="row justify-content-end bb-margin-high-bottom">
        <button onclick='showModalForCreatePage()' class="button button--primary">
            Ajouter une Page
        </button>
    </div>
    <?php if (isset($createPageErrors) && count($createPageErrors) > 0) : ?>
        <ul class="alert alert--danger bb-margin-medium-top-bottom">
            <li><?= join(", ", $createPageErrors) ?></li>
        </ul>
    <?php endif; ?>
    <?php if (isset($_GET['updatePageErrors'])) : ?>
        <ul class="alert alert--danger bb-margin-medium-top-bottom">
            <li><?= $_GET['updatePageErrors'] ?></li>
        </ul>
    <?php endif; ?>
    <?php if (isset($_GET['deletePageErrors'])) : ?>
        <ul class="alert alert--danger bb-margin-medium-top-bottom">
            <li><?= $_GET['deletePageErrors'] ?></li>
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
    <?php if (isset($pages) && count($pages) > 0) : ?>
        <?php foreach ($pages as $page) : ?>
            <?php unset($page['content']) ?>
            <div class="row row-page ">
                <a href="<?php Router::go($page['id'] . "/edit"); ?>">
                    <p><?= $page['name']; ?></p>
                    <p><?= '/' . $page['slug']; ?></p>
                </a>
                <div>
                    <p class="<?php echo $page['isMain'] ? 'star light-star' : 'star dark-star' ?>"></p>
                    <ul class="row">
                        <li class="<?php echo $page['isPublished'] ? 'published' : 'unpublished' ?>">
                            <?= $page['isPublished'] ? 'Publié' : 'Brouillon' ?>
                        </li>
                        <li class="<?php echo $page['isPublished'] ? 'checked' : '' ?>"></li>
                    </ul>
                    <ul class="row">
                        <li onclick='showModalForUpdatePage(<?php BinksBeatHelper::toJson($page); ?>)' class="edit"></li>
                        <li onclick='showModalForDeletePage(<?php BinksBeatHelper::toJson($page); ?>)' class="delete"></li>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="row bb-padding">
            <div class="no-data">
                <p class="sad"></p>
                <p class="text">Vous ne possédez pas de pages ...</p>
            </div>
        </div>
    <?php endif; ?>
</section>


<script type="text/javascript">
    // remove query params for a clean url
    // const lastDeepOfCurrentPath = window.location.pathname.split('/').filter(str => str !== '').reverse()[0]

    const pageOptions = [{
            name: 'Brouillon',
            value: 0,
        },
        {
            name: 'Publié',
            value: 1
        }
    ]

    function showModalForCreatePage() {
        const modal = new FormModal({
            title: 'Créer une Page',
            form: {
                method: 'POST',
                inputs: [{
                        label: 'Nom de la page',
                        type: 'text',
                        name: 'name'
                    },
                    {
                        label: 'Chemin de la page (URL)',
                        type: 'text',
                        name: 'slug'
                    },
                    {
                        label: 'Page principale',
                        type: 'checkbox',
                        name: 'isMain',
                        value: 1,
                        checked: true
                    },
                    {
                        label: 'Status de la page',
                        type: 'select',
                        name: 'isPublished',
                        options: pageOptions
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
        modal.open()
    }

    function showModalForUpdatePage(page) {
        const modal = new FormModal({
            title: `Page: ${page['name']}`,
            form: {
                method: 'POST',
                action: `${page['id']}/update`,
                inputs: [{
                        label: 'Nom de la page',
                        type: 'text',
                        name: 'name',
                        value: page['name']
                    },
                    {
                        label: 'Chemin de la page (URL)',
                        type: 'text',
                        name: 'slug',
                        value: page['slug']
                    },
                    {
                        label: 'Page principale',
                        type: 'checkbox',
                        name: 'isMain',
                        value: 1,
                        checked: parseInt(page['isMain'], 10)
                    },
                    {
                        label: 'Status de la page',
                        type: 'select',
                        name: 'isPublished',
                        options: [{
                                name: 'Brouillon',
                                value: 0,
                                selected: parseInt(page['isPublished'], 10)
                            },
                            {
                                name: 'Publié',
                                value: 1,
                                selected: parseInt(page['isPublished'], 10)
                            }
                        ]
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
        modal.open()
    }

    function showModalForDeletePage(page) {
        const modal = new YesNoModal({
            title: `Voulez vous supprimer ${page['name']} ?`,
            form: {
                method: 'POST',
                action: `${page['id']}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }
</script>