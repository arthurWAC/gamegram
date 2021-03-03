<div class="starter-template text-center mt-5 px-3">
	<h1 class="mb-3">Le feed de <?= $_member->pseudo; ?></h1>
</div>

<div class="row justify-content-center mt-5">
	<div class="col col-sm-8">
    <?php
    foreach ($_member->LastPostsAndComments as $postOrComment) {

        if (is_a($postOrComment['data'], 'Post')) {
            $post = $postOrComment['data'];
            include(DIR_VIEWS . 'Elements/post_seul.php');
        }

        if (is_a($postOrComment['data'], 'Comment')) {
            $comment = $postOrComment['data'];
            include(DIR_VIEWS . 'Elements/comment_seul.php');
        }
    }
    ?>
    </div>
</div>