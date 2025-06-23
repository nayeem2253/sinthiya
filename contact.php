<?php
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'bn' ? 'bn' : 'en';
}
$lang = $_SESSION['lang'] ?? 'en';
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'bn' ? 'bn' : 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang==='bn' ? 'যোগাযোগ | সিন্থিয়া টেলিকম' : 'Contact | Sinthiya Telecom' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(120deg, #f4f8fb 60%, #e0e7ff 100%);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 2rem;
            letter-spacing: 2px;
            text-shadow: 1px 1px 8px #fff, 0 2px 8px #0078d7;
        }
        .rainbow-text {
            background: linear-gradient(90deg, #ff005a, #ffb300, #00d084, #00bfff, #8e54e9, #ff005a);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: rainbow 3s linear infinite;
        }
        @keyframes rainbow {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        .contact-section {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem;
            margin-top: 3rem;
        }
        .footer {
            font-size: 1.1rem;
            background: linear-gradient(90deg, #0078d7 60%, #00bfff 100%);
            box-shadow: 0 -2px 8px rgba(0,0,0,0.08);
        }
        .contact-animate {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.7s forwards;
        }
        .contact-animate:nth-child(1) { animation-delay: 0.2s; }
        .contact-animate:nth-child(2) { animation-delay: 0.4s; }
        .contact-animate:nth-child(3) { animation-delay: 0.6s; }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand rainbow-text" href="index.php">Sinthiya Telecom</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php"><?= $lang==='bn' ? 'হোম' : 'Home' ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php"><?= $lang==='bn' ? 'আমাদের সম্পর্কে' : 'About' ?></a></li>
                    <li class="nav-item"><a class="nav-link active" href="contact.php"><?= $lang==='bn' ? 'যোগাযোগ' : 'Contact' ?></a></li>
                </ul>
                <form class="d-flex ms-3" method="get" action="">
                    <select name="lang" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="en"<?= $lang==='en'?' selected':'' ?>>English</option>
                        <option value="bn"<?= $lang==='bn'?' selected':'' ?>>বাংলা</option>
                    </select>
                </form>
            </div>
        </div>
    </nav>
    <div class="container contact-section">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <h1 class="rainbow-text mb-4"><?= $lang==='bn' ? 'যোগাযোগ করুন' : 'Contact Us' ?></h1>
                <img src="Img/mnk810385.jpg" alt="Your Photo" class="rounded-circle shadow mb-4" style="width: 160px; height: 160px; object-fit: cover; border: 4px solid #0078d7;">
                <hr>
                <div class="mt-4">
                    <h5><?= $lang==='bn' ? 'যোগাযোগের তথ্য' : 'Contact Information' ?></h5>
                    <ul class="list-unstyled">
                        <?php if ($lang==='bn'): ?>
                        <li class="contact-animate"><strong><i class="bi bi-telephone-fill"></i> ফোন:</strong> 01307085310</li>
                        <li class="contact-animate"><strong><i class="bi bi-envelope-fill"></i> ইমেইল:</strong> fbaccountoffice.com</li>
                        <li class="contact-animate"><strong><i class="bi bi-geo-alt-fill"></i> ঠিকানা:</strong> হাট পাঙ্গাশী, রায়গঞ্জ, সিরাজগঞ্জ, বাংলাদেশ</li>
                        <?php else: ?>
                        <li class="contact-animate"><strong><i class="bi bi-telephone-fill"></i> Phone:</strong> 01307085310</li>
                        <li class="contact-animate"><strong><i class="bi bi-envelope-fill"></i> Email:</strong> fbaccountoffice.com</li>
                        <li class="contact-animate"><strong><i class="bi bi-geo-alt-fill"></i> Address:</strong> Hat Pangashi, Raigonj, Sirajganj, Bangladesh</li>
                        <?php endif; ?>
                    </ul>
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <a href="https://imo.im/01307085310" target="_blank" class="btn btn-outline-primary rounded-circle" title="IMO"><i class="bi bi-chat-dots-fill" style="font-size: 1.7rem;"></i></a>
                        <a href="https://wa.me/01307085310" target="_blank" class="btn btn-outline-success rounded-circle" title="WhatsApp"><i class="bi bi-whatsapp" style="font-size: 1.7rem;"></i></a>
                        <a href="https://m.facebook.com/mnk810385" target="_blank" class="btn btn-outline-primary rounded-circle" title="Messenger"><i class="bi bi-messenger" style="font-size: 1.7rem;"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
