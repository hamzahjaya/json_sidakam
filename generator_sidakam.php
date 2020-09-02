<?php

// 	$database = 'sidakam_online';
// 	$host = 'localhost';
// 	$username = 'root';
// 	$password = '';

//   $db_conn = pg_connect("host=$host dbname=$database user=$username password=$password");
// if (!$db_conn) {
//   echo "Failed connecting to postgres database $database\n";
//   exit;
// }
$servername = "localhost";
$username = "root";
$password = "";


try {
    $conn = new PDO("mysql:host=$servername;dbname=sidakam_online", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// $stmt  = $conn->query("SELECT p.nama as nama_paslon, w.nama,
// 		sum(case when d.tipe = 'PENERIMAAN' then dh.jumlah else 0 end) as penerimaan_ladk,
// 		sum(case when d.tipe = 'PENGELUARAN' then dh.jumlah else 0 end) as pengeluaran_ladk,
// 		sum(case when d2.tipe = 'PENERIMAAN' then dh2.jumlah else 0 end) as penerimaan_lpsdk,
// 		sum(case when d3.tipe = 'PENERIMAAN' then dh3.jumlah else 0 end) as penerimaan_lppdk,
// 		sum(case when d3.tipe = 'PENGELUARAN' then dh3.jumlah else 0 end) as pengeluaran_lppdk 
//         FROM paslon p 
//         LEFT JOIN tahapan t ON t.id_paslon = p.id and t.id_jenis_tahapan = '1'
//         LEFT JOIN data_helper dh ON dh.id_tahapan = t.id
//         LEFT JOIN data d ON d.id = dh.id_data
//         LEFT JOIN tahapan t2 ON t2.id_paslon = p.id and t2.id_jenis_tahapan = '2'
//         LEFT JOIN data_helper dh2 ON dh2.id_tahapan = t2.id 
//         LEFT JOIN data d2 ON d2.id = dh2.id_data
//         LEFT JOIN tahapan t3 ON t3.id_paslon = p.id and t3.id_jenis_tahapan ='3'
//         LEFT JOIN data_helper dh3 ON dh3.id_tahapan = t3.id 
//         LEFT JOIN data d3 ON d3.id = dh3.id_data
//         JOIN user u ON u.id = p.id_user
//         JOIN wilayah w ON  w.id = u.id_wilayah
//         WHERE u.id_role
//         GROUP BY p.id
//         ORDER BY w.id ASC");

$stmt  = $conn->query("SELECT p.jenis as jenis_pencalonan, p.id as id, p.nama as nama_paslon, w.nama as nama_wilayah,
		
sum(case when d.tipe = 'PENERIMAAN' then dh.jumlah else 0 end) as penerimaan_ladk,
sum(case when d.tipe = 'PENGELUARAN' then dh.jumlah else 0 end) as pengeluaran_ladk,
sum(case when d2.tipe = 'PENERIMAAN' then dh2.jumlah else 0 end) as penerimaan_lpsdk,
sum(case when d3.tipe = 'PENERIMAAN' then dh3.jumlah else 0 end) as penerimaan_lppdk,
sum(case when d3.tipe = 'PENGELUARAN' then dh3.jumlah else 0 end) as pengeluaran_lppdk, 
    case  
    when j.level = '1' then 'Gubernur dan Wakil Gubernur'
        when j.level = 'KOTA ' then 'Walikota dan Wakil Walikota'
    when j.level = '2' then 'Bupati dan Wakil Bupati'
    end as jenis_pemilihan
    
    FROM paslon p 
    
    LEFT JOIN tahapan t ON t.id_paslon = p.id and t.id_jenis_tahapan = '1'
    LEFT JOIN data_helper dh ON dh.id_tahapan = t.id
    LEFT JOIN data d ON d.id = dh.id_data
    LEFT JOIN tahapan t2 ON t2.id_paslon = p.id and t2.id_jenis_tahapan = '2'
    LEFT JOIN data_helper dh2 ON dh2.id_tahapan = t2.id 
    LEFT JOIN data d2 ON d2.id = dh2.id_data
    LEFT JOIN tahapan t3 ON t3.id_paslon = p.id and t3.id_jenis_tahapan ='3'
    LEFT JOIN data_helper dh3 ON dh3.id_tahapan = t3.id 
    LEFT JOIN data d3 ON d3.id = dh3.id_data
    
    JOIN user u ON u.id = p.id_user
    JOIN wilayah j on j.id = u.id_wilayah
    JOIN wilayah w ON  w.id = u.id_wilayah
    WHERE u.id_role
    GROUP BY p.id
    ORDER BY w.id ASC");

$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$fp = fopen('results_sidakam1.json', 'w');

// $result = $stmt ->get_result();
fwrite($fp, json_encode(($data)));
fclose($fp);

// free_result($qu);
// close($conn);
?>
<!-- 
SELECT j.level as jenis_pemilihan, p.nama as nama_paslon, w.nama, 
		sum(case when d.tipe = 'PENERIMAAN' then dh.jumlah else 0 end) as penerimaan_ladk,
		sum(case when d.tipe = 'PENGELUARAN' then dh.jumlah else 0 end) as pengeluaran_ladk,
		sum(case when d2.tipe = 'PENERIMAAN' then dh2.jumlah else 0 end) as penerimaan_lpsdk,
		sum(case when d3.tipe = 'PENERIMAAN' then dh3.jumlah else 0 end) as penerimaan_lppdk,
		sum(case when d3.tipe = 'PENGELUARAN' then dh3.jumlah else 0 end) as pengeluaran_lppdk 
        FROM paslon p 
        LEFT JOIN tahapan t ON t.id_paslon = p.id and t.id_jenis_tahapan = '1'
        LEFT JOIN data_helper dh ON dh.id_tahapan = t.id
        LEFT JOIN data d ON d.id = dh.id_data
        LEFT JOIN tahapan t2 ON t2.id_paslon = p.id and t2.id_jenis_tahapan = '2'
        LEFT JOIN data_helper dh2 ON dh2.id_tahapan = t2.id 
        LEFT JOIN data d2 ON d2.id = dh2.id_data
        LEFT JOIN tahapan t3 ON t3.id_paslon = p.id and t3.id_jenis_tahapan ='3'
        LEFT JOIN data_helper dh3 ON dh3.id_tahapan = t3.id 
        LEFT JOIN data d3 ON d3.id = dh3.id_data
        
        JOIN user u ON u.id = p.id_user
        JOIN wilayah j on j.id = u.id_wilayah
        JOIN wilayah w ON  w.id = u.id_wilayah
        WHERE u.id_role
        GROUP BY p.id
        ORDER BY w.id ASC -->


<!-- 
        SELECT j.level as level, p.nama as nama_paslon, w.nama,
		
		sum(case when d.tipe = 'PENERIMAAN' then dh.jumlah else 0 end) as penerimaan_ladk,
		sum(case when d.tipe = 'PENGELUARAN' then dh.jumlah else 0 end) as pengeluaran_ladk,
		sum(case when d2.tipe = 'PENERIMAAN' then dh2.jumlah else 0 end) as penerimaan_lpsdk,
		sum(case when d3.tipe = 'PENERIMAAN' then dh3.jumlah else 0 end) as penerimaan_lppdk,
		sum(case when d3.tipe = 'PENGELUARAN' then dh3.jumlah else 0 end) as pengeluaran_lppdk, 
        case  
        when j.level = '1' then 'Gubernur dan Wakil Gubernur'
            when j.level = 'KOTA ' then 'Walikota dan Wakil Walikota'
        when j.level = '2' then 'Bupati dan Wakil Bupati'
        end as jenis_pemilihan1
        
        FROM paslon p 
        
        LEFT JOIN tahapan t ON t.id_paslon = p.id and t.id_jenis_tahapan = '1'
        LEFT JOIN data_helper dh ON dh.id_tahapan = t.id
        LEFT JOIN data d ON d.id = dh.id_data
        LEFT JOIN tahapan t2 ON t2.id_paslon = p.id and t2.id_jenis_tahapan = '2'
        LEFT JOIN data_helper dh2 ON dh2.id_tahapan = t2.id 
        LEFT JOIN data d2 ON d2.id = dh2.id_data
        LEFT JOIN tahapan t3 ON t3.id_paslon = p.id and t3.id_jenis_tahapan ='3'
        LEFT JOIN data_helper dh3 ON dh3.id_tahapan = t3.id 
        LEFT JOIN data d3 ON d3.id = dh3.id_data
        
        JOIN user u ON u.id = p.id_user
        JOIN wilayah j on j.id = u.id_wilayah
        JOIN wilayah w ON  w.id = u.id_wilayah
        WHERE u.id_role
        GROUP BY p.id
        ORDER BY w.id ASC -->