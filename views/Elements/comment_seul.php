<?php
if (!isset($comment)) {
    die('Mauvaise utilisation de cet élément, il manque $comment');
}
?>
<div class="row justify-content-center mb-5">
	<div class="col col-sm-8">
        <div class="card">
            <div class="card-header">
                <h5 class="subtitle">Commentaire au post <i><?= $comment->Post->title; ?></i></h5>
            </div>
            <div class="card-body">
                <p><?= $comment->content; ?></p>
            </div>
        </div>
    </div>
</div>