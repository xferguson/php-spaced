<?
	
	include_once("php-spaced.php");
	
	$itema = Array("repetition" => 0, "interval" => 0, "ef" => 2.5);
	
	$x = 0;
	while ($x < 100) {
		$grade = mt_rand(2,5);
		echo "$grade\n\n";
		print_r($itema);

		$itema = calculate_sm2_noisy($itema, $grade);
		
		$x++;
	}
	
	print_r($itema);

?>