<?php
function statistika($data, $menu)
{
	if ($menu == "median" || $menu == "modus")
	{
		sort($data);
	}
	$n = sizeof($data);
	if ($menu == "mean")
	{
		return array_sum($data) / $n;	
	}
	else if ($menu == "modus")
	{
		$ram = array_count_values($data);
		return array_search(max($ram), $ram);
	}
	else if ($menu == "median")
	{
		if ($n % 2 != 0)
		{
			return (double)$data[$n / 2];
		}
		else
		{
			$x1 = $data[($n / 2) -1];
			$x2 = $data[$n /2 ];
			return (double)($x1 + $x2) / 2;
		}
	}
	else if ($menu == "std")
	{
		$ram = statistika($data, "mean");
		$x1 = array();
		$x2 = array();
		for ($i=0; $i < $n; $i++)
		{
			array_push($x1, round(($data[$i] - $ram),2));
			array_push($x2, round($x1[$i]*$x1[$i],3));
		}
		$hasil = sqrt(array_sum($x2) / $n);
		return $hasil;
	}
	else if ($menu == "var")
	{
		$ram = statistika($data, "mean");
		$x1 = array();
		$x2 = array();
		for ($i=0; $i<$n; $i++)
		{
			array_push($x1, ($data[$i] - $ram));
			array_push($x2, ($x1[$i]*$x1[$i]));
		}
		$hasil = array_sum($x2) / $n;
		return $hasil;
	}
}

$data = array(32,111,138,28,59,77,97);
echo "Mean   : ".statistika($data, "mean")."<br>";
echo "Median : ".statistika($data, "median")."<br>";
echo "Modus  : ".statistika($data, "modus")."<br>";
echo "STD	 : ".statistika($data, "std")."<br>";
echo "Varian : ".statistika($data, "var");
?>