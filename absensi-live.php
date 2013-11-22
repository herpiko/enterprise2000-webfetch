<html>
<head>
<meta http-equiv="refresh" content="300" > 
</head>
<body>
 
<?php
function post($url,$data) { 
$process = curl_init();
$options = array(
CURLOPT_URL => $url,
CURLOPT_HEADER => false,
CURLOPT_POSTFIELDS => $data,
CURLOPT_RETURNTRANSFER => true,
CURLOPT_FOLLOWLOCATION => TRUE,
CURLOPT_POST => TRUE,
CURLOPT_BINARYTRANSFER => TRUE
);
curl_setopt_array($process, $options);
$return = curl_exec($process); 
curl_close($process); 
return $return; 
}

$tanggal_awal=date('Y-m-d');
$tanggal_akhir=date('Y-m-d');
$jumlah_karyawan=200;
$ip='192.168.168.61';

$data[]="sdate={$tanggal_awal}";
$data[]="edate={$tanggal_akhir}";
$data[]='period=1';
for ($i=1;$i<$jumlah_karyawan;$i++) {
        $data[]="uid={$i}";
}

$result = post("http://{$ip}/form/Download", implode('&',$data));

//Proses data yang diterima.

$row=explode("
", $result);
$absen=array();
foreach($row as $data) {
$col = explode(" ",$data);
$id=intval($col[0]);
$absen[$id]['name']=$col[1];
$s = explode(' ', $col[2]);
$absen[$id][$s[0]][]=$s[1];
}

//sebagai alternatif, data nama bisa diambil dari sqldb FTM

$nama=array(
	0=>'',
	1=>'',
	2=>'',
	3=>'',
	4=>''
	);

echo "<strong>FOR TESTING PURPOSE. Date : ".$tanggal_awal.". <br>Silakan cek absensi anda. </strong>Laman ini diperbarui secara otomatis setiap 5 menit.<br><br>";

$hasil=array();
$j=0;

//pindah ke array berurutan
for ($i=0; $i < 150; $i++) { 
//unset($absen[$i][name]);
	foreach ($absen[$i] as $key => $value) {
		$x=substr($key,2,1);
		$y=substr($key,11,1);
		//echo $x;
		if ($x==':') {
			if ($y=="0") {
				$check="Check In";
			} else {
				$check="Check Out";
			}
			$hasil[$j]=array();
			$hasil[$j][nama]=$nama[$i];
			$hasil[$j][status]=$check;
			$hasil[$j][waktu]=substr($key,0,-5);
			$j=$j+1;
			}	else {
				//do nothing
			}
	}
}


for ($i=0; $i < 150; $i++) { 
//unset($absen[$i][name]);
		$x=substr($absen[$i][name],2,1);
		$y=substr($absen[$i][name],11,1);
		//echo $x;
		if ($x==':') {
			if ($y=="0") {
				$check="Check In";
			} else {
				$check="Check Out";
			}
			$hasil[$j]=array();
			$hasil[$j][nama]=$nama[$i];
			$hasil[$j][status]=$check;
			$hasil[$j][waktu]=substr($absen[$i][name],0,-5);
			$j=$j+1;
			}	else {
				//do nothing
			}
	
}



//cetak hasil
echo "<table><tr valign=\"top\">";
echo "<td>";
echo "<table>";
for ($z=0; $z < 20; $z++) { 
		echo "<tr><td>".$hasil[$z][nama]."</td>";
		echo "<td>&nbsp&nbsp".$hasil[$z][status]."</td>";		
		echo "<td>&nbsp&nbsp".$hasil[$z][waktu]."&nbsp&nbsp&nbsp&nbsp";
		echo "</td></tr>";
}
echo "</table>";
echo "</td>";
echo "<td>";
echo "<table>";
for ($z=21; $z < 40; $z++) { 
		echo "<tr><td>".$hasil[$z][nama]."</td>";
		echo "<td>&nbsp&nbsp".$hasil[$z][status]."</td>";		
		echo "<td>&nbsp&nbsp".$hasil[$z][waktu]."&nbsp&nbsp&nbsp&nbsp";
		echo "</td></tr>";
}
echo "</table>";
echo "</td>";
echo "<td>";
echo "<table>";
for ($z=41; $z < 60; $z++) { 
		echo "<tr><td>".$hasil[$z][nama]."</td>";
		echo "<td>&nbsp&nbsp".$hasil[$z][status]."</td>";		
		echo "<td>&nbsp&nbsp".$hasil[$z][waktu]."&nbsp&nbsp&nbsp&nbsp";
		echo "</td></tr>";
}
echo "</table>";


echo "</td>";
echo "</tr></table>";

//print_r($absen);
// echo "<br><br>";
// echo $absen[106][name];
echo "<br><br>Pure fetch data :<br>";
print_r($absen);
echo "<br><br>Rearranged fetch data: <br> ";
print_r($hasil);
//echo $tanggal_awal;
?>

</div>
