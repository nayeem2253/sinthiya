<?php
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'bn' ? 'bn' : 'en';
}
$lang = $_SESSION['lang'] ?? 'en';
// Read offers from offers.txt
$offers = [];
if (file_exists('offers.txt')) {
    $lines = file('offers.txt');
    foreach (array_reverse($lines) as $l) {
        $parts = explode('||', $l);
        if (count($parts) === 4) {
            $offers[] = [
                'title' => $parts[0],
                'img' => $parts[1],
                'details' => $parts[2],
                'dt' => $parts[3]
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'bn' ? 'bn' : 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinthiya Telecom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .navbar {
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
        }
        .card {
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            border: none;
        }
        .card.active-offer {
            box-shadow: 0 0 0 4px #0078d7, 0 8px 32px rgba(0,0,0,0.18);
            background: linear-gradient(120deg, #e0e7ff 80%, #f4f8fb 100%);
            filter: none;
            transform: scale(1.03);
            transition: box-shadow 0.3s, background 0.3s, transform 0.3s;
            z-index: 3;
            position: relative;
        }
        .card-title {
            color: #0078d7;
            font-weight: bold;
        }
        .btn-success, .btn-primary {
            border-radius: 2rem;
            font-weight: 600;
            letter-spacing: 1px;
        }
        .offer-img {
            max-width: 100%;
            max-height: 180px;
            width: auto;
            height: auto;
            border-radius: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 12px rgba(0,0,0,0.10);
            object-fit: cover;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .footer {
            font-size: 1.1rem;
            background: linear-gradient(90deg, #0078d7 60%, #00bfff 100%);
            box-shadow: 0 -2px 8px rgba(0,0,0,0.08);
        }
        .card-text {
            word-break: break-word;
            overflow-wrap: break-word;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand rainbow-text" href="#">Sinthiya Telecom</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php"><?= $lang==='bn' ? 'হোম' : 'Home' ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php"><?= $lang==='bn' ? 'আমাদের সম্পর্কে' : 'About' ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php"><?= $lang==='bn' ? 'যোগাযোগ' : 'Contact' ?></a></li>
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
    <div class="container mt-5">
        <div class="text-center">
            <?php if ($lang==='bn'): ?>
                <h1 class="display-4 rainbow-text">সিন্থিয়া টেলিকম-এ স্বাগতম</h1>
                <p class="lead">আপনার নির্ভরযোগ্য টেলিকম সঙ্গী।</p>
            <?php else: ?>
                <h1 class="display-4 rainbow-text">Welcome to Sinthiya Telecom</h1>
                <p class="lead">Your trusted partner for telecom solutions.</p>
            <?php endif; ?>
        </div>
        <!-- Offer Posts in Two Columns -->
        <div class="row mt-5">
            <?php if (!empty($offers)): ?>
                <?php foreach ($offers as $idx => $offer): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100 border-primary border-2">
                            <div class="card-body">
                                <img src="<?= htmlspecialchars($offer['img']) ?>" alt="Offer Image" class="offer-img">
                                <h3 class="card-title mb-3">
                                    <b><?= $lang==='bn' ? 'অফার: ' : '' ?><?= htmlspecialchars($offer['title']) ?></b>
                                </h3>
                                <span class="badge bg-danger mb-2">Admin Post By <b>Nayeem</b></span>
                                <p class="card-text" style="font-size:1.1rem;">
                                    <b>
                                    <?php
                                        $short = mb_substr($offer['details'], 0, 100, 'UTF-8');
                                        $isLong = mb_strlen($offer['details'], 'UTF-8') > 100;
                                        echo nl2br(htmlspecialchars($short));
                                        if ($isLong) echo '...';
                                    ?>
                                    </b>
                                </p>
                                <small class="text-muted">
                                    <b><?= $lang==='bn' ? 'পোস্ট হয়েছে: ' : 'Posted: ' ?><?= htmlspecialchars($offer['dt']) ?></b>
                                </small>
                                <br>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <b><?= $lang==='bn' ? 'এখনও কোনো অফার পোস্ট করা হয়নি।' : 'No offers posted yet.' ?></b>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
