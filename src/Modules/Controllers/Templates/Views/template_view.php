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
    <div class="row justify-content-start bb-header">
        <div class="exit">
            <a href="<?php Router::go("..") ?>">
                <div>
                    <p></p>
                </div>
            </a>
        </div>
    </div>
    <div class="bb-card">
        <div class="bb-card-header">
            <h3>Édition du Template : <?= $tpl['name'] ?></h3>
        </div>
        <div class="row flex-column bb-padding">
            <div class="row justify-content-end">
                <button onclick='showModalForDeleteTemplate()' class="button button--danger">Supprimer le Template</button>
            </div>
            <?php $form->render() ?>
        </div>

    </div>
</main>

<script src="https://cdn.tiny.cloud/1/s989d7t1555ikkqjx18527sclb7fhrjwhs3m7ionqylqz3us/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    const projectId = <?php BinksBeatHelper::toJson($projectId); ?>;
    const templateId = <?php BinksBeatHelper::toJson($templateId); ?>;



    // let saveTemplateTimeOut;
    /**
     * @params page ex: { content : 'blablabla', backgroundColor: '#FFFFFF' }
     */
    // function saveTemplate(template) {
    //     return fetch(`/projects/${projectId}/templates/${templateId}/content`, {
    //             method: 'POST',
    //             body: JSON.stringify({
    //                 ...template,
    //                 csrf // this variable is in the parent script js (project_tpl.php)
    //             })
    //         })
    //         .then(res => res.json())
    //         .then(result => {
    //             document.getElementById('content-status').style.color = '#2ED47A'
    //             document.getElementById('content-status').innerHTML = 'Sauvegarde effectuée'
    //         })
    //         .catch(err => console.log(err))
    // }

    // function decodeHTML(html) {
    //     var txt = document.createElement('textarea');
    //     txt.innerHTML = html;
    //     return txt.value;
    // }

    // function setTemplateWithSettings(template, settings) {
    //     const decodedTemplate = decodeHTML(template)
    //     const templateWithSettings = getTemplateWithSettings(decodedTemplate, settings)
    //     setContentTemplate(templateWithSettings)
    // }

    // function getTemplateWithSettings(template, settings) {
    //     var el = document.createElement('div');
    //     el.innerHTML = decodeHTML(template);
    //     const children = [...el.getElementsByTagName('*')];
    //     children.forEach((child) => {
    //         setSettings(child, settings)
    //     });
    //     return el.outerHTML
    // }

    // function setSettings(element, settings) {
    //     const elementSettings = settings[element.tagName.toLowerCase()]
    //     if (elementSettings) {
    //         setStyle(element, elementSettings);
    //     }
    // }

    // function setStyle(element, elementSettings) {
    //     if (element.children.length) {
    //         const span = element.children[0]
    //         for (var key in elementSettings) {
    //             span.style[key] = elementSettings[key];
    //         }
    //     } else {
    //         for (var key in elementSettings) {
    //             element.style[key] = elementSettings[key];
    //         }
    //     }

    // }

    function showModalForDeleteTemplate() {
        const modal = new YesNoModal({
            title: `Êtes vous sûr de vouloir supprimer définitivement ?`,
            form: {
                method: 'POST',
                action: `/projects/${projectId}/templates/${templateId}/delete`,
                csrf,
                submit: 'Oui'
            }
        })
        modal.open()
    }

</script>