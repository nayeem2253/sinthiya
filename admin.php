<?php
// Simple session-based admin authentication (for demo)
session_start();
// Database connection settings
$db_host = 'localhost';
$db_user = 'root'; // Change if needed
$db_pass = '';
$db_name = 'fahim'; // Change to your DB name
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Login logic
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT password FROM admin_users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();
        if ($password === $db_password) {
            $_SESSION['admin'] = true;
            $ok = 'লগইন সফল!';
        } else {
            $error = 'ভুল ইউজারনেম বা পাসওয়ার্ড!';
        }
    } else {
        $error = 'ভুল ইউজারনেম বা পাসওয়ার্ড!';
    }
    $stmt->close();
}
// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
// Offer post logic
if (isset($_POST['offerTitle']) && isset($_SESSION['admin'])) {
    $title = htmlspecialchars($_POST['offerTitle']);
    $details = htmlspecialchars($_POST['offerDetails']);
    $img = '';
    if (isset($_FILES['offerImage']) && $_FILES['offerImage']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['offerImage']['name'], PATHINFO_EXTENSION);
        $img = 'uploads/' . uniqid('offer_', true) . '.' . $ext;
        move_uploaded_file($_FILES['offerImage']['tmp_name'], $img);
    } elseif (!empty($_POST['offerImageUrl'])) {
        $img = htmlspecialchars($_POST['offerImageUrl']);
    }
    $data = [$title, $img, $details, date('Y-m-d H:i')];
    $line = implode('||', $data) . "\n";
    file_put_contents('offers.txt', $line, FILE_APPEND);
    $success = 'অফার পোস্ট হয়েছে!';
}
// Delete offer logic
if (isset($_GET['delete']) && isset($_SESSION['admin'])) {
    $delete_index = (int)$_GET['delete'];
    $lines = file('offers.txt');
    if (isset($lines[$delete_index])) {
        unset($lines[$delete_index]);
        file_put_contents('offers.txt', implode('', $lines));
        $success = 'অফার ডিলিট হয়েছে!';
    }
}
// Edit offer logic
if (isset($_POST['editIndex']) && isset($_SESSION['admin'])) {
    $edit_index = (int)$_POST['editIndex'];
    $lines = file('offers.txt');
    if (isset($lines[$edit_index])) {
        $title = htmlspecialchars($_POST['offerTitle']);
        $details = htmlspecialchars($_POST['offerDetails']);
        $img = '';
        if (isset($_FILES['offerImage']) && $_FILES['offerImage']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['offerImage']['name'], PATHINFO_EXTENSION);
            $img = 'uploads/' . uniqid('offer_', true) . '.' . $ext;
            move_uploaded_file($_FILES['offerImage']['tmp_name'], $img);
        } elseif (!empty($_POST['offerImageUrl'])) {
            $img = htmlspecialchars($_POST['offerImageUrl']);
        } else {
            $img = explode('||', $lines[$edit_index])[1];
        }
        $dt = trim(explode('||', $lines[$edit_index])[3] ?? date('Y-m-d H:i'));
        $lines[$edit_index] = implode('||', [$title, $img, $details, $dt]) . "\n";
        file_put_contents('offers.txt', implode('', $lines));
        $success = 'অফার এডিট হয়েছে!';
    }
}
// Password reset logic
if (isset($_POST['reset_password'])) {
    $username = $_POST['reset_username'];
    $new_password = $_POST['reset_new_password'];
    $reset_code = $_POST['reset_code'];
    $stmt = $conn->prepare('SELECT reset_code FROM admin_users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_code);
        $stmt->fetch();
        if ($reset_code === $db_code && !empty($reset_code)) {
            $stmt->close();
            $update = $conn->prepare('UPDATE admin_users SET password = ? WHERE username = ?');
            $update->bind_param('ss', $new_password, $username);
            $update->execute();
            $update->close();
            $reset_success = 'পাসওয়ার্ড সফলভাবে রিসেট হয়েছে! এখন লগইন করুন।';
        } else {
            $reset_error = 'রিসেট কোড ভুল!';
        }
    } else {
        $reset_error = 'ইউজারনেম খুঁজে পাওয়া যায়নি!';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sinthiya Telecom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, #f4f8fb 60%, #e0e7ff 100%); }
        .admin-header { font-weight: bold; font-size: 2rem; letter-spacing: 2px; color: #0078d7; margin-top: 2rem; }
        .card { border-radius: 1.2rem; box-shadow: 0 4px 24px rgba(0,0,0,0.08); border: none; }
        .footer { font-size: 1.1rem; background: linear-gradient(90deg, #0078d7 60%, #00bfff 100%); box-shadow: 0 -2px 8px rgba(0,0,0,0.08); }
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Site View</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="text-center admin-header">Admin Panel - Offer Post</div>
        <?php if (!isset($_SESSION['admin'])): ?>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">অ্যাডমিন লগইন</h4>
                        <?php if (isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
                        <?php if (isset($reset_success)) echo '<div class="alert alert-success">'.$reset_success.'</div>'; ?>
                        <?php if (isset($ok)) echo '<div class="alert alert-success">'.$ok.'</div>'; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </form>
                        <div class="mt-3 text-end">
                            <a href="#" id="show-reset" class="text-decoration-underline">Forgot Password?</a>
                        </div>
                        <form method="post" id="reset-form" style="display:none; margin-top:20px;">
                            <h5 class="mb-2">পাসওয়ার্ড রিসেট করুন</h5>
                            <?php if (isset($reset_error)) echo '<div class="alert alert-danger">'.$reset_error.'</div>'; ?>
                            <div class="mb-2">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="reset_username" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="reset_new_password" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Reset Code</label>
                                <input type="text" class="form-control" name="reset_code" required>
                            </div>
                            <button type="submit" name="reset_password" class="btn btn-warning">Reset Password</button>
                            <button type="button" id="cancel-reset" class="btn btn-secondary ms-2">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
        document.getElementById('show-reset').onclick = function(e) {
            e.preventDefault();
            document.getElementById('reset-form').style.display = 'block';
            this.style.display = 'none';
        };
        document.getElementById('cancel-reset').onclick = function() {
            document.getElementById('reset-form').style.display = 'none';
            document.getElementById('show-reset').style.display = 'inline';
        };
        </script>
        <?php else: ?>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">নতুন অফার পোস্ট করুন</h4>
                            <a href="?logout=1" class="btn btn-outline-danger btn-sm">Logout</a>
                        </div>
                        <?php if (isset($success)) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
                        <form method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="offerTitle" class="form-label">অফার টাইটেল</label>
                                <input type="text" class="form-control" id="offerTitle" name="offerTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="offerImage" class="form-label">ছবি (ইমেজ আপলোড করুন)</label>
                                <input type="file" class="form-control" id="offerImage" name="offerImage" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="offerImageUrl" class="form-label">অথবা, ছবি URL দিন</label>
                                <input type="url" class="form-control" id="offerImageUrl" name="offerImageUrl" placeholder="https://example.com/image.jpg">
                            </div>
                            <div class="mb-3">
                                <label for="offerDetails" class="form-label">অফার বিবরণ</label>
                                <textarea class="form-control" id="offerDetails" name="offerDetails" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">পোস্ট করুন</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php
        // সব অফার দেখাও (অ্যাডমিন দেখবে)
        if (isset($_SESSION['admin']) && file_exists('offers.txt')) {
            echo '<div class="row justify-content-center mt-4"><div class="col-md-8"><h5>সকল অফার</h5>';
            $lines = file('offers.txt');
            $total = count($lines);
            foreach (array_reverse($lines, true) as $i => $l) {
                list($title, $img, $details, $dt) = explode('||', $l);
                // Edit form
                if (isset($_GET['edit']) && $_GET['edit'] == ($total - $i - 1)) {
                    echo '<div class="card mb-3"><div class="card-body">';
                    echo '<form method="post" enctype="multipart/form-data"><input type="hidden" name="editIndex" value="'.($total - $i - 1).'">';
                    echo '<div class="mb-2"><label>অফার টাইটেল</label><input type="text" class="form-control" name="offerTitle" value="'.htmlspecialchars($title).'" required></div>';
                    echo '<div class="mb-2"><label>ছবি (ইমেজ আপলোড করুন)</label><input type="file" class="form-control" name="offerImage" accept="image/*"></div>';
                    echo '<div class="mb-2"><label>অথবা, ছবি URL দিন</label><input type="url" class="form-control" name="offerImageUrl" value="'.htmlspecialchars($img).'"></div>';
                    echo '<div class="mb-2"><label>অফার বিবরণ</label><textarea class="form-control" name="offerDetails" required>'.htmlspecialchars($details).'</textarea></div>';
                    echo '<button type="submit" class="btn btn-success btn-sm">Save</button> ';
                    echo '<a href="admin.php" class="btn btn-secondary btn-sm">Cancel</a>';
                    echo '</form></div></div>';
                } else {
                    echo '<div class="card mb-3"><div class="card-body">';
                    echo '<img src="'.trim($img).'" class="offer-img mb-2" style="max-width:200px;display:block;">';
                    echo '<h5>'.$title.'</h5>';
                    echo '<p>'.$details.'</p>';
                    echo '<small class="text-muted">Posted: '.$dt.'</small><br>';
                    echo '<a href="?edit='.($total - $i - 1).'" class="btn btn-warning btn-sm mt-2">Edit</a> ';
                    echo '<a href="?delete='.($total - $i - 1).'" class="btn btn-danger btn-sm mt-2" onclick="return confirm(\'Are you sure?\')">Delete</a>';
                    echo '</div></div>';
                }
            }
            echo '</div></div>';
        }
        ?>
    </div>
    <footer class="footer text-white text-center py-3 mt-5">
        &copy; 2025 Sinthiya Telecom. All rights reserved.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
