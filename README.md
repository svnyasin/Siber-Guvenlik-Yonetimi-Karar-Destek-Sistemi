> **T.C.**
>
> **DOKUZ EYLÜL ÜNİVERSİTESİ**
>
> **İKTİSADİ VE İDARİ BİLİMLER FAKÜLTESİ**
>
> **YÖNETİM BİLİŞİM SİSTEMLERİ BÖLÜMÜ**
>
> **SİBER GÜVENLİK KARAR DESTEK SİSTEMİ**
>
> **HAZIRLAYAN**
>
> **YASİN SEVEN**
>
> **2017469044**
>
> **DERS SORUMLULARI**
>
> **Prof. Dr. Vahap TECİM**
>
> **Doç. Dr. Çiğdem TARHAN**
>
> **Doç. Dr. Can AYDIN**
>
> **İZMİR, 2021**

1.  **Özet**

Bu proje şirketlerin siber güvenlik teması altında diğer şirketlerle
yapacağı anlaşmalar ve yazılım satın alımları hakkında alacağı kararlara
destek olmak için geliştirilmiştir. Demo uygulamada "Ver-Cloud" isminde
hayali bir bulut bilişim şirketi ele alınmış ve bu şirketin sahip olduğu
tüm ağ altyapısı karar vericiye analiz ederek sunularak, karar vericinin
daha sağlıklı karar alması desteklenmeye çalışılmıştır.

2.  **Amaç**

Bu karar destek sistemi, bilgisayar ağlarını kullanan herhangi bir
şirketin sistemin sahip olduğu güvenlik riskleri ve zafiyetlerini analiz
ederek bu karar destek sisteminin kullanıldığı kuruluşun diğer
şirketlerle yazılım anlaşmaları yapan ve bu ağı tümüyle yöneten üst
düzey siber güvenlik sorumlusu için hangi cihazların hangi yazılıma
sahip olduğunu, hangi yazılımların hangi zafiyetlere sahip olduğunu,
sistemin ve kullanılan yazılımların genel risk durumu hakkında bilgi
sahibi olabileceği ve bu bilgiler ışığında hangi yazılımları değiştirip
hangi şirketlerle anlaşmalar yapacağı konusunda kararlar almasına destek
amacıyla oluşturulmuştur.

3.  **Projede Kullanılan Teknolojiler**

**Kullanılan Programlar:** Microsoft Visual Studio Code, WampServer64

**Kullanılan Programlama Dilleri:** Php, SQL, JavaScript

**Kullanılan Veritabanı:** MySQL

4.  **Veritabanı Tasarımı**

![](myMediaFolder\media\image18.png){width="6.267716535433071in"
height="2.5277777777777777in"}

![](myMediaFolder\media\image1.png){width="3.7031255468066493in"
height="1.7133858267716535in"}

**ER Diyagramı**

![](myMediaFolder\media\image7.png){width="6.267716535433071in"
height="3.4583333333333335in"}

**Kullanılan SQL Sorguları**

**1.Sistemdeki cihaz sayısını bulan sorgu**

**SELECT COUNT(cihaz.ip) as cihaz_sayisi FROM cihaz**

![](myMediaFolder\media\image3.png){width="1.03125in"
height="0.4270833333333333in"}

**2.Sistemdeki zafiyet sayısını bulan sorgu**

**SELECT COUNT(zafiyet.cve_kodu) as zafiyet_sayisi FROM zafiyet**

![](myMediaFolder\media\image9.png){width="1.09375in"
height="0.46875in"}

**3.Sistemdeki yazılım sayısını bulan sorgu**

**SELECT COUNT(yazilim.yazilim_id) as yazilim_sayisi FROM yazilim**

![](myMediaFolder\media\image21.png){width="1.0833333333333333in"
height="0.4270833333333333in"}

**4.Cihazların bulunduğu konumları bulan sorgu**

**SELECT COUNT(konum.konum_id) as konum_sayisi FROM konum**

![](myMediaFolder\media\image12.png){width="1.125in"
height="0.4583333333333333in"}

**5. Sistemdeki işletim sistemi sayısını bulan sorgu**

**SELECT COUNT(isletim.isletim_id) as isletim_sayisi FROM isletim**

![](myMediaFolder\media\image19.png){width="1.0416666666666667in"
height="0.40625in"}

**6.Tüm sistemin risk ortalamasını hesaplayan sorgu**

**SELECT round(AVG(ort),2) as sistem_riski**

**FROM (SELECT IFNULL(round(zafiyet.cvss_skor,2),0) as ort**

**FROM cihaz**

**LEFT JOIN baglanti**

**ON baglanti.ip=cihaz.ip**

**LEFT JOIN zafiyet**

**ON zafiyet.cve_kodu=baglanti.cve_kodu) as T**

![](myMediaFolder\media\image5.png){width="0.9583333333333334in"
height="0.4895833333333333in"}

**7.Ülkelere göre risk ortalamasını hesaplayan sorgu**

**SELECT konum.ulke, round(AVG(zafiyet.cvss_skor),2) as ort FROM
konum,cihaz,baglanti,zafiyet WHERE konum.konum_id=cihaz.konum_id AND
cihaz.ip=baglanti.ip AND baglanti.cve_kodu=zafiyet.cve_kodu GROUP BY
konum.ulke**

![](myMediaFolder\media\image2.png){width="1.5in"
height="3.3229166666666665in"}

**8.Zafiyet sayısı en çok olan 5 cihazı gösteren sorgu**

**SELECT cihaz.ad as cihaz_ad,COUNT(zafiyet.cve_kodu) as
zafiyet_sayisi**

**FROM cihaz, baglanti, zafiyet**

**WHERE cihaz.ip=baglanti.ip**

**AND baglanti.cve_kodu=zafiyet.cve_kodu**

**GROUP BY cihaz.ip**

**ORDER BY zafiyet_sayisi DESC**

**LIMIT 5**

![](myMediaFolder\media\image14.png){width="2.84375in"
height="1.3125in"}

**8.Her işletim sistemine göre kaç cihazda bulunduğunu gösteren sorgu**

**SELECT isletim.aile, COUNT(cihaz.ip) as cihaz_sayisi FROM isletim,
baglanti, cihaz WHERE isletim.isletim_id=baglanti.isletim_id AND
baglanti.ip=cihaz.ip GROUP BY isletim.aile**

![](myMediaFolder\media\image17.png){width="1.65625in"
height="0.8854166666666666in"}

**9.Hangi yılda hangi işletim sisteminde kaç zafiyet çıkmış görüntüleyen
sorgu**

**SELECT DISTINCT TT.yil, SUM(TT.value1) AS windows_zafiyet_sayisi,
SUM(TT.value2) AS linux_zafiyet_sayisi, SUM(TT.value3) AS
unix_zafiyet_sayisi**

**FROM (select IFNULL(t.yil,0) as yil,IFNULL(t.value1,0) as
value1,IFNULL(t.value2,0) as value2,IFNULL(t.value3,0) as value3**

**from (**

**select coalesce(t.yil, t3.yil) yil,**

**t.value1,**

**t.value2,**

**t3.value value3**

**from (**

**select coalesce(t1.yil, t2.yil) yil,**

**t1.value value1,**

**t2.value value2**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**union all**

**select coalesce(t1.yil, t2.yil),**

**t1.value,**

**t2.value**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**where not exists (**

**select 1**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) t**

**where t.yil = t2.yil**

**and right(t.value, 1) = right(t2.value, 1)**

**)**

**) t**

**right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Unix\'**

**GROUP BY yil) t3 on t.yil = t3.yil**

**and right(coalesce(t.value1, t.value2), 1) = right(t3.value, 1)**

**union all**

**select coalesce(t.yil, t3.yil) yil,**

**t.value1,**

**t.value2,**

**t3.value value3**

**from (**

**select coalesce(t1.yil, t2.yil) yil,**

**t1.value value1,**

**t2.value value2**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**union all**

**select coalesce(t1.yil, t2.yil),**

**t1.value,**

**t2.value**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**where not exists (**

**select 1**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) t**

**where t.yil = t2.yil**

**and right(t.value, 1) = right(t2.value, 1)**

**)**

**) t**

**left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Unix\'**

**GROUP BY yil) t3 on t.yil = t3.yil**

**and right(coalesce(t.value1, t.value2), 1) = right(t3.value, 1)**

**where not exists (**

**select 1**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Unix\'**

**GROUP BY yil) t2**

**where t2.yil = t.yil**

**and right(t2.value, 1) = right(coalesce(t.value1, t.value2), 1)**

**)**

**) t**

**order by yil,**

**value1,**

**value2,**

**value3) AS TT**

**GROUP BY TT.yil**

**ORDER BY TT.yil ASC**

![](myMediaFolder\media\image24.png){width="5.03125in"
height="5.677083333333333in"}

**10.Ülkelere göre risk skorunu hesaplayan sorgu**

**SELECT konum.ulke_id, konum.ulke, round(AVG(zafiyet.cvss_skor),2) as
ort FROM konum,cihaz,baglanti,zafiyet WHERE
konum.konum_id=cihaz.konum_id AND cihaz.ip=baglanti.ip AND
baglanti.cve_kodu=zafiyet.cve_kodu GROUP BY konum.ulke**

![](myMediaFolder\media\image10.png){width="2.1979166666666665in"
height="3.2916666666666665in"}

**11.Adı verilen ülkede olan cihazları gösterensorgu**

**SELECT cihaz.ad, konum.ulke**

**FROM konum,cihaz**

**WHERE konum.konum_id=cihaz.konum_id**

**AND konum.ulke = \'Turkey\'**

![](myMediaFolder\media\image11.png){width="1.4375in"
height="0.9166666666666666in"}

**12.Tüm cihazları bilgileriyle birlikte gösteren sorgu**

**SELECT konum.ulke_id, konum.ulke, konum.sehir, konum.konum_id,
cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS yazilim_adi,
yazilim.uretici, zafiyet.\*, isletim.ad as isletim_adi, isletim.uretici
as isletim_uretici, isletim.aile as isletim_aile**

**FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim**

**WHERE konum.konum_id=cihaz.konum_id**

**AND cihaz.ip=baglanti.ip**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND baglanti.cve_kodu = zafiyet.cve_kodu**

![](myMediaFolder\media\image25.png){width="10.588541119860018in"
height="4.06791447944007in"}

**13.Sistemdeki yazılım ve işletim sistemlerini tek tabloda gösteren
sorgu**

**SELECT yazilim.ad**

**FROM yazilim**

**UNION**

**SELECT isletim.ad**

**FROM isletim**

![](myMediaFolder\media\image20.png){width="2.1145833333333335in"
height="5.708333333333333in"}

**14.Parametre olarak girilen yazılım veya işletim sisteminin
özelliklerini gösteren sorgu**

**SELECT yazilim.\*, COUNT(zafiyet.cvss_skor) as zafiyet_sayisi**

**FROM zafiyet,baglanti,yazilim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**and yazilim.ad = \'\$secilen_yazilim\'**

**GROUP BY yazilim.ad**

**UNION**

**SELECT isletim.isletim_id, isletim.ad, isletim.uretici,
isletim.fiyat,COUNT(zafiyet.cvss_skor) as zafiyet_sayisi**

**FROM zafiyet,baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**and isletim.ad = \'\$secilen_yazilim\'**

**GROUP BY isletim.ad\"**

**(\$secilen_yazilim değişkeni "VMware Workstation" olursa)**

![](myMediaFolder\media\image6.png){width="4.6875in"
height="0.4583333333333333in"}

5.  **Dashboard Tasarımı**

Karar destek sistemine ilk giriş yapıldığında aşağıdaki giriş ekranıyla
karşılaşıyoruz. Bu ekranda doğru şifre girilmeden hiçbir şekilde siteye
giriş yapılamamaktadır, bu ekrandan yeni hesap oluşturulabilir ve bu
hesapla giriş yapılabilir. Yeni hesapların parolaları şifrelenerek
veritabanına eklenir.

![](myMediaFolder\media\image27.png){width="6.267716535433071in"
height="3.5277777777777777in"}

Giriş yapıldıktan sonra kullanıcıya sistem hakkında çeşitli analizler
sunan bir anasayfa kullanıcıyı karşılar. Sol kısımdaki sidebar ile
sayfalar arasında gezebilir, sağ üstteki çıkış butonu ile oturumunu
sonlandırabilir.

![](myMediaFolder\media\image26.png){width="6.267716535433071in"
height="3.5277777777777777in"}

Anasayfanın üst kısmında şirketin sahip olduğu ağ altyapısının
özellikleri ve sistem hakkında genel risk bilgisi yer alır.

![](myMediaFolder\media\image13.png){width="6.267716535433071in"
height="1.2916666666666667in"}

Altında ise ağ içindeki cihazların koşturdukları işletim sistemlerinin
oranları ve bu işletim sistemlerinin yıllara göre yeni zafiyet sayıları
yer alır.

![](myMediaFolder\media\image16.png){width="6.267716535433071in"
height="1.3055555555555556in"}

Bir altta ise kullanıcının notlar alabilmesi için bir yapılacaklar kısmı
ve sağında ise sistemin en çok zafiyete sahip makinalarını görebileceği
bir grafik
bulunmakta.![](myMediaFolder\media\image15.png){width="6.267716535433071in"
height="1.2638888888888888in"}

Karar alıcı ana ekrana baktıktan sonra şirketin sahip olduğu ağ
altyapısı hakkında bilgi edinir, artık hangi işletim sistemini tercih
etmesi gerektiği gelecekte hangi işletim sistemine daha fazla ağırlık
vermesi gerektiğini ve en riskli cihazlar hakkında bilgi sahibidir.

![](myMediaFolder\media\image23.png){width="6.267716535433071in"
height="3.5277777777777777in"}

Karar vericiyi ikinci sayfada ağ altyapısının dünya üzerinde hangi
ülkelerde cihazlara sahip olduğuna ve o ülkelerin risk değerleri
hakkında bilgi alabileceği "Konumlar" sayfası karşılar.

![](myMediaFolder\media\image22.png){width="6.267716535433071in"
height="3.5277777777777777in"}

Bir sonraki "Cihazlar" sayfasında karar verici sahip olunan tüm
cihazları tüm bilgileriyle beraber tablo olarak görüntüleyebilir,
dilerse bir önceki sayfadan sahip olduğu konum bilgileriyle belli bir
cihazı seçerek o cihazın üzerinde koşan zafiyet, program ve işletim
sistemlerini görebilir.

![](myMediaFolder\media\image4.png){width="6.267716535433071in"
height="3.5277777777777777in"}

"Zafiyetler" sayfasında kullanıcı belli bir zafiyet kodu hakkında
bilgileri bulabilir ve sayfanın sağ kısmında sistemdeki en riskli
yazılımları sıralanmış şekilde görerek hangi yazılımları hangisine
tercih edeceği hakkında fikir sahibi olabilir.

![](myMediaFolder\media\image8.png){width="6.267716535433071in"
height="3.5277777777777777in"}

"Karşılaştırma" ekranında ise karar verici önceki sayfalarda bilgi
sahibi olduğu riskli konumlardaki riskli yazılımlar hakkında risk skoru
ve fiyat karşılaştırması yaparak hangi yazılımı satın alacağına karar
verebilir.

6.  **KODLAR**

**Dosyalar:** index.php, konumlar.php, cihazlar.php, karsilastir.php,
zafiyetler.php, config.php, login.php, logout.php, register.php,
style.css, cihazlar.css, karsilastir.css, konumlar.css, zafiyetler.css

**Github:**
https://github.com/yasinsvn/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi

**index.php:**

**\<?php**

**// Include config file**

**require_once \"config.php\";**

**session_start();**

**// Check if the user is logged in, if not then redirect him to login
page**

