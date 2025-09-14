<!-- Navbar -->
<nav class="navbar navbar-expand-lg p-3" style="background: linear-gradient(to right, #ffecd2, #fcb69f);">
  <a class="navbar-brand flex items-center gap-2 font-bold text-lg text-green-800" href="index.php" style="font-family: 'Comic Neue', cursive;">
    📖 Writer Panel
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav gap-3">
      <li class="nav-item">
        <a class="nav-link flex items-center gap-1 text-blue-900 font-semibold hover:text-blue-600 transition" href="index.php" style="font-family: 'Comic Neue', cursive;">
          🏠 Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link flex items-center gap-1 text-orange-800 font-semibold hover:text-orange-600 transition" href="articles_submitted.php" style="font-family: 'Comic Neue', cursive;">
          ✍️ Articles Submitted
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link flex items-center gap-1 text-orange-800 font-semibold hover:text-orange-600 transition" href="shared_articles.php" style="font-family: 'Comic Neue', cursive;">
          🗂️ Shared Articles</a>

      </li>
      <li class="nav-item">
        <a class="nav-link flex items-center gap-1 text-red-800 font-semibold hover:text-red-600 transition" href="core/handleForms.php?logoutUserBtn=1" style="font-family: 'Comic Neue', cursive;">
          🚪 Logout
        </a>
      </li>
    </ul>
  </div>
</nav>

<!-- Add Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
