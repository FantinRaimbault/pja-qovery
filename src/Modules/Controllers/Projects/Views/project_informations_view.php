<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;

?>

<section class="padding-section row flex-column full-height overflow-y-scroll">
    <div class="row justify-content-start bb-header">
        <h2>
            Informations
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
    <div class="row">
        <div class="flex flex-1">
            <div class="bb-card">
                <div class="bb-card-header">
                    <h3>Profil</h3>
                </div>
                <div class="row flex-column bb-padding">
                    <div style="background-color: <?php echo $_SESSION['currentProject']['picture'] ?>" class="project-profile-picture align-self-center bb-margin-5 "></div>
                    <?php $generalForm->render() ?>
                </div>
            </div>
        </div>
        <div class="flex flex-column flex-2">
            <div class="flex flex-1">
                <div class="bb-card bb-margin-medium-left bb-margin-medium-right">
                    <div class="bb-card-header">
                        <h3>Vos derniers Beats</h3>
                    </div>
                    <div class="row bb-padding">
                        <div class="no-data">
                            <p class="sad"></p>
                            <p class="text">Vous ne possédez pas de musiques ...</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-1-1-300 flex-column">
                    <div class="bb-card-header bb-margin-medium-bottom">
                        <h3>Partager à la communauté</h3>
                        <input onchange='toggleCheckbox(this)' type="checkbox" class="switch toggle" <?php echo boolval(($_SESSION['currentProject']['allowCommunity'])) ? 'checked' : '' ?>>
                    </div>
                    <div class="bb-card">
                        <div class="bb-card-header">
                            <h3>Chiffres clés</h3>
                        </div>
                        <div class="row bb-padding">
                            Salut tlm
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-1">
                <div class="bb-card-header bb-margin-medium-left bb-margin-medium-top full-width">
                    <h3>URL de votre projet</h3>
                    <div class="flex align-items-center">
                        <input class="width-350" type="text" value="<?php echo $_SERVER['HTTP_HOST'] . "/" . $_SESSION['currentProject']['slug'] ?>" disabled name="name">
                        <a target="_blank" href="<?php Router::go("~/" . $_SESSION['currentProject']['slug']); ?>">
                            <p class="web bb-margin-medium-left"></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    const currentProject = <?php BinksBeatHelper::toJson($_SESSION['currentProject']); ?>;
    const {
        id: projectId
    } = currentProject

    function toggleCheckbox(checkbox) {
        fetch(`/projects/${projectId}/informations/allowCommunity`, {
                method: 'POST',
                body: JSON.stringify({
                    allowCommunity: Number(checkbox.checked),
                    csrf // this variable is in the parent script js (project_tpl.php)
                })
            })
            .then(res => res.json())
    }
</script>