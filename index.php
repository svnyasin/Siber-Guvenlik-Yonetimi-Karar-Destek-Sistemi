<?php
	// Include config file
require_once "config.php";

  session_start();
 
  // Check if the user is logged in, if not then redirect him to login page
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
      header("location: login.php");
      exit;
  }
  
  
  
	$sql = "SELECT COUNT(cihaz.ip) as cihaz_sayisi FROM cihaz";
  $result = mysqli_query($mysqli, $sql);
  $cihaz_sayisi=mysqli_fetch_assoc($result);

  $sql = "SELECT COUNT(zafiyet.cve_kodu) as zafiyet_sayisi FROM zafiyet";
  $result = mysqli_query($mysqli, $sql);
  $zafiyet_sayisi=mysqli_fetch_assoc($result);

  $sql = "SELECT COUNT(yazilim.yazilim_id) as yazilim_sayisi FROM yazilim";
  $result = mysqli_query($mysqli, $sql);
  $yazilim_sayisi=mysqli_fetch_assoc($result);

  $sql = "SELECT COUNT(konum.konum_id) as konum_sayisi FROM konum";
  $result = mysqli_query($mysqli, $sql);
  $konum_sayisi=mysqli_fetch_assoc($result);

  $sql = "SELECT COUNT(isletim.isletim_id) as isletim_sayisi FROM isletim";
  $result = mysqli_query($mysqli, $sql);
  $isletim_sayisi=mysqli_fetch_assoc($result);
  //echo $cihaz_sayisi['cihaz_sayisi'];
  
  $sql = "SELECT round(AVG(ort),2) as sistem_riski
  FROM (SELECT IFNULL(round(zafiyet.cvss_skor,2),0) as ort
  FROM cihaz
    LEFT JOIN baglanti
        ON baglanti.ip=cihaz.ip
            LEFT JOIN zafiyet
                ON zafiyet.cve_kodu=baglanti.cve_kodu) as T";
  $result = mysqli_query($mysqli, $sql);
  $sistem_riski=mysqli_fetch_assoc($result);
  $sistem_riski['sistem_riski']=$sistem_riski['sistem_riski']*10

  
	
			
  

