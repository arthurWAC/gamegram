<?php
class Design
{
	// Renvoie l'url d'une icone en fonction d'un family_id
	public function icon($familyId)
	{
		$correspondances = [
			1 => 'Sport',
			2 => 'Landscape',
			3 => 'Sports Mode',
			4 => 'Crime',
			5 => 'Fantasy',
			6 => 'Puzzle',
			7 => 'Music',
			8 => 'Audience',
			9 => 'Sci Fi',
			10 => 'Iron Man',
			11 => 'Iron Man',
			12 => 'Action',
			13 => 'Binoculars',
			14 => 'Iron Man',
			15 => 'Music',
			16 => 'Fantasy',
		];

		$image = $correspondances[$familyId];

		if ($image == '') {
			$image = 'Start';
		}

		return 'assets/img/icons/'. $image .'.svg';
	}
}