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
      background: #fdfdfd;
    }
  </style>
</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <div class="container mt-5">
    <!-- Header -->
    <div class="text-center mb-5">
      <h1 class="text-3xl md:text-4xl font-bold text-green-800 flex items-center justify-center gap-2">
        📝 My Submitted Articles
      </h1>
      <p class="text-gray-600 text-lg">Double click an article card to edit ✏️</p>
    </div>

    <!-- Article Form -->
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-lg mb-5">
          <div class="card-body">
            <h3 class="text-2xl font-semibold mb-4 flex items-center gap-2 text-gray-800">
              ✍️ Submit a New Article
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

        <!-- Submitted Articles -->
        <?php $articles = $articleObj->getArticlesByUserID($_SESSION['user_id']); ?>
        <?php foreach ($articles as $article) { ?>
          <div class="card mt-4 shadow-md border-0 rounded-lg articleCard">
            <div class="card-body">
              <h4 class="font-bold text-xl mb-2 text-green-800">
                <?php echo $article['title']; ?>
              </h4>
              <small class="text-gray-500 d-block mb-2">
                ✍️ <?php echo $article['username'] ?> • 📅 <?php echo $article['created_at']; ?>
              </small>

              <?php if (!empty($article['image_path'])) { ?>
                <div class="mb-3 text-center">
                  <img src="../<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="Article Image" style="max-height: 250px;">
                </div>
              <?php } ?>

              <!-- Status -->
              <?php if ($article['is_active'] == 0) { ?>
                <p class="text-warning font-bold">⏳ Status: PENDING</p>
              <?php } ?>
              <?php if ($article['is_active'] == 1) { ?>
                <p class="text-success font-bold">✅ Status: ACTIVE</p>
              <?php } ?>

              <!-- Content -->
              <p class="text-gray-700"><?php echo $article['content']; ?></p>

              <!-- Delete Button -->
              <form class="deleteArticleForm">
                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
                <button type="submit" class="btn btn-danger btn-sm float-right mb-2 deleteArticleBtn">
                  🗑️ Delete
                </button>
              </form>

              <!-- Update Form (Hidden by default) -->
              <div class="updateArticleForm d-none mt-4">
                <h5 class="font-bold mb-3">✏️ Edit Your Article</h5>
                <form action="core/handleForms.php" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control" name="title" value="<?php echo $article['title']; ?>">
                  </div>
                  <div class="form-group">
                    <textarea name="description" class="form-control" rows="4"><?php echo $article['content']; ?></textarea>
                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                    <button type="submit" class="btn btn-primary btn-sm mt-3" name="editArticleBtn">
                      💾 Save Changes
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>  
        <?php } ?> 
      </div>
    </div>
  </div>

  <script>
    // Double click to toggle edit form
    $('.articleCard').on('dblclick', function () {
      var updateArticleForm = $(this).find('.updateArticleForm');
      updateArticleForm.toggleClass('d-none');
    });

    // Delete with confirmation + AJAX
    $('.deleteArticleForm').on('submit', function (event) {
      event.preventDefault();
      var formData = {
        article_id: $(this).find('.article_id').val(),
        deleteArticleBtn: 1
      }
      if (confirm("Are you sure you want to delete this article?")) {
        $.ajax({
          type:"POST",
          url: "core/handleForms.php",
          data:formData,
          success: function (data) {
            if (data) {
              location.reload();
            } else {
              alert("Deletion failed ❌");
            }
          }
        })
      }
    })
  </script>
</body>
</html>