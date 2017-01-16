<?php

require_once "./../loader.php";

use core\Cell\CellDecorator;
use core\Set\Region;
use core\Strategy\Strategy;

try {
	$sudoku = new \core\Sudoku\SudokuExtreme();

	(new Strategy())->execute($sudoku->getRows())
                ->execute($sudoku->getColumns())
                ->execute($sudoku->getRegions());

	(new Strategy())->execute($sudoku->getRows())
	                ->execute($sudoku->getColumns())
	                ->execute($sudoku->getRegions());

	(new Strategy())->execute($sudoku->getRows())
	                ->execute($sudoku->getColumns())
	                ->execute($sudoku->getRegions());
}
catch (Exception $e) {
	echo "<pre>";
	print $e->getTraceAsString()."\n";
	echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sudoku</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>




	<script src="js/sudoku.grid.js" type="application/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<table class="sudoku-grid">
	<tr>
		<th class="cell">&nbsp;</th>
		<?php for ($i = 1; $i <= 9; $i++) { ?>
			<th class="cell"><?php print $i; ?></th>
		<?php } ?>
	</tr>

	<tbody>
		<?php foreach ($sudoku->getGrid() as $rowNumber => $row) { ?>
			<tr>
				<th class="cell"><?php print $rowNumber; ?></th>

				<?php foreach ($row as $columnNumber => $cell) { ?>
					<td class="<?php CellDecorator::build($cell)->printClassList() ?>"
					    data-row="<?php print $rowNumber; ?>"
					    data-column="<?php print $columnNumber; ?>"
					    data-region="<?php print Region::getIdByCoordinate($rowNumber, $columnNumber); ?>">

						<?php if ($cell->hasValue()) { ?>
							<?php print $cell->getValue(); ?>
						<?php } else { ?>
							<div class="candidates clearfix">
								<?php foreach ($cell->getCandidates() as $candidate) { ?>
									<div class="candidate">
										<?php print $candidate; ?>
									</div>
								<?php } ?>
							</div>

						<?php } ?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>


</table>

</body>
</html>