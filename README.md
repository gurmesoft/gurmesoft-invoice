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
    'apıUser'   => 'XXXXXXXX',                  // Aracı firma tarafından verilen anahtar,kullanıcı vb.
    'apiPass'   => 'XXXXXXXX',                  // Aracı firma tarafından verilen şifre,gizli anahtar vb.
);

$mysoft = new \GurmesoftInvoice\Client('Mysoft', $options);
```

### Fatura oluşturma

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
 * 0 = EARSIVFATURA
 * 1 = EFATURA
 * 2 = ESMM
 * 3 = EMM
 *
 * Atama yapılmaz ise EARSIVFATURA
 */
->setDocumentType('0')

/**
 * Fatura senaryo bilgisidir.
 * Mükellef GİB e-fatura mükellefi listesinde yer alıyor ise EARSIVFATURA gönderilmelidir.
 * Mükellef sorgusu dökümanda yer almaktadır.
 *
 * 0 = EARSIVFATURA
 * 1 = TEMELFATURA
 * 2 = TICARIFATURA
 * 3 = YOLCUBERABERFATURA
 * 4 = IHRACAT
 * 5 = KAMU
 * 6 = HKS
 * 7 = EARSIVBELGE
 * 8 = OZELFATURA
 *
 * Atama yapılmaz ise TEMELFATURA
 */
->setScenario('0')

/**
 * Fatura tipi bilgisidir.
 * Fatura tipi İADE ise, senaryo değeri TEMELFATURA olmalıdır.
 *
 * 0 = SATIS
 * 1 = IADE
 * 2 = TEVKIFAT
 * 3 = ISTISNA
 * 4 = OZELMATRAH
 * 5 = IHRACKAYITLI
 * 6 = SGK
 * 7 = KOMISYONCU
 * 8 = HKSSATIS
 * 9 = HKSKOMISYONCU
 *
 * Atama yapılmaz ise SATIS
 */
->setType('0')

/**
 * Ön ek bilgisidir.
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
 * 0 = TRY
 * 1 = USD
 * 2 = EUR
 * 3 = GBP
 *
 * Atama yapılmaz ise TRY
 */
->setCurrency('0')

/**
 * Döviz kuru bilgisidir.
 * TRY için atama yapılmayabilir
 */
->setCurrencyRate('18,2')

/**
 * İade fatura no bilgisidir.
 * Fatura tipi IADE olması durumunda zorunludur.
 */
->setReferenceNo('')

/**
 * Faturaya ait alıcı bilgileri.
 * Ayrıntılar için dökümanın devamını inceleyiniz.
 */
->setCustomer($customer)

/**
 * Fatura satırları
 * Ayrıntılar için dökümanın devamını inceleyiniz.
 */
->addLine($line);

$mysoft->sendInvoice($document);

```

### Müşteri oluşturma

```php

$customer = new GurmesoftInvoice\Base\Customer;

/**
 * Alıcı Vergi Kimlik No yada Tc Kimlik bilgisi.
 */
$customer->setTaxNumber('3333333333')

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

### Satır oluşturma

```php

$line = new GurmesoftInvoice\Base\Line;

/**
 * Ürün kodu
 */
$line->setCode('XSYADSA')
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