?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Ver Cloud Karar Destek Sistemi" />
    <meta name="keyword" content="Ver Cloud,cloud,karar,destek" />
    <title>Ver Cloud Karar Destek Sistemi</title>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-map.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
  <script src="https://cdn.anychart.com/geodata/latest/custom/world/world.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['', 
          <?php
                echo $sistem_riski['sistem_riski'];
                ?>
          ]
        ]);

        var options = {
          width: 400, height: 250,
          redFrom: 75, redTo: 100,
          yellowFrom:50, yellowTo: 75,
          minorTicks: 10
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Ülke', 'Risk Skoru'],
          <?php
			$sql = "SELECT konum.ulke, round(AVG(zafiyet.cvss_skor),2) as ort FROM konum,cihaz,baglanti,zafiyet WHERE konum.konum_id=cihaz.konum_id AND cihaz.ip=baglanti.ip AND baglanti.cve_kodu=zafiyet.cve_kodu GROUP BY konum.ulke";
    $result = mysqli_query($mysqli, $sql);

    
	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
    echo "['".$row['ulke']."',".$row['ort']."],";
  }
			?>
        ]);

        var options = {};
        options['colorAxis'] = { minValue : 0, maxValue : 10, colors : ['#9fa0c2','#0006b8']};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Cihaz", "Zafiyet Sayısı", { role: "style" } ],
        <?php
        $sql = "SELECT cihaz.ad as cihaz_ad,COUNT(zafiyet.cve_kodu) as zafiyet_sayisi
        FROM cihaz, baglanti, zafiyet
        WHERE cihaz.ip=baglanti.ip
        AND baglanti.cve_kodu=zafiyet.cve_kodu
        GROUP BY cihaz.ip
        ORDER BY zafiyet_sayisi DESC
        LIMIT 5
        ";
          $result = mysqli_query($mysqli, $sql);
      
          
          $i = 0;
          //loop through the returned data
          while ($row = mysqli_fetch_array($result)) {
            
            
            if ($i == 0) {
              echo "['".$row['cihaz_ad']."',".$row['zafiyet_sayisi'].",","'","#E9A1B2","'","],";
              $i = 1;
            }
            elseif ($i == 1){
              echo "['".$row['cihaz_ad']."',".$row['zafiyet_sayisi'].",","'","#A6A7CF","'","],";
              $i = 0;
            }
            
          }
        
        ?>
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: " En Çok Zafiyete Sahip Cihazlar",
        titleTextStyle: {
          color: '#808080',
          fontSize: "14"},
        bar: {groupWidth: "75%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("toplam_hasta_graf"));
      chart.draw(view, options);
  }
  </script>
  
  <script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['isletim', 'Sayı'],
        <?php
			$sql = "SELECT isletim.aile, COUNT(cihaz.ip) as cihaz_sayisi FROM isletim, baglanti, cihaz WHERE isletim.isletim_id=baglanti.isletim_id AND baglanti.ip=cihaz.ip GROUP BY isletim.aile";
    $result = mysqli_query($mysqli, $sql);

    
	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
    echo "['".$row['aile']."',".$row['cihaz_sayisi']."],";
  }
			?>
      ]);

      var options = {
        title: "İşletim Sistemi Dağılımı",
        titleTextStyle: {
          color: '#808080',
          fontSize: "14"},
        pieHole: 0.4,
        slices: {
            0: { color: "#E9A1B2" },
            1: { color: "#A6A7CF" },
            2: { color: "#6BB3F4"}
          }
      };

      var chart = new google.visualization.PieChart(document.getElementById('ilac_stok'));
      chart.draw(data, options);
    }
  </script>
  
  <script type="text/javascript">
    google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Yıl');
    data.addColumn('number', 'Windows');
    data.addColumn('number', 'Linux');
    data.addColumn('number', 'Unix');

    data.addRows([
      <?php
      $sql = "SELECT DISTINCT TT.yil, SUM(TT.value1) AS windows_zafiyet_sayisi, SUM(TT.value2) AS linux_zafiyet_sayisi, SUM(TT.value3) AS unix_zafiyet_sayisi
      FROM (select IFNULL(t.yil,0) as yil,IFNULL(t.value1,0) as value1,IFNULL(t.value2,0) as value2,IFNULL(t.value3,0) as value3
      from (
        select coalesce(t.yil, t3.yil) yil,
          t.value1,
          t.value2,
          t3.value value3
        from (
          select coalesce(t1.yil, t2.yil) yil,
            t1.value value1,
            t2.value value2
          from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Windows'
            GROUP BY yil) as t1
          left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Linux'
            GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)
            and t1.yil = t2.yil
          
          union all
          
          select coalesce(t1.yil, t2.yil),
            t1.value,
            t2.value
          from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Windows'
            GROUP BY yil) as t1
          right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Linux'
            GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)
            and t1.yil = t2.yil
          where not exists (
              select 1
              from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Windows'
            GROUP BY yil) t
              where t.yil = t2.yil
                and right(t.value, 1) = right(t2.value, 1)
              )
          ) t
        right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Unix'
            GROUP BY yil) t3 on t.yil = t3.yil
          and right(coalesce(t.value1, t.value2), 1) = right(t3.value, 1)
        
        union all
        
        select coalesce(t.yil, t3.yil) yil,
          t.value1,
          t.value2,
          t3.value value3
        from (
          select coalesce(t1.yil, t2.yil) yil,
            t1.value value1,
            t2.value value2
          from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Windows'
            GROUP BY yil) as t1
          left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Linux'
            GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)
            and t1.yil = t2.yil
          
          union all
          
          select coalesce(t1.yil, t2.yil),
            t1.value,
            t2.value
          from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Windows'
            GROUP BY yil) as t1
          right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Linux'
            GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)
            and t1.yil = t2.yil
          where not exists (
              select 1
              from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Windows'
            GROUP BY yil) t
              where t.yil = t2.yil
                and right(t.value, 1) = right(t2.value, 1)
              )
          ) t
        left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Unix'
            GROUP BY yil) t3 on t.yil = t3.yil
          and right(coalesce(t.value1, t.value2), 1) = right(t3.value, 1)
        where not exists (
            select 1
            from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil, COUNT(zafiyet.cve_kodu) as value
            FROM zafiyet, baglanti,isletim
            WHERE zafiyet.cve_kodu=baglanti.cve_kodu
            AND baglanti.isletim_id=isletim.isletim_id
            AND isletim.aile='Unix'
            GROUP BY yil) t2
            where t2.yil = t.yil
              and right(t2.value, 1) = right(coalesce(t.value1, t.value2), 1)
            )
        ) t
      order by yil,
        value1,
        value2,
        value3) AS TT
          
          GROUP BY TT.yil
          ORDER BY TT.yil ASC";
      $result = mysqli_query($mysqli, $sql);
    
      
      //loop through the returned data
      while ($row = mysqli_fetch_array($result)) {
        echo "['".$row['yil']."',".$row['windows_zafiyet_sayisi'].",".$row['linux_zafiyet_sayisi'].",".$row['unix_zafiyet_sayisi'].",],";
      }
      ?>
    ]);

    var options = {
      chart: {
        title: 'Genel Bakış',},
        titleTextStyle: {
          color: '#808080',
          fontSize: "14"},
      axes: {
        x: {
          0: {side: 'down'}
        }
      },
      series: {
        0:{color: "#E9A1B2"},
        1:{color: "#A6A7CF"},
        2:{color: "#6BB3F4"}
}
    };

    var chart = new google.charts.Line(document.getElementById('durum_graf'));

    chart.draw(data, google.charts.Line.convertOptions(options));
  }
