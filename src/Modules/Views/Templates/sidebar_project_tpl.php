<?php

use App\Core\Logger;
use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;
use App\Modules\Controllers\Auth\Models\Contributor;

$projects = $_SESSION['projects'];
$currentProjectId = $_SESSION['currentProject']['id'];
$userId = $_SESSION['user']['id'];

$contributorResult = (new Contributor())->findOne([
    ['userId', "=", $userId],
    ['projectId', "=", $currentProjectId],
]);
$contributor = new Contributor($contributorResult);
?>
<main class="row">
    <div class="sidebar">
        <ul class="row flex-column sidebar-content">
            <div class="md-select bb-select-one">
                <label for="ul-id"><button type="button" class="ng-binding"><?= BinksBeatHelper::shortText($_SESSION['currentProject']['name'])  ?></button></label>
                <ul role="listbox" id="ul-id" class="md-whiteframe-z1" aria-activedescendant="state2_AK" name="ul-id">
                    <?php foreach ($projects as $project) : ?>
                        <li role="option" id="state2_AK" class="ng-binding ng-scope active">
                            <a href="<?php Router::setRoute('project', $project['id']) ?>">
                                <?= $project['name']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="<?php Router::go("~/projects/$currentProjectId/informations"); ?>">Informations</a>
            <?php if ($contributor->canAccessPages()) : ?>
                <a href="<?php Router::go("~/projects/$currentProjectId/pages"); ?>">Pages</a>
            <?php endif; ?>
            <?php if ($contributor->canAccessMusiques()) : ?>
                <a>Musiques</a>
            <?php endif; ?>
            <a>Statistiques</a>
            <?php if ($contributor->canAccessTemplates()) : ?>
                <a href="<?php Router::go("~/projects/$currentProjectId/templates"); ?>">Templates</a>
            <?php endif; ?>
            <a href="<?php Router::go("~/projects/$currentProjectId/settings"); ?>">Paramètres</a>
        </ul>
    </div>
    <div id="content">
        <?php include $this->view ?>
    </div>
</main>