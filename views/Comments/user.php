<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3">Les commentaires de <?= $Auth->User->pseudo; ?></h1>
</div>
<div class="row justify-content-center mt-5">
	<div class="col col-sm-8">
    <?php
    foreach ($_comments as $comment) {
        include(DIR_VIEWS . 'Elements/comment_seul.php');
    }
    ?>
    </div>
</div>