<?php

function string_to_int($str)
{
	$length = strlen($str);
	if (! $length > 0) {
		return false;
	}
	$int_value = 0;
	for ($i = 0; $i < $length; $i++) {
		$int_value += ord($str{$i}) * pow(256, $i);
	}
	return $int_value;
}

function int_to_binary_string($int, $bits)
{
	$bin1 = sprintf('%b', $int);
	$bin2 = str_pad($bin1, $bits, '0', STR_PAD_LEFT);
	$length = strlen($bin2);
	if ($length > $bits) {
		return substr($bin2, $length - $bits);
	} else {
		return $bin2;
	}
}

function binary_string_to_int($bin)
{
	echo $bin . "\n";

	$length = strlen($bin);

	$int = 0;

	$i = 0;

	while ($i < $length) {
		$digit_value = pow($bin{$i}, ($length - $i - 1));
		echo $digit_value;
		$int += pow($bin{$i}, ($length - $i - 1));
		$i++;
	}

	return $int;
}

function twos_complement($int, $bits)
{
	//  Convert to binary string representation

	$bin = int_to_binary_string($int, $bits);

	$length = strlen($bin);

	$i = 0;

	//  Apply quick twos complement transform

	$found_one = false;

	while ($i < $length) {
		$index = $length - 1;
		if ($found_one) {
			if ($bin{$index} == 1) {
				$bin{$index} = '0';
			} else {
				$bin{$index} = '1';
			}
		}
		if ($bin{$index} == 1) {
			$found_one = true;
		}
		$i++;
	}

	return $bin;
}

function twos_complement_int($int)
{
	$inv_int = ~ $int;
	$inv_int += 1;
	$inv_int = $inv_int & 65535;
	return $inv_int;
}
