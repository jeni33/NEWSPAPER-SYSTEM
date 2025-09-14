<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
}  
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
     
  <style>
    body {
      font-family: 'Comic Neue', cursive;
      background: #fefefe;
    }
  </style>
  
  </head>
  <body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container mt-5">
    <!-- Greeting -->
    <div class="text-center mb-5">
      <h1 class="text-3xl md:text-4xl font-bold text-green-800 flex items-center justify-center gap-2">
        📚 Hello there and welcome, <span class="text-blue-600"><?php echo $_SESSION['username']; ?></span>!
      </h1>
      <p class="text-gray-600 text-lg">Here are all the awesome articles submitted by our young writers ✨</p>
    </div>

    <!-- Submit Article -->
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-lg">
          <div class="card-body">
            <h3 class="text-2xl font-semibold mb-4 flex items-center gap-2 text-gray-800">
              ✍️ Submit an Article
            </h3>
            <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" class="form-control mt-4" name="title" placeholder="Input title here">
                </div>
                <div class="form-group">
                  <textarea name="description" class="form-control mt-4" placeholder="Submit an article!"></textarea>
                </div>
                 <div class="form-group">
                  <label for="image">Upload Image (Optional)</label>
                  <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
                </div>
                <input type="submit" class="btn btn-primary form-control mt-4 mb-4" name="insertArticleBtn">
                🚀 Submit Article
              </button>
            </form>
          </div>
        </div>

        <!-- Published Articles -->
        <h2 class="mt-5 mb-3 text-2xl font-bold flex items-center gap-2 text-gray-800">
          📖 Published Articles
        </h2>

        <?php $articles = $articleObj->getActiveArticles(); ?>
        <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow-md border-0 rounded-lg">
            <div class="card-body">
              <h4 class="font-bold text-xl mb-2 text-green-800">
                <?php echo $article['title']; ?>
              </h4>

              <?php if ($article['is_admin'] == 1) { ?>
                <p><small class="bg-blue-500 text-white px-2 py-1 rounded">Message From Admin</small></p>
              <?php } ?>

              <small class="text-gray-500">
                <strong><?php echo $article['username'] ?></strong> - <?php echo $article['created_at']; ?>
              </small>

              <?php if (!empty($article['image_path'])) { ?>
                <div class="mb-3">
                  <img src="../<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="Article Image" style="max-height: 300px;">
                </div>
              <?php } ?>
              
              <p class="mt-2 text-gray-700"><?php echo $article['content']; ?></p>

              <!-- Request Edit Button -->
              <?php if ($article['author_id'] != $_SESSION['user_id']) { ?>
                <form action="core/handleForms.php" method="POST" class="mt-3">
                  <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                  <button type="submit" name="requestEditBtn" class="btn btn-warning btn-sm">
                    ✏️ Request Edit
                  </button>
                </form>
              <?php } ?>
            </div>
          </div>
        <?php } ?> 
      </div>
    </div>
  </div>
</body>
</html>
