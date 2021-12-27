<?php

function nilai_tengah($data, $total)
{
	sort($data);
	if ($total %2 != 0)
	{
		return (double)$data[$total / 2];
	}else{
		$x1 = $data[($total / 2) -1];
		$x2 = $data[$total /2 ];
		return (double)($x1 + $x2) / 2;
	}
}

$data = array(13,21,21,40,42,48,55,72);
sort($data);
$n = sizeof($data);
echo "Median = ".nilai_tengah($data, $n);
?>