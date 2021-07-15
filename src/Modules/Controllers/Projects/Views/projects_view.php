<section>
    <p>Welcome to your home <?= $user['firstname']; ?> !</p>
    <?php $form->render() ?>
    <ul>
        <?php foreach ($projects as $project) : ?>
            <li>
                <a href="<?php echo '/projects/' . $project['id'] . '/informations' ?>"><?= $project['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>