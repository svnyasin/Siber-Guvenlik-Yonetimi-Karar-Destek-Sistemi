<?php
	/* Database connection settings */
	// Include config file
require_once "config.php";
    $secilen="Hepsi";
    if(strip_tags(trim(isset($_POST["secilen"])))){
        $secilen=$_POST["secilen"];
    }
    
    
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Ver Cloud Karar Destek Sistemi" />
    <meta name="keyword" content="Ver Cloud,cloud,karar,destek" />
    <title>Ver Cloud Karar Destek Sistemi</title>
    <link rel="stylesheet" href="css/zafiyetler.css" />
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  <script>

anychart.onDocumentReady(function () {
  // create bar chart
  var chart = anychart.bar();

  chart.animation(true);

  chart.padding([10, 40, 5, 20]);

  chart.title('Risklerine Göre Uygulamalar');

  // create bar series with passed data
  var series = chart.bar([
    <?php
    $sql = "SELECT yazilim.*, COUNT(zafiyet.cvss_skor) as zafiyet_sayisi
    FROM zafiyet,baglanti,yazilim
    WHERE zafiyet.cve_kodu=baglanti.cve_kodu
    AND baglanti.yazilim_id=yazilim.yazilim_id
    GROUP BY yazilim.ad
    UNION
    
    SELECT isletim.isletim_id, isletim.ad, isletim.uretici, isletim.fiyat, COUNT(zafiyet.cvss_skor) as zafiyet_sayisi
    FROM zafiyet,baglanti,isletim
    WHERE zafiyet.cve_kodu=baglanti.cve_kodu
    AND baglanti.isletim_id=isletim.isletim_id
    GROUP BY isletim.ad
    
    ORDER BY zafiyet_sayisi DESC";
    $result = mysqli_query($mysqli, $sql);

    
	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
    echo "['".$row['ad']."',".$row['zafiyet_sayisi']."],";
  }
    
    ?>
  ]);

  // set tooltip settings
  series
    .tooltip()
    .position('right')
    .anchor('left-center')
    .offsetX(5)
    .offsetY(0)
    .titleFormat('{%X}')
    .format('{%Value}');

  // set yAxis labels formatter
  chart.yAxis().labels().format('{%Value}{groupsSeparator: }');

  // set titles for axises
  chart.xAxis().title('Program');
  chart.yAxis().title('Risk');
  chart.interactivity().hoverMode('by-x');
  chart.tooltip().positionMode('point');
  // set scale minimum
  chart.yScale().minimum(0);

  // set container id for the chart
  chart.container('container');
  // initiate chart drawing
  chart.draw();
});

</script>
  <style>
        table {
            border-collapse: collapse;
    margin-left: 25px 0;
    margin-right: 25px 0;
    margin-bottom: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}
    thead tr {
    background-color: #6BB3F4;
    color: #ffffff;
    text-align: left;
}
    th,
    td {
        padding: 12px 15px;
    }
    tbody tr {
    border-bottom: 1px solid #dddddd;
}

    tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    tbody tr:last-of-type {
        border-bottom: 2px solid #6BB3F4;
    }
    tbody tr.active-row {
    font-weight: bold;
    color: #6BB3F4;
}
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
   
  </head>

  <body>
    <div class="kenarCubugu">
      <div class="yanBaslik">
        <a href="#"><img src="images/logo.png" alt="" /></a>        
      </div>
      <div class="kullanici">
        <img src="images/kullanici.png" />
        <div class="bilgi">
          <span class="isim">Yasin Seven</span>
          <span class="unvan">Siber Güvenlik Mimarı</span>
        </div>
      </div>
      <a href="index.php" class="kontrolPaneli">
        <span>Ana Ekran</span>
        <i class="fas fa-home"></i>
      </a>
      <a href="konumlar.php" class="konumlar">
        <span>Konumlar</span>
        <i class="fas fa-map-marker-alt"></i>
      </a >
      <a href="cihazlar.php" class="cihazlar">
        <span>Cihazlar</span>
        <i class="fas fa-desktop"></i>
      </a >
      <a href="zafiyetler.php" class="zafiyetler">
        <span>Zafiyetler</span>
        <i class="fas fa-biohazard"></i>
      </a >
      <a href="karsilastir.php" class="karsilastirma">
        <span>Karşılaştırma</span>
        <i class="fas fa-tasks"></i>
      </a >
    </div>
    <div class="icerik">
      <div class="baslik">
        <i class="fas fa-bars"></i>
        <div class="arama">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Arama..." />
        </div>
        <div class="kullanici">
          <img src="images/kullanici.png" />
          <span>Yasin Seven</span>
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="bildirim">
          <div class="baslikMektup">
            <i class="far fa-envelope"></i>
            <i class="fas fa-circle"></i>
          </div>
          <div class="baslikCan">
            <i class="far fa-bell"></i>
            <i class="fas fa-circle"></i>
          </div>
          <div class="baslikBayrak">
            <i class="far fa-flag"></i>
            <i class="fas fa-circle"></i>
          </div>
        </div>
        <a href="logout.php" class="logOut"><i class="fas fa-sign-out-alt"></i></a>
      </div>
      <div class="anaEkran">
        <div class="ust">
          <div class="sol">
            <span>Zafiyetler</span>
            <i class="fas fa-home"></i>
          </div>
          <div class="sag">
            <i class="fas fa-tachometer-alt"></i>
            <span>Zafiyetler</span>
            <span>></span>
            <span>Zafiyetler</span>
          </div>
        </div>
        <div class="alt">
        
    <div class="kutu1">
        <?php
        
            // Check connection
            if($mysqli === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

                $sql = "SELECT * FROM zafiyet ORDER BY zafiyet.cve_kodu DESC";
            
            // Attempt select query execution
            
            if($result = mysqli_query($mysqli, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<table class='styled_table'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>cve_kodu</th>";
                            echo "<th>cvss_ciddiyet</th>";
                            echo "<th>cvss_skor</th>";
                            echo "<th>yayinlanma</th>";
                        echo "</tr>";
                        echo "</thead>";
                    while($row = mysqli_fetch_array($result)){
                        echo "<tbody>";
                        echo "<tr>";
                            echo "<td>" . $row['cve_kodu'] . "</td>";
                            echo "<td>" . $row['cvss_ciddiyet'] . "</td>";
                            echo "<td>" . $row['cvss_skor'] . "</td>";
                            echo "<td>" . $row['yayinlanma'] . "</td>";
                        echo "</tr>";
                        echo "</tbody>";
                    }
                    echo "</table>";
                    // Free result set
                    mysqli_free_result($result);
                } else{
                    echo "No records matching your query were found.";
                }
            } else{
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
            }    
        
        ?>
    </div>
    <div class="kutu2">
        <div id="container"></div>
    </div>
        </div>
</form>
      <div class="footer">
        <div class="sol">
          <span>Site Haritası</span>
          <span>Organ Bağışı Yapmak İstiyorum</span>
          <span>Geri Bildirim</span>
          <span>İhaleler</span>
          <span>İletişim - Ulaşım</span></div>
        <span class="copyright">2020 Copyright © Tüm hakları saklıdır. - Yasin Seven</span>
      </div>
    </div>    
  </body>
</html>
