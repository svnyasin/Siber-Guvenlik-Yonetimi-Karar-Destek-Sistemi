<?php
	// Include config file
require_once "config.php";

$secilen_yazilim="";
$secilen_yazilim1="";
    if(strip_tags(trim(isset($_POST["secilen_yazilim"])))){
        $secilen_yazilim=$_POST["secilen_yazilim"];
    }

    if(strip_tags(trim(isset($_POST["secilen_yazilim1"])))){
        $secilen_yazilim1=$_POST["secilen_yazilim1"];
    }
?>

<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Ver Cloud Karar Destek Sistemi" />
    <meta name="keyword" content="Ver Cloud,cloud,karar,destek" />
    <title>Ver Cloud Karar Destek Sistemi</title>
    <link rel="stylesheet" href="css/karsilastir.css" />
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
  <style>
        table {
            border-collapse: collapse;
    margin: 25px 0;
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
            <span>Yazılım Karşılaştırma</span>
            <i class="fas fa-home"></i>
          </div>
          <div class="sag">
            <i class="fas fa-tachometer-alt"></i>
            <span>Yazılım Karşılaştırma</span>
            <span>></span>
            <span>Yazılım Karşılaştırma</span>
          </div>
        </div>
        <div class="alt">
            <div class="dropDown">
            <form action="" method="POST">
    <select class="form-control" type="text" name="secilen_yazilim">
        <option value="<?php echo $secilen_yazilim ?>" hidden selected="<?php echo $secilen_yazilim ?>"><?php echo $secilen_yazilim ?></option>
        <?php
            $sql = "SELECT yazilim.ad
            FROM yazilim
            UNION
            SELECT isletim.ad
            FROM isletim";
            
            $result = mysqli_query($mysqli, $sql);
        
            
            //loop through the returned data
            while ($row = mysqli_fetch_array($result)) {
            echo "<option value='".$row['ad']."'>".$row['ad']."</option>";
          }
        
        ?>  
    </select>
    <select class="form-control" type="text" name="secilen_yazilim1">
        <option value="<?php echo $secilen_yazilim1 ?>" hidden selected="<?php echo $secilen_yazilim1 ?>"><?php echo $secilen_yazilim1 ?></option>
        <?php
            $sql = "SELECT yazilim.ad
            FROM yazilim
            UNION
            SELECT isletim.ad
            FROM isletim";
            
            $result = mysqli_query($mysqli, $sql);
        
            
            //loop through the returned data
            while ($row = mysqli_fetch_array($result)) {
            echo "<option value='".$row['ad']."'>".$row['ad']."</option>";
          }
        
        ?>  
    </select>
    
    
    <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>

          



            </div>
            <div class="tablolar">
              <div class="tablo1">
              <?php
        
        // Check connection
        if($mysqli === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT yazilim.*, COUNT(zafiyet.cvss_skor) as zafiyet_sayisi
        FROM zafiyet,baglanti,yazilim
        WHERE zafiyet.cve_kodu=baglanti.cve_kodu
        AND baglanti.yazilim_id=yazilim.yazilim_id
        and yazilim.ad = '$secilen_yazilim'
        GROUP BY yazilim.ad
        UNION
        
        SELECT isletim.isletim_id, isletim.ad, isletim.uretici, isletim.fiyat,COUNT(zafiyet.cvss_skor) as zafiyet_sayisi
        FROM zafiyet,baglanti,isletim
        WHERE zafiyet.cve_kodu=baglanti.cve_kodu
        AND baglanti.isletim_id=isletim.isletim_id
        and isletim.ad = '$secilen_yazilim'
        GROUP BY isletim.ad";
        
        // Attempt select query execution
        
        if($result = mysqli_query($mysqli, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='styled_table'>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tbody>";
                    echo "<thead>";
                    echo "<tr>";
                        echo "<td>Yazılım ID : </td>";
                        echo "<td>" . $row['yazilim_id'] . "</td>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tr>";
                    
                        echo "<td>Yazılım Adı : </td>";
                        echo "<td>" . $row['ad'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                        echo "<td>Üretici : </td>";
                        echo "<td>" . $row['uretici'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                        echo "<td>Zafiyet Sayısı : </td>";
                        echo "<td>" . $row['zafiyet_sayisi'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                        echo "<td>Yıllık Fiyat : </td>";
                        echo "<td>" . $row['fiyat'] . "</td>";
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
              <div class="tablo2">
              <?php
        
        // Check connection
        if($mysqli === false){
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        $sql = "SELECT yazilim.*, COUNT(zafiyet.cvss_skor) as zafiyet_sayisi
        FROM zafiyet,baglanti,yazilim
        WHERE zafiyet.cve_kodu=baglanti.cve_kodu
        AND baglanti.yazilim_id=yazilim.yazilim_id
        and yazilim.ad = '$secilen_yazilim1'
        GROUP BY yazilim.ad
        UNION
        
        SELECT isletim.isletim_id, isletim.ad, isletim.uretici, isletim.fiyat,COUNT(zafiyet.cvss_skor) as zafiyet_sayisi
        FROM zafiyet,baglanti,isletim
        WHERE zafiyet.cve_kodu=baglanti.cve_kodu
        AND baglanti.isletim_id=isletim.isletim_id
        and isletim.ad = '$secilen_yazilim1'
        GROUP BY isletim.ad";
        
        // Attempt select query execution
        
        if($result = mysqli_query($mysqli, $sql)){
            if(mysqli_num_rows($result) > 0){
                echo "<table class='styled_table'>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tbody>";
                    echo "<thead>";
                    echo "<tr>";
                        echo "<td>Yazılım ID : </td>";
                        echo "<td>" . $row['yazilim_id'] . "</td>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tr>";
                    
                        echo "<td>Yazılım Adı : </td>";
                        echo "<td>" . $row['ad'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                        echo "<td>Üretici : </td>";
                        echo "<td>" . $row['uretici'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                        echo "<td>Zafiyet Sayısı : </td>";
                        echo "<td>" . $row['zafiyet_sayisi'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    
                        echo "<td>Yıllık Fiyat : </td>";
                        echo "<td>" . $row['fiyat'] . "</td>";
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
