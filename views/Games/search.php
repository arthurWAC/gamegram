<div class="starter-template text-center mt-5 px-3">
	<h1>Recherche</h1>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8">
	<?php
    $form = new BootstrapForm('search', 'Game', METHOD_GET);
    $form->addInput('name',	TYPE_TEXT, 	[
        'label' => 'Nom du jeu',
        'placeholder' => 'Ecris tout ou une partie du nom',
        'value' => $_search_name
    ]);
   
    $form->addInput('publisher_id', TYPE_SELECT, [
        'label' => 'Editeur', 
        'data' => $_publishers,
        'empty' => 'Tous les éditeurs',
        'class' => 'select2',
        'value' => $_search_publisher_id
    ]);
    
    $form->addInput('family_id', TYPE_SELECT, [
        'label' => 'Genre',
        'data' => $_families,
        'empty' => 'Toutes les familles',
        'class' => 'select2',
        'value' => $_search_family_id
    ]);
    
    $form->addInput('platform_id', TYPE_SELECT, [
        'label' => 'Plateforme',
        'data' => $_platforms,
        'empty' => 'Toutes les plateformes',
        'class' => 'select2',
        'value' => $_search_platform_id
    ]);

    $form->addInput('note', TYPE_RADIO, [
        'label' => 'Note minimale',
        'data' => [0 => 'Toutes les notes', 6 => '6+', 7 => '7+', 8 => '8+', 9 => '9+'],
        'value' => $_search_note
    ]);
    
	$form->setSubmit('Je recherche', ['color' => WARNING]);
	
	echo $form->form();
	?>
	</div>
</div>

<?php if (!empty($_games)) : ?>
<div class="starter-template text-center mt-5 px-3">
	<h3>Résultats de recherche : <?= count($_games); ?></h3>
    
    <div class="row justify-content-center">
        <div class="col col-md-6">
        <?php foreach ($_games as $jeu): ?>

            <div class="card mb-2">
                <div class="card-body">
                <span class="badge bg-success float-end"><?= $jeu->year; ?></span>
                    <h5 class="card-title"><?= ucfirst($jeu->name)?> </h5>
                    <p class="card-text">Note du public : <strong><?= $jeu->note ;?></strong>/10</p>
                    <?php
                    
                    echo $html->button(
                        'Voir le jeu',
                        [
                            'dir' => 'games',
                            'page' => 'one',
                            'options' => ['id' => $jeu->id]
                        ],
                        ['color' => SUCCESS,'class' => 'btn-sm']
                    );

                    if (in_array($jeu->id, $_collection)) {
                        echo '<p class="mt-3"><i>Jeu dans la collection</i></p>';
                    } else {
                        $form = new BootstrapForm('addToCollection', 'Collection', METHOD_POST);

                        $form->addInput('game_id', TYPE_HIDDEN, ['value' => $jeu->id]);
                        $form->setSubmit('Ajouter à ma collection', ['color' => WARNING, 'class' => 'btn-sm']);
                        
                        echo $form->form();
                    }
                    ?>
                </div>
            </div>

            <?php endforeach; ?>
            </div>
        </div>
</div>
<?php endif; ?>