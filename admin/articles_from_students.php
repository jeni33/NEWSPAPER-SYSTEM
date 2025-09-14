<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
}  
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin - Manage Articles</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<style>
  body {
    font-family: "Poppins", "Segoe UI", Arial, sans-serif;
    background: linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)),
                url("https://i.pinimg.com/1200x/62/71/aa/6271aabc246da5eb2a9f5e8d3fa3e121.jpg");
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    color: #333;
  }

  .page-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
  }

  .page-header h2 {
    font-weight: 700;
    color: #3498db; /* school blue */
    font-size: 2rem;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.15);
  }

  .form-box {
    background: #ffffffcc;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.12);
    margin-bottom: 35px;
    border: 2px dashed #ffb347; /* playful orange accent */
  }

  .article-card {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 5px 14px rgba(0,0,0,0.1);
    border-left: 6px solid #6ecb63; /* green accent for fresh look */
    transition: transform 0.2s ease;
  }

  .article-card:hover {
    transform: scale(1.02);
  }

  .status-badge {
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
  }

  .status-pending {
    background: #fff3cd; /* softer yellow */
    color: #856404;
  }

  .status-active {
    background: #d4edda; /* green */
    color: #155724;
  }

  .btn-custom {
    background: linear-gradient(45deg, #ff6f61, #ffd93b);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 25px;
    padding: 10px 18px;
    transition: 0.3s;
  }

  .btn-custom:hover {
    transform: scale(1.07);
    background: linear-gradient(45deg, #ff8f61, #ffe15b);
  }

  /* playful icons for header */
  .page-header::before {
    content: "📰✏️";
    font-size: 1.8rem;
    display: block;
    margin-bottom: 8px;
  }
</style>

</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <div class="container mt-4">
    <!-- Page Header -->
    <div class="page-header">
      <h2>Manage Articles</h2>
      <p class="text-muted">Add, approve, or remove articles from the system</p>
    </div>

    <!-- Pending/Active Articles -->
    <?php $articles = $articleObj->getArticles(); ?>
    <?php foreach ($articles as $article) { ?>
      <div class="article-card">
        <h5><?php echo $article['title']; ?></h5>
        <small class="text-muted">
          <strong><?php echo $article['username']; ?></strong> • <?php echo $article['created_at']; ?>
        </small>

        <!-- Status -->
        <p class="mt-2">
          <?php if ($article['is_active'] == 0) { ?>
            <span class="status-badge status-pending">Pending</span>
          <?php } else { ?>
            <span class="status-badge status-active">Active</span>
          <?php } ?>
        </p>

        <!-- Content -->
        <p><?php echo $article['content']; ?></p>

        <!-- Image -->
        <?php if (!empty($article['image_path'])) { ?>
          <div class="mb-3">
            <img src="../<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="Article Image" style="max-height: 300px;">
          </div>
        <?php } ?>

        <!-- Status Update -->
        <form class="updateArticleStatus mb-3">
          <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
          <select name="is_active" class="form-control form-control-sm is_active_select" article_id="<?php echo $article['article_id']; ?>">
            <option value="">Change status...</option>
            <option value="0">Pending</option>
            <option value="1">Active</option>
          </select>
        </form>

        <!-- Delete -->
        <form class="deleteArticleForm d-inline">
          <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>" class="article_id">
          <button type="submit" class="btn btn-sm btn-outline-danger deleteArticleBtn">Delete</button>
        </form>
      </div>
    <?php } ?>
  </div>

  <script>
    // Update article status
    $('.is_active_select').on('change', function (event) {
      event.preventDefault();
      var formData = {
        article_id: $(this).attr('article_id'),
        status: $(this).val(),
        updateArticleVisibility: 1
      }
      if (formData.article_id !== "" && formData.status !== "") {
        $.ajax({
          type: "POST",
          url: "core/handleForms.php",
          data: formData,
          success: function (data) {
            if (data) {
              location.reload();
            } else {
              alert("Visibility update failed");
            }
          }
        })
      }
    });

    // Delete article
    $('.deleteArticleForm').on('submit', function (event) {
      event.preventDefault();
      var formData = {
        article_id: $(this).find('.article_id').val(),
        deleteArticleBtn: 1
      }
      if (confirm("Are you sure you want to delete this article?")) {
        $.ajax({
          type: "POST",
          url: "core/handleForms.php",
          data: formData,
          success: function (data) {
            if (data) {
              location.reload();
            } else {
              alert("Deletion failed");
            }
          }
        })
      }
    });
  </script>
</body>
</html>