<?php

use App\Core\Router\Router;
use App\Modules\BinksBeatHelper;
?>

<div class="edit-nav">
    <div class="row left-options">
        <div class="exit">
            <a href="<?php Router::go('../..'); ?>">
                <div>
                    <p></p>
                </div>
            </a>
        </div>
        <div id="selected-page" class="md-select bb-select-two">
            <label style="margin: auto" for="ul-id"><button id="select-page" type="button" class="ng-binding"><?= BinksBeatHelper::shortText($currentPage['name']) ?></button></label>
            <ul style="top: 80px" role="listbox" id="ul-id" class="md-whiteframe-z1" aria-activedescendant="state2_AK" name="ul-id">
                <?php foreach ($pages as $page) : ?>
                    <li role="option" id="state2_AK" class="ng-binding ng-scope active">
                        <a href="<?php Router::setRoute('pages', $page['id']) ?>">
                            <?= $page['name']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>
        <div class="eye">
            <a target="_blank" href="<?php Router::go("~/" . $currentProject['slug'] . "/" . $currentPage['slug']); ?>">
                <div>
                    <p></p>
                </div>
            </a>
        </div>
        <div class="stretch">
            <div onclick='removeSides()'>
                <p></p>
            </div>
        </div>
    </div>
    <div class="row right-options">
        <div>
            <span id="content-status"></span>
        </div>
        <div id="publish" class="md-select bb-select-two">
            <label style="margin: auto" for="ul-id2">
                <button id="select-publish" type="button" class="ng-binding"><?= boolval($currentPage['isPublished']) ? "Publié" : "Brouillon"  ?></button>
            </label>
            <ul style="top: 50px; margin-left: 50px" role="listbox" id="ul-id2" class="md-whiteframe-z1" aria-activedescendant="state2_AK" name="ul-id">
                <li onclick='savePublishStatusPage(1)' for="select-publish" role="option" id="state2_AK" class="ng-binding ng-scope active">
                    <a>Publié</a>
                </li>
                <li onclick='savePublishStatusPage(0)' for="select-publish" role="option" id="state2_AK" class="ng-binding ng-scope active">
                    <a>Brouillon</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<main id="editPage" class="row">
    <div id="content">
        <?php include $this->view ?>
    </div>
</main>

<script type="text/javascript">
    const csrf = <?php echo json_encode($_SESSION["csrf"]); ?>

    function savePublishStatusPage(status) {
        fetch('', {
                method: 'POST',
                body: JSON.stringify({
                    isPublished: status.toString(),
                    csrf
                })
            })
            .then(res => res.json())
            .then(result => {
                console.log(result)
            })
            .catch(err => console.log(err))
    }

    function removeSides() {
        const leftSideBar = document.getElementById('left-sidebar');
        const rightSideBar = document.getElementById('right-sidebar');
        leftSideBar.style.display === 'none' ? leftSideBar.style.display = 'inherit' : leftSideBar.style.display = 'none'
        rightSideBar.style.display === 'none' ? rightSideBar.style.display = 'inherit' : rightSideBar.style.display = 'none'
    }
</script>