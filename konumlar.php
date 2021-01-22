<?php
	// Include config file
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Ver Cloud Karar Destek Sistemi" />
    <meta name="keyword" content="Ver Cloud,cloud,karar,destek" />
    <title>Ver Cloud Karar Destek Sistemi</title>
    <link rel="stylesheet" href="css/konumlar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-map.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js"></script>
  <script src="https://cdn.anychart.com/geodata/latest/custom/world/world.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
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
            <span>Konumlar</span>
            <i class="fas fa-home"></i>
          </div>
          <div class="sag">
            <i class="fas fa-tachometer-alt"></i>
            <span>Konumlar</span>
            <span>></span>
            <span>Konumlar</span>
          </div>
        </div>
        <div class="kutular4">
          <div class="kutu1">
          <div id="container"></div>
  

  <script>

    anychart.onDocumentReady(function () {      
      anychart.data.loadJsonFile(
        'https://cdn.anychart.com/samples/maps-choropleth/world-women-suffrage-map/data.json',
        function (data) {
          anychart.palettes
            .distinctColors()
            .items([
              '#fff59d',
              '#fbc02d',
              '#ff8f00',
              '#ef6c00',
              '#bbdefb',
              '#90caf9',
              '#64b5f6',
              '#42a5f5',
              '#1e88e5',
              '#1976d2',
              '#1565c0',
              '#01579b',
              '#0097a7',
              '#00838f'
            ]);
          // The data used in this sample can be obtained from the CDN
          // https://cdn.anychart.com/samples/maps-choropleth/world-women-suffrage-map/data.js
          var dataSet = anychart.data.set(
            [
              <?php
                $sql = "SELECT konum.ulke_id, konum.ulke, round(AVG(zafiyet.cvss_skor),2) as ort FROM konum,cihaz,baglanti,zafiyet WHERE konum.konum_id=cihaz.konum_id AND cihaz.ip=baglanti.ip AND baglanti.cve_kodu=zafiyet.cve_kodu GROUP BY konum.ulke";
                $result = mysqli_query($mysqli, $sql);
              
                  
                //loop through the returned data
                while ($row = mysqli_fetch_array($result)) {
                  echo "{'id'",":","'".$row['ulke_id']."','name'",":","'".$row['ulke']."','value'",":","'".$row['ort']."'",",","'description'",":","' '","},";
                }
              ?>



            ]
          );

          var mapData = dataSet.mapAs({ description: 'description' });

          var map = anychart.map();

          // set map settings
          map
            .geoData('anychart.maps.world')
            .legend(false)
            .interactivity({ selectionMode: 'none' });

          map
            .title()
            .enabled(true)
            .fontSize(16)
            .padding(0, 0, 30, 0)
            .text('Konuma Göre Risk Durumu');

          
          var series = map.choropleth(mapData);
          series.geoIdField('iso_a2').labels(false);
          series.hovered().fill('#455a64');
          var scale = anychart.scales.ordinalColor([
            { less: 2 },
            { from: 2, to: 3 },
            { from: 3, to: 4 },
            { from: 4, to: 5 },
            { from: 5, to: 6 },
            { from: 6, to: 7 },
            { from: 7, to: 8 },
            { greater: 8 }
          ]);

          scale.colors([
            '#42a5f5',
            '#64b5f6',
            '#90caf9',
            '#ffa726',
            '#fb8c00',
            '#f57c00',
            '#ef6c00',
            '#e65100'
          ]);
          series.colorScale(scale);

          var colorRange = map.colorRange();
          colorRange
            .enabled(true)
            .padding([20, 0, 0, 0])
            .colorLineSize(5)
            .marker({ size: 7 });
          colorRange
            .ticks()
            .enabled(true)
            .stroke('3 #ffffff')
            .position('center')
            .length(20);
          colorRange
            .labels()
            .fontSize(10)
            .padding(0, 0, 0, 5)
            .format(function () {
              var range = this.colorRange;
              var name;
              if (isFinite(range.start + range.end)) {
                name = range.start + ' - ' + range.end;
              } else if (isFinite(range.start)) {
                name = 'After ' + range.start;
              } else {
                name = 'Before ' + range.end;
              }
              return name;
            });

          

          // create zoom controls
          var zoomController = anychart.ui.zoom();
          zoomController.render(map);

          // set container id for the chart
          map.container('container');
          // initiate chart drawing
          map.draw();

          
        }
      );
    });
  
</script>
          </div>
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
