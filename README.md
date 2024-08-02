# GBCLStudio/fof-upload-qcloud

![License](https://img.shields.io/badge/license-MIT-green.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/gbcl/fof-upload-qcloud.svg)](https://packagist.org/packages/gbcl/fof-upload-qcloud)

A [Flarum](http://flarum.org) extension. An extension for FoF Upload to support Tencent COS upload

### Installation

Install manually with composer:

```sh
composer require gbcl/fof-upload-qcloud
```

After installation, you must set the following settings in the admin panel:

- `qcloud_secret_id`
- `qcloud_secret_key`
- `qcloud_region`
- `qcloud_bucket`
- `qcloud_path`
- `qcloud_domain`

then you need to set the adapter and template to `Tencent COS` and corresponding template.

**If these settings are not set correctly, the upload will fail and will cause a fatal error.**

### Updating

```sh
composer update gbcl/fof-upload-qcloud
php flarum cache:clear
```

### Features

- Support audio/picture/video/pdf preview and common download
- Support file signature and custom signatureToken name/time
- Support most commonly used regions

### Links

- [Packagist](https://packagist.org/packages/gbcl/fof-upload-qcloud)
- [discuss](https://discuss.flarum.org.cn/d/4058)

### Special

VideoTemplate is using DPlayer@1.27 By [DIYgod](https://github.com/DIYgod)

PdfTemplate is using PDFObject@latest By [PDFObject](https://pdfobject.com)

Support my works at [afdian.net](https://afdian.net/@GBCLStudio)