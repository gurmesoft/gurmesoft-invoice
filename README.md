# Gurmesoft/Invoice

Gurmesoft için üretilmiş fatura entegrasyon pakedi. Mysoft, Paraşüt mevcuttur.

## Adım 1

`composer.json` dosyası oluşturulur yada var olan dosyadaki uygun objelere ekleme yapılır.

```json
{
  "require": {
    "gurmesoft/invoice": "dev-master"
  },
  "repositories": [
    {
      "type": "github",
      "url": "https://github.com/gurmesoft/gurmesoft-invoice"
    }
  ]
}
```

## Adım 2

`composer` kullanılarak paket çağırılır

```bash
composer require gurmesoft/invoice:dev-master
```

## Adım 3

### Client

`vendor/autoload.php` dosyası dahil edilir ve firma türetilerek hazır hale getirilir.

```php
<?php

require 'vendor/autoload.php';

$options = array(
    'live'      => false,                       // Test ortamı için gereklidir.
    'apiUser'   => 'XXXXXXXX',                  // Aracı firma tarafından verilen anahtar,kullanıcı vb.
    'apiPass'   => 'XXXXXXXX',                  // Aracı firma tarafından verilen şifre,gizli anahtar vb.
);

$mysoft = new \GurmesoftInvoice\Client('Mysoft', $options);
```

## Adım 4

### 4.1 Fatura oluşturma

```php

$document = new GurmesoftInvoice\Base\Invoice;

/**
 * Fatura eşsiz numara bilgisi
 * Max int32
 */
$document->setId(rand(1111111, 999999))

/**
 * Belge Tipi alanıdır.
 *
 * EARSIVFATURA
 * EFATURA
 * ESMM
 * EMM
 *
 * Atama yapılmaz ise EFATURA
 */
->setDocumentType('EARSIVFATURA')

/**
 * Fatura senaryo bilgisidir.
 * Mükellef GİB e-fatura mükellefi listesinde yer alıyor ise EARSIVFATURA gönderilmelidir.
 * Mükellef sorgusu dökümanda yer almaktadır. (Adım 4.2)
 *
 * TICARIFATURA
 * EARSIVFATURA
 * TEMELFATURA
 * YOLCUBERABERFATURA
 * IHRACAT
 * KAMU
 * HKS
 * EARSIVBELGE
 * OZELFATURA
 *
 * Atama yapılmaz ise TICARIFATURA
 */
->setScenario('EARSIVFATURA')

/**
 * Fatura tipi bilgisidir.
 * Fatura tipi İADE ise, senaryo değeri TEMELFATURA olmalıdır.
 *
 * SATIS
 * IADE
 * TEVKIFAT
 * ISTISNA
 * OZELMATRAH
 * IHRACKAYITLI
 * SGK
 * KOMISYONCU
 * HKSSATIS
 * HKSKOMISYONCU
 *
 * Atama yapılmaz ise SATIS
 */
->setType('SATIS')

/**
 * Ön ek bilgisidir.
 *
* Atama yapılmaz ise sistemdeki varsayılan ek baz alınır.
 */
->setPrefix('FTR')

/**
 * Fatura tarihi bilgisidir.
 *
 * Y/m/d H:i:s Formatinda gönderilmelidir.
 *
 * Atama yapılmaz ise anlık saat baz alınır.
 */
->setDate('28/04/2022 14:33:58')

/**
 * Vade tarihi bilgisidir.
 *
 * Y/m/d H:i:s Formatinda gönderilmelidir.
 */
->setDueDate('28/04/2022 14:33:58')

/**
 * Döviz tipi bilgisidir.
 *
 * TRY
 * USD
 * EUR
 * GBP
 *
 * Atama yapılmaz ise TRY
 */
->setCurrency('TRY')

/**
 * Döviz kuru bilgisidir.
 * TRY için atama yapılmayabilir
 */
->setCurrencyRate('1')

/**
 * İade fatura no bilgisidir.
 * Fatura tipi IADE olması durumunda zorunludur.
 */
->setReferenceNo('XXXXXXXX')

/**
 * Faturaya ait mükellef bilgileri.
 * Ayrıntılar için dökümanın devamını inceleyiniz.
 */
->setTaxpayer($taxpayer)

/**
 * Fatura satırları
 * Ayrıntılar için dökümanın devamını inceleyiniz.
 */
->addLine($line);

$response = $mysoft->sendInvoice($document);

/**
 * Apiden dönen tüm cevap
*/
$response->getResponse();

if ($response->isSuccess()) {
    /**
     * Benzersiz fatura referans no
    */
    $response->getReference();
    /**
     * MX, KLF, FTR vb. ile başlayan döküman no
    */
    $response->getDocumentNo();
} else {
    /**
     * Hata kodu ve mesajı
    */
    $response->getErrorCode();
    $response->getErrorMessage();
}

```

