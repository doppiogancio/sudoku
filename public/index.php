<?php

require_once "./../loader.php";

use core\Cell\CellDecorator;
use core\Set\Region;
use core\Strategy\Strategy;
use core\Strategy\StrategyCandidatesRow;
use core\Log\Log;

Log::addPrimary( 'Partita cominciata' );

try {
	$sudoku = new \core\Sudoku\SudokuSummerExpert();

	( new Strategy() )->execute( $sudoku->getSets() );
	( new StrategyCandidatesRow() )->execute( $sudoku->getSets() );
	( new Strategy() )->execute( $sudoku->getSets() );
	( new StrategyCandidatesRow() )->execute( $sudoku->getSets() );
} catch ( Exception $e ) {
	Log::addException( $e );
}

Log::addPrimary( 'Partita terminata' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sudoku</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
	      integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
	      integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
	        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
	        crossorigin="anonymous"></script>

	<script src="js/sudoku.grid.js" type="application/javascript"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<div class="container">

	<div class="row">
		<div class="col-md-6 col-xs-12">
			<h2>Sudoku</h2>

			<?php if ( ! empty( $sudoku ) ) { ?>

				<table class="sudoku-grid">
					<tr>
						<td class="cell">&nbsp;</td>
						<?php for ( $i = 1; $i <= 9; $i ++ ) { ?>
							<th class="cell"><?php print $i; ?></th>
						<?php } ?>
					</tr>
					<tbody>
					<?php foreach ( $sudoku->getGrid() as $rowNumber => $row ) { ?>
						<tr>
							<th class="cell"><?php print $rowNumber; ?></th>

							<?php foreach ( $row as $columnNumber => $cell ) { ?>
								<td class="<?php CellDecorator::build( $cell )->printClassList() ?>"
								    data-row="<?php print $rowNumber; ?>"
								    data-column="<?php print $columnNumber; ?>"
								    data-region="<?php print Region::getIdByCoordinate( $rowNumber, $columnNumber ); ?>">

									<?php if ( $cell->hasValue() ) { ?>
										<?php print $cell->getValue(); ?>
									<?php } else { ?>
										<div class="candidates clearfix">
											<?php foreach ( $cell->getCandidates() as $candidate ) { ?>
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

			<?php } ?>
		</div>
		<div class="col-md-6 col-xs-12">
			<h2>Log</h2>
			<?php Log::print(); ?>
		</div>
	</div>
</div>


</body>
</html>