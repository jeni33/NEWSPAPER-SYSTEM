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
  <title>Admin Dashboard</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>
  body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #e6e4e0ff, #f1eeeaff);
    color: #333;
    margin: 0;
    padding: 0;
    text-align: center; /* lahat ng text naka-center */
  }

  .page-header {
    margin-bottom: 30px;
  }
  .page-header h2 {
    font-weight: 700;
    font-size: 2rem;
    color: #333;
  }

  .form-box {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    margin: 0 auto 30px auto;
    max-width: 600px;
  }

  .article-card {
    background: #fff;
    border-radius: 12px;
    padding: 20px;
    margin: 20px auto;
    max-width: 600px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
  }
  .article-card:hover {
    transform: translateY(-5px);
  }

  .status-badge {
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    display: inline-block;
    margin-top: 10px;
  }
  .status-pending {
    background: #fff3cd;
    color: #856404;
  }
  .status-active {
    background: #d4edda;
    color: #155724;
  }

  .btn-custom {
    background: #ffdd57;
    color: #333;
    font-weight: 600;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 15px;
  }
  .btn-custom:hover {
    background: #ffb347;
    transform: scale(1.05);
  }
</style>

</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <div class="container mt-5">
    <!-- Welcome -->
    <div class="welcome-box">
      <h2>Welcome, <span style="color: #efd442;"><?php echo $_SESSION['username']; ?></span>
      <p>Manage articles from the admin side</p>
    </div>

    <!-- Form -->
    <div class="form-box">
      <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <input type="text" class="form-control" name="title" placeholder="Article title" required>
        </div>
        <div class="form-group">
          <textarea name="description" class="form-control" placeholder="Message as admin" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <label for="image">Article Image (Optional)</label>
          <input type="file" class="form-control-file" name="image" id="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-custom btn-block" name="insertAdminArticleBtn">Post Article</button>
      </form>
    </div>

    <!-- Articles -->
    <?php $articles = $articleObj->getActiveArticles(); ?>
    <?php foreach ($articles as $article) { ?>
      <div class="article-card">
        <h4><?php echo $article['title']; ?></h4>
        <?php if ($article['is_admin'] == 1) { ?>
          <p><span class="badge badge-danger">Admin Message</span></p>
        <?php } ?>
        <small class="text-muted">
          <strong><?php echo $article['username']; ?></strong> • <?php echo $article['created_at']; ?>
        </small>
        
        <?php if (!empty($article['image_path'])) { ?>
          <div class="mb-3">
            <img src="../<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="Article Image" style="max-height: 300px;">
          </div>
        <?php } ?>
        
        <p class="mt-2"><?php echo $article['content']; ?></p>
      </div>
    <?php } ?>
  </div>
</body>
</html>
