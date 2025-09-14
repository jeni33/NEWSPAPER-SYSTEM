<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: admin/index.php");
}  
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shared Articles</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<style>
  body {
    font-family: "Segoe UI", Arial, sans-serif;
    background: linear-gradient(135deg, #fdfbfb, #ebedee); /* light clean gradient */
    color: #2c3e50; /* darker gray text */
    margin: 0;
    padding: 0;
  }

  /* Welcome box */
  .welcome-box {
    background: #ffffff;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 30px auto;
    text-align: center;
    max-width: 900px;
    border: 1px solid #eee;
  }

  .welcome-box h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #34495e; /* deep gray-blue */
    text-shadow: none;
  }

  .welcome-box span {
    color: #f39c12; /* warm yellow for username */
  }

  /* Article cards */
  .card.article-card {
    border-radius: 14px;
    background: #fff;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform 0.2s ease;
    border: 1px solid #f1f1f1;
  }

  .card.article-card:hover {
    transform: translateY(-3px);
  }

  .card.article-card h4 {
    font-weight: 700;
    color: #2c3e50;
  }

  /* Badges */
  .shared-badge {
    background-color: #3498db; /* blue */
    color: white;
    font-size: 0.85rem;
    border-radius: 8px;
    padding: 4px 10px;
  }

  .admin-badge {
    background-color: #e74c3c; /* red for admin */
    color: white;
    font-size: 0.8rem;
    border-radius: 8px;
    padding: 3px 10px;
  }

  /* Buttons */
  .btn-warning {
    background-color: #27ae60 !important; /* green for edit */
    border: none;
    color: white !important;
    font-weight: 600;
    border-radius: 8px;
    padding: 6px 14px;
    transition: 0.3s;
  }

  .btn-warning:hover {
    background-color: #219150 !important;
  }
</style>

</head>
<body>
  <?php include 'includes/navbar.php'; ?>

  <div class="container mt-5">
    <div class="welcome-box">
      <h1>Shared Articles with 
        <span style="color: #efd442;"><?php echo $_SESSION['username']; ?></span>
      </h1>
      <p class="text-muted mb-0">Articles you have edit access to:</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        
        <!-- Shared Articles -->
        <?php $sharedArticles = $articleObj->getSharedArticles($_SESSION['user_id']); ?>
        <?php if (empty($sharedArticles)) { ?>
          <div class="card article-card mb-4">
            <div class="card-body text-center">
              <h4>No Shared Articles</h4>
              <p class="text-muted">You don't have edit access to any articles yet.</p>
            </div>
          </div>
        <?php } else { ?>
          <?php foreach ($sharedArticles as $article) { ?>
          <div class="card article-card mb-4">
            <div class="card-body">
              <h4><?php echo $article['title']; ?></h4> 

              <p><span class="badge shared-badge">Shared by <?php echo $article['shared_by_name']; ?></span></p>

              <?php if ($article['is_admin'] == 1) { ?>
                <p><span class="badge badge-primary admin-badge">Message From Admin</span></p>
              <?php } ?>

              <small class="text-muted d-block mb-2">
                <strong><?php echo $article['username']; ?></strong> · <?php echo $article['created_at']; ?>
                <br>Shared on: <?php echo $article['shared_at']; ?>
              </small>

              <?php if (!empty($article['image_path'])) { ?>
                <div class="mb-3">
                  <img src="../<?php echo $article['image_path']; ?>" class="img-fluid rounded" alt="Article Image" style="max-height: 300px;">
                </div>
              <?php } ?>

              <p><?php echo $article['content']; ?></p>
              
              <div class="mt-3">
                <a href="articles_submitted.php?edit=<?php echo $article['article_id']; ?>" class="btn btn-sm btn-warning">
                  Edit Article
                </a>
              </div>
            </div>
          </div>  
          <?php } ?> 
        <?php } ?>

      </div>
    </div>
  </div>
</body>
</html>