**if(!isset(\$\_SESSION\[\"loggedin\"\]) \|\|
\$\_SESSION\[\"loggedin\"\] !== true){**

**header(\"location: login.php\");**

**exit;**

**}**

**\$sql = \"SELECT COUNT(cihaz.ip) as cihaz_sayisi FROM cihaz\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$cihaz_sayisi=mysqli_fetch_assoc(\$result);**

**\$sql = \"SELECT COUNT(zafiyet.cve_kodu) as zafiyet_sayisi FROM
zafiyet\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$zafiyet_sayisi=mysqli_fetch_assoc(\$result);**

**\$sql = \"SELECT COUNT(yazilim.yazilim_id) as yazilim_sayisi FROM
yazilim\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$yazilim_sayisi=mysqli_fetch_assoc(\$result);**

**\$sql = \"SELECT COUNT(konum.konum_id) as konum_sayisi FROM konum\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$konum_sayisi=mysqli_fetch_assoc(\$result);**

**\$sql = \"SELECT COUNT(isletim.isletim_id) as isletim_sayisi FROM
isletim\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$isletim_sayisi=mysqli_fetch_assoc(\$result);**

**//echo \$cihaz_sayisi\[\'cihaz_sayisi\'\];**

**\$sql = \"SELECT round(AVG(ort),2) as sistem_riski**

**FROM (SELECT IFNULL(round(zafiyet.cvss_skor,2),0) as ort**

**FROM cihaz**

**LEFT JOIN baglanti**

**ON baglanti.ip=cihaz.ip**

**LEFT JOIN zafiyet**

**ON zafiyet.cve_kodu=baglanti.cve_kodu) as T\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$sistem_riski=mysqli_fetch_assoc(\$result);**

**\$sistem_riski\[\'sistem_riski\'\]=\$sistem_riski\[\'sistem_riski\'\]\*10**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"tr\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\" /\>**

**\<meta name=\"description\" content=\"Ver Cloud Karar Destek Sistemi\"
/\>**

**\<meta name=\"keyword\" content=\"Ver Cloud,cloud,karar,destek\" /\>**

**\<title\>Ver Cloud Karar Destek Sistemi\</title\>**

**\<link rel=\"stylesheet\" href=\"css/style.css\" /\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-base.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-map.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/geodata/latest/custom/world/world.js\"\>\</script\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js\"\>\</script\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<script type=\"text/javascript\"
src=\"https://www.gstatic.com/charts/loader.js\"\>\</script\>**

**\<script type=\"text/javascript\"\>**

**google.charts.load(\'current\', {\'packages\':\[\'gauge\'\]});**

**google.charts.setOnLoadCallback(drawChart);**

**function drawChart() {**

**var data = google.visualization.arrayToDataTable(\[**

**\[\'Label\', \'Value\'\],**

**\[\'\',**

**\<?php**

**echo \$sistem_riski\[\'sistem_riski\'\];**

**?\>**

**\]**

**\]);**

**var options = {**

**width: 400, height: 250,**

**redFrom: 75, redTo: 100,**

**yellowFrom:50, yellowTo: 75,**

**minorTicks: 10**

**};**

**var chart = new
google.visualization.Gauge(document.getElementById(\'chart_div\'));**

**chart.draw(data, options);**

**}**

**\</script\>**

**\<script type=\"text/javascript\"\>**

**google.charts.load(\'current\', {**

**\'packages\':\[\'geochart\'\],**

**// Note: you will need to get a mapsApiKey for your project.**

**// See:
https://developers.google.com/chart/interactive/docs/basic_load_libs\#load-settings**

**\'mapsApiKey\': \'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY\'**

**});**

**google.charts.setOnLoadCallback(drawRegionsMap);**

**function drawRegionsMap() {**

**var data = google.visualization.arrayToDataTable(\[**

**\[\'Ülke\', \'Risk Skoru\'\],**

**\<?php**

**\$sql = \"SELECT konum.ulke, round(AVG(zafiyet.cvss_skor),2) as ort
FROM konum,cihaz,baglanti,zafiyet WHERE konum.konum_id=cihaz.konum_id
AND cihaz.ip=baglanti.ip AND baglanti.cve_kodu=zafiyet.cve_kodu GROUP BY
konum.ulke\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo \"\[\'\".\$row\[\'ulke\'\].\"\',\".\$row\[\'ort\'\].\"\],\";**

**}**

**?\>**

**\]);**

**var options = {};**

**options\[\'colorAxis\'\] = { minValue : 0, maxValue : 10, colors :
\[\'\#9fa0c2\',\'\#0006b8\'\]};**

**var chart = new
google.visualization.GeoChart(document.getElementById(\'regions_div\'));**

**chart.draw(data, options);**

**}**

**\</script\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js\"\>\</script\>**

**\<script type=\"text/javascript\"\>**

**google.charts.load(\"current\", {packages:\[\'corechart\'\]});**

**google.charts.setOnLoadCallback(drawChart);**

**function drawChart() {**

**var data = google.visualization.arrayToDataTable(\[**

**\[\"Cihaz\", \"Zafiyet Sayısı\", { role: \"style\" } \],**

**\<?php**

**\$sql = \"SELECT cihaz.ad as cihaz_ad,COUNT(zafiyet.cve_kodu) as
zafiyet_sayisi**

**FROM cihaz, baglanti, zafiyet**

**WHERE cihaz.ip=baglanti.ip**

**AND baglanti.cve_kodu=zafiyet.cve_kodu**

**GROUP BY cihaz.ip**

**ORDER BY zafiyet_sayisi DESC**

**LIMIT 5**

**\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**\$i = 0;**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**if (\$i == 0) {**

**echo
\"\[\'\".\$row\[\'cihaz_ad\'\].\"\',\".\$row\[\'zafiyet_sayisi\'\].\",\",\"\'\",\"\#E9A1B2\",\"\'\",\"\],\";**

**\$i = 1;**

**}**

**elseif (\$i == 1){**

**echo
\"\[\'\".\$row\[\'cihaz_ad\'\].\"\',\".\$row\[\'zafiyet_sayisi\'\].\",\",\"\'\",\"\#A6A7CF\",\"\'\",\"\],\";**

**\$i = 0;**

**}**

**}**

**?\>**

**\]);**

**var view = new google.visualization.DataView(data);**

**view.setColumns(\[0, 1,**

**{ calc: \"stringify\",**

**sourceColumn: 1,**

**type: \"string\",**

**role: \"annotation\" },**

**2\]);**

**var options = {**

**title: \" En Çok Zafiyete Sahip Cihazlar\",**

**titleTextStyle: {**

**color: \'\#808080\',**

**fontSize: \"14\"},**

**bar: {groupWidth: \"75%\"},**

**legend: { position: \"none\" },**

**};**

**var chart = new
google.visualization.ColumnChart(document.getElementById(\"toplam_hasta_graf\"));**

**chart.draw(view, options);**

**}**

**\</script\>**

**\<script type=\"text/javascript\"\>**

**google.charts.load(\"current\", {packages:\[\"corechart\"\]});**

**google.charts.setOnLoadCallback(drawChart);**

**function drawChart() {**

**var data = google.visualization.arrayToDataTable(\[**

**\[\'isletim\', \'Sayı\'\],**

**\<?php**

**\$sql = \"SELECT isletim.aile, COUNT(cihaz.ip) as cihaz_sayisi FROM
isletim, baglanti, cihaz WHERE isletim.isletim_id=baglanti.isletim_id
AND baglanti.ip=cihaz.ip GROUP BY isletim.aile\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo
\"\[\'\".\$row\[\'aile\'\].\"\',\".\$row\[\'cihaz_sayisi\'\].\"\],\";**

**}**

**?\>**

**\]);**

**var options = {**

**title: \"İşletim Sistemi Dağılımı\",**

**titleTextStyle: {**

**color: \'\#808080\',**

**fontSize: \"14\"},**

**pieHole: 0.4,**

**slices: {**

**0: { color: \"\#E9A1B2\" },**

**1: { color: \"\#A6A7CF\" },**

**2: { color: \"\#6BB3F4\"}**

**}**

**};**

**var chart = new
google.visualization.PieChart(document.getElementById(\'ilac_stok\'));**

**chart.draw(data, options);**

**}**

**\</script\>**

**\<script type=\"text/javascript\"\>**

**google.charts.load(\'current\', {\'packages\':\[\'line\'\]});**

**google.charts.setOnLoadCallback(drawChart);**

**function drawChart() {**

**var data = new google.visualization.DataTable();**

**data.addColumn(\'string\', \'Yıl\');**

**data.addColumn(\'number\', \'Windows\');**

**data.addColumn(\'number\', \'Linux\');**

**data.addColumn(\'number\', \'Unix\');**

**data.addRows(\[**

**\<?php**

**\$sql = \"SELECT DISTINCT TT.yil, SUM(TT.value1) AS
windows_zafiyet_sayisi, SUM(TT.value2) AS linux_zafiyet_sayisi,
SUM(TT.value3) AS unix_zafiyet_sayisi**

**FROM (select IFNULL(t.yil,0) as yil,IFNULL(t.value1,0) as
value1,IFNULL(t.value2,0) as value2,IFNULL(t.value3,0) as value3**

**from (**

**select coalesce(t.yil, t3.yil) yil,**

**t.value1,**

**t.value2,**

**t3.value value3**

**from (**

**select coalesce(t1.yil, t2.yil) yil,**

**t1.value value1,**

**t2.value value2**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**union all**

**select coalesce(t1.yil, t2.yil),**

**t1.value,**

**t2.value**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**where not exists (**

**select 1**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) t**

**where t.yil = t2.yil**

**and right(t.value, 1) = right(t2.value, 1)**

**)**

**) t**

**right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Unix\'**

**GROUP BY yil) t3 on t.yil = t3.yil**

**and right(coalesce(t.value1, t.value2), 1) = right(t3.value, 1)**

**union all**

**select coalesce(t.yil, t3.yil) yil,**

**t.value1,**

**t.value2,**

**t3.value value3**

**from (**

**select coalesce(t1.yil, t2.yil) yil,**

**t1.value value1,**

**t2.value value2**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**union all**

**select coalesce(t1.yil, t2.yil),**

**t1.value,**

**t2.value**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) as t1**

**right join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Linux\'**

**GROUP BY yil) as t2 on RIGHT(t2.value, 1) = RIGHT(t1.value, 1)**

**and t1.yil = t2.yil**

**where not exists (**

**select 1**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Windows\'**

**GROUP BY yil) t**

**where t.yil = t2.yil**

**and right(t.value, 1) = right(t2.value, 1)**

**)**

**) t**

**left join (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Unix\'**

**GROUP BY yil) t3 on t.yil = t3.yil**

**and right(coalesce(t.value1, t.value2), 1) = right(t3.value, 1)**

**where not exists (**

**select 1**

**from (SELECT RIGHT(zafiyet.yayinlanma,4) as yil,
COUNT(zafiyet.cve_kodu) as value**

**FROM zafiyet, baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND isletim.aile=\'Unix\'**

**GROUP BY yil) t2**

**where t2.yil = t.yil**

**and right(t2.value, 1) = right(coalesce(t.value1, t.value2), 1)**

**)**

**) t**

**order by yil,**

**value1,**

**value2,**

**value3) AS TT**

**GROUP BY TT.yil**

**ORDER BY TT.yil ASC\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo
\"\[\'\".\$row\[\'yil\'\].\"\',\".\$row\[\'windows_zafiyet_sayisi\'\].\",\".\$row\[\'linux_zafiyet_sayisi\'\].\",\".\$row\[\'unix_zafiyet_sayisi\'\].\",\],\";**

**}**

**?\>**

**\]);**

**var options = {**

**chart: {**

**title: \'Genel Bakış\',},**

**titleTextStyle: {**

**color: \'\#808080\',**

**fontSize: \"14\"},**

**axes: {**

**x: {**

**0: {side: \'down\'}**

**}**

**},**

**series: {**

**0:{color: \"\#E9A1B2\"},**

**1:{color: \"\#A6A7CF\"},**

**2:{color: \"\#6BB3F4\"}**

**}**

**};**

**var chart = new
google.charts.Line(document.getElementById(\'durum_graf\'));**

**chart.draw(data, google.charts.Line.convertOptions(options));**

**}**

**\</script\>**

**\</head\>**

**\<body\>**

**\<div class=\"kenarCubugu\"\>**

**\<div class=\"yanBaslik\"\>**

**\<a href=\"\#\"\>\<img src=\"images/logo.png\" alt=\"\" /\>\</a\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<div class=\"bilgi\"\>**

**\<span class=\"isim\"\>Yasin Seven\</span\>**

**\<span class=\"unvan\"\>Siber Güvenlik Mimarı\</span\>**

**\</div\>**

**\</div\>**

**\<a href=\"index.php\" class=\"kontrolPaneli\"\>**

**\<span\>Ana Ekran\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</a\>**

**\<a href=\"konumlar.php\" class=\"konumlar\"\>**

**\<span\>Konumlar\</span\>**

**\<i class=\"fas fa-map-marker-alt\"\>\</i\>**

**\</a \>**

**\<a href=\"cihazlar.php\" class=\"cihazlar\"\>**

**\<span\>Cihazlar\</span\>**

**\<i class=\"fas fa-desktop\"\>\</i\>**

**\</a \>**

**\<a href=\"zafiyetler.php\" class=\"zafiyetler\"\>**

**\<span\>Zafiyetler\</span\>**

**\<i class=\"fas fa-biohazard\"\>\</i\>**

**\</a \>**

**\<a href=\"karsilastir.php\" class=\"karsilastirma\"\>**

**\<span\>Karşılaştırma\</span\>**

**\<i class=\"fas fa-tasks\"\>\</i\>**

**\</a \>**

**\</div\>**

**\<div class=\"icerik\"\>**

**\<div class=\"baslik\"\>**

**\<i class=\"fas fa-bars\"\>\</i\>**

**\<div class=\"arama\"\>**

**\<i class=\"fas fa-search\"\>\</i\>**

**\<input type=\"text\" placeholder=\"Arama\...\" /\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<span\>Yasin Seven\</span\>**

**\<i class=\"fas fa-chevron-down\"\>\</i\>**

**\</div\>**

**\<div class=\"bildirim\"\>**

**\<div class=\"baslikMektup\"\>**

**\<i class=\"far fa-envelope\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikCan\"\>**

**\<i class=\"far fa-bell\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikBayrak\"\>**

**\<i class=\"far fa-flag\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<a href=\"logout.php\" class=\"logOut\"\>\<i class=\"fas
fa-sign-out-alt\"\>\</i\>\</a\>**

**\</div\>**

**\<div class=\"anaEkran\"\>**

**\<div class=\"ust\"\>**

**\<div class=\"sol\"\>**

**\<span\>Ana Ekran\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</div\>**

**\<div class=\"sag\"\>**

**\<i class=\"fas fa-tachometer-alt\"\>\</i\>**

**\<span\>Ana Ekran\</span\>**

**\<span\>\>\</span\>**

**\<span\>Ana Ekran\</span\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutular1\"\>**

**\<div class=\"kutu1\"\>**

**\<span\>Sistem Riski\</span\>**

**\<div id=\"chart_div\" style=\"width: 400px; height:
120px;\"\>\</div\>**

**\</div\>**

**\<div class=\"kutu2\"\>**

**\<div class=\"kutu2-1\"\>**

**\<div class=\"kutuBaslik\"\>Cihaz Sayısı\</div\>**

**\<span class=\"sayi\"\>**

**\<?php**

**echo \$cihaz_sayisi\[\'cihaz_sayisi\'\];**

**?\>**

**\</span\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"fas fa-desktop\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutu2-2\"\>**

**\<div class=\"kutuBaslik\"\>Zafiyet Sayısı\</div\>**

**\<span class=\"sayi\"\>**

**\<?php**

**echo \$zafiyet_sayisi\[\'zafiyet_sayisi\'\];**

**?\>**

**\</span\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"fas fa-biohazard\"\>\</i\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutu3\"\>**

**\<div class=\"kutu3-1\"\>**

**\<div class=\"kutuBaslik\"\>Yazılım Sayısı\</div\>**

**\<span class=\"sayi\"\>**

**\<?php**

**echo \$yazilim_sayisi\[\'yazilim_sayisi\'\];**

**?\>**

**\</span\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"fas fa-box-open\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutu3-2\"\>**

**\<div class=\"kutuBaslik\"\>Konum Sayısı\</div\>**

**\<span class=\"sayi\"\>**

**\<?php**

**echo \$konum_sayisi\[\'konum_sayisi\'\];**

**?\>**

**\</span\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"fas fa-map-marker-alt\"\>\</i\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutu4\"\>**

**\<div class=\"kutu4-1\"\>**

**\<div class=\"kutuBaslik\"\>İşletim Sistemi Sayısı\</div\>**

**\<span class=\"sayi\"\>**

**\<?php**

**echo \$isletim_sayisi\[\'isletim_sayisi\'\];**

**?\>**

**\</span\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"fab fa-windows\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutu4-2\"\>**

**\<div class=\"kutuBaslik\"\>Bu Ayki Top. Gelir\</div\>**

**\<span class=\"sayi\"\>430.000TL\</span\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"fas fa-money-bill-alt\"\>\</i\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutular3\"\>**

**\<div class=\"kutu1\"\>**

**\<div id=\"ilac_stok\"\>\</div\>**

**\</div\>**

**\<div class=\"kutu2\"\>**

**\<div id=\"durum_graf\"\>\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutular2\"\>**

**\<div class=\"kutu1\"\>**

**\<div class=\"bas\"\>**

**\<div class=\"kutuBas\"\>**

**\<div class=\"simge\"\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\<i class=\"far fa-file-alt\"\>\</i\>**

**\</div\>**

**\<span\>Yapılacaklar\</span\>**

**\</div\>**

**\<div class=\"sayfalar\"\>**

**\<a href=\"\#\"\>&laquo;\</a\>**

**\<a href=\"\#\"\>1\</a\>**

**\<a href=\"\#\" class=\"active\"\>2\</a\>**

**\<a href=\"\#\"\>3\</a\>**

**\<a href=\"\#\"\>4\</a\>**

**\<a href=\"\#\"\>5\</a\>**

**\<a href=\"\#\"\>6\</a\>**

**\<a href=\"\#\"\>&raquo;\</a\>**

**\</div\>**

**\</div\>**

**\<div class=\"liste\"\>**

**\<div class=\"list\"\>**

**\<div\>**

**\<i class=\"fas fa-ellipsis-v\"\>\</i\>**

**\<input type=\"checkbox\" checked/\>**

**\</div\>**

**\<span\>Yönetim kurulu toplantısı, 09.30 Perşembe\</span\>**

**\<div class=\"uyari\"\>**

**\<span\>30 Dakika\</span\>**

**\<i class=\"far fa-clock\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"list\"\>**

**\<div\>**

**\<i class=\"fas fa-ellipsis-v\"\>\</i\>**

**\<input type=\"checkbox\" /\>**

**\</div\>**

**\<span\>Güngün Gazetesi ropörtajı, 14.30 Salı\</span\>**

**\<div class=\"uyari\"\>**

**\<span\>5 Saat\</span\>**

**\<i class=\"far fa-clock\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"list\"\>**

**\<div\>**

**\<i class=\"fas fa-ellipsis-v\"\>\</i\>**

**\<input type=\"checkbox\" /\>**

**\</div\>**

**\<span\>Stajyer ziyareti, 11.15 Pazartesi\</span\>**

**\<div class=\"uyari\"\>**

**\<span\>1 Gün\</span\>**

**\<i class=\"far fa-clock\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"list\"\>**

**\<div\>**

**\<i class=\"fas fa-ellipsis-v\"\>\</i\>**

**\<input type=\"checkbox\" /\>**

**\</div\>**

**\<span\>Alexander Graham ile iş yemeği, 21.00 Perşembe\</span\>**

**\<div class=\"uyari\"\>**

**\<span\>3 Gün\</span\>**

**\<i class=\"far fa-clock\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"list\"\>**

**\<div\>**

**\<i class=\"fas fa-ellipsis-v\"\>\</i\>**

**\<input type=\"checkbox\" /\>**

**\</div\>**

**\<span\>Rapor Teslimi, 08.00 Pazartesi\</span\>**

**\<div class=\"uyari\"\>**

**\<span\>1 Hafta\</span\>**

**\<i class=\"far fa-clock\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<div class=\"list\"\>**

**\<div\>**

**\<i class=\"fas fa-ellipsis-v\"\>\</i\>**

**\<input type=\"checkbox\" /\>**

**\</div\>**

**\<span\>Genel müdür ile toplantı, 10.45 Cuma\</span\>**

**\<div class=\"uyari\"\>**

**\<span\>1 Ay\</span\>**

**\<i class=\"far fa-clock\"\>\</i\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutu2\"\>**

**\<div id=\"toplam_hasta_graf\"\>\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"footer\"\>**

**\<div class=\"sol\"\>**

**\<span\>Site Haritası\</span\>**

**\<span\>Hakkımızda\</span\>**

**\<span\>Geri Bildirim\</span\>**

**\<span\>İhaleler\</span\>**

**\<span\>İletişim - Ulaşım\</span\>\</div\>**

**\<span class=\"copyright\"\>2020 Copyright © Tüm hakları saklıdır. -
Yasin Seven\</span\>**

**\</div\>**

**\</div\>**

**\</body\>**

**\</html\>**

**konumlar.php**

**\<?php**

**// Include config file**

**require_once \"config.php\";**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"tr\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\" /\>**

**\<meta name=\"description\" content=\"Ver Cloud Karar Destek Sistemi\"
/\>**

**\<meta name=\"keyword\" content=\"Ver Cloud,cloud,karar,destek\" /\>**

**\<title\>Ver Cloud Karar Destek Sistemi\</title\>**

**\<link rel=\"stylesheet\" href=\"css/konumlar.css\" /\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-base.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-map.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/geodata/latest/custom/world/world.js\"\>\</script\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js\"\>\</script\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\</head\>**

**\<body\>**

**\<div class=\"kenarCubugu\"\>**

**\<div class=\"yanBaslik\"\>**

**\<a href=\"\#\"\>\<img src=\"images/logo.png\" alt=\"\" /\>\</a\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<div class=\"bilgi\"\>**

**\<span class=\"isim\"\>Yasin Seven\</span\>**

**\<span class=\"unvan\"\>Siber Güvenlik Mimarı\</span\>**

**\</div\>**

**\</div\>**

**\<a href=\"index.php\" class=\"kontrolPaneli\"\>**

**\<span\>Ana Ekran\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</a\>**

**\<a href=\"konumlar.php\" class=\"konumlar\"\>**

**\<span\>Konumlar\</span\>**

**\<i class=\"fas fa-map-marker-alt\"\>\</i\>**

**\</a \>**

**\<a href=\"cihazlar.php\" class=\"cihazlar\"\>**

**\<span\>Cihazlar\</span\>**

**\<i class=\"fas fa-desktop\"\>\</i\>**

**\</a \>**

**\<a href=\"zafiyetler.php\" class=\"zafiyetler\"\>**

**\<span\>Zafiyetler\</span\>**

**\<i class=\"fas fa-biohazard\"\>\</i\>**

**\</a \>**

**\<a href=\"karsilastir.php\" class=\"karsilastirma\"\>**

**\<span\>Karşılaştırma\</span\>**

**\<i class=\"fas fa-tasks\"\>\</i\>**

**\</a \>**

**\</div\>**

**\<div class=\"icerik\"\>**

**\<div class=\"baslik\"\>**

**\<i class=\"fas fa-bars\"\>\</i\>**

**\<div class=\"arama\"\>**

**\<i class=\"fas fa-search\"\>\</i\>**

**\<input type=\"text\" placeholder=\"Arama\...\" /\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<span\>Yasin Seven\</span\>**

**\<i class=\"fas fa-chevron-down\"\>\</i\>**

**\</div\>**

**\<div class=\"bildirim\"\>**

**\<div class=\"baslikMektup\"\>**

**\<i class=\"far fa-envelope\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikCan\"\>**

**\<i class=\"far fa-bell\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikBayrak\"\>**

**\<i class=\"far fa-flag\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<a href=\"logout.php\" class=\"logOut\"\>\<i class=\"fas
fa-sign-out-alt\"\>\</i\>\</a\>**

**\</div\>**

**\<div class=\"anaEkran\"\>**

**\<div class=\"ust\"\>**

**\<div class=\"sol\"\>**

**\<span\>Konumlar\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</div\>**

**\<div class=\"sag\"\>**

**\<i class=\"fas fa-tachometer-alt\"\>\</i\>**

**\<span\>Konumlar\</span\>**

**\<span\>\>\</span\>**

**\<span\>Konumlar\</span\>**

**\</div\>**

**\</div\>**

**\<div class=\"kutular4\"\>**

**\<div class=\"kutu1\"\>**

**\<div id=\"container\"\>\</div\>**

**\<script\>**

**anychart.onDocumentReady(function () {**

**anychart.data.loadJsonFile(**

**\'https://cdn.anychart.com/samples/maps-choropleth/world-women-suffrage-map/data.json\',**

**function (data) {**

**anychart.palettes**

**.distinctColors()**

**.items(\[**

**\'\#fff59d\',**

**\'\#fbc02d\',**

**\'\#ff8f00\',**

**\'\#ef6c00\',**

**\'\#bbdefb\',**

**\'\#90caf9\',**

**\'\#64b5f6\',**

**\'\#42a5f5\',**

**\'\#1e88e5\',**

**\'\#1976d2\',**

**\'\#1565c0\',**

**\'\#01579b\',**

**\'\#0097a7\',**

**\'\#00838f\'**

**\]);**

**// The data used in this sample can be obtained from the CDN**

**//
https://cdn.anychart.com/samples/maps-choropleth/world-women-suffrage-map/data.js**

**var dataSet = anychart.data.set(**

**\[**

**\<?php**

**\$sql = \"SELECT konum.ulke_id, konum.ulke,
round(AVG(zafiyet.cvss_skor),2) as ort FROM konum,cihaz,baglanti,zafiyet
WHERE konum.konum_id=cihaz.konum_id AND cihaz.ip=baglanti.ip AND
baglanti.cve_kodu=zafiyet.cve_kodu GROUP BY konum.ulke\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo
\"{\'id\'\",\":\",\"\'\".\$row\[\'ulke_id\'\].\"\',\'name\'\",\":\",\"\'\".\$row\[\'ulke\'\].\"\',\'value\'\",\":\",\"\'\".\$row\[\'ort\'\].\"\'\",\",\",\"\'description\'\",\":\",\"\'
\'\",\"},\";**

**}**

**?\>**

**\]**

**);**

**var mapData = dataSet.mapAs({ description: \'description\' });**

**var map = anychart.map();**

**// set map settings**

**map**

**.geoData(\'anychart.maps.world\')**

**.legend(false)**

**.interactivity({ selectionMode: \'none\' });**

**map**

**.title()**

**.enabled(true)**

**.fontSize(16)**

**.padding(0, 0, 30, 0)**

**.text(\'Konuma Göre Risk Durumu\');**

**var series = map.choropleth(mapData);**

**series.geoIdField(\'iso_a2\').labels(false);**

**series.hovered().fill(\'\#455a64\');**

**var scale = anychart.scales.ordinalColor(\[**

**{ less: 2 },**

**{ from: 2, to: 3 },**

**{ from: 3, to: 4 },**

**{ from: 4, to: 5 },**

**{ from: 5, to: 6 },**

**{ from: 6, to: 7 },**

**{ from: 7, to: 8 },**

**{ greater: 8 }**

**\]);**

**scale.colors(\[**

**\'\#42a5f5\',**

**\'\#64b5f6\',**

**\'\#90caf9\',**

**\'\#ffa726\',**

**\'\#fb8c00\',**

**\'\#f57c00\',**

**\'\#ef6c00\',**

**\'\#e65100\'**

**\]);**

**series.colorScale(scale);**

**var colorRange = map.colorRange();**

**colorRange**

**.enabled(true)**

**.padding(\[20, 0, 0, 0\])**

**.colorLineSize(5)**

**.marker({ size: 7 });**

**colorRange**

**.ticks()**

**.enabled(true)**

**.stroke(\'3 \#ffffff\')**

**.position(\'center\')**

**.length(20);**

**colorRange**

**.labels()**

**.fontSize(10)**

**.padding(0, 0, 0, 5)**

**.format(function () {**

**var range = this.colorRange;**

**var name;**

**if (isFinite(range.start + range.end)) {**

**name = range.start + \' - \' + range.end;**

**} else if (isFinite(range.start)) {**

**name = \'After \' + range.start;**

**} else {**

**name = \'Before \' + range.end;**

**}**

**return name;**

**});**

**// create zoom controls**

**var zoomController = anychart.ui.zoom();**

**zoomController.render(map);**

**// set container id for the chart**

**map.container(\'container\');**

**// initiate chart drawing**

**map.draw();**

**}**

**);**

**});**

**\</script\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"footer\"\>**

**\<div class=\"sol\"\>**

**\<span\>Site Haritası\</span\>**

**\<span\>Hakkımızda\</span\>**

**\<span\>Geri Bildirim\</span\>**

**\<span\>İhaleler\</span\>**

**\<span\>İletişim - Ulaşım\</span\>\</div\>**

**\<span class=\"copyright\"\>2020 Copyright © Tüm hakları saklıdır. -
Yasin Seven\</span\>**

**\</div\>**

**\</div\>**

**\</body\>**

**\</html\>**

**cihazlar.php:**

**\<?php**

**// Include config file**

**require_once \"config.php\";**

**\$secilen=\"Hepsi\";**

**if(strip_tags(trim(isset(\$\_POST\[\"secilen\"\])))){**

**\$secilen=\$\_POST\[\"secilen\"\];**

**}**

**\$secilen_cihaz=\"Hepsi\";**

**if(strip_tags(trim(isset(\$\_POST\[\"secilen_cihaz\"\])))){**

**\$secilen_cihaz=\$\_POST\[\"secilen_cihaz\"\];**

**}**

**//\<option value=\"United Kingdom\"\>United Kingdom\</option\>**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"tr\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\" /\>**

**\<meta name=\"description\" content=\"Ver Cloud Karar Destek Sistemi\"
/\>**

**\<meta name=\"keyword\" content=\"Ver Cloud,cloud,karar,destek\" /\>**

**\<title\>Ver Cloud Karar Destek Sistemi\</title\>**

**\<link rel=\"stylesheet\" href=\"css/cihazlar.css\" /\>**

**\<style\>**

**table {**

**border-collapse: collapse;**

**margin: 25px 0;**

**font-size: 0.9em;**

**font-family: sans-serif;**

**min-width: 400px;**

**box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);**

**}**

**thead tr {**

**background-color: \#6BB3F4;**

**color: \#ffffff;**

**text-align: left;**

**}**

**th,**

**td {**

**padding: 12px 15px;**

**}**

**tbody tr {**

**border-bottom: 1px solid \#dddddd;**

**}**

**tbody tr:nth-of-type(even) {**

**background-color: \#f3f3f3;**

**}**

**tbody tr:last-of-type {**

**border-bottom: 2px solid \#6BB3F4;**

**}**

**tbody tr.active-row {**

**font-weight: bold;**

**color: \#6BB3F4;**

**}**

**\</style\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js\"\>\</script\>**

**\</head\>**

**\<body\>**

**\<div class=\"kenarCubugu\"\>**

**\<div class=\"yanBaslik\"\>**

**\<a href=\"\#\"\>\<img src=\"images/logo.png\" alt=\"\" /\>\</a\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<div class=\"bilgi\"\>**

**\<span class=\"isim\"\>Yasin Seven\</span\>**

**\<span class=\"unvan\"\>Siber Güvenlik Mimarı\</span\>**

**\</div\>**

**\</div\>**

**\<a href=\"index.php\" class=\"kontrolPaneli\"\>**

**\<span\>Ana Ekran\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</a\>**

**\<a href=\"konumlar.php\" class=\"konumlar\"\>**

**\<span\>Konumlar\</span\>**

**\<i class=\"fas fa-map-marker-alt\"\>\</i\>**

**\</a \>**

**\<a href=\"cihazlar.php\" class=\"cihazlar\"\>**

**\<span\>Cihazlar\</span\>**

**\<i class=\"fas fa-desktop\"\>\</i\>**

**\</a \>**

**\<a href=\"zafiyetler.php\" class=\"zafiyetler\"\>**

**\<span\>Zafiyetler\</span\>**

**\<i class=\"fas fa-biohazard\"\>\</i\>**

**\</a \>**

**\<a href=\"karsilastir.php\" class=\"karsilastirma\"\>**

**\<span\>Karşılaştırma\</span\>**

**\<i class=\"fas fa-tasks\"\>\</i\>**

**\</a \>**

**\</div\>**

**\<div class=\"icerik\"\>**

**\<div class=\"baslik\"\>**

**\<i class=\"fas fa-bars\"\>\</i\>**

**\<div class=\"arama\"\>**

**\<i class=\"fas fa-search\"\>\</i\>**

**\<input type=\"text\" placeholder=\"Arama\...\" /\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<span\>Yasin Seven\</span\>**

**\<i class=\"fas fa-chevron-down\"\>\</i\>**

**\</div\>**

**\<div class=\"bildirim\"\>**

**\<div class=\"baslikMektup\"\>**

**\<i class=\"far fa-envelope\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikCan\"\>**

**\<i class=\"far fa-bell\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikBayrak\"\>**

**\<i class=\"far fa-flag\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<a href=\"logout.php\" class=\"logOut\"\>\<i class=\"fas
fa-sign-out-alt\"\>\</i\>\</a\>**

**\</div\>**

**\<div class=\"anaEkran\"\>**

**\<div class=\"ust\"\>**

**\<div class=\"sol\"\>**

**\<span\>Cihazlar\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</div\>**

**\<div class=\"sag\"\>**

**\<i class=\"fas fa-tachometer-alt\"\>\</i\>**

**\<span\>Cihazlar\</span\>**

**\<span\>\>\</span\>**

**\<span\>Cihazlar\</span\>**

**\</div\>**

**\</div\>**

**\<div class=\"alt\"\>**

**\<form action=\"\" method=\"POST\"\>**

**\<select class=\"form-control\" type=\"text\" name=\"secilen\"\>**

**\<option value=\"\<?php echo \$secilen ?\>\" hidden selected=\"\<?php
echo \$secilen ?\>\"\>\<?php echo \$secilen ?\>\</option\>**

**\<option value=\"Hepsi\"\>Hepsi\</option\>**

**\<?php**

**\$sql = \"select konum.ulke from konum\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo \"\<option
value=\'\".\$row\[\'ulke\'\].\"\'\>\".\$row\[\'ulke\'\].\"\</option\>\";**

**}**

**?\>**

**\</select\>**

**\<form action=\"\" method=\"POST\"\>**

**\<select class=\"form-control\" type=\"text\"
name=\"secilen_cihaz\"\>**

**\<option value=\"\<?php echo \$secilen_cihaz ?\>\" hidden
selected=\"\<?php echo \$secilen_cihaz ?\>\"\>\<?php echo
\$secilen_cihaz ?\>\</option\>**

**\<option value=\"Hepsi\"\>Hepsi\</option\>**

**\<?php**

**if (\$secilen == \"Hepsi\") {**

**\$sql = \"SELECT cihaz.ad, konum.ulke**

**FROM konum,cihaz**

**WHERE konum.konum_id=cihaz.konum_id\";**

**} else {**

**\$sql = \"SELECT cihaz.ad, konum.ulke**

**FROM konum,cihaz**

**WHERE konum.konum_id=cihaz.konum_id**

**AND konum.ulke = \'\$secilen\'\";**

**}**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo \"\<option
value=\'\".\$row\[\'ad\'\].\"\'\>\".\$row\[\'ad\'\].\"\</option\>\";**

**}**

**?\>**

**\</select\>**

**\<button type=\"submit\" class=\"btn
btn-primary\"\>Güncelle\</button\>**

**\<div class=\"kutu1\"\>**

**\<?php**

**// Check connection**

**if(\$mysqli === false){**

**die(\"ERROR: Could not connect. \" . mysqli_connect_error());**

**}**

**if (\$secilen == \"Hepsi\" && \$secilen_cihaz != \"Hepsi\") {**

**\$sql = \"SELECT konum.ulke_id, konum.ulke, konum.sehir,
konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS
yazilim_adi, yazilim.uretici, zafiyet.\*, isletim.ad as isletim_adi,
isletim.uretici as isletim_uretici, isletim.aile as isletim_aile**

**FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim**

**WHERE konum.konum_id=cihaz.konum_id**

**AND cihaz.ip=baglanti.ip**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND baglanti.cve_kodu = zafiyet.cve_kodu**

**AND cihaz.ad = \'\$secilen_cihaz\'\";**

**} else {**

**if (\$secilen == \"Hepsi\" && \$secilen_cihaz ==\"Hepsi\") {**

**\$sql = \"SELECT konum.ulke_id, konum.ulke, konum.sehir,
konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS
yazilim_adi, yazilim.uretici, zafiyet.\*, isletim.ad as isletim_adi,
isletim.uretici as isletim_uretici, isletim.aile as isletim_aile**

**FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim**

**WHERE konum.konum_id=cihaz.konum_id**

**AND cihaz.ip=baglanti.ip**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND baglanti.cve_kodu = zafiyet.cve_kodu\";**

**}else {**

**if (\$secilen_cihaz == \"Hepsi\") {**

**\$sql = \"SELECT konum.ulke_id, konum.ulke, konum.sehir,
konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS
yazilim_adi, yazilim.uretici, zafiyet.\*, isletim.ad as isletim_adi,
isletim.uretici as isletim_uretici, isletim.aile as isletim_aile**

**FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim**

**WHERE konum.konum_id=cihaz.konum_id**

**AND cihaz.ip=baglanti.ip**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND baglanti.cve_kodu = zafiyet.cve_kodu**

**AND konum.ulke = \'\$secilen\'\";**

**} else {**

**\$sql = \"SELECT konum.ulke_id, konum.ulke, konum.sehir,
konum.konum_id, cihaz.ip, cihaz.ad as cihaz_adi, yazilim.ad AS
yazilim_adi, yazilim.uretici, zafiyet.\*, isletim.ad as isletim_adi,
isletim.uretici as isletim_uretici, isletim.aile as isletim_aile**

**FROM konum,cihaz,baglanti,zafiyet,yazilim,isletim**

**WHERE konum.konum_id=cihaz.konum_id**

**AND cihaz.ip=baglanti.ip**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**AND baglanti.isletim_id=isletim.isletim_id**

**AND baglanti.cve_kodu = zafiyet.cve_kodu**

**AND konum.ulke = \'\$secilen\'**

**AND cihaz.ad = \'\$secilen_cihaz\'\";**

**}**

**}**

**}**

**// Attempt select query execution**

**if(\$result = mysqli_query(\$mysqli, \$sql)){**

**if(mysqli_num_rows(\$result) \> 0){**

**echo \"\<table class=\'styled_table\'\>\";**

**echo \"\<thead\>\";**

**echo \"\<tr\>\";**

**echo \"\<th\>ulke\</th\>\";**

**echo \"\<th\>sehir\</th\>\";**

**echo \"\<th\>konum_id\</th\>\";**

**echo \"\<th\>ip\</th\>\";**

**echo \"\<th\>cihaz_adi\</th\>\";**

**echo \"\<th\>yazilim_adi\</th\>\";**

**echo \"\<th\>uretici\</th\>\";**

**echo \"\<th\>cve_kodu\</th\>\";**

**echo \"\<th\>cvss_ciddiyet\</th\>\";**

**echo \"\<th\>cvss_skor\</th\>\";**

**echo \"\<th\>yayinlanma\</th\>\";**

**echo \"\<th\>isletim_adi\</th\>\";**

**echo \"\</tr\>\";**

**echo \"\</thead\>\";**

**while(\$row = mysqli_fetch_array(\$result)){**

**echo \"\<tbody\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>\" . \$row\[\'ulke\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'sehir\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'konum_id\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'ip\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'cihaz_adi\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'yazilim_adi\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'uretici\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'cve_kodu\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'cvss_ciddiyet\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'cvss_skor\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'yayinlanma\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'isletim_adi\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\</tbody\>\";**

**}**

**echo \"\</table\>\";**

**// Free result set**

**mysqli_free_result(\$result);**

**} else{**

**echo \"No records matching your query were found.\";**

**}**

**} else{**

**echo \"ERROR: Could not able to execute \$sql. \" .
mysqli_error(\$mysqli);**

**}**

**?\>**

**\</div\>**

**\</div\>**

**\</form\>**

**\<div class=\"footer\"\>**

**\<div class=\"sol\"\>**

**\<span\>Site Haritası\</span\>**

**\<span\>Hakkımızda\</span\>**

**\<span\>Geri Bildirim\</span\>**

**\<span\>İhaleler\</span\>**

**\<span\>İletişim - Ulaşım\</span\>\</div\>**

**\<span class=\"copyright\"\>2020 Copyright © Tüm hakları saklıdır. -
Yasin Seven\</span\>**

**\</div\>**

**\</div\>**

**\</body\>**

**\</html\>**

**karsilastir.php:**

**\<?php**

**// Include config file**

**require_once \"config.php\";**

**\$secilen_yazilim=\"\";**

**\$secilen_yazilim1=\"\";**

**if(strip_tags(trim(isset(\$\_POST\[\"secilen_yazilim\"\])))){**

**\$secilen_yazilim=\$\_POST\[\"secilen_yazilim\"\];**

**}**

**if(strip_tags(trim(isset(\$\_POST\[\"secilen_yazilim1\"\])))){**

**\$secilen_yazilim1=\$\_POST\[\"secilen_yazilim1\"\];**

**}**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"tr\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\" /\>**

**\<meta name=\"description\" content=\"Ver Cloud Karar Destek Sistemi\"
/\>**

**\<meta name=\"keyword\" content=\"Ver Cloud,cloud,karar,destek\" /\>**

**\<title\>Ver Cloud Karar Destek Sistemi\</title\>**

**\<link rel=\"stylesheet\" href=\"css/karsilastir.css\" /\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-base.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-map.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-data-adapter.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/geodata/latest/custom/world/world.js\"\>\</script\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.3.15/proj4.js\"\>\</script\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<style\>**

**table {**

**border-collapse: collapse;**

**margin: 25px 0;**

**font-size: 0.9em;**

**font-family: sans-serif;**

**min-width: 400px;**

**box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);**

**}**

**thead tr {**

**background-color: \#6BB3F4;**

**color: \#ffffff;**

**text-align: left;**

**}**

**th,**

**td {**

**padding: 12px 15px;**

**}**

**tbody tr {**

**border-bottom: 1px solid \#dddddd;**

**}**

**tbody tr:nth-of-type(even) {**

**background-color: \#f3f3f3;**

**}**

**tbody tr:last-of-type {**

**border-bottom: 2px solid \#6BB3F4;**

**}**

**tbody tr.active-row {**

**font-weight: bold;**

**color: \#6BB3F4;**

**}**

**\</style\>**

**\</head\>**

**\<body\>**

**\<div class=\"kenarCubugu\"\>**

**\<div class=\"yanBaslik\"\>**

**\<a href=\"\#\"\>\<img src=\"images/logo.png\" alt=\"\" /\>\</a\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<div class=\"bilgi\"\>**

**\<span class=\"isim\"\>Yasin Seven\</span\>**

**\<span class=\"unvan\"\>Siber Güvenlik Mimarı\</span\>**

**\</div\>**

**\</div\>**

**\<a href=\"index.php\" class=\"kontrolPaneli\"\>**

**\<span\>Ana Ekran\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</a\>**

**\<a href=\"konumlar.php\" class=\"konumlar\"\>**

**\<span\>Konumlar\</span\>**

**\<i class=\"fas fa-map-marker-alt\"\>\</i\>**

**\</a \>**

**\<a href=\"cihazlar.php\" class=\"cihazlar\"\>**

**\<span\>Cihazlar\</span\>**

**\<i class=\"fas fa-desktop\"\>\</i\>**

**\</a \>**

**\<a href=\"zafiyetler.php\" class=\"zafiyetler\"\>**

**\<span\>Zafiyetler\</span\>**

**\<i class=\"fas fa-biohazard\"\>\</i\>**

**\</a \>**

**\<a href=\"karsilastir.php\" class=\"karsilastirma\"\>**

**\<span\>Karşılaştırma\</span\>**

**\<i class=\"fas fa-tasks\"\>\</i\>**

**\</a \>**

**\</div\>**

**\<div class=\"icerik\"\>**

**\<div class=\"baslik\"\>**

**\<i class=\"fas fa-bars\"\>\</i\>**

**\<div class=\"arama\"\>**

**\<i class=\"fas fa-search\"\>\</i\>**

**\<input type=\"text\" placeholder=\"Arama\...\" /\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<span\>Yasin Seven\</span\>**

**\<i class=\"fas fa-chevron-down\"\>\</i\>**

**\</div\>**

**\<div class=\"bildirim\"\>**

**\<div class=\"baslikMektup\"\>**

**\<i class=\"far fa-envelope\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikCan\"\>**

**\<i class=\"far fa-bell\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikBayrak\"\>**

**\<i class=\"far fa-flag\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<a href=\"logout.php\" class=\"logOut\"\>\<i class=\"fas
fa-sign-out-alt\"\>\</i\>\</a\>**

**\</div\>**

**\<div class=\"anaEkran\"\>**

**\<div class=\"ust\"\>**

**\<div class=\"sol\"\>**

**\<span\>Yazılım Karşılaştırma\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</div\>**

**\<div class=\"sag\"\>**

**\<i class=\"fas fa-tachometer-alt\"\>\</i\>**

**\<span\>Yazılım Karşılaştırma\</span\>**

**\<span\>\>\</span\>**

**\<span\>Yazılım Karşılaştırma\</span\>**

**\</div\>**

**\</div\>**

**\<div class=\"alt\"\>**

**\<div class=\"dropDown\"\>**

**\<form action=\"\" method=\"POST\"\>**

**\<select class=\"form-control\" type=\"text\"
name=\"secilen_yazilim\"\>**

**\<option value=\"\<?php echo \$secilen_yazilim ?\>\" hidden
selected=\"\<?php echo \$secilen_yazilim ?\>\"\>\<?php echo
\$secilen_yazilim ?\>\</option\>**

**\<?php**

**\$sql = \"SELECT yazilim.ad**

**FROM yazilim**

**UNION**

**SELECT isletim.ad**

**FROM isletim\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo \"\<option
value=\'\".\$row\[\'ad\'\].\"\'\>\".\$row\[\'ad\'\].\"\</option\>\";**

**}**

**?\>**

**\</select\>**

**\<select class=\"form-control\" type=\"text\"
name=\"secilen_yazilim1\"\>**

**\<option value=\"\<?php echo \$secilen_yazilim1 ?\>\" hidden
selected=\"\<?php echo \$secilen_yazilim1 ?\>\"\>\<?php echo
\$secilen_yazilim1 ?\>\</option\>**

**\<?php**

**\$sql = \"SELECT yazilim.ad**

**FROM yazilim**

**UNION**

**SELECT isletim.ad**

**FROM isletim\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo \"\<option
value=\'\".\$row\[\'ad\'\].\"\'\>\".\$row\[\'ad\'\].\"\</option\>\";**

**}**

**?\>**

**\</select\>**

**\<button type=\"submit\" class=\"btn
btn-primary\"\>Güncelle\</button\>**

**\</form\>**

**\</div\>**

**\<div class=\"tablolar\"\>**

**\<div class=\"tablo1\"\>**

**\<?php**

**// Check connection**

**if(\$mysqli === false){**

**die(\"ERROR: Could not connect. \" . mysqli_connect_error());**

**}**

**\$sql = \"SELECT yazilim.\*, COUNT(zafiyet.cvss_skor) as
zafiyet_sayisi**

**FROM zafiyet,baglanti,yazilim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**and yazilim.ad = \'\$secilen_yazilim\'**

**GROUP BY yazilim.ad**

**UNION**

**SELECT isletim.isletim_id, isletim.ad, isletim.uretici,
isletim.fiyat,COUNT(zafiyet.cvss_skor) as zafiyet_sayisi**

**FROM zafiyet,baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**and isletim.ad = \'\$secilen_yazilim\'**

**GROUP BY isletim.ad\";**

**// Attempt select query execution**

**if(\$result = mysqli_query(\$mysqli, \$sql)){**

**if(mysqli_num_rows(\$result) \> 0){**

**echo \"\<table class=\'styled_table\'\>\";**

**while(\$row = mysqli_fetch_array(\$result)){**

**echo \"\<tbody\>\";**

**echo \"\<thead\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Yazılım ID : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'yazilim_id\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\</thead\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Yazılım Adı : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'ad\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Üretici : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'uretici\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Zafiyet Sayısı : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'zafiyet_sayisi\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Yıllık Fiyat : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'fiyat\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\</tbody\>\";**

**}**

**echo \"\</table\>\";**

**// Free result set**

**mysqli_free_result(\$result);**

**} else{**

**echo \"No records matching your query were found.\";**

**}**

**} else{**

**echo \"ERROR: Could not able to execute \$sql. \" .
mysqli_error(\$mysqli);**

**}**

**?\>**

**\</div\>**

**\<div class=\"tablo2\"\>**

**\<?php**

**// Check connection**

**if(\$mysqli === false){**

**die(\"ERROR: Could not connect. \" . mysqli_connect_error());**

**}**

**\$sql = \"SELECT yazilim.\*, COUNT(zafiyet.cvss_skor) as
zafiyet_sayisi**

**FROM zafiyet,baglanti,yazilim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**and yazilim.ad = \'\$secilen_yazilim1\'**

**GROUP BY yazilim.ad**

**UNION**

**SELECT isletim.isletim_id, isletim.ad, isletim.uretici,
isletim.fiyat,COUNT(zafiyet.cvss_skor) as zafiyet_sayisi**

**FROM zafiyet,baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**and isletim.ad = \'\$secilen_yazilim1\'**

**GROUP BY isletim.ad\";**

**// Attempt select query execution**

**if(\$result = mysqli_query(\$mysqli, \$sql)){**

**if(mysqli_num_rows(\$result) \> 0){**

**echo \"\<table class=\'styled_table\'\>\";**

**while(\$row = mysqli_fetch_array(\$result)){**

**echo \"\<tbody\>\";**

**echo \"\<thead\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Yazılım ID : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'yazilim_id\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\</thead\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Yazılım Adı : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'ad\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Üretici : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'uretici\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Zafiyet Sayısı : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'zafiyet_sayisi\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>Yıllık Fiyat : \</td\>\";**

**echo \"\<td\>\" . \$row\[\'fiyat\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\</tbody\>\";**

**}**

**echo \"\</table\>\";**

**// Free result set**

**mysqli_free_result(\$result);**

**} else{**

**echo \"No records matching your query were found.\";**

**}**

**} else{**

**echo \"ERROR: Could not able to execute \$sql. \" .
mysqli_error(\$mysqli);**

**}**

**?\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\</div\>**

**\<div class=\"footer\"\>**

**\<div class=\"sol\"\>**

**\<span\>Site Haritası\</span\>**

**\<span\>Hakkımızda\</span\>**

**\<span\>Geri Bildirim\</span\>**

**\<span\>İhaleler\</span\>**

**\<span\>İletişim - Ulaşım\</span\>\</div\>**

**\<span class=\"copyright\"\>2020 Copyright © Tüm hakları saklıdır. -
Yasin Seven\</span\>**

**\</div\>**

**\</div\>**

**\</body\>**

**\</html\>**

**zafiyetler.php:**

**\<?php**

**/\* Database connection settings \*/**

**// Include config file**

**require_once \"config.php\";**

**\$secilen=\"Hepsi\";**

**if(strip_tags(trim(isset(\$\_POST\[\"secilen\"\])))){**

**\$secilen=\$\_POST\[\"secilen\"\];**

**}**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"tr\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\" /\>**

**\<meta name=\"description\" content=\"Ver Cloud Karar Destek Sistemi\"
/\>**

**\<meta name=\"keyword\" content=\"Ver Cloud,cloud,karar,destek\" /\>**

**\<title\>Ver Cloud Karar Destek Sistemi\</title\>**

**\<link rel=\"stylesheet\" href=\"css/zafiyetler.css\" /\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-base.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js\"\>\</script\>**

**\<script
src=\"https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js\"\>\</script\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<link
href=\"https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css\"
type=\"text/css\" rel=\"stylesheet\"\>**

**\<script\>**

**anychart.onDocumentReady(function () {**

**// create bar chart**

**var chart = anychart.bar();**

**chart.animation(true);**

**chart.padding(\[10, 40, 5, 20\]);**

**chart.title(\'Risklerine Göre Uygulamalar\');**

**// create bar series with passed data**

**var series = chart.bar(\[**

**\<?php**

**\$sql = \"SELECT yazilim.\*, COUNT(zafiyet.cvss_skor) as
zafiyet_sayisi**

**FROM zafiyet,baglanti,yazilim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.yazilim_id=yazilim.yazilim_id**

**GROUP BY yazilim.ad**

**UNION**

**SELECT isletim.isletim_id, isletim.ad, isletim.uretici, isletim.fiyat,
COUNT(zafiyet.cvss_skor) as zafiyet_sayisi**

**FROM zafiyet,baglanti,isletim**

**WHERE zafiyet.cve_kodu=baglanti.cve_kodu**

**AND baglanti.isletim_id=isletim.isletim_id**

**GROUP BY isletim.ad**

**ORDER BY zafiyet_sayisi DESC\";**

**\$result = mysqli_query(\$mysqli, \$sql);**

**//loop through the returned data**

**while (\$row = mysqli_fetch_array(\$result)) {**

**echo
\"\[\'\".\$row\[\'ad\'\].\"\',\".\$row\[\'zafiyet_sayisi\'\].\"\],\";**

**}**

**?\>**

**\]);**

**// set tooltip settings**

**series**

**.tooltip()**

**.position(\'right\')**

**.anchor(\'left-center\')**

**.offsetX(5)**

**.offsetY(0)**

**.titleFormat(\'{%X}\')**

**.format(\'{%Value}\');**

**// set yAxis labels formatter**

**chart.yAxis().labels().format(\'{%Value}{groupsSeparator: }\');**

**// set titles for axises**

**chart.xAxis().title(\'Program\');**

**chart.yAxis().title(\'Risk\');**

**chart.interactivity().hoverMode(\'by-x\');**

**chart.tooltip().positionMode(\'point\');**

**// set scale minimum**

**chart.yScale().minimum(0);**

**// set container id for the chart**

**chart.container(\'container\');**

**// initiate chart drawing**

**chart.draw();**

**});**

**\</script\>**

**\<style\>**

**table {**

**border-collapse: collapse;**

**margin-left: 25px 0;**

**margin-right: 25px 0;**

**margin-bottom: 25px 0;**

**font-size: 0.9em;**

**font-family: sans-serif;**

**min-width: 400px;**

**box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);**

**}**

**thead tr {**

**background-color: \#6BB3F4;**

**color: \#ffffff;**

**text-align: left;**

**}**

**th,**

**td {**

**padding: 12px 15px;**

**}**

**tbody tr {**

**border-bottom: 1px solid \#dddddd;**

**}**

**tbody tr:nth-of-type(even) {**

**background-color: \#f3f3f3;**

**}**

**tbody tr:last-of-type {**

**border-bottom: 2px solid \#6BB3F4;**

**}**

**tbody tr.active-row {**

**font-weight: bold;**

**color: \#6BB3F4;**

**}**

**\</style\>**

**\<script
src=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js\"\>\</script\>**

**\</head\>**

**\<body\>**

**\<div class=\"kenarCubugu\"\>**

**\<div class=\"yanBaslik\"\>**

**\<a href=\"\#\"\>\<img src=\"images/logo.png\" alt=\"\" /\>\</a\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<div class=\"bilgi\"\>**

**\<span class=\"isim\"\>Yasin Seven\</span\>**

**\<span class=\"unvan\"\>Siber Güvenlik Mimarı\</span\>**

**\</div\>**

**\</div\>**

**\<a href=\"index.php\" class=\"kontrolPaneli\"\>**

**\<span\>Ana Ekran\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</a\>**

**\<a href=\"konumlar.php\" class=\"konumlar\"\>**

**\<span\>Konumlar\</span\>**

**\<i class=\"fas fa-map-marker-alt\"\>\</i\>**

**\</a \>**

**\<a href=\"cihazlar.php\" class=\"cihazlar\"\>**

**\<span\>Cihazlar\</span\>**

**\<i class=\"fas fa-desktop\"\>\</i\>**

**\</a \>**

**\<a href=\"zafiyetler.php\" class=\"zafiyetler\"\>**

**\<span\>Zafiyetler\</span\>**

**\<i class=\"fas fa-biohazard\"\>\</i\>**

**\</a \>**

**\<a href=\"karsilastir.php\" class=\"karsilastirma\"\>**

**\<span\>Karşılaştırma\</span\>**

**\<i class=\"fas fa-tasks\"\>\</i\>**

**\</a \>**

**\</div\>**

**\<div class=\"icerik\"\>**

**\<div class=\"baslik\"\>**

**\<i class=\"fas fa-bars\"\>\</i\>**

**\<div class=\"arama\"\>**

**\<i class=\"fas fa-search\"\>\</i\>**

**\<input type=\"text\" placeholder=\"Arama\...\" /\>**

**\</div\>**

**\<div class=\"kullanici\"\>**

**\<img src=\"images/kullanici.png\" /\>**

**\<span\>Yasin Seven\</span\>**

**\<i class=\"fas fa-chevron-down\"\>\</i\>**

**\</div\>**

**\<div class=\"bildirim\"\>**

**\<div class=\"baslikMektup\"\>**

**\<i class=\"far fa-envelope\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikCan\"\>**

**\<i class=\"far fa-bell\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\<div class=\"baslikBayrak\"\>**

**\<i class=\"far fa-flag\"\>\</i\>**

**\<i class=\"fas fa-circle\"\>\</i\>**

**\</div\>**

**\</div\>**

**\<a href=\"logout.php\" class=\"logOut\"\>\<i class=\"fas
fa-sign-out-alt\"\>\</i\>\</a\>**

**\</div\>**

**\<div class=\"anaEkran\"\>**

**\<div class=\"ust\"\>**

**\<div class=\"sol\"\>**

**\<span\>Zafiyetler\</span\>**

**\<i class=\"fas fa-home\"\>\</i\>**

**\</div\>**

**\<div class=\"sag\"\>**

**\<i class=\"fas fa-tachometer-alt\"\>\</i\>**

**\<span\>Zafiyetler\</span\>**

**\<span\>\>\</span\>**

**\<span\>Zafiyetler\</span\>**

**\</div\>**

**\</div\>**

**\<div class=\"alt\"\>**

**\<div class=\"kutu1\"\>**

**\<?php**

**// Check connection**

**if(\$mysqli === false){**

**die(\"ERROR: Could not connect. \" . mysqli_connect_error());**

**}**

**\$sql = \"SELECT \* FROM zafiyet ORDER BY zafiyet.cve_kodu DESC\";**

**// Attempt select query execution**

**if(\$result = mysqli_query(\$mysqli, \$sql)){**

**if(mysqli_num_rows(\$result) \> 0){**

**echo \"\<table class=\'styled_table\'\>\";**

**echo \"\<thead\>\";**

**echo \"\<tr\>\";**

**echo \"\<th\>cve_kodu\</th\>\";**

**echo \"\<th\>cvss_ciddiyet\</th\>\";**

**echo \"\<th\>cvss_skor\</th\>\";**

**echo \"\<th\>yayinlanma\</th\>\";**

**echo \"\</tr\>\";**

**echo \"\</thead\>\";**

**while(\$row = mysqli_fetch_array(\$result)){**

**echo \"\<tbody\>\";**

**echo \"\<tr\>\";**

**echo \"\<td\>\" . \$row\[\'cve_kodu\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'cvss_ciddiyet\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'cvss_skor\'\] . \"\</td\>\";**

**echo \"\<td\>\" . \$row\[\'yayinlanma\'\] . \"\</td\>\";**

**echo \"\</tr\>\";**

**echo \"\</tbody\>\";**

**}**

**echo \"\</table\>\";**

**// Free result set**

**mysqli_free_result(\$result);**

**} else{**

**echo \"No records matching your query were found.\";**

**}**

**} else{**

**echo \"ERROR: Could not able to execute \$sql. \" .
mysqli_error(\$mysqli);**

**}**

**?\>**

**\</div\>**

**\<div class=\"kutu2\"\>**

**\<div id=\"container\"\>\</div\>**

**\</div\>**

**\</div\>**

**\</form\>**

**\<div class=\"footer\"\>**

**\<div class=\"sol\"\>**

**\<span\>Site Haritası\</span\>**

**\<span\>Organ Bağışı Yapmak İstiyorum\</span\>**

**\<span\>Geri Bildirim\</span\>**

**\<span\>İhaleler\</span\>**

**\<span\>İletişim - Ulaşım\</span\>\</div\>**

**\<span class=\"copyright\"\>2020 Copyright © Tüm hakları saklıdır. -
Yasin Seven\</span\>**

**\</div\>**

**\</div\>**

**\</body\>**

**\</html\>**

**config.php:**

**\<?php**

**/\* Database credentials. Assuming you are running MySQL**

**server with default setting (user \'root\' with no password) \*/**

**define(\'DB_SERVER\', \'localhost\');**

**define(\'DB_USERNAME\', \'root\');**

**define(\'DB_PASSWORD\', \'\');**

**define(\'DB_NAME\', \'karar_destek\');**

**/\* Attempt to connect to MySQL database \*/**

**\$mysqli = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD,
DB_NAME);**

**\$mysqli -\> set_charset(\"utf8\");**

**// Check connection**

**if(\$mysqli === false){**

**die(\"ERROR: Could not connect. \" . mysqli_connect_error());**

**}**

**?\>**

**login.php:**

**\<?php**

**// Initialize the session**

**session_start();**

**// Check if the user is already logged in, if yes then redirect him to
welcome page**

**if(isset(\$\_SESSION\[\"loggedin\"\]) && \$\_SESSION\[\"loggedin\"\]
=== true){**

**header(\"location: index.php\");**

**exit;**

**}**

**// Include config file**

**require_once \"config.php\";**

**// Define variables and initialize with empty values**

**\$username = \$password = \"\";**

**\$username_err = \$password_err = \"\";**

**// Processing form data when form is submitted**

**if(\$\_SERVER\[\"REQUEST_METHOD\"\] == \"POST\"){**

**// Check if username is empty**

**if(empty(trim(\$\_POST\[\"username\"\]))){**

**\$username_err = \"Please enter username.\";**

**} else{**

**\$username = trim(\$\_POST\[\"username\"\]);**

**}**

**// Check if password is empty**

**if(empty(trim(\$\_POST\[\"password\"\]))){**

**\$password_err = \"Please enter your password.\";**

**} else{**

**\$password = trim(\$\_POST\[\"password\"\]);**

**}**

**// Validate credentials**

**if(empty(\$username_err) && empty(\$password_err)){**

**// Prepare a select statement**

**\$sql = \"SELECT id, username, password FROM users WHERE username =
?\";**

**if(\$stmt = mysqli_prepare(\$mysqli, \$sql)){**

**// Bind variables to the prepared statement as parameters**

**mysqli_stmt_bind_param(\$stmt, \"s\", \$param_username);**

**// Set parameters**

**\$param_username = \$username;**

**// Attempt to execute the prepared statement**

**if(mysqli_stmt_execute(\$stmt)){**

**// Store result**

**mysqli_stmt_store_result(\$stmt);**

**// Check if username exists, if yes then verify password**

**if(mysqli_stmt_num_rows(\$stmt) == 1){**

**// Bind result variables**

**mysqli_stmt_bind_result(\$stmt, \$id, \$username,
\$hashed_password);**

**if(mysqli_stmt_fetch(\$stmt)){**

**if(password_verify(\$password, \$hashed_password)){**

**// Password is correct, so start a new session**

**session_start();**

**// Store data in session variables**

**\$\_SESSION\[\"loggedin\"\] = true;**

**\$\_SESSION\[\"id\"\] = \$id;**

**\$\_SESSION\[\"username\"\] = \$username;**

**// Redirect user to index page**

**header(\"location: index.php\");**

**} else{**

**// Display an error message if password is not valid**

**\$password_err = \"The password you entered was not valid.\";**

**}**

**}**

**} else{**

**// Display an error message if username doesn\'t exist**

**\$username_err = \"No account found with that username.\";**

**}**

**} else{**

**echo \"Oops! Something went wrong. Please try again later.\";**

**}**

**// Close statement**

**mysqli_stmt_close(\$stmt);**

**}**

**}**

**// Close connection**

**mysqli_close(\$mysqli);**

**}**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"en\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\"\>**

**\<title\>Login\</title\>**

**\<link rel=\"stylesheet\"
href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css\"\>**

**\<style type=\"text/css\"\>**

**body{ font: 14px sans-serif; background-size: cover; background-image:
url(\'https://ckab.com/wp-content/uploads/cyber-scurity.jpg\');}**

**.wrapper{ width: 350px; padding: 20px; ; padding: 20px;**

**background-color: white;**

**position: absolute;**

**top: 50%;**

**left: 50%;**

**margin-left: -600px;**

**margin-top: -150px;**

**border-radius: 10px;**

**}**

**\</style\>**

**\</head\>**

**\<body\>**

**\<div class=\"wrapper\"\>**

**\<h2\>Giriş\</h2\>**

**\<form action=\"\<?php echo
htmlspecialchars(\$\_SERVER\[\"PHP_SELF\"\]); ?\>\" method=\"post\"\>**

**\<div class=\"form-group \<?php echo (!empty(\$username_err)) ?
\'has-error\' : \'\'; ?\>\"\>**

**\<label\>Kullanıcı Adı\</label\>**

**\<input type=\"text\" name=\"username\" class=\"form-control\"
value=\"\<?php echo \$username; ?\>\"\>**

**\<span class=\"help-block\"\>\<?php echo \$username_err;
?\>\</span\>**

**\</div\>**

**\<div class=\"form-group \<?php echo (!empty(\$password_err)) ?
\'has-error\' : \'\'; ?\>\"\>**

**\<label\>Parola\</label\>**

**\<input type=\"password\" name=\"password\" class=\"form-control\"\>**

**\<span class=\"help-block\"\>\<?php echo \$password_err;
?\>\</span\>**

**\</div\>**

**\<div class=\"form-group\"\>**

**\<input type=\"submit\" class=\"btn btn-primary\" value=\"Giriş\"\>**

**\</div\>**

**\<p\>Hesabınız yok mu? \<a href=\"register.php\"\>Hemen
oluşturun.\</a\>.\</p\>**

**\</form\>**

**\</div\>**

**\</body\>**

**\</html\>**

**logout.php:**

**\<?php**

**// Initialize the session**

**session_start();**

**// Unset all of the session variables**

**\$\_SESSION = array();**

**// Destroy the session.**

**session_destroy();**

**// Redirect to login page**

**header(\"location: login.php\");**

**exit;**

**?\>**

**register.php:**

**\<?php**

**// Include config file**

**require_once \"config.php\";**

**// Define variables and initialize with empty values**

**\$username = \$password = \$confirm_password = \"\";**

**\$username_err = \$password_err = \$confirm_password_err = \"\";**

**// Processing form data when form is submitted**

**if(\$\_SERVER\[\"REQUEST_METHOD\"\] == \"POST\"){**

**// Validate username**

**if(empty(trim(\$\_POST\[\"username\"\]))){**

**\$username_err = \"Please enter a username.\";**

**} else{**

**// Prepare a select statement**

**\$sql = \"SELECT id FROM users WHERE username = ?\";**

**if(\$stmt = mysqli_prepare(\$mysqli, \$sql)){**

**// Bind variables to the prepared statement as parameters**

**mysqli_stmt_bind_param(\$stmt, \"s\", \$param_username);**

**// Set parameters**

**\$param_username = trim(\$\_POST\[\"username\"\]);**

**// Attempt to execute the prepared statement**

**if(mysqli_stmt_execute(\$stmt)){**

**/\* store result \*/**

**mysqli_stmt_store_result(\$stmt);**

**if(mysqli_stmt_num_rows(\$stmt) == 1){**

**\$username_err = \"This username is already taken.\";**

**} else{**

**\$username = trim(\$\_POST\[\"username\"\]);**

**}**

**} else{**

**echo \"Oops! Something went wrong. Please try again later.\";**

**}**

**// Close statement**

**mysqli_stmt_close(\$stmt);**

**}**

**}**

**// Validate password**

**if(empty(trim(\$\_POST\[\"password\"\]))){**

**\$password_err = \"Please enter a password.\";**

**} elseif(strlen(trim(\$\_POST\[\"password\"\])) \< 6){**

**\$password_err = \"Password must have atleast 6 characters.\";**

**} else{**

**\$password = trim(\$\_POST\[\"password\"\]);**

**}**

**// Validate confirm password**

**if(empty(trim(\$\_POST\[\"confirm_password\"\]))){**

**\$confirm_password_err = \"Please confirm password.\";**

**} else{**

**\$confirm_password = trim(\$\_POST\[\"confirm_password\"\]);**

**if(empty(\$password_err) && (\$password != \$confirm_password)){**

**\$confirm_password_err = \"Password did not match.\";**

**}**

**}**

**// Check input errors before inserting in database**

**if(empty(\$username_err) && empty(\$password_err) &&
empty(\$confirm_password_err)){**

**// Prepare an insert statement**

**\$sql = \"INSERT INTO users (username, password) VALUES (?, ?)\";**

**if(\$stmt = mysqli_prepare(\$mysqli, \$sql)){**

**// Bind variables to the prepared statement as parameters**

**mysqli_stmt_bind_param(\$stmt, \"ss\", \$param_username,
\$param_password);**

**// Set parameters**

**\$param_username = \$username;**

**\$param_password = password_hash(\$password, PASSWORD_DEFAULT); //
Creates a password hash**

**// Attempt to execute the prepared statement**

**if(mysqli_stmt_execute(\$stmt)){**

**// Redirect to login page**

**header(\"location: login.php\");**

**} else{**

**echo \"Something went wrong. Please try again later.\";**

**}**

**// Close statement**

**mysqli_stmt_close(\$stmt);**

**}**

**}**

**// Close connection**

**mysqli_close(\$mysqli);**

**}**

**?\>**

**\<!DOCTYPE html\>**

**\<html lang=\"en\"\>**

**\<head\>**

**\<meta charset=\"UTF-8\"\>**

**\<title\>Sign Up\</title\>**

**\<link rel=\"stylesheet\"
href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css\"\>**

**\<style type=\"text/css\"\>**

**body{ font: 14px sans-serif; background-size: cover; background-image:
url(\'https://ckab.com/wp-content/uploads/cyber-scurity.jpg\');}**

**.wrapper{ width: 350px; padding: 20px; ; padding: 20px;**

**background-color: white;**

**position: absolute;**

**top: 50%;**

**left: 50%;**

**margin-left: -600px;**

**margin-top: -150px;**

**border-radius: 10px;**

**}**

**\</style\>**

**\</head\>**

**\<body\>**

**\<div class=\"wrapper\"\>**

**\<h2\>Hesap Oluştur\</h2\>**

**\<form action=\"\<?php echo
htmlspecialchars(\$\_SERVER\[\"PHP_SELF\"\]); ?\>\" method=\"post\"\>**

**\<div class=\"form-group \<?php echo (!empty(\$username_err)) ?
\'has-error\' : \'\'; ?\>\"\>**

**\<label\>Kullanıcı Adı\</label\>**

**\<input type=\"text\" name=\"username\" class=\"form-control\"
value=\"\<?php echo \$username; ?\>\"\>**

**\<span class=\"help-block\"\>\<?php echo \$username_err;
?\>\</span\>**

**\</div\>**

**\<div class=\"form-group \<?php echo (!empty(\$password_err)) ?
\'has-error\' : \'\'; ?\>\"\>**

**\<label\>Parola\</label\>**

**\<input type=\"password\" name=\"password\" class=\"form-control\"
value=\"\<?php echo \$password; ?\>\"\>**

**\<span class=\"help-block\"\>\<?php echo \$password_err;
?\>\</span\>**

**\</div\>**

**\<div class=\"form-group \<?php echo (!empty(\$confirm_password_err))
? \'has-error\' : \'\'; ?\>\"\>**

**\<label\>Parolayı Doğrula\</label\>**

**\<input type=\"password\" name=\"confirm_password\"
class=\"form-control\" value=\"\<?php echo \$confirm_password; ?\>\"\>**

**\<span class=\"help-block\"\>\<?php echo \$confirm_password_err;
?\>\</span\>**

**\</div\>**

**\<div class=\"form-group\"\>**

**\<input type=\"submit\" class=\"btn btn-primary\"
value=\"Oluştur\"\>**

**\<input type=\"reset\" class=\"btn btn-default\" value=\"Temizle\"\>**

**\</div\>**

**\<p\>Hesabın var mı? \<a href=\"login.php\"\>Giriş Yap\</a\>.\</p\>**

**\</form\>**

**\</div\>**

**\</body\>**

**\</html\>**

**style.css:**

**\@import
\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\";**

**html,**

**body,**

**div,**

**span,**

**applet,**

**object,**

**iframe,**

**h1,**

**h2,**

**h3,**

**h4,**

**h5,**

**h6,**

**p,**

**blockquote,**

**pre,**

**a,**

**abbr,**

**acronym,**

**address,**

**big,**

**cite,**

**code,**

**del,**

**dfn,**

**em,**

**img,**

**ins,**

**kbd,**

**q,**

**s,**

**samp,**

**small,**

**strike,**

**strong,**

**sub,**

**sup,**

**tt,**

**var,**

**b,**

**u,**

**i,**

**center,**

**dl,**

**dt,**

**dd,**

**ol,**

**ul,**

**li,**

**fieldset,**

**form,**

**label,**

**legend,**

**table,**

**caption,**

**tbody,**

**tfoot,**

**thead,**

**tr,**

**th,**

**td,**

**article,**

**aside,**

**canvas,**

**details,**

**embed,**

**figure,**

**figcaption,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**output,**

**ruby,**

**section,**

**summary,**

**time,**

**mark,**

**audio,**

**video {**

**margin: 0;**

**padding: 0;**

**border: 0;**

**font-size: 100%;**

**font: inherit;**

**vertical-align: baseline;**

**}**

**/\* HTML5 display-role reset for older browsers \*/**

**article,**

**aside,**

**details,**

**figcaption,**

**figure,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**section {**

**display: block;**

**}**

**body {**

**line-height: 1;**

**}**

**ol,**

**ul {**

**list-style: none;**

**}**

**blockquote,**

**q {**

**quotes: none;**

**}**

**blockquote:before,**

**blockquote:after,**

**q:before,**

**q:after {**

**content: \"\";**

**content: none;**

**}**

**table {**

**border-collapse: collapse;**

**border-spacing: 0;**

**}**

**\* {**

**margin: 0;**

**padding: 0;**

**}**

**body {**

**display: flex;**

**font-family: \"Segoe UI\", \"Open Sans\", \"Helvetica Neue\",
sans-serif;**

**}**

**.kenarCubugu {**

**width: 260px;**

**height: 1000px;**

**background: \#ffffff;**

**align-items: center;**

**text-align: center;**

**}**

**.kenarCubugu .yanBaslik img {**

**width: 60%;**

**height: 80%;**

**}**

**.kenarCubugu .kullanici {**

**width: 100%;**

**height: 75px;**

**color: \#ffffff;**

**display: flex;**

**margin-top: 20px;**

**}**

**.kenarCubugu .kullanici img {**

**width: 45px;**

**height: 45px;**

**border-radius: 30px;**

**margin-left: 50px;**

**margin-top: 10px;**

**}**

**.kenarCubugu .kullanici .bilgi {**

**display: flex;**

**flex-direction: column;**

**font-size: 16px;**

**margin-top: 15px;**

**margin-left: 15px;**

**}**

**.kenarCubugu .kullanici .bilgi .isim {**

**color: black;**

**margin-bottom: 7px;**

**font-weight: 500;**

**}**

**.kenarCubugu .kullanici .bilgi .unvan {**

**color: grey;**

**font-size: 12px;**

**}**

**.kenarCubugu .kontrolPaneli {**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**margin-top: 10px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**}**

**.kenarCubugu .kontrolPaneli span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .kontrolPaneli .fa-home {**

**padding-right: 30px;**

**}**

**.kenarCubugu .konumlar {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .konumlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .konumlar .fa-map-marker-alt {**

**padding-right: 30px;**

**}**

**.kenarCubugu .cihazlar {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .cihazlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .cihazlar .fa-desktop {**

**padding-right: 30px;**

**}**

**.kenarCubugu .zafiyetler {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .zafiyetler span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .zafiyetler .fa-biohazard {**

**padding-right: 30px;**

**}**

**.kenarCubugu .karsilastirma {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .karsilastirma span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .karsilastirma .fa-tasks {**

**padding-right: 30px;**

**}**

**.kontrolPaneli:hover,**

**.konumlar:hover,**

**.cihazlar:hover,**

**.zafiyetler:hover,**

**.karsilastirma:hover {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**}**

**.icerik {**

**flex: 1;**

**background: \#eceef9;**

**}**

**.icerik .baslik {**

**flex: 1;**

**display: flex;**

**height: 68px;**

**background: white;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .baslik .fa-bars {**

**padding-left: 25px;**

**color: \#999999;**

**}**

**.icerik .baslik .arama {**

**display: flex;**

**padding-left: 25px;**

**}**

**.icerik .baslik .arama input {**

**width: 220px;**

**height: 30px;**

**border-radius: 5px;**

**background: \#ffffff;**

**border: 0;**

**font-size: 14px;**

**color: \#000000;**

**padding-left: 10px;**

**margin-left: 10px;**

**box-sizing: border-box;**

**margin-top: 5px;**

**}**

**.icerik .baslik .arama .fa-search {**

**color: \#999999;**

**padding-top: 12px;**

**font-size: 13px;**

**}**

**.icerik .baslik .kullanici img {**

**width: 35px;**

**height: 35px;**

**margin-left: 50px;**

**margin-top: 17px;**

**border-radius: 30px;**

**}**

**.icerik .baslik .kullanici span {**

**position: absolute;**

**padding-left: 20px;**

**padding-top: 25px;**

**color: \#444444;**

**}**

**.icerik .baslik .kullanici .fa-chevron-down {**

**color: \#999999;**

**position: absolute;**

**margin-left: 120px;**

**margin-top: 28px;**

**}**

**.icerik .baslik .kullanici {**

**width: 200px;**

**height: 100%;**

**margin-left: auto !important;**

**padding-right: 70px;**

**}**

**.icerik .baslik .logOut .fa-sign-out-alt {**

**margin-right: 30px;**

**color: \#999999;**

**}**

**.icerik .baslik .bildirim {**

**color: \#999999;**

**width: 150px;**

**padding-right: 40px;**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .baslik .bildirim .baslikMektup .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: \#fed713;**

**border-radius: 20px;**

**}**

**.icerik .baslik .bildirim .baslikCan .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: orange;**

**}**

**.icerik .baslik .bildirim .baslikBayrak .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: rgb(226, 49, 49);**

**}**

**.icerik .anaEkran .ust {**

**flex: 1;**

**height: 120px;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .ust .sol {**

**width: 36px;**

**height: 36px;**

**margin-top: 20px;**

**margin-left: 38px;**

**border-radius: 30px;**

**background: \#6bb3f4;**

**}**

**.icerik .anaEkran .ust .sol .fa-home {**

**color: \#ffffff;**

**width: 15px;**

**margin-top: 9px;**

**margin-left: 11px;**

**}**

**.icerik .anaEkran .ust .sol span {**

**position: absolute;**

**margin-left: 45px;**

**margin-top: 8px;**

**font-size: 18px;**

**font-weight: 500;**

**}**

**.icerik .anaEkran .ust .sag {**

**margin-top: 20px;**

**margin-right: 39px;**

**font-size: 13px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .ust .sag .fa-tachometer-alt {**

**padding-right: 10px;**

**color: \#3a9ae6;**

**}**

**.icerik .anaEkran .kutular1 {**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .kutular1 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 33%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**.icerik .anaEkran .kutular1 .kutu1 \#chart_div {**

**margin-left: 29%;**

**}**

**.icerik .anaEkran .kutular1 .kutu1 span {**

**margin-top: 15px;**

**margin-bottom: 8px;**

**font-size: 24px;**

**font-weight: 700;**

**color: grey;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 {**

**width: 19%;**

**height: 300px;**

**display: flex;**

**flex-direction: column;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#f3f4fd;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .fa-desktop {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#a6a7cf;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#fef0f2;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .fa-biohazard {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: rgb(240, 168, 189);**

**}**

**.icerik .anaEkran .kutular1 .kutu3 {**

**width: 19%;**

**height: 300px;**

**display: flex;**

**flex-direction: column;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#fef0f2;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .fa-box-open {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#e9a1b2;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#f3f4fd;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .fa-map-marker-alt {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#a6a7cf;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 {**

**width: 19%;**

**height: 300px;**

**display: flex;**

**flex-direction: column;**

**justify-content: space-between;**

**margin-right: 35px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#f3f4fd;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .fa-windows {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#a6a7cf;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**width: auto;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: rgb(250, 243, 253);**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .fa-money-bill-alt {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 14px;**

**color: \#e9a1b2;**

**}**

**.icerik .anaEkran .kutular2 {**

**display: flex;**

**width: 100%;**

**height: 300px;**

**margin-top: 35px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 60%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas {**

**display: flex;**

**height: 100px;**

**width: 100%;**

**box-sizing: border-box;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas {**

**width: 65%;**

**height: 100%;**

**padding: 22px;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas span {**

**margin-left: 20px;**

**padding-top: 20px;**

**color: grey;**

**font-size: 14px;**

**font-weight: 700;**

**width: auto;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas .simge {**

**display: flex;**

**padding-left: 10px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: rgb(250, 243, 253);**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas .simge .fa-file-alt
{**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 14px;**

**color: \#e9a1b2;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar {**

**display: inline-block;**

**width: 270px;**

**margin-top: 40px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar a {**

**color: grey;**

**padding: 1px 6px;**

**text-decoration: none;**

**width: 8px;**

**height: 8px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar a.active {**

**background-color: \#e9a1b2;**

**color: white;**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar a:hover:not(.active)
{**

**background-color: \#ddd;**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .liste {**

**display: flex;**

**flex-direction: column;**

**width: 100%;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .liste .list {**

**display: flex;**

**padding: 7px 60px;**

**justify-content: space-between;**

**font-size: 14px;**

**font-weight: 500;**

**color: \#444444;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .liste .list div .fa-ellipsis-v {**

**padding-right: 20px;**

**}**

**.icerik .anaEkran .kutular2 .kutu2 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 37%;**

**margin-left: 3%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-right: 35px;**

**}**

**\#toplam_hasta_graf {**

**padding-top: 20px;**

**margin-left: 50px;**

**width: 100%;**

**height: 90%;**

**}**

**.icerik .anaEkran .kutular3 {**

**display: flex;**

**width: 100%;**

**height: 300px;**

**margin-top: 35px;**

**margin-bottom: 30px;**

**}**

**.icerik .anaEkran .kutular3 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 30%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**.icerik .anaEkran .kutular3 .kutu2 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 65%;**

**margin-left: 3%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-right: 35px;**

**}**

**.icerik .anaEkran .kutular4 {**

**display: flex;**

**width: 100%;**

**height: 800px;**

**margin-top: 35px;**

**margin-bottom: 30px;**

**}**

**.icerik .anaEkran .kutular4 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 100%;**

**height: 100%;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**\#container {**

**width: 100%;**

**height: 100%;**

**margin: 0;**

**padding: 0;**

**}**

**.anychart-tooltip {**

**background: \#fff;**

**border: 1px solid \#ccc;**

**max-width: 300px;**

**color: \#545f69;**

**}**

**\#ilac_stok {**

**width: 90%;**

**height: 90%;**

**margin-top: 35px;**

**margin-left: 20px;**

**}**

**\#durum_graf {**

**width: 85%;**

**height: 85%;**

**margin-left: 0px;**

**margin-top: 20px;**

**}**

**.footer {**

**height: 50px;**

**border-top: 1px solid \#dee3e9;**

**justify-content: space-between;**

**display: flex;**

**}**

**.footer .copyright {**

**margin-top: 15px;**

**margin-right: 50px;**

**}**

**.footer .sol {**

**width: 700px;**

**margin-top: 15px;**

**margin-left: 30px;**

**display: flex;**

**justify-content: space-between;**

**}**

**cihazlar.css:**

**\@import
\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\";**

**html,**

**body,**

**div,**

**span,**

**applet,**

**object,**

**iframe,**

**h1,**

**h2,**

**h3,**

**h4,**

**h5,**

**h6,**

**p,**

**blockquote,**

**pre,**

**a,**

**abbr,**

**acronym,**

**address,**

**big,**

**cite,**

**code,**

**del,**

**dfn,**

**em,**

**img,**

**ins,**

**kbd,**

**q,**

**s,**

**samp,**

**small,**

**strike,**

**strong,**

**sub,**

**sup,**

**tt,**

**var,**

**b,**

**u,**

**i,**

**center,**

**dl,**

**dt,**

**dd,**

**ol,**

**ul,**

**li,**

**fieldset,**

**form,**

**label,**

**legend,**

**table,**

**caption,**

**tbody,**

**tfoot,**

**thead,**

**tr,**

**th,**

**td,**

**article,**

**aside,**

**canvas,**

**details,**

**embed,**

**figure,**

**figcaption,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**output,**

**ruby,**

**section,**

**summary,**

**time,**

**mark,**

**audio,**

**video {**

**margin: 0;**

**padding: 0;**

**border: 0;**

**font-size: 100%;**

**font: inherit;**

**vertical-align: baseline;**

**}**

**/\* HTML5 display-role reset for older browsers \*/**

**article,**

**aside,**

**details,**

**figcaption,**

**figure,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**section {**

**display: block;**

**}**

**body {**

**line-height: 1;**

**}**

**ol,**

**ul {**

**list-style: none;**

**}**

**blockquote,**

**q {**

**quotes: none;**

**}**

**blockquote:before,**

**blockquote:after,**

**q:before,**

**q:after {**

**content: \"\";**

**content: none;**

**}**

**\* {**

**margin: 0;**

**padding: 0;**

**}**

**body {**

**display: flex;**

**font-family: \"Segoe UI\", \"Open Sans\", \"Helvetica Neue\",
sans-serif;**

**}**

**.kenarCubugu {**

**width: 260px;**

**height: 1000px;**

**background: \#ffffff;**

**align-items: center;**

**text-align: center;**

**min-width: 260px;**

**}**

**.kenarCubugu .yanBaslik img {**

**width: 60%;**

**height: 80%;**

**}**

**.kenarCubugu .kullanici {**

**width: 100%;**

**height: 75px;**

**color: \#ffffff;**

**display: flex;**

**margin-top: 20px;**

**}**

**.kenarCubugu .kullanici img {**

**width: 45px;**

**height: 45px;**

**border-radius: 30px;**

**margin-left: 50px;**

**margin-top: 10px;**

**}**

**.kenarCubugu .kullanici .bilgi {**

**display: flex;**

**flex-direction: column;**

**font-size: 16px;**

**margin-top: 15px;**

**margin-left: 15px;**

**}**

**.kenarCubugu .kullanici .bilgi .isim {**

**color: black;**

**margin-bottom: 7px;**

**font-weight: 500;**

**}**

**.kenarCubugu .kullanici .bilgi .unvan {**

**color: grey;**

**font-size: 12px;**

**}**

**.kenarCubugu .kontrolPaneli {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**margin-top: 10px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .kontrolPaneli span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .kontrolPaneli .fa-home {**

**padding-right: 30px;**

**}**

**.kenarCubugu .konumlar {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .konumlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .konumlar .fa-map-marker-alt {**

**padding-right: 30px;**

**}**

**.kenarCubugu .cihazlar {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .cihazlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .cihazlar .fa-desktop {**

**padding-right: 30px;**

**}**

**.kenarCubugu .zafiyetler {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .zafiyetler span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .zafiyetler .fa-biohazard {**

**padding-right: 30px;**

**}**

**.kenarCubugu .karsilastirma {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .karsilastirma span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .karsilastirma .fa-tasks {**

**padding-right: 30px;**

**}**

**.kontrolPaneli:hover,**

**.konumlar:hover,**

**.cihazlar:hover,**

**.zafiyetler:hover,**

**.karsilastirma:hover {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**}**

**.icerik {**

**flex: 1;**

**background: \#eceef9;**

**}**

**.icerik .baslik {**

**flex: 1;**

**display: flex;**

**height: 68px;**

**background: white;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .baslik .fa-bars {**

**padding-left: 25px;**

**color: \#999999;**

**}**

**.icerik .baslik .arama {**

**display: flex;**

**padding-left: 25px;**

**}**

**.icerik .baslik .arama input {**

**width: 220px;**

**height: 30px;**

**border-radius: 5px;**

**background: \#ffffff;**

**border: 0;**

**font-size: 14px;**

**color: \#000000;**

**padding-left: 10px;**

**margin-left: 10px;**

**box-sizing: border-box;**

**margin-top: 5px;**

**}**

**.icerik .baslik .arama .fa-search {**

**color: \#999999;**

**padding-top: 12px;**

**font-size: 13px;**

**}**

**.icerik .baslik .kullanici img {**

**width: 35px;**

**height: 35px;**

**margin-left: 50px;**

**margin-top: 17px;**

**border-radius: 30px;**

**}**

**.icerik .baslik .kullanici span {**

**position: absolute;**

**padding-left: 20px;**

**padding-top: 25px;**

**color: \#444444;**

**}**

**.icerik .baslik .kullanici .fa-chevron-down {**

**color: \#999999;**

**position: absolute;**

**margin-left: 120px;**

**margin-top: 28px;**

**}**

**.icerik .baslik .kullanici {**

**width: 200px;**

**height: 100%;**

**margin-left: auto !important;**

**padding-right: 70px;**

**}**

**.icerik .baslik .fa-sign-out-alt {**

**margin-right: 30px;**

**color: \#999999;**

**}**

**.icerik .baslik .bildirim {**

**color: \#999999;**

**width: 150px;**

**padding-right: 40px;**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .baslik .bildirim .baslikMektup .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: \#fed713;**

**border-radius: 20px;**

**}**

**.icerik .baslik .bildirim .baslikCan .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: orange;**

**}**

**.icerik .baslik .bildirim .baslikBayrak .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: rgb(226, 49, 49);**

**}**

**.icerik .anaEkran .ust {**

**flex: 1;**

**height: 120px;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .ust .sol {**

**width: 36px;**

**height: 36px;**

**margin-top: 20px;**

**margin-left: 38px;**

**border-radius: 30px;**

**background: \#6bb3f4;**

**}**

**.icerik .anaEkran .ust .sol .fa-home {**

**color: \#ffffff;**

**width: 15px;**

**margin-top: 9px;**

**margin-left: 11px;**

**}**

**.icerik .anaEkran .ust .sol span {**

**position: absolute;**

**margin-left: 45px;**

**margin-top: 8px;**

**font-size: 18px;**

**font-weight: 500;**

**}**

**.icerik .anaEkran .ust .sag {**

**margin-top: 20px;**

**margin-right: 39px;**

**font-size: 13px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .ust .sag .fa-tachometer-alt {**

**padding-right: 10px;**

**color: \#3a9ae6;**

**}**

**.icerik .anaEkran .alt {**

**height: 750px;**

**padding-left: 35px;**

**padding-right: 35px;**

**overflow-y: auto;**

**}**

**\#container {**

**width: 100%;**

**height: 100%;**

**margin: 0;**

**padding: 0;**

**}**

**.anychart-tooltip {**

**background: \#fff;**

**border: 1px solid \#ccc;**

**max-width: 300px;**

**color: \#545f69;**

**}**

**\#ilac_stok {**

**width: 90%;**

**height: 90%;**

**margin-top: 55px;**

**margin-left: 20px;**

**}**

**\#durum_graf {**

**width: 85%;**

**height: 85%;**

**margin-left: 0px;**

**margin-top: 20px;**

**}**

**.footer {**

**height: 50px;**

**border-top: 1px solid \#dee3e9;**

**justify-content: space-between;**

**display: flex;**

**}**

**.footer .copyright {**

**margin-top: 15px;**

**margin-right: 50px;**

**}**

**.footer .sol {**

**width: 700px;**

**margin-top: 15px;**

**margin-left: 30px;**

**display: flex;**

**justify-content: space-between;**

**}**

**karsilastir.css:**

**\@import
\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\";**

**html,**

**body,**

**div,**

**span,**

**applet,**

**object,**

**iframe,**

**h1,**

**h2,**

**h3,**

**h4,**

**h5,**

**h6,**

**p,**

**blockquote,**

**pre,**

**a,**

**abbr,**

**acronym,**

**address,**

**big,**

**cite,**

**code,**

**del,**

**dfn,**

**em,**

**img,**

**ins,**

**kbd,**

**q,**

**s,**

**samp,**

**small,**

**strike,**

**strong,**

**sub,**

**sup,**

**tt,**

**var,**

**b,**

**u,**

**i,**

**center,**

**dl,**

**dt,**

**dd,**

**ol,**

**ul,**

**li,**

**fieldset,**

**form,**

**label,**

**legend,**

**table,**

**caption,**

**tbody,**

**tfoot,**

**thead,**

**tr,**

**th,**

**td,**

**article,**

**aside,**

**canvas,**

**details,**

**embed,**

**figure,**

**figcaption,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**output,**

**ruby,**

**section,**

**summary,**

**time,**

**mark,**

**audio,**

**video {**

**margin: 0;**

**padding: 0;**

**border: 0;**

**font-size: 100%;**

**font: inherit;**

**vertical-align: baseline;**

**}**

**/\* HTML5 display-role reset for older browsers \*/**

**article,**

**aside,**

**details,**

**figcaption,**

**figure,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**section {**

**display: block;**

**}**

**body {**

**line-height: 1;**

**}**

**ol,**

**ul {**

**list-style: none;**

**}**

**blockquote,**

**q {**

**quotes: none;**

**}**

**blockquote:before,**

**blockquote:after,**

**q:before,**

**q:after {**

**content: \"\";**

**content: none;**

**}**

**table {**

**border-collapse: collapse;**

**border-spacing: 0;**

**}**

**\* {**

**margin: 0;**

**padding: 0;**

**}**

**body {**

**display: flex;**

**font-family: \"Segoe UI\", \"Open Sans\", \"Helvetica Neue\",
sans-serif;**

**}**

**.kenarCubugu {**

**width: 260px;**

**height: 1000px;**

**background: \#ffffff;**

**align-items: center;**

**text-align: center;**

**}**

**.kenarCubugu .yanBaslik img {**

**width: 60%;**

**height: 80%;**

**}**

**.kenarCubugu .kullanici {**

**width: 100%;**

**height: 75px;**

**color: \#ffffff;**

**display: flex;**

**margin-top: 20px;**

**}**

**.kenarCubugu .kullanici img {**

**width: 45px;**

**height: 45px;**

**border-radius: 30px;**

**margin-left: 50px;**

**margin-top: 10px;**

**}**

**.kenarCubugu .kullanici .bilgi {**

**display: flex;**

**flex-direction: column;**

**font-size: 16px;**

**margin-top: 15px;**

**margin-left: 15px;**

**}**

**.kenarCubugu .kullanici .bilgi .isim {**

**color: black;**

**margin-bottom: 7px;**

**font-weight: 500;**

**}**

**.kenarCubugu .kullanici .bilgi .unvan {**

**color: grey;**

**font-size: 12px;**

**}**

**.kenarCubugu .kontrolPaneli {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**margin-top: 10px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .kontrolPaneli span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .kontrolPaneli .fa-home {**

**padding-right: 30px;**

**}**

**.kenarCubugu .konumlar {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .konumlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .konumlar .fa-map-marker-alt {**

**padding-right: 30px;**

**}**

**.kenarCubugu .cihazlar {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .cihazlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .cihazlar .fa-desktop {**

**padding-right: 30px;**

**}**

**.kenarCubugu .zafiyetler {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .zafiyetler span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .zafiyetler .fa-biohazard {**

**padding-right: 30px;**

**}**

**.kenarCubugu .karsilastirma {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .karsilastirma span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .karsilastirma .fa-tasks {**

**padding-right: 30px;**

**}**

**.kontrolPaneli:hover,**

**.konumlar:hover,**

**.cihazlar:hover,**

**.zafiyetler:hover,**

**.karsilastirma:hover {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**}**

**.icerik {**

**flex: 1;**

**background: \#eceef9;**

**}**

**.icerik .baslik {**

**flex: 1;**

**display: flex;**

**height: 68px;**

**background: white;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .baslik .fa-bars {**

**padding-left: 25px;**

**color: \#999999;**

**}**

**.icerik .baslik .arama {**

**display: flex;**

**padding-left: 25px;**

**}**

**.icerik .baslik .arama input {**

**width: 220px;**

**height: 30px;**

**border-radius: 5px;**

**background: \#ffffff;**

**border: 0;**

**font-size: 14px;**

**color: \#000000;**

**padding-left: 10px;**

**margin-left: 10px;**

**box-sizing: border-box;**

**margin-top: 5px;**

**}**

**.icerik .baslik .arama .fa-search {**

**color: \#999999;**

**padding-top: 12px;**

**font-size: 13px;**

**}**

**.icerik .baslik .kullanici img {**

**width: 35px;**

**height: 35px;**

**margin-left: 50px;**

**margin-top: 17px;**

**border-radius: 30px;**

**}**

**.icerik .baslik .kullanici span {**

**position: absolute;**

**padding-left: 20px;**

**padding-top: 25px;**

**color: \#444444;**

**}**

**.icerik .baslik .kullanici .fa-chevron-down {**

**color: \#999999;**

**position: absolute;**

**margin-left: 120px;**

**margin-top: 28px;**

**}**

**.icerik .baslik .kullanici {**

**width: 200px;**

**height: 100%;**

**margin-left: auto !important;**

**padding-right: 70px;**

**}**

**.icerik .baslik .fa-sign-out-alt {**

**margin-right: 30px;**

**color: \#999999;**

**}**

**.icerik .baslik .bildirim {**

**color: \#999999;**

**width: 150px;**

**padding-right: 40px;**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .baslik .bildirim .baslikMektup .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: \#fed713;**

**border-radius: 20px;**

**}**

**.icerik .baslik .bildirim .baslikCan .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: orange;**

**}**

**.icerik .baslik .bildirim .baslikBayrak .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: rgb(226, 49, 49);**

**}**

**.icerik .anaEkran .ust {**

**flex: 1;**

**height: 120px;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .ust .sol {**

**width: 36px;**

**height: 36px;**

**margin-top: 20px;**

**margin-left: 38px;**

**border-radius: 30px;**

**background: \#6bb3f4;**

**}**

**.icerik .anaEkran .ust .sol .fa-home {**

**color: \#ffffff;**

**width: 15px;**

**margin-top: 9px;**

**margin-left: 11px;**

**}**

**.icerik .anaEkran .ust .sol span {**

**position: absolute;**

**margin-left: 45px;**

**margin-top: 8px;**

**font-size: 18px;**

**font-weight: 500;**

**}**

**.icerik .anaEkran .ust .sag {**

**margin-top: 20px;**

**margin-right: 39px;**

**font-size: 13px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .ust .sag .fa-tachometer-alt {**

**padding-right: 10px;**

**color: \#3a9ae6;**

**}**

**.icerik .anaEkran .kutular4 {**

**display: flex;**

**width: 100%;**

**height: 700px;**

**margin-bottom: 30px;**

**}**

**.icerik .anaEkran .kutular4 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 100%;**

**height: 100%;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**margin-right: 35px;**

**}**

**.icerik .anaEkran .kutular4 .kutu2 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 100%;**

**height: 100%;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**margin-right: 35px;**

**}**

**.anaEkran .alt {**

**height: 600px;**

**width: 70%;**

**margin-left: 230px;**

**}**

**.anaEkran .alt .dropDown{**

**height: 70px;**

**width: 70%;**

**left: 50%;**

**margin-left: -120px;**

**margin-top: -50px;**

**position:absolute;**

**}**

**.anaEkran .alt .tablolar {**

**display: flex;**

**justify-content: space-around;**

**margin-top:50px;**

**}**

**.anaEkran .alt .tablo1 {**

**height: 500px;**

**width: 400px;**

**}**

**.anaEkran .alt .tablo2 {**

**height: 500px;**

**width: 400px;**

**}**

**\#container {**

**width: 100%;**

**height: 100%;**

**margin: 0;**

**padding: 0;**

**}**

**.anychart-tooltip {**

**background: \#fff;**

**border: 1px solid \#ccc;**

**max-width: 300px;**

**color: \#545f69;**

**}**

**\#ilac_stok {**

**width: 90%;**

**height: 90%;**

**margin-top: 55px;**

**margin-left: 20px;**

**}**

**\#durum_graf {**

**width: 85%;**

**height: 85%;**

**margin-left: 0px;**

**margin-top: 20px;**

**}**

**.footer {**

**height: 50px;**

**border-top: 1px solid \#dee3e9;**

**justify-content: space-between;**

**display: flex;**

**}**

**.footer .copyright {**

**margin-top: 15px;**

**margin-right: 50px;**

**}**

**.footer .sol {**

**width: 700px;**

**margin-top: 15px;**

**margin-left: 30px;**

**display: flex;**

**justify-content: space-between;**

**}**

**konumlar.css:**

**\@import
\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\";**

**html,**

**body,**

**div,**

**span,**

**applet,**

**object,**

**iframe,**

**h1,**

**h2,**

**h3,**

**h4,**

**h5,**

**h6,**

**p,**

**blockquote,**

**pre,**

**a,**

**abbr,**

**acronym,**

**address,**

**big,**

**cite,**

**code,**

**del,**

**dfn,**

**em,**

**img,**

**ins,**

**kbd,**

**q,**

**s,**

**samp,**

**small,**

**strike,**

**strong,**

**sub,**

**sup,**

**tt,**

**var,**

**b,**

**u,**

**i,**

**center,**

**dl,**

**dt,**

**dd,**

**ol,**

**ul,**

**li,**

**fieldset,**

**form,**

**label,**

**legend,**

**table,**

**caption,**

**tbody,**

**tfoot,**

**thead,**

**tr,**

**th,**

**td,**

**article,**

**aside,**

**canvas,**

**details,**

**embed,**

**figure,**

**figcaption,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**output,**

**ruby,**

**section,**

**summary,**

**time,**

**mark,**

**audio,**

**video {**

**margin: 0;**

**padding: 0;**

**border: 0;**

**font-size: 100%;**

**font: inherit;**

**vertical-align: baseline;**

**}**

**/\* HTML5 display-role reset for older browsers \*/**

**article,**

**aside,**

**details,**

**figcaption,**

**figure,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**section {**

**display: block;**

**}**

**body {**

**line-height: 1;**

**}**

**ol,**

**ul {**

**list-style: none;**

**}**

**blockquote,**

**q {**

**quotes: none;**

**}**

**blockquote:before,**

**blockquote:after,**

**q:before,**

**q:after {**

**content: \"\";**

**content: none;**

**}**

**table {**

**border-collapse: collapse;**

**border-spacing: 0;**

**}**

**\* {**

**margin: 0;**

**padding: 0;**

**}**

**body {**

**display: flex;**

**font-family: \"Segoe UI\", \"Open Sans\", \"Helvetica Neue\",
sans-serif;**

**}**

**.kenarCubugu {**

**width: 260px;**

**height: 1000px;**

**background: \#ffffff;**

**align-items: center;**

**text-align: center;**

**}**

**.kenarCubugu .yanBaslik img {**

**width: 60%;**

**height: 80%;**

**}**

**.kenarCubugu .kullanici {**

**width: 100%;**

**height: 75px;**

**color: \#ffffff;**

**display: flex;**

**margin-top: 20px;**

**}**

**.kenarCubugu .kullanici img {**

**width: 45px;**

**height: 45px;**

**border-radius: 30px;**

**margin-left: 50px;**

**margin-top: 10px;**

**}**

**.kenarCubugu .kullanici .bilgi {**

**display: flex;**

**flex-direction: column;**

**font-size: 16px;**

**margin-top: 15px;**

**margin-left: 15px;**

**}**

**.kenarCubugu .kullanici .bilgi .isim {**

**color: black;**

**margin-bottom: 7px;**

**font-weight: 500;**

**}**

**.kenarCubugu .kullanici .bilgi .unvan {**

**color: grey;**

**font-size: 12px;**

**}**

**.kenarCubugu .kontrolPaneli {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**margin-top: 10px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .kontrolPaneli span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .kontrolPaneli .fa-home {**

**padding-right: 30px;**

**}**

**.kenarCubugu .konumlar {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .konumlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .konumlar .fa-map-marker-alt {**

**padding-right: 30px;**

**}**

**.kenarCubugu .cihazlar {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .cihazlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .cihazlar .fa-desktop {**

**padding-right: 30px;**

**}**

**.kenarCubugu .zafiyetler {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .zafiyetler span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .zafiyetler .fa-biohazard {**

**padding-right: 30px;**

**}**

**.kenarCubugu .karsilastirma {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .karsilastirma span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .karsilastirma .fa-tasks {**

**padding-right: 30px;**

**}**

**.kontrolPaneli:hover,**

**.konumlar:hover,**

**.cihazlar:hover,**

**.zafiyetler:hover,**

**.karsilastirma:hover {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**}**

**.icerik {**

**flex: 1;**

**background: \#eceef9;**

**}**

**.icerik .baslik {**

**flex: 1;**

**display: flex;**

**height: 68px;**

**background: white;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .baslik .fa-bars {**

**padding-left: 25px;**

**color: \#999999;**

**}**

**.icerik .baslik .arama {**

**display: flex;**

**padding-left: 25px;**

**}**

**.icerik .baslik .arama input {**

**width: 220px;**

**height: 30px;**

**border-radius: 5px;**

**background: \#ffffff;**

**border: 0;**

**font-size: 14px;**

**color: \#000000;**

**padding-left: 10px;**

**margin-left: 10px;**

**box-sizing: border-box;**

**margin-top: 5px;**

**}**

**.icerik .baslik .arama .fa-search {**

**color: \#999999;**

**padding-top: 12px;**

**font-size: 13px;**

**}**

**.icerik .baslik .kullanici img {**

**width: 35px;**

**height: 35px;**

**margin-left: 50px;**

**margin-top: 17px;**

**border-radius: 30px;**

**}**

**.icerik .baslik .kullanici span {**

**position: absolute;**

**padding-left: 20px;**

**padding-top: 25px;**

**color: \#444444;**

**}**

**.icerik .baslik .kullanici .fa-chevron-down {**

**color: \#999999;**

**position: absolute;**

**margin-left: 120px;**

**margin-top: 28px;**

**}**

**.icerik .baslik .kullanici {**

**width: 200px;**

**height: 100%;**

**margin-left: auto !important;**

**padding-right: 70px;**

**}**

**.icerik .baslik .fa-sign-out-alt {**

**margin-right: 30px;**

**color: \#999999;**

**}**

**.icerik .baslik .bildirim {**

**color: \#999999;**

**width: 150px;**

**padding-right: 40px;**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .baslik .bildirim .baslikMektup .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: \#fed713;**

**border-radius: 20px;**

**}**

**.icerik .baslik .bildirim .baslikCan .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: orange;**

**}**

**.icerik .baslik .bildirim .baslikBayrak .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: rgb(226, 49, 49);**

**}**

**.icerik .anaEkran .ust {**

**flex: 1;**

**height: 120px;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .ust .sol {**

**width: 36px;**

**height: 36px;**

**margin-top: 20px;**

**margin-left: 38px;**

**border-radius: 30px;**

**background: \#6bb3f4;**

**}**

**.icerik .anaEkran .ust .sol .fa-home {**

**color: \#ffffff;**

**width: 15px;**

**margin-top: 9px;**

**margin-left: 11px;**

**}**

**.icerik .anaEkran .ust .sol span {**

**position: absolute;**

**margin-left: 45px;**

**margin-top: 8px;**

**font-size: 18px;**

**font-weight: 500;**

**}**

**.icerik .anaEkran .ust .sag {**

**margin-top: 20px;**

**margin-right: 39px;**

**font-size: 13px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .ust .sag .fa-tachometer-alt {**

**padding-right: 10px;**

**color: \#3a9ae6;**

**}**

**.icerik .anaEkran .kutular1 {**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .kutular1 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 33%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**.icerik .anaEkran .kutular1 .kutu1 \#chart_div {**

**margin-left: 29%;**

**}**

**.icerik .anaEkran .kutular1 .kutu1 span {**

**margin-top: 15px;**

**margin-bottom: 8px;**

**font-size: 24px;**

**font-weight: 700;**

**color: grey;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 {**

**width: 19%;**

**height: 300px;**

**display: flex;**

**flex-direction: column;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#f3f4fd;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-1 .fa-calendar-alt {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#a6a7cf;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#fef0f2;**

**}**

**.icerik .anaEkran .kutular1 .kutu2 .kutu2-2 .fa-user-md {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: rgb(240, 168, 189);**

**}**

**.icerik .anaEkran .kutular1 .kutu3 {**

**width: 19%;**

**height: 300px;**

**display: flex;**

**flex-direction: column;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#fef0f2;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-1 .fa-procedures {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#e9a1b2;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#f3f4fd;**

**}**

**.icerik .anaEkran .kutular1 .kutu3 .kutu3-2 .fa-user-nurse {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#a6a7cf;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 {**

**width: 19%;**

**height: 300px;**

**display: flex;**

**flex-direction: column;**

**justify-content: space-between;**

**margin-right: 35px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: \#f3f4fd;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-1 .fa-cut {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 13px;**

**color: \#a6a7cf;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 {**

**display: flex;**

**flex-direction: column;**

**align-items: baseline;**

**width: 100%;**

**height: 140px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .kutuBaslik {**

**margin-left: 40px;**

**padding-top: 27px;**

**color: grey;**

**padding-bottom: 10px;**

**font-size: 14px;**

**font-weight: 700;**

**width: auto;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .sayi {**

**margin-left: 40px;**

**padding-top: 20px;**

**color: \#444444;**

**font-size: 30px;**

**font-weight: 400;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .simge {**

**display: flex;**

**position: absolute;**

**padding-left: 11.5%;**

**margin-top: 50px;**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: rgb(250, 243, 253);**

**}**

**.icerik .anaEkran .kutular1 .kutu4 .kutu4-2 .fa-money-bill-alt {**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 14px;**

**color: \#e9a1b2;**

**}**

**.icerik .anaEkran .kutular2 {**

**display: flex;**

**width: 100%;**

**height: 300px;**

**margin-top: 35px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 60%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas {**

**display: flex;**

**height: 100px;**

**width: 100%;**

**box-sizing: border-box;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas {**

**width: 65%;**

**height: 100%;**

**padding: 22px;**

**display: flex;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas span {**

**margin-left: 20px;**

**padding-top: 20px;**

**color: grey;**

**font-size: 14px;**

**font-weight: 700;**

**width: auto;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas .simge {**

**display: flex;**

**padding-left: 10px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas .simge .fa-circle {**

**width: 60px;**

**height: 60px;**

**color: rgb(250, 243, 253);**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .kutuBas .simge .fa-file-alt
{**

**position: absolute;**

**width: 30px;**

**height: 30px;**

**padding-left: 15px;**

**padding-top: 14px;**

**color: \#e9a1b2;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar {**

**display: inline-block;**

**width: 270px;**

**margin-top: 40px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar a {**

**color: grey;**

**padding: 1px 6px;**

**text-decoration: none;**

**width: 8px;**

**height: 8px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar a.active {**

**background-color: \#e9a1b2;**

**color: white;**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .bas .sayfalar a:hover:not(.active)
{**

**background-color: \#ddd;**

**border-radius: 5px;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .liste {**

**display: flex;**

**flex-direction: column;**

**width: 100%;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .liste .list {**

**display: flex;**

**padding: 7px 60px;**

**justify-content: space-between;**

**font-size: 14px;**

**font-weight: 500;**

**color: \#444444;**

**}**

**.icerik .anaEkran .kutular2 .kutu1 .liste .list div .fa-ellipsis-v {**

**padding-right: 20px;**

**}**

**.icerik .anaEkran .kutular2 .kutu2 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 37%;**

**margin-left: 3%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-right: 35px;**

**}**

**\#toplam_hasta_graf {**

**padding-top: 20px;**

**margin-left: 50px;**

**width: 100%;**

**height: 90%;**

**}**

**.icerik .anaEkran .kutular3 {**

**display: flex;**

**width: 100%;**

**height: 300px;**

**margin-top: 35px;**

**margin-bottom: 30px;**

**}**

**.icerik .anaEkran .kutular3 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 30%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**}**

**.icerik .anaEkran .kutular3 .kutu2 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 65%;**

**margin-left: 3%;**

**height: 300px;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-right: 35px;**

**}**

**.icerik .anaEkran .kutular4 {**

**display: flex;**

**width: 100%;**

**height: 700px;**

**margin-bottom: 30px;**

**}**

**.icerik .anaEkran .kutular4 .kutu1 {**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**width: 100%;**

**height: 100%;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-left: 35px;**

**margin-right: 35px;**

**}**

**\#container {**

**width: 100%;**

**height: 100%;**

**margin: 0;**

**padding: 0;**

**}**

**.anychart-tooltip {**

**background: \#fff;**

**border: 1px solid \#ccc;**

**max-width: 300px;**

**color: \#545f69;**

**}**

**\#ilac_stok {**

**width: 90%;**

**height: 90%;**

**margin-top: 55px;**

**margin-left: 20px;**

**}**

**\#durum_graf {**

**width: 85%;**

**height: 85%;**

**margin-left: 0px;**

**margin-top: 20px;**

**}**

**.footer {**

**height: 50px;**

**border-top: 1px solid \#dee3e9;**

**justify-content: space-between;**

**display: flex;**

**}**

**.footer .copyright {**

**margin-top: 15px;**

**margin-right: 50px;**

**}**

**.footer .sol {**

**width: 700px;**

**margin-top: 15px;**

**margin-left: 30px;**

**display: flex;**

**justify-content: space-between;**

**}**

**zafiyetler.css:**

**\@import
\"https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css\";**

**html,**

**body,**

**div,**

**span,**

**applet,**

**object,**

**iframe,**

**h1,**

**h2,**

**h3,**

**h4,**

**h5,**

**h6,**

**p,**

**blockquote,**

**pre,**

**a,**

**abbr,**

**acronym,**

**address,**

**big,**

**cite,**

**code,**

**del,**

**dfn,**

**em,**

**img,**

**ins,**

**kbd,**

**q,**

**s,**

**samp,**

**small,**

**strike,**

**strong,**

**sub,**

**sup,**

**tt,**

**var,**

**b,**

**u,**

**i,**

**center,**

**dl,**

**dt,**

**dd,**

**ol,**

**ul,**

**li,**

**fieldset,**

**form,**

**label,**

**legend,**

**table,**

**caption,**

**tbody,**

**tfoot,**

**thead,**

**tr,**

**th,**

**td,**

**article,**

**aside,**

**canvas,**

**details,**

**embed,**

**figure,**

**figcaption,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**output,**

**ruby,**

**section,**

**summary,**

**time,**

**mark,**

**audio,**

**video {**

**margin: 0;**

**padding: 0;**

**border: 0;**

**font-size: 100%;**

**font: inherit;**

**vertical-align: baseline;**

**}**

**/\* HTML5 display-role reset for older browsers \*/**

**article,**

**aside,**

**details,**

**figcaption,**

**figure,**

**footer,**

**header,**

**hgroup,**

**menu,**

**nav,**

**section {**

**display: block;**

**}**

**body {**

**line-height: 1;**

**}**

**ol,**

**ul {**

**list-style: none;**

**}**

**blockquote,**

**q {**

**quotes: none;**

**}**

**blockquote:before,**

**blockquote:after,**

**q:before,**

**q:after {**

**content: \"\";**

**content: none;**

**}**

**\* {**

**margin: 0;**

**padding: 0;**

**}**

**body {**

**display: flex;**

**font-family: \"Segoe UI\", \"Open Sans\", \"Helvetica Neue\",
sans-serif;**

**}**

**.kenarCubugu {**

**width: 260px;**

**background: \#ffffff;**

**align-items: center;**

**text-align: center;**

**min-width: 260px;**

**}**

**.kenarCubugu .yanBaslik img {**

**width: 60%;**

**height: 80%;**

**}**

**.kenarCubugu .kullanici {**

**width: 100%;**

**height: 75px;**

**color: \#ffffff;**

**display: flex;**

**margin-top: 20px;**

**}**

**.kenarCubugu .kullanici img {**

**width: 45px;**

**height: 45px;**

**border-radius: 30px;**

**margin-left: 50px;**

**margin-top: 10px;**

**}**

**.kenarCubugu .kullanici .bilgi {**

**display: flex;**

**flex-direction: column;**

**font-size: 16px;**

**margin-top: 15px;**

**margin-left: 15px;**

**}**

**.kenarCubugu .kullanici .bilgi .isim {**

**color: black;**

**margin-bottom: 7px;**

**font-weight: 500;**

**}**

**.kenarCubugu .kullanici .bilgi .unvan {**

**color: grey;**

**font-size: 12px;**

**}**

**.kenarCubugu .kontrolPaneli {**

**background: \#ffffff;**

**width: 100%;**

**height: 40px;**

**color: \#999999;**

**padding-left: 30px;**

**margin-top: 10px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .kontrolPaneli span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .kontrolPaneli .fa-home {**

**padding-right: 30px;**

**}**

**.kenarCubugu .konumlar {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .konumlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .konumlar .fa-map-marker-alt {**

**padding-right: 30px;**

**}**

**.kenarCubugu .cihazlar {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .cihazlar span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .cihazlar .fa-desktop {**

**padding-right: 30px;**

**}**

**.kenarCubugu .zafiyetler {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .zafiyetler span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .zafiyetler .fa-biohazard {**

**padding-right: 30px;**

**}**

**.kenarCubugu .karsilastirma {**

**background: \#ffffff;**

**color: \#999999;**

**width: 100%;**

**height: 40px;**

**padding-left: 30px;**

**box-sizing: border-box;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**font-size: 14px;**

**}**

**.kenarCubugu .karsilastirma span {**

**padding-left: 10px;**

**}**

**.kenarCubugu .karsilastirma .fa-tasks {**

**padding-right: 30px;**

**}**

**.kontrolPaneli:hover,**

**.konumlar:hover,**

**.cihazlar:hover,**

**.zafiyetler:hover,**

**.karsilastirma:hover {**

**background: \#e0e0e0;**

**color: \#3a9ae6;**

**}**

**.icerik {**

**flex: 1;**

**background: \#eceef9;**

**}**

**.icerik .baslik {**

**flex: 1;**

**display: flex;**

**height: 68px;**

**background: white;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .baslik .fa-bars {**

**padding-left: 25px;**

**color: \#999999;**

**}**

**.icerik .baslik .arama {**

**display: flex;**

**padding-left: 25px;**

**}**

**.icerik .baslik .arama input {**

**width: 220px;**

**height: 30px;**

**border-radius: 5px;**

**background: \#ffffff;**

**border: 0;**

**font-size: 14px;**

**color: \#000000;**

**padding-left: 10px;**

**margin-left: 10px;**

**box-sizing: border-box;**

**margin-top: 5px;**

**}**

**.icerik .baslik .arama .fa-search {**

**color: \#999999;**

**padding-top: 12px;**

**font-size: 13px;**

**}**

**.icerik .baslik .kullanici img {**

**width: 35px;**

**height: 35px;**

**margin-left: 50px;**

**margin-top: 17px;**

**border-radius: 30px;**

**}**

**.icerik .baslik .kullanici span {**

**position: absolute;**

**padding-left: 20px;**

**padding-top: 25px;**

**color: \#444444;**

**}**

**.icerik .baslik .kullanici .fa-chevron-down {**

**color: \#999999;**

**position: absolute;**

**margin-left: 120px;**

**margin-top: 28px;**

**}**

**.icerik .baslik .kullanici {**

**width: 200px;**

**height: 100%;**

**margin-left: auto !important;**

**padding-right: 70px;**

**}**

**.icerik .baslik .fa-sign-out-alt {**

**margin-right: 30px;**

**color: \#999999;**

**}**

**.icerik .baslik .bildirim {**

**color: \#999999;**

**width: 150px;**

**padding-right: 40px;**

**display: flex;**

**justify-content: space-between;**

**}**

**.icerik .baslik .bildirim .baslikMektup .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: \#fed713;**

**border-radius: 20px;**

**}**

**.icerik .baslik .bildirim .baslikCan .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: orange;**

**}**

**.icerik .baslik .bildirim .baslikBayrak .fa-circle {**

**width: 8px;**

**height: 8px;**

**padding-bottom: 10px;**

**color: rgb(226, 49, 49);**

**}**

**.icerik .anaEkran .ust {**

**flex: 1;**

**height: 120px;**

**display: flex;**

**align-items: center;**

**justify-content: space-between;**

**}**

**.icerik .anaEkran .ust .sol {**

**width: 36px;**

**height: 36px;**

**margin-top: 20px;**

**margin-left: 38px;**

**border-radius: 30px;**

**background: \#6bb3f4;**

**}**

**.icerik .anaEkran .ust .sol .fa-home {**

**color: \#ffffff;**

**width: 15px;**

**margin-top: 9px;**

**margin-left: 11px;**

**}**

**.icerik .anaEkran .ust .sol span {**

**position: absolute;**

**margin-left: 45px;**

**margin-top: 8px;**

**font-size: 18px;**

**font-weight: 500;**

**}**

**.icerik .anaEkran .ust .sag {**

**margin-top: 20px;**

**margin-right: 39px;**

**font-size: 13px;**

**font-weight: 400;**

**}**

**.icerik .anaEkran .ust .sag .fa-tachometer-alt {**

**padding-right: 10px;**

**color: \#3a9ae6;**

**}**

**.icerik .anaEkran .alt {**

**height: 800px;**

**padding-left: 35px;**

**padding-right: 35px;**

**}**

**\#container {**

**width: 100%;**

**height: 100%;**

**margin: 0;**

**padding: 0;**

**}**

**.anychart-tooltip {**

**background: \#fff;**

**border: 1px solid \#ccc;**

**max-width: 300px;**

**color: \#545f69;**

**}**

**\#ilac_stok {**

**width: 90%;**

**height: 90%;**

**margin-top: 55px;**

**margin-left: 20px;**

**}**

**\#durum_graf {**

**width: 85%;**

**height: 85%;**

**margin-left: 0px;**

**margin-top: 20px;**

**}**

**.footer {**

**height: 50px;**

**border-top: 1px solid \#dee3e9;**

**justify-content: space-between;**

**display: flex;**

**}**

**.footer .copyright {**

**margin-top: 15px;**

**margin-right: 50px;**

**}**

**.footer .sol {**

**width: 700px;**

**margin-top: 15px;**

**margin-left: 30px;**

**display: flex;**

**justify-content: space-between;**

**}**

**\#container {**

**width: 100%;**

**height: 100%;**

**margin: 0;**

**padding: 0;**

**}**

**.icerik .anaEkran .alt {**

**display: flex;**

**flex: 1;**

**}**

**.icerik .anaEkran .alt .kutu1 {**

**width: 500px;**

**height: 700px;**

**overflow-y: auto;**

**margin-left: 50px;**

**margin-top: 25px;**

**}**

**.icerik .anaEkran .alt .kutu2 {**

**height: 700px;**

**width: 55%;**

**display: flex;**

**flex-direction: column;**

**align-items: center;**

**background: white;**

**-webkit-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**-moz-box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**box-shadow: 0px 0px 15px -7px rgba(0, 0, 0, 0.75);**

**border-radius: 5px;**

**margin-top: 25px;**

**margin-left: 100px;**

**}**

**\#slider {**

**width: 300px;**

**height: 300px;**

**display: flex;**

**}**
