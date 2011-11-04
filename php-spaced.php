<?

	/**************
	
	php-spaced is a set of functions implementing spaced repetition algorithms.
	The functions were written by John Biesnecker <jbiesnecker@gmail.com> and released
	into the public domain under a CC0 license:
	
	http://creativecommons.org/publicdomain/zero/1.0/
	
	If you do anything awesome with them, though, please let me know -- I'd love to see
	what you've built.
	
	
	**************/
	
	
	/*
	
	This function takes an array with three values:
	
	'repetition' : the number of repetitions completed BEFORE the current repetition
	'interval' : the existing interval (or 0 if this is the first repetition)
	'ef' : the existing EF (>= 1.3)
	
	as well as a grade (between 0 and 5)
	
	and returns an identical array with values updated based on the grade or false on error
	
	See http://www.supermemo.com/english/ol/sm2.htm for more information on the algorithm
	
	*/
	
	function calculate_sm2($params, $grade) {
		
		// sanity check
		if (!$params || !$grade) return false;
		if (!isset($params['repetition'])) return false;
		if (!isset($params['interval'])) return false;
		if (!isset($params['ef'])) return false;
		if (intval($grade) < 0 || intval($grade) > 5) return false;
		
		$grade = intval($grade);
		$repetition = $params['repetiton'];
		$interval = $params['interval'];
		$ef = $params['ef'];
		
		// if grade is 3 or greater, use the algorithm, otherwise just reset and
		// dont' adjust EF
		
		if ($grade >= 3) {
		
			// this repetition is going to count
			$repetition ++;
		
			// handle the special cases first
			if ($repetition == 0) {
			
				$interval = 1;
				
			} else if ($repetition == 1) {
			
				$interval = 6;
				
			} else {
			
				// new interval is old interval multiplied by the EF
				$interval = round($interval * $ef);
				
			}
			
			// calculate the new EF, clamp to 1.3 at bottom
			
			$ef = round($ef + (0.1 - (5 - $grade) * (0.08 + (5 - $grade) * 0.02)), 1);
			if ($ef < 1.3) $ef = 1.3;
			
		} else {
		
			$repetition = 0;
			$interval = 1;
			
		}
		
		return Array("repetition" => $repetition, "interval" => $interval, "ef" => $ef);
	
	}
	
	/*
	
	This function is identical to calculate_sm2 (and calls it for most of the work)
	but adds a small amount of variability (+/- 5%) to the resulting interval, to help
	with clumping of repetitions
	
	*/
	
	function calculate_sm2_noisy($params, $grade) {
		
		// call calculate_sm2 for the heavy lifting
		$results = calculate_sm2($params, $grade);
		if (!$results) return false;
		
		// between 0.95 and 1.05
		$noise = 1 + ((mt_rand(0, 100) - 50) / 1000);
		
		$noisy_interval = round($results['interval'] * $noise);
		$results['interval'] = $noisy_results;
		
		return $results;
		
	}




?>