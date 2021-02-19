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

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image18.png)

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image1.png)

**ER Diyagramı**

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image7.png)

5.  **Dashboard Tasarımı**

Karar destek sistemine ilk giriş yapıldığında aşağıdaki giriş ekranıyla
karşılaşıyoruz. Bu ekranda doğru şifre girilmeden hiçbir şekilde siteye
giriş yapılamamaktadır, bu ekrandan yeni hesap oluşturulabilir ve bu
hesapla giriş yapılabilir. Yeni hesapların parolaları şifrelenerek
veritabanına eklenir.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image27.png)

Giriş yapıldıktan sonra kullanıcıya sistem hakkında çeşitli analizler
sunan bir anasayfa kullanıcıyı karşılar. Sol kısımdaki sidebar ile
sayfalar arasında gezebilir, sağ üstteki çıkış butonu ile oturumunu
sonlandırabilir.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image26.png)

Anasayfanın üst kısmında şirketin sahip olduğu ağ altyapısının
özellikleri ve sistem hakkında genel risk bilgisi yer alır.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image13.png)

Altında ise ağ içindeki cihazların koşturdukları işletim sistemlerinin
oranları ve bu işletim sistemlerinin yıllara göre yeni zafiyet sayıları
yer alır.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image16.png)

Bir altta ise kullanıcının notlar alabilmesi için bir yapılacaklar kısmı
ve sağında ise sistemin en çok zafiyete sahip makinalarını görebileceği
bir grafik
bulunmakta.![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image15.png)

Karar alıcı ana ekrana baktıktan sonra şirketin sahip olduğu ağ
altyapısı hakkında bilgi edinir, artık hangi işletim sistemini tercih
etmesi gerektiği gelecekte hangi işletim sistemine daha fazla ağırlık
vermesi gerektiğini ve en riskli cihazlar hakkında bilgi sahibidir.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image23.png)

Karar vericiyi ikinci sayfada ağ altyapısının dünya üzerinde hangi
ülkelerde cihazlara sahip olduğuna ve o ülkelerin risk değerleri
hakkında bilgi alabileceği "Konumlar" sayfası karşılar.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image22.png)

Bir sonraki "Cihazlar" sayfasında karar verici sahip olunan tüm
cihazları tüm bilgileriyle beraber tablo olarak görüntüleyebilir,
dilerse bir önceki sayfadan sahip olduğu konum bilgileriyle belli bir
cihazı seçerek o cihazın üzerinde koşan zafiyet, program ve işletim
sistemlerini görebilir.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image4.png)

"Zafiyetler" sayfasında kullanıcı belli bir zafiyet kodu hakkında
bilgileri bulabilir ve sayfanın sağ kısmında sistemdeki en riskli
yazılımları sıralanmış şekilde görerek hangi yazılımları hangisine
tercih edeceği hakkında fikir sahibi olabilir.

![](https://github.com/svnyasin/Siber-Guvenlik-Yonetimi-Karar-Destek-Sistemi/blob/main/myMediaFolder/media/image8.png)

"Karşılaştırma" ekranında ise karar verici önceki sayfalarda bilgi
sahibi olduğu riskli konumlardaki riskli yazılımlar hakkında risk skoru
ve fiyat karşılaştırması yaparak hangi yazılımı satın alacağına karar
verebilir.
