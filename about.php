<?php
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'bn' ? 'bn' : 'en';
}
$lang = $_SESSION['lang'] ?? 'bn';
?>
<!DOCTYPE html>
<html lang="<?= $lang === 'bn' ? 'bn' : 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang==='bn' ? 'আমাদের সম্পর্কে | সিন্থিয়া টেলিকম' : 'About | Sinthiya Telecom' ?></title>
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
        .about-section {
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
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        .card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 8px 32px rgba(0,123,215,0.18);
        }
        .card h1, .card h4, .card p, .card ul, .card li {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.7s forwards;
        }
        .card h1 { animation-delay: 0.1s; }
        .card h4 { animation-delay: 0.2s; }
        .card p, .card ul { animation-delay: 0.3s; }
        .card li { animation-delay: 0.4s; }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card:hover h1, .card:hover h4, .card:hover p, .card:hover ul, .card:hover li {
            color: #0078d7;
            text-shadow: 0 2px 12px #b3d8ff;
            transition: color 0.3s, text-shadow 0.3s;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand rainbow-text" href="index.php">Sinthiya Telecom</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="নেভিগেশন টগল করুন">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php"><?= $lang==='bn' ? 'হোম' : 'Home' ?></a></li>
                    <li class="nav-item"><a class="nav-link active" href="about.php"><?= $lang==='bn' ? 'আমাদের সম্পর্কে' : 'About' ?></a></li>
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
    <div class="container about-section">
        <?php if ($lang==='bn'): ?>
        <div class="card mb-4 p-4">
            <h1 class="rainbow-text mb-4">সিন্থিয়া টেলিকম সম্পর্কে</h1>
            <p class="lead">সিন্থিয়া টেলিকম আপনার নির্ভরযোগ্য টেলিকম সঙ্গী। প্রতিষ্ঠার পর থেকে আমরা আমাদের সম্মানিত গ্রাহকদের জন্য নির্ভরযোগ্য, সাশ্রয়ী এবং উদ্ভাবনী টেলিকম সেবা দিয়ে আসছি।</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>আমাদের লক্ষ্য</h4>
                    <p>ব্যক্তি নিরবচ্ছিন্ন সংযোগ এবং চমৎকার গ্রাহকসেবা নিশ্চিত করা, যাতে সবাই আধুনিক যুগে সংযুক্ত থাকতে পারে।</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>আমরা কী সেবা দেই</h4>
                    <ul>
                        <li>মোবাইল রিচার্জ ও টপ-আপ সার্ভিস</li>
                        <li>ইন্টারনেট প্যাকেজ ও বিশেষ অফার</li>
                        <li>গ্রাহক সহায়তা</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>কেন আমাদের নির্বাচন করবেন?</h4>
                    <ul>
                        <li>হাজারো সন্তুষ্ট গ্রাহকের আস্থা</li>
                        <li>দ্রুত ও নিরাপদ লেনদেন</li>
                        <li>বন্ধুত্বপূর্ণ ও দক্ষ কর্মী</li>
                        <li>সবসময় গ্রাহক সন্তুষ্টির জন্য কাজ করি</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>আমাদের সেবা ও কার্যক্রম</h4>
                    <ul>
                        <li>আমরা সাধারণত গ্রাহকদের গ্রামীণ, বাংলালিংক, রবি, এয়ারটেল ইত্যাদিতে মোবাইল রিচার্জ করে দিই।</li>
                        <li>টাকা ট্রান্সফার করি এবং এই অ্যাকাউন্টে কোনো সমস্যা হলে তা ঠিক করি।</li>
                        <li>এছাড়াও, আমরা রঙিন ছবি ও ফটোকপি করি।</li>
                    </ul>
                    <p class="mb-0"><strong>দোকান খোলার সময়:</strong> প্রতি শুক্রবার দোকান <b>বন্ধ</b> থাকে। বাকি ছয় দিন সকাল <b>৯টা</b> থেকে রাত <b>৮টা</b> পর্যন্ত খোলা থাকে।</p>
                </div>
            </div>
        </div>
        <div class="card mt-4 p-3">
            <p class="mb-0">সিন্থিয়া টেলিকম বেছে নেওয়ার জন্য ধন্যবাদ। আমরা আপনাকে সেবা দিতে অপেক্ষায় আছি!</p>
        </div>
        <?php else: ?>
        <div class="card mb-4 p-4">
            <h1 class="rainbow-text mb-4">About Sinthiya Telecom</h1>
            <p class="lead">Sinthiya Telecom is your trusted partner for all telecom solutions. Since our founding, we have been committed to providing reliable, affordable, and innovative telecom services to our valued customers.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>Our Mission</h4>
                    <p>To empower individuals and businesses with seamless connectivity and outstanding customer service, ensuring everyone stays connected in today's fast-paced world.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>What We Offer</h4>
                    <ul>
                        <li>Mobile recharge and top-up services</li>
                        <li>Internet packages and special offers</li>
                        <li>Customer support</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>Why Choose Us?</h4>
                    <ul>
                        <li>Trusted by thousands of customers</li>
                        <li>Fast and secure transactions</li>
                        <li>Friendly and knowledgeable staff</li>
                        <li>Always striving for customer satisfaction</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-3">
                    <h4>Our Services & Activities</h4>
                    <ul>
                        <li>We usually load customers with Grameen, Banglalink, Robi, Airtel, etc. on their mobile phones.</li>
                        <li>We transfer money and fix any account issues.</li>
                        <li>We also make color photos and photocopies.</li>
                    </ul>
                    <p class="mb-0"><strong>Shop Hours:</strong> We close the shop every Friday. The remaining six days are open from 9:00 AM to 8:00 PM.</p>
                </div>
            </div>
        </div>
        <div class="card mt-4 p-3">
            <p class="mb-0">Thank you for choosing Sinthiya Telecom. We look forward to serving you!</p>
        </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
