<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;

$currentProject = $_SESSION['currentProject'];

['templateApplied' => $templateApplied] = $currentProject;

?>

<section class="padding-section">
    <div class="row justify-content-start bb-header">
        <h2>
            Templates
        </h2>
    </div>
    <div class="row justify-content-end bb-margin-high-bottom">
        <button onclick='showModalForCreateTemplate()' class="button button--primary">
            Créer un Template
        </button>
    </div>
    <?php if (isset($_GET['success'])) : ?>
        <ul class="alert alert--success bb-margin-medium-top-bottom">
            <?php $successMessages = explode(',', $_GET['success']) ?>
            <?php foreach ($successMessages as $message) : ?>
                <li><?= htmlspecialchars($message) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if (isset($templates) && count($templates) > 0) : ?>
        <?php foreach ($templates as $template) : ?>
            <?php $templateId = $template['id'] ?>
            <div class="row row-template <?php echo $templateApplied === $templateId ? 'bb-border-selected' : ''; ?>">
                <p><?= $template['name']; ?></p>
                <ul>
                    <?php $title = $templateApplied === $templateId ? 'Enlever le Template' : 'Appliquer le Template'; ?>
                    <button onclick='showModalForApplyTemplate(<?php BinksBeatHelper::toJson($title) ?>, <?php BinksBeatHelper::toJson($templateId) ?>)' class="button-light button-light--secondary bb-padding-10">
                        <?php echo $title; ?>
                    </button>
                </ul>
                <div>
                    <ul class="row">
                    </ul>
                    <ul class="row">
                        <a href="<?php Router::go($template['id']) ?>" class="edit"></a>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="row bb-padding">
            <div class="no-data">
                <p class="sad"></p>
                <p class="text">Vous ne possédez pas de templates ...</p>
            </div>
        </div>
    <?php endif; ?>
</section>


<script type="text/javascript">
    const {
        id: projectId
    } = <?php BinksBeatHelper::toJson($currentProject); ?>;

    function showModalForCreateTemplate() {
        const modal = new FormModal({
            title: 'Créer un Template',
            form: {
                method: 'POST',
                action: `/projects/${projectId}/templates`,
                inputs: [{
                        label: 'Nom du Template',
                        type: 'text',
                        name: 'name'
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

    function showModalForApplyTemplate(title, templateId) {
        const modal = new YesNoModal({
            title: title + '? Attention, vous risquez d\'écraser des modifications de style !',
            form: {
                method: 'POST',
                action: `/projects/${projectId}/templates/${templateId}/apply`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }
</script>