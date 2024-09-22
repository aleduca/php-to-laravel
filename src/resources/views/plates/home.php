<?php $this->layout('layout', ['title' => $title]) ?>

<?php $this->insert('partials/slide') ?>

<section class="ac-post-home mt-50 post-fundo">
  <div class="container">
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 post-espaco">
        <div class="col-md-6 post-titulo">
          <h2 class="fw-bold">posts</h2>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
          <a href="#" class="ac-btn">Todos Posts</a>
        </div>
      </div>
    </div>
    <div class="ac-post-content">
      <div class="row gx-5">
        <div class="col-xl-8 col-lg-12 col-md-12">
          <div class="ac-posta-main-content">
            <div class="ac-post-img img-transition-scale">
              <a href="/post/<?= $posts[0]->slug ?>">
                <img src="<?= $posts[0]->image ?>" alt="do php ao laravel">
              </a>
            </div>
            <div class="ac-posta-meta-content">
              <div class="ac-meta-box">
                <div class="ac-meta-btn">
                  <span>
                    <?= $posts[0]->category->name; ?>
                  </span>
                </div>
                <div class="ac-meta-date">
                  <span>
                    <?= formatDate($posts[0]->created_at)->translatedFormat('d F Y'); ?>
                  </span>
                </div>
              </div>
              <div class="ac-post-img-title left">
                <h2>
                  <a href="/post/<?= $posts[0]->slug ?>" class="text-capitalize">
                    <?= $posts[0]->title; ?>
                  </a>
                </h2>
                <p>
                  <?= truncate($posts[0]->description, 150); ?>
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
          <div class="right-side">
            <?php foreach (array_splice($posts, 1, 3) as $post): ?>
              <div class="ac-posta-main-content small">
                <div class="ac-post-img img-transition-scale">
                  <a href="/post/<?= $post->slug ?>">
                    <img src="<?= $post->image; ?>" alt="do php ao laravel">
                  </a>
                </div>
                <div class="ac-posta-meta-content">
                  <div class="ac-meta-box">
                    <div class="ac-meta-btn">
                      <span><?= $post->category->name; ?></span>
                    </div>
                    <div class="ac-meta-date">
                      <span>
                        <?= formatDate($post->created_at)->translatedFormat('d F Y');  ?>
                      </span>
                    </div>
                  </div>
                  <div class="ac-post-img-title">
                    <h3>
                      <a href="/post/<?= $post->slug ?>" class="text-capitalize title-hover">
                        <?= $post->title; ?>
                      </a>
                    </h3>
                  </div>
                </div>
              <?php endforeach; ?>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>