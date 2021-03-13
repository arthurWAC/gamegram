<div class="starter-template text-center mt-5 px-3">
	<h1>Recherche</h1>
</div>

<div class="row justify-content-center">
	<div class="col col-sm-8">
	<?php
    $form = new BootstrapForm('search', 'Game', METHOD_GET);
    $form->addInput('name',	TYPE_TEXT, 	['label' => 'Nom du jeu', 'placeholder' => 'Ecris tout ou une partie du nom']);
   
    $form->addInput('publisher_id', TYPE_SELECT, [
        'label' => 'Editeur', 
        'data' => $_publishers,
        'empty' => 'Tous les éditeurs',
        'class' => 'select2'
    ]);
    
    $form->addInput('family_id', TYPE_SELECT, [
        'label' => 'Genre',
        'data' => $_families,
        'empty' => 'Toutes les familles',
        'class' => 'select2'
    ]);
    
    $form->addInput('platform_id', TYPE_SELECT, [
        'label' => 'Plateforme',
        'data' => $_platforms,
        'empty' => 'Toutes les plateformes',
        'class' => 'select2'
    ]);

    $form->addInput('note', TYPE_RADIO, [
        'label' => 'Note minimale',
        'data' => [0 => 'Toutes les notes', 6 => '6+', 7 => '7+', 8 => '8+', 9 => '9+'],
        'value' => 0
    ]);
    
	$form->setSubmit('Je recherche', ['color' => WARNING]);
	
	echo $form->form();
	?>
	</div>
</div>

<?php if (!empty($_games)) : ?>
<div class="starter-template text-center mt-5 px-3">
	<h3>Résultats de recherche : <?= count($_games); ?></h3>
</div>
<?php endif; ?>