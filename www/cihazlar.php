<?php
	// Include config file
require_once "config.php";
    $secilen="Hepsi";
    if(strip_tags(trim(isset($_POST["secilen"])))){
        $secilen=$_POST["secilen"];
    }
    $secilen_cihaz="Hepsi";
    if(strip_tags(trim(isset($_POST["secilen_cihaz"])))){
        $secilen_cihaz=$_POST["secilen_cihaz"];
    }
  //<option value="United Kingdom">United Kingdom</option>   
    
?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Ver Cloud Karar Destek Sistemi" />
    <meta name="keyword" content="Ver Cloud,cloud,karar,destek" />
    <title>Ver Cloud Karar Destek Sistemi</title>
    <link rel="stylesheet" href="css/cihazlar.css" />
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
            <span>Cihazlar</span>
            <i class="fas fa-home"></i>
          </div>
          <div class="sag">
            <i class="fas fa-tachometer-alt"></i>
            <span>Cihazlar</span>
            <span>></span>
            <span>Cihazlar</span>
          </div>
        </div>
        <div class="alt">
        <form action="" method="POST">
    <select class="form-control" type="text" name="secilen">
        <option value="<?php echo $secilen ?>" hidden selected="<?php echo $secilen ?>"><?php echo $secilen ?></option>
        <option value="Hepsi">Hepsi</option>
        <?php
            $sql = "select konum.ulke from konum";
            $result = mysqli_query($mysqli, $sql);
        
            
            //loop through the returned data
            while ($row = mysqli_fetch_array($result)) {
            echo "<option value='".$row['ulke']."'>".$row['ulke']."</option>";
          }
        
        ?>  
    </select>
    <form action="" method="POST">
    <select class="form-control" type="text" name="secilen_cihaz">
        <option value="<?php echo $secilen_cihaz ?>" hidden selected="<?php echo $secilen_cihaz ?>"><?php echo $secilen_cihaz ?></option>
        <option value="Hepsi">Hepsi</option>
        <?php
            if ($secilen == "Hepsi") {
                $sql = "SELECT cihaz.ad, konum.ulke 
            FROM konum,cihaz
            WHERE konum.konum_id=cihaz.konum_id";
            } else {
                $sql = "SELECT cihaz.ad, konum.ulke 
            FROM konum,cihaz
            WHERE konum.konum_id=cihaz.konum_id
            AND konum.ulke = '$secilen'";
            }
            
            $result = mysqli_query($mysqli, $sql);
        
            
            //loop through the returned data
            while ($row = mysqli_fetch_array($result)) {
            echo "<option value='".$row['ad']."'>".$row['ad']."</option>";
          }
        
        ?>  
    </select>
    <button type="submit" class="btn btn-primary">Güncelle</button>
    <div class="kutu1">
        <?php
        
            // Check connection
            if($mysqli === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            if ($secilen == "Hepsi" && $secilen_cihaz != "Hepsi") {
                $sql = "SELECT konum.ulke_id, konum.ulke, konum.sehir, konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS yazilim_adi, yazilim.uretici, zafiyet.*, isletim.ad as isletim_adi, isletim.uretici as isletim_uretici, isletim.aile as isletim_aile
                FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim
                WHERE konum.konum_id=cihaz.konum_id
                AND cihaz.ip=baglanti.ip
                AND baglanti.yazilim_id=yazilim.yazilim_id
                AND baglanti.isletim_id=isletim.isletim_id
                AND baglanti.cve_kodu = zafiyet.cve_kodu
                AND cihaz.ad = '$secilen_cihaz'";
            } else {
                if ($secilen == "Hepsi" && $secilen_cihaz =="Hepsi") {
                    $sql = "SELECT konum.ulke_id, konum.ulke, konum.sehir, konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS yazilim_adi, yazilim.uretici, zafiyet.*, isletim.ad as isletim_adi, isletim.uretici as isletim_uretici, isletim.aile as isletim_aile
                    FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim
                    WHERE konum.konum_id=cihaz.konum_id
                    AND cihaz.ip=baglanti.ip
                    AND baglanti.yazilim_id=yazilim.yazilim_id
                    AND baglanti.isletim_id=isletim.isletim_id
                    AND baglanti.cve_kodu = zafiyet.cve_kodu";
                }else {
                    if ($secilen_cihaz == "Hepsi") {
                        $sql = "SELECT konum.ulke_id, konum.ulke, konum.sehir, konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS yazilim_adi, yazilim.uretici, zafiyet.*, isletim.ad as isletim_adi, isletim.uretici as isletim_uretici, isletim.aile as isletim_aile
                    FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim
                    WHERE konum.konum_id=cihaz.konum_id
                    AND cihaz.ip=baglanti.ip
                    AND baglanti.yazilim_id=yazilim.yazilim_id
                    AND baglanti.isletim_id=isletim.isletim_id
                    AND baglanti.cve_kodu = zafiyet.cve_kodu
                    AND konum.ulke = '$secilen'";
                    } else {
                        $sql = "SELECT konum.ulke_id, konum.ulke, konum.sehir, konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS yazilim_adi, yazilim.uretici, zafiyet.*, isletim.ad as isletim_adi, isletim.uretici as isletim_uretici, isletim.aile as isletim_aile
                    FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim
                    WHERE konum.konum_id=cihaz.konum_id
                    AND cihaz.ip=baglanti.ip
                    AND baglanti.yazilim_id=yazilim.yazilim_id
                    AND baglanti.isletim_id=isletim.isletim_id
                    AND baglanti.cve_kodu = zafiyet.cve_kodu
                    AND konum.ulke = '$secilen'
                    AND cihaz.ad = '$secilen_cihaz'";
                    }
                }
            }

            
            // Attempt select query execution
            
            if($result = mysqli_query($mysqli, $sql)){
                if(mysqli_num_rows($result) > 0){
                    echo "<table class='styled_table'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th>ulke</th>";
                            echo "<th>sehir</th>";
                            echo "<th>konum_id</th>";
                            echo "<th>ip</th>";
                            echo "<th>cihaz_adi</th>";
                            echo "<th>yazilim_adi</th>";
                            echo "<th>uretici</th>";
                            echo "<th>cve_kodu</th>";
                            echo "<th>cvss_ciddiyet</th>";
                            echo "<th>cvss_skor</th>";
                            echo "<th>yayinlanma</th>";
                            echo "<th>isletim_adi</th>";
                        echo "</tr>";
                        echo "</thead>";
                    while($row = mysqli_fetch_array($result)){
                        echo "<tbody>";
                        echo "<tr>";
                            echo "<td>" . $row['ulke'] . "</td>";
                            echo "<td>" . $row['sehir'] . "</td>";
                            echo "<td>" . $row['konum_id'] . "</td>";
                            echo "<td>" . $row['ip'] . "</td>";
                            echo "<td>" . $row['cihaz_adi'] . "</td>";
                            echo "<td>" . $row['yazilim_adi'] . "</td>";
                            echo "<td>" . $row['uretici'] . "</td>";
                            echo "<td>" . $row['cve_kodu'] . "</td>";
                            echo "<td>" . $row['cvss_ciddiyet'] . "</td>";
                            echo "<td>" . $row['cvss_skor'] . "</td>";
                            echo "<td>" . $row['yayinlanma'] . "</td>";
                            echo "<td>" . $row['isletim_adi'] . "</td>";
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
</form>
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
