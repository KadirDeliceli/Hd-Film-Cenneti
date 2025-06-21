🎬 Film İnceleme Sitesi

Bu proje, kullanıcıların film listelerini görüntüleyip beğenme, kaydetme, puanlama, yorum yapma ve izlenme bilgilerini takip etmesine olanak tanıyan basit bir PHP tabanlı film sitesi uygulamasıdır.

---

## 🚀 Özellikler

- ✅ Film listeleme
- ❤️ Beğeni ve kaydetme sistemi
- 📝 Yorum yapma ve puanlama
- 👁️ İzlenme takibi
- 👤 Kullanıcı oturumu yönetimi
- 🖼️ Profil fotoğrafı desteği

---

## 🛠️ Kurulum

### 1. Gerekli Yazılımlar

- [XAMPP] veya benzeri bir PHP geliştirme ortamı
- PHP 7.x veya üstü
- MySQL (phpMyAdmin desteğiyle)

### 2. Veritabanı Kurulumu

1. PhpMyAdmin'e giriş yapın.
2. `film` adında bir veritabanı oluşturun.
3. Proje içinde yer alan `film.sql` dosyasını içe aktararak tabloları oluşturun.

### 3. Bağlantı Ayarları

`config.php` veya bağlantı dosyanızda aşağıdaki satırı kontrol edin:

```php
$VeritabaniBaglantisi = mysqli_connect("localhost", "root", "", "film", 3357);

📌 Port numarası sizde farklıysa (örneğin 3306), kendi sisteminize göre değiştirin.

film ekleme işlemini yapabilmek için kullanıcı adı ve şifre 'admin' 'dir.
