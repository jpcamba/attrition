<?php

use Kachkaev\PHPR\RCore;
use Kachkaev\PHPR\Engine\CommandLineREngine;

class SimulationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('simulation.simulation');
	}

	//Individual Factor - Employment
	public function showEmployment() {
		$error = '';
		return View::make('simulation.employment.employment', compact('error'));
	}

	//Show Attrition - Employment
	public function postEmployment() {
		$input = [];
		$input['ft'] = Input::get('full-time');
		$input['pt'] = Input::get('part-time');
		$input['ne'] = Input::get('not-employed');
		$error = '';
		$employed = ($input['ft'] + $input['pt']) / 100;
		$unemployed = $input['ne'] / 100;
		$attrition = 0;
		$error = '';

		$rPath = '/usr/bin';
		$pubPath = public_path();
		$pubPath = str_replace('\\', '/', $pubPath);
		$dirPath = '\''.$pubPath.'/simulation-others/data/\'';

		$rFile = fopen($pubPath.'\\simulation-others\\scripts\\simulation.R', 'w');
		$rScript = (<<<EOF
			library(e1071)
			dataDirectory<-
EOF
);

		if ($unemployed > $employed) {
			$rScript = $rScript.$dirPath.(<<<EOF

				data<-read.csv(paste(dataDirectory, 'all_employment.csv', sep=''), header = TRUE)
				model<-svm(Y ~ X, data)
				predictY<-predict(model, data.frame(X =
EOF
);
			$rScript = str_replace(' ', '', $rScript);
			$employed2 = 1 - $unemployed;
			$rScript = $rScript.$employed2;
			$rScript = $rScript.(<<<EOF
				))
				predictY
EOF
);
		}

		else {
			$rScript = $rScript.$dirPath.(<<<EOF

				data<-read.csv(paste(dataDirectory, 'all_unemployment.csv', sep=''), header = TRUE)
				model<-svm(Y ~ X, data)
				predictY<-predict(model, data.frame(X =
EOF
);
			$rScript = str_replace(' ', '', $rScript);
			$unemployed2 = 1 - $employed;
			$rScript = $rScript.$unemployed2;
			$rScript = $rScript.(<<<EOF
				))
				predictY
EOF
);

		}

		fwrite($rFile, $rScript);
		fclose($rFile);

		exec('cd '.$rPath.' && Rscript '.$pubPath.'/simulation-others/scripts/simulation.R', $attrition);

		$attrition = round($attrition[1], 4) * 100;

		if (array_sum($input) != 100) {
			$error = 'Invalid input. Sum of input should be equal to 100%.';
			return View::make('simulation.employment.employment', compact('error', 'attrition'));
		}

		else
			return View::make('simulation.employment.attrition', compact('error', 'input', 'attrition'));
	}

	//Individual Factor - Grades
	public function showGrades() {
		$error = '';
		return View::make('simulation.grades.grades', compact('error'));
	}

	//Show Attrition - Grades
	public function postGrades() {
		$input = [];
		$input['lineof1'] = Input::get('lineof1');
		$input['lineof2'] = Input::get('lineof2');
		$input['lineof3'] = Input::get('lineof3');
		$input['lineof4'] = Input::get('lineof4');
		$passing = ($input['lineof1'] + $input['lineof2']) / 100;
		$failing = ($input['lineof3'] + $input['lineof4']) / 100;
		$attrition = 0;
		$error = '';

		$rPath = '/usr/bin';
		$pubPath = public_path();
		$pubPath = str_replace('\\', '/', $pubPath);
		$dirPath = '\''.$pubPath.'/simulation-others/data/\'';

		$rFile = fopen($pubPath.'\\simulation-others\\scripts\\simulation.R', 'w');
		$rScript = (<<<EOF
			library(e1071)
			dataDirectory<-
EOF
);

		if ($passing > $failing) {
			$rScript = $rScript.$dirPath.(<<<EOF


		data<-read.csv(paste(dataDirectory, 'all_lowgrades.csv', sep=''), header = TRUE)
		model<-svm(Y ~ X, data)
		predictY<-predict(model, data.frame(X =
EOF
);
			$rScript = str_replace(' ', '', $rScript);
			$passing2 = 1 - $failing;
			$rScript = $rScript.$passing2;
			$rScript = $rScript.(<<<EOF
				))
				predictY
EOF
);
		}

		else {
			$rScript = $rScript.$dirPath.(<<<EOF

				data<-read.csv(paste(dataDirectory, 'all_highgrades.csv', sep=''), header = TRUE)
				model<-svm(Y ~ X, data)
				predictY<-predict(model, data.frame(X =
EOF
);
			$rScript = str_replace(' ', '', $rScript);
			$failing2 = 1 - $passing;
			$rScript = $rScript.$failing2;
			$rScript = $rScript.(<<<EOF
				))
				predictY
EOF
);

		}

		fwrite($rFile, $rScript);
		fclose($rFile);

		exec('cd '.$rPath.' && Rscript '.$pubPath.'/simulation-others/scripts/simulation.R', $attrition);

		$attrition = round($attrition[1], 4) * 100;

		if (array_sum($input) != 100) {
			$error = 'Invalid input. Sum of input should be equal to 100%.';
			return View::make('simulation.grades.grades', compact('error'));
		}

		else
			return View::make('simulation.grades.attrition', compact('error', 'input', 'attrition'));
	}

	//Individual Factor - Region
	public function showRegion() {
		$error = '';
		return View::make('simulation.region.region', compact('error'));
	}

	//Show Attrition - Region
	public function postRegion() {
		$input = [];
		$input['luzon'] = Input::get('luzon');
		$input['visayas'] = Input::get('visayas');
		$input['mindanao'] = Input::get('mindanao');
		$far = ($input['visayas'] + $input['mindanao']) / 100;
		$attrition = 0;
		$error = '';

		$rPath = 'C:/Program Files/R/R-3.2.4revised/bin';
		$pubPath = public_path();
		$pubPath = str_replace('\\', '/', $pubPath);
		$dirPath = '\''.$pubPath.'/simulation-others/data/\'';

		$rFile = fopen($pubPath.'\\simulation-others\\scripts\\simulation.R', 'w');
		$rScript = (<<<EOF
			library(e1071)
			dataDirectory<-
EOF
);
		$rScript = $rScript.$dirPath.(<<<EOF

			data<-read.csv(paste(dataDirectory, 'all_region.csv', sep=''), header = TRUE)
			model<-svm(Y ~ X, data)
			predictY<-predict(model, data.frame(X =
EOF
);
		$rScript = str_replace(' ', '', $rScript);
		$rScript = $rScript.$far;
		$rScript = $rScript.(<<<EOF
			))
			predictY
EOF
);

		fwrite($rFile, $rScript);
		fclose($rFile);

		exec('cd '.$rPath.' && Rscript '.$pubPath.'/simulation-others/scripts/simulation.R', $attrition);

		$attrition = round($attrition[1], 4) * 100;
		if (array_sum($input) != 100) {
			$error = 'Invalid input. Sum of input should be equal to 100%.';
			return View::make('simulation.region.region', compact('error'));
		}

		else
			return View::make('simulation.region.attrition', compact('error', 'input', 'attrition'));
	}

	//Individual Factor - ST Bracket
	public function showStbracket() {
		$error = '';
		return View::make('simulation.stdiscount.stdiscount', compact('error'));
	}

	//Show Attrition - ST Bracket
	public function postStbracket() {
		$input = [];
		$input['nd'] = Input::get('nd');
		$input['pd33'] = Input::get('pd33');
		$input['pd60'] = Input::get('pd60');
		$input['pd80'] = Input::get('pd80');
		$input['fd'] = Input::get('fd');
		$input['fds'] = Input::get('fds');
		$poor = ($input['nd'] + $input['pd33']) / 100;
		$attrition = 0;
		$error = '';

		$rPath = '/usr/bin';
		$pubPath = public_path();
		$pubPath = str_replace('\\', '/', $pubPath);
		$dirPath = '\''.$pubPath.'/simulation-others/data/\'';

		$rFile = fopen($pubPath.'\\simulation-others\\scripts\\simulation.R', 'w');
		$rScript = (<<<EOF
			library(e1071)
			dataDirectory<-
EOF
);
		$rScript = $rScript.$dirPath.(<<<EOF

			data<-read.csv(paste(dataDirectory, 'all_stbracketab.csv', sep=''), header = TRUE)
			model<-svm(Y ~ X, data)
			predictY<-predict(model, data.frame(X =
EOF
);
		$rScript = str_replace(' ', '', $rScript);
		$rScript = $rScript.$poor;
		$rScript = $rScript.(<<<EOF
			))
			predictY
EOF
);

		fwrite($rFile, $rScript);
		fclose($rFile);

		exec('cd '.$rPath.' && Rscript '.$pubPath.'/simulation-others/scripts/simulation.R', $attrition);

		$attrition = round($attrition[1], 4) * 100;

		if (array_sum($input) != 100) {
			$error = 'Invalid input. Sum of input should be equal to 100%.';
			return View::make('simulation.stdiscount.stdiscount', compact('error'));
		}

		else
			return View::make('simulation.stdiscount.attrition', compact('error', 'input', 'attrition'));
	}

	//Individual Factor - Units
	public function showUnits() {
		$error = '';
		return View::make('simulation.units.units', compact('error'));
	}

	//Show Attrition - Units
	public function postUnits() {
		$input = [];
		$input['underload'] = Input::get('underload');
		$input['regular'] = Input::get('regular');
		$input['overload'] = Input::get('overload');
		$overloading = $input['overload'] / 100;
		$underloading = $input['underload'] / 100;
		$attrition = 0;
		$error = '';

		$rPath = '/usr/bin';
		$pubPath = public_path();
		$pubPath = str_replace('\\', '/', $pubPath);
		$dirPath = '\''.$pubPath.'/simulation-others/data/\'';

		$rFile = fopen($pubPath.'\\simulation-others\\scripts\\simulation.R', 'w');
		$rScript = (<<<EOF
			library(e1071)
			dataDirectory<-
EOF
);

		if ($input['underload'] >= ($input['regular'] + $input['overload'])) {
			$rScript = $rScript.$dirPath.(<<<EOF

				data<-read.csv(paste(dataDirectory, 'all_underloadingunits.csv', sep=''), header = TRUE)
				model<-svm(Y ~ X, data)
				predictY<-predict(model, data.frame(X =
EOF
);
			$rScript = str_replace(' ', '', $rScript);
			$rScript = $rScript.$underloading;
		}

		else {
			$rScript = $rScript.$dirPath.(<<<EOF

				data<-read.csv(paste(dataDirectory, 'all_overloadingunits.csv', sep=''), header = TRUE)
				model<-svm(Y ~ X, data)
				predictY<-predict(model, data.frame(X =
EOF
);
			$rScript = str_replace(' ', '', $rScript);
			$rScript = $rScript.$overloading;
		}

		$rScript = $rScript.(<<<EOF
			))
			predictY
EOF
);

		fwrite($rFile, $rScript);
		fclose($rFile);

		exec('cd '.$rPath.' && Rscript '.$pubPath.'/simulation-others/scripts/simulation.R', $attrition);

		$attrition = round($attrition[1], 4) * 100;

		if (array_sum($input) != 100) {
			$error = 'Invalid input. Sum of input should be equal to 100%.';
			return View::make('simulation.units.units', compact('error'));
		}

		else
			return View::make('simulation.units.attrition', compact('error', 'input', 'attrition'));
	}
}
