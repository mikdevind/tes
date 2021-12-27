<?php
function statistika($data, $menu)
{
	sort($data);
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
}

$data = array(99,86,87,88,111,86,103,87,94,78,77,85,86);
echo "Mean   : ".statistika($data, "mean")."<br>";
echo "Median : ".statistika($data, "median")."<br>";
echo "Modus  : ".statistika($data, "modus");
?>