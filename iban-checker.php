<?php
/**
 * IBAN Checker v0.9
 * Created by Siniša Šešlak.
 * Date: 3/3/15
 *
 * Simple IBAN validator. Possible errors in code.
 *
 * Send bug reports to sinisa@seslak.com
 *
 */

$iban = $_GET['IBAN'];

function _iban($iban)
{
$iban = substr($iban,4,strlen($iban)-4) . substr($iban,0,4);
$iban_new = 0; $i = 1;
while ($i <= strlen($iban)) {
$iban_convert = substr($iban,$i-1,1);
if (ctype_digit($iban_convert)) { $iban_new = $iban_new . $iban_convert; }
else { $iban_new = $iban_new . _iban_convert($iban_convert); }
$i++;
}
$iban = substr($iban_new,1,strlen($iban_new)-1);
$iban = _iban_check_digit_test($iban);
if ($iban == 1) { $iban = "VALID"; }
else { $iban = "INVALID"; }
return $iban;
}

/* Piece-wise digit test calculation */
/* Taking care of different/weaker arches */

function _iban_check_digit_test($iban) {
$iban_digi_c = strlen($iban);
$iban_cd = 0;
if ($iban_digi_c > 9)
{
$iban_dump = fmod(substr($iban,$iban_cd,9),97);
$iban_digi_c = $iban_digi_c - 9;
$iban_cd = $iban_cd + 9;
while ($iban_digi_c > 7) {
$iban_dump = fmod($iban_dump . substr($iban,$iban_cd,7),97);
$iban_digi_c = $iban_digi_c - 7;
$iban_cd = $iban_cd + 7;
}
$iban_dump = fmod($iban_dump . substr($iban,-$iban_digi_c,$iban_digi_c+7),97);
$iban = $iban_dump;
}
else {
$iban = fmod($iban,97);
}
return $iban;
}

function _iban_convert($iban_convert) {
$i_c = 0;
$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
while (substr($alphabet,$i_c,1) != strtoupper($iban_convert)) { $i_c++; }
return $i_c+10;
}

echo "IBAN= " . strtoupper($iban) . " is " . _iban($iban);

?>