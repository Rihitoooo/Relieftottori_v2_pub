<!DOCTYPE html>
<html lang="ja">
  <head prefix="og: http://ogp.me/ns#">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>鳥取県特別救護隊</title>
    <link rel="icon" href="img/wappen2.jpg" />
    <meta
      name="description"
      content="任意団体鳥取県特別救護隊のホームページです。本団体は鳥取県西部に拠点を置き、県内を中心に周辺県(岡山県・島根県)でお祭やマラソン等でのイベント救護を実施するボランティアグループです。"
    />
    <meta name="keywords" content="" />
    <meta property="og:url" content="relieftottori.shop/index.html" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="鳥取県特別救護隊" />
    <meta
      property="og:description"
      content="任意団体鳥取県特別救護隊のホームページです。本団体は鳥取県西部に拠点を置き、県内を中心に周辺県(岡山県・島根県)でお祭やマラソン等でのイベント救護を実施するボランティアグループです。"
    />
    <meta property="og:site_name" content="鳥取県特別救護隊" />
    <meta property="og:image" content="img/wappen.jpg" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/common.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
  <body>
    <div id="wrapper">
      <?php include "header.html" ?>

      <div class="main">
        <!-- Page Hero -->
        <section class="page-hero">
            <div class="section-inner">
                <span class="section-label">NEWS</span>
                <h1>お知らせ</h1>
                <p>鳥取県特別救護隊の最新情報。</p>
            </div>
        </section>

        <!-- ========================================
            News
        ========================================= -->
        <section class="news-page">

            <div class="section-inner">

                <div class="section-heading">
                    <p class="section-label">
                        NEWS
                    </p>

                    <h1>
                        お知らせ
                    </h1>

                    <p class="news-lead">
                        鳥取県特別救護隊からのお知らせや活動報告をご紹介します。
                    </p>
                </div>


                <?php

                // DB接続
                require_once "db.php";

                // 1ページに表示する件数
                $perPage = 5;

                // 現在のページ
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

                if ($page < 1) {
                    $page = 1;
                }

                // 全件数を取得
                $countStmt = $pdo->query("SELECT COUNT(*) FROM news");
                $totalNews = (int)$countStmt->fetchColumn();

                // 総ページ数
                $totalPages = max(1, ceil($totalNews / $perPage));

                // 存在しないページへのアクセスを防ぐ
                if ($page > $totalPages) {
                    $page = $totalPages;
                }

                // OFFSET
                $offset = ($page - 1) * $perPage;


                // ニュース取得
                $stmt = $pdo->prepare("
                    SELECT id, date, category, title, body, image
                    FROM news
                    ORDER BY date DESC, id DESC
                    LIMIT :limit OFFSET :offset
                ");

                $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

                $stmt->execute();

                $newsList = $stmt->fetchAll(PDO::FETCH_ASSOC);

                ?>


                <div class="news-list">

                    <?php if (count($newsList) > 0): ?>

                        <?php foreach ($newsList as $news): ?>

                            <article class="news-page-item" id="news-<?php echo htmlspecialchars($news['id']); ?>">

                                <!-- 日付 -->
                                <time
                                    class="news-page-date"
                                    datetime="<?php echo htmlspecialchars($news['date']); ?>"
                                >
                                    <?php echo date('Y.m.d', strtotime($news['date'])); ?>
                                </time>

                                <!-- カテゴリー -->
                                <div class="news-page-category">
                                    <?php echo htmlspecialchars($news['category']); ?>
                                </div>

                                <!-- タイトル -->
                                <h2 class="news-page-title">
                                    <?php echo htmlspecialchars($news['title']); ?>
                                </h2>

                                <!-- 本文 -->
                                <div class="news-page-body">
                                    <?php echo nl2br(htmlspecialchars($news['body'])); ?>
                                </div>

                                <!-- 画像 -->
                                <?php if (!empty($news['image'])): ?>
                                    <div class="news-page-image">
                                        <img
                                            src="<?php echo htmlspecialchars($news['image']); ?>"
                                            alt="<?php echo htmlspecialchars($news['title']); ?>"
                                        >
                                    </div>
                                <?php endif; ?>

                            </article>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <p class="news-empty">
                            現在、お知らせはありません。
                        </p>

                    <?php endif; ?>

                </div>


                <!-- ========================================
                    Pagination
                ========================================= -->

                <?php if ($totalPages > 1): ?>

                    <nav class="pagination" aria-label="ページネーション">

                        <?php if ($page > 1): ?>

                            <a
                                href="?page=<?php echo $page - 1; ?>"
                                class="pagination-arrow"
                            >
                                ←
                            </a>

                        <?php endif; ?>


                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                            <?php if ($i == $page): ?>

                                <span class="pagination-current">
                                    <?php echo $i; ?>
                                </span>

                            <?php else: ?>

                                <a href="?page=<?php echo $i; ?>">
                                    <?php echo $i; ?>
                                </a>

                            <?php endif; ?>

                        <?php endfor; ?>


                        <?php if ($page < $totalPages): ?>

                            <a
                                href="?page=<?php echo $page + 1; ?>"
                                class="pagination-arrow"
                            >
                                →
                            </a>

                        <?php endif; ?>

                    </nav>

                <?php endif; ?>

            </div>

        </section> 

      </div>
      
      <?php include "footer.html" ?>
    </div>
    <script>

    </script>
  </body>
</html>