</script>
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
            <span>Ana Ekran</span>
            <i class="fas fa-home"></i>
          </div>
          <div class="sag">
            <i class="fas fa-tachometer-alt"></i>
            <span>Ana Ekran</span>
            <span>></span>
            <span>Ana Ekran</span>
          </div>
        </div>
        <div class="kutular1">
          <div class="kutu1">
            <span>Sistem Riski</span>
            <div id="chart_div" style="width: 400px; height: 120px;"></div>
          </div>
          <div class="kutu2">
            <div class="kutu2-1">
              <div class="kutuBaslik">Cihaz Sayısı</div>
              <span class="sayi">
                <?php
                echo $cihaz_sayisi['cihaz_sayisi'];
                ?>
              </span>
              <div class="simge">
                <i class="fas fa-circle"></i>
                <i class="fas fa-desktop"></i>
              </div>
            </div>
            <div class="kutu2-2">
              <div class="kutuBaslik">Zafiyet Sayısı</div>
              <span class="sayi">
              <?php
                echo $zafiyet_sayisi['zafiyet_sayisi'];
                ?>
              </span>
              <div class="simge">
                <i class="fas fa-circle"></i>
                <i class="fas fa-biohazard"></i>
              </div>
            </div>
          </div>
          <div class="kutu3">
            <div class="kutu3-1">
              <div class="kutuBaslik">Yazılım Sayısı</div>
              <span class="sayi">
              <?php
                echo $yazilim_sayisi['yazilim_sayisi'];
                ?>
              </span>
              <div class="simge">
                <i class="fas fa-circle"></i>
                <i class="fas fa-box-open"></i>
              </div>
            </div>
            <div class="kutu3-2">
              <div class="kutuBaslik">Konum Sayısı</div>
              <span class="sayi">
              <?php
                echo $konum_sayisi['konum_sayisi'];
                ?>
              </span>
              <div class="simge">
                <i class="fas fa-circle"></i>
                <i class="fas fa-map-marker-alt"></i>
              </div>
            </div>
          </div>
          <div class="kutu4">
            <div class="kutu4-1">
              <div class="kutuBaslik">İşletim Sistemi Sayısı</div>
              <span class="sayi">
              <?php
                echo $isletim_sayisi['isletim_sayisi'];
                ?>
              </span>
              <div class="simge">
                <i class="fas fa-circle"></i>
                <i class="fab fa-windows"></i>
              </div>
            </div>
            <div class="kutu4-2">
              <div class="kutuBaslik">Bu Ayki Top. Gelir</div>
              <span class="sayi">430.000TL</span>
              <div class="simge">
                <i class="fas fa-circle"></i>
                <i class="fas fa-money-bill-alt"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="kutular3">
          <div class="kutu1">
            <div id="ilac_stok"></div>
          </div>
          <div class="kutu2">
            <div id="durum_graf"></div>
          </div>
        </div>
        <div class="kutular2">
          <div class="kutu1">
            <div class="bas">
              <div class="kutuBas">
                <div class="simge">
                  <i class="fas fa-circle"></i>
                  <i class="far fa-file-alt"></i>
                </div>

                <span>Yapılacaklar</span>
              </div>

              <div class="sayfalar">
                <a href="#">&laquo;</a>
                <a href="#">1</a>
                <a href="#" class="active">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">6</a>
                <a href="#">&raquo;</a>
              </div>
            </div>
            <div class="liste">
              <div class="list">
                <div>
                  <i class="fas fa-ellipsis-v"></i>
                  <input type="checkbox" checked/>
                </div>
                <span>Yönetim kurulu toplantısı, 09.30 Perşembe</span>
                <div class="uyari">
                  <span>30 Dakika</span>
                  <i class="far fa-clock"></i>
                </div>
              </div>
              <div class="list">
                <div>
                  <i class="fas fa-ellipsis-v"></i>
                  <input type="checkbox" />
                </div>
                <span>Güngün Gazetesi ropörtajı, 14.30 Salı</span>
                <div class="uyari">
                  <span>5 Saat</span>
                  <i class="far fa-clock"></i>
                </div>
              </div>
              <div class="list">
                <div>
                  <i class="fas fa-ellipsis-v"></i>
                  <input type="checkbox" />
                </div>
                <span>Stajyer ziyareti, 11.15 Pazartesi</span>
                <div class="uyari">
                  <span>1 Gün</span>
                  <i class="far fa-clock"></i>
                </div>
              </div>
              <div class="list">
                <div>
                  <i class="fas fa-ellipsis-v"></i>
                  <input type="checkbox" />
                </div>
                <span>Alexander Graham ile iş yemeği, 21.00 Perşembe</span>
                <div class="uyari">
                  <span>3 Gün</span>
                  <i class="far fa-clock"></i>
                </div>
              </div>
              <div class="list">
                <div>
                  <i class="fas fa-ellipsis-v"></i>
                  <input type="checkbox" />
                </div>
                <span>Rapor Teslimi, 08.00 Pazartesi</span>
                <div class="uyari">
                  <span>1 Hafta</span>
                  <i class="far fa-clock"></i>
                </div>
              </div>
              <div class="list">
                <div>
                  <i class="fas fa-ellipsis-v"></i>
                  <input type="checkbox" />
                </div>
                <span>Genel müdür ile toplantı, 10.45 Cuma</span>
                <div class="uyari">
                  <span>1 Ay</span>
                  <i class="far fa-clock"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="kutu2">
            <div id="toplam_hasta_graf"></div>
          </div>
        </div>
        
        
      <div class="footer">
        <div class="sol">
          <span>Site Haritası</span>
          <span>Hakkımızda</span>
          <span>Geri Bildirim</span>
          <span>İhaleler</span>
          <span>İletişim - Ulaşım</span></div>
        <span class="copyright">2020 Copyright © Tüm hakları saklıdır. - Yasin Seven</span>
      </div>
    </div>
    
  </body>
</html>
