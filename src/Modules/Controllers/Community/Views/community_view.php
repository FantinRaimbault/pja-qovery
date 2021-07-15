<?php

use App\Core\Router\Router;
?>

<section class="padding-section row flex-column full-height">
    <div class="row justify-content-start bb-header">
        <h2>
            Communauté
        </h2>
    </div>
    <div class="flex-1-1-auto overflow-y-auto">
        <?php if (isset($projects) && count($projects) > 0) : ?>
            <?php foreach ($projects as $project) : ?>
                <?php
                [
                    "projectId" => $projectId,
                    "name" => $name,
                    "description" => $description,
                    "slug" => $slug,
                    "PSLUG" => $PSLUG,
                    "owner_firstname" => $ownerFirstname,
                    "picture" => $picture
                ] = $project;
                ?>
                <div class="row bb-margin-medium-bottom project-card">
                    <a href="<?php Router::go("/$projectId") ?>">
                        <div style="background-color: <?php echo $picture ?>" class="profile-picture">

                        </div>
                    </a>
                    <div class="flex-8 flex flex-column left-content">
                        <div class="title"><?= $name ?></div>
                        <div class="description"><?= $description ?></div>
                        <div class="stars">
                            <div class="flex btn-star">
                                <p class="nb-stars">60</p>
                                <p class="star"></p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-2 flex flex-column right-content">
                        <div class="flex align-items-center justify-content-center link-to-project">
                            <a href="<?php Router::go("~/$slug/$PSLUG") ?>">
                                <button class="button-underlined button-underlined--blue">Voir le projet</button>
                            </a>
                        </div>
                        <div class="flex align-items-center justify-content-center owner">
                            <p><?= $ownerFirstname ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>