### 4.2 Mükellef sorgulama

```php
/**
 * $taxNumber Mükellefin vergi kimlik numarası
 */
$response = $mysoft->checkTaxpayerStatus($taxNumber);

/**
 * Bool true yada false dönecektir
 */
$response->isEFatura()
```

### 4.3 Fatura için mükellef oluşturma

```php

$taxpayer = new GurmesoftInvoice\Base\Taxpayer;

/**
 * Alıcı Vergi Kimlik No yada Tc Kimlik bilgisi.
 */
$taxpayer->setTaxNumber('XXXXXXXXXX')

/**
 * Alıcı Vergi dairesi bilgisi.
 */
->setTaxOffice('Nilüfer')

/**
 * Şahıs için
 */
->setFirstName('Fikret')
->setLastName('Çin')

/**
 * Firma için
 */
->setCompany('Gurmesoft')

/**
 * Adres bilgileri
 */
->setAddress('Üçevler Mh. Ertuğrul Cd.')
->setDistrict('Nilüfer')
->setCity('Bursa')
->setCountry('Türkiye')

/**
 * İletişim bilgileri
 */
->setPhone('5555555555')
->setEmail('mail@gurmesoft.com');
```

### 4.4 Fatura için satır oluşturma

```php
/**
 * Sınıf tekrar türetilerek birden fazla satır ekleyebilirsiniz.
 */
$line = new GurmesoftInvoice\Base\Line;

/**
 * Ürün stok kodu
 */
$line->setStockCode('TRLK203845')

/**
 * Ürün adı
 */
->setName('Terlik')

/**
 * Ürün adedi
 */
->setQuantity(1)

/**
 * Ürün birim fiyatı
 */
->setUnitPrice(100)

/**
 * Ürün vergi oranı
 */
->setVatRate(18);

```

## Adım 5

### Fatura durum sorgulama ve iptali

```php

/**
 * $referenceNo Fatura oluşturulduğunda benzersiz numara
*/

$response = $mysoft->checkInvoiceStatus($referenceNo);
$response->getStatus();

/**
 * İptal Nedeni ($message)
 *
 * Atama yapılmaz ise İptal Edildi
 *
 * İptal Tipi ($type)
 *
 * GIB
 * NOTER
 * KEP
 * TAAHHUTLUMEKTUP
 * PORTAL
 *
 * Atama yapılmaz ise GIB
*/
$response = $mysoft->cancelInvoice($referenceNo, $message, $type);
```

## Extra

```php

/**
 * Sistem üzerindeki tüm müekkeleflerinizi döndürür.
 *
 * $start başlangıç numarası varsayılan 0
 * $limit limit adedi varsayılan 100
*/

$response = $mysoft->getTaxpayerList($start, $limit);
$response->getList();

/**
 * Sistem üzerindeki giden faturala listesi döndürür.
 *
 * $startDate liste başlangıç tarihi  '01-01-2022'
 * $endDate   liste bitiş tarihi      '26-04-2022'
*/

$response = $mysoft->getInvoiceList($startDate, $endDate);
$response->getList();

/**
 * Faturanın PDF ini indirmenizi sağlar.
 * Bu özelliği kullanabilmek için Php allow_url_fopen = 1 olmalıdır.
 *
*/

$mysoft->getInvoicePdf($referenceNo);
```
