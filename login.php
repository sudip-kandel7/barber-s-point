<!-- <?php
session_start();
$bg = 'https://cdn.builder.io/api/v1/image/assets%2F4381bdb92bfa41289360caf58eb76501%2Fb2a55ca8b01f4333a70026aff4fee5d9?format=webp&width=1600';
$errors = [];
$email = '';
$userType = 'customer';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim((string)($_POST['email'] ?? ''));
  $password = (string)($_POST['password'] ?? '');
  $userType = in_array($_POST['userType'] ?? '', ['customer','barber','admin']) ? $_POST['userType'] : 'customer';

  if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
  }
  if ($password === '' || strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 characters.';
  }

  $demoUsers = [
    'admin@barberspoint.com' => password_hash('admin123', PASSWORD_DEFAULT),
    'customer@example.com' => password_hash('password', PASSWORD_DEFAULT),
    'barber@barberexample.com' => password_hash('password', PASSWORD_DEFAULT),
  ];

  if (empty($errors)) {
    if (isset($demoUsers[$email]) && password_verify($password, $demoUsers[$email])) {
      $_SESSION['user'] = ['email' => $email, 'type' => $userType];
      header('Location: /');
      exit;
    } else {
      $errors[] = 'Invalid email or password.';
    }
  }
}
?>  -->


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Sign In — Barber's Point</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .card-enter { opacity: 0; transform: translateY(18px) scale(.995); }
    .card-enter-active { opacity: 1; transform: translateY(0) scale(1); transition: all .45s cubic-bezier(.22,1,.36,1); }
  </style>
</head>
<body class="min-h-screen bg-black/40">
  <div class="min-h-screen bg-center bg-cover relative" style="background-image: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)), url('<?php echo htmlspecialchars($bg, ENT_QUOTES); ?>')">
    <header class="w-full border-b border-yellow-100 bg-white/60 backdrop-blur-sm">
      <div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 p-2 rounded-md shadow">
            <svg class="w-6 h-6 text-black" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden><path d="M4 21s4-1 8-1 8 1 8 1" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 9a5 5 0 10-10 0c0 2.8 5 5 5 5s5-2.2 5-5z" stroke="black" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </div>
    </header>

    <main class="max-w-3xl mx-auto px-6 py-20">
      <div class="flex justify-center">
        <div id="authCard" class="card-enter w-full max-w-md">
          <div class="bg-white/95 backdrop-blur-sm border border-gray-200 rounded-lg shadow-2xl overflow-hidden">
            <div class="px-6 py-5 text-center border-b">
              <h1 class="text-xl font-semibold text-gray-900">Sign In</h1>
              <p class="text-sm text-gray-500 mt-1">Enter your credentials to access your account</p>
            </div>

            <div class="p-6">
              <!-- <?php if (!empty($errors)): ?>
                <div class="mb-4">
                  <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    <ul class="text-sm list-disc list-inside">
                      <?php foreach ($errors as $e): ?><li><?php echo htmlspecialchars($e, ENT_QUOTES); ?></li><?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              <?php endif; ?> -->

              <form method="post" class="space-y-4" novalidate>
                <div>
                  <label for="userType" class="block text-sm font-medium text-gray-700 mb-1">I am a</label>
                  <select id="userType" name="userType" class="w-full h-11 px-3 rounded-md border border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <option value="customer" <?php echo $userType==='customer'?'selected':''; ?>>Customer</option>
                    <option value="barber" <?php echo $userType==='barber'?'selected':''; ?>>Barber</option>
                    <option value="admin" <?php echo $userType==='admin'?'selected':''; ?>>Admin</option>
                  </select>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                  <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES); ?>" placeholder="Enter your email" class="w-full h-11 px-3 rounded-md border border-gray-300 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400" required />
                </div>

                <div>
                  <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                  <div class="relative">
                    <input id="password" name="password" type="password" placeholder="Enter your password" class="w-full h-11 px-3 rounded-md border border-gray-300 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 pr-10" required />
                    <button type="button" onclick="togglePassword()" aria-label="Toggle password" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                      <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </button>
                  </div>
                </div>

                <div>
                  <button type="submit" class="w-full h-11 rounded-md bg-yellow-500 hover:bg-yellow-600 text-black font-semibold shadow">Sign In</button>
                </div>
              </form>

              <div class="mt-4 text-sm text-gray-600">
                <strong class="block text-gray-800 mb-2">Demo Credentials:</strong>
                <div class="text-xs text-gray-700 space-y-1">
                  <div><span class="font-medium">Admin:</span> admin@barberspoint.com / admin123</div>
                  <div><span class="font-medium">Customer:</span> customer@example.com / password</div>
                  <div><span class="font-medium">Barber:</span> barber@barberexample.com / password</div>
                </div>
              </div>

              <div class="mt-5 text-center text-sm">
                Don't have an account? <a href="/register" class="text-yellow-600 font-medium">Create one here</a>
              </div>
            </div>

            <div class="px-6 py-4 text-center text-xs text-gray-500 border-t">By signing in, you agree to our terms of service and privacy policy</div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <!-- <script>
    (function () {
      const c = document.getElementById('authCard');
      if (!c) return;
      requestAnimationFrame(() => {
        c.classList.remove('card-enter');
        c.classList.add('card-enter-active');
      });
    })();

    function togglePassword() {
      const p = document.getElementById('password');
      if (!p) return;
      p.type = p.type === 'password' ? 'text' : 'password';
    }

    window.addEventListener('load', () => {
      const e = document.getElementById('email');
      if (e) e.focus();
    });
  </script> -->
</body>
</html>