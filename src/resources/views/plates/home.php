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
              <a href="/post/teste">
                <img src="assets/images/cursos/dophp6.webp" alt="do php ao laravel">
              </a>
            </div>
            <div class="ac-posta-meta-content">
              <div class="ac-meta-box">
                <div class="ac-meta-btn">
                  <span>Laravel</span>
                </div>
                <div class="ac-meta-date">
                  <span>01 Jan 2024</span>
                </div>
              </div>
              <div class="ac-post-img-title left">
                <h2>
                  <a href="/post/teste" class="text-capitalize">
                    Lorem, ipsum dolor sit amet adipisicing elit.
                  </a>
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-12 col-md-12">
          <div class="right-side">
            <div class="ac-posta-main-content small">
              <div class="ac-post-img img-transition-scale">
                <a href="blog.html">
                  <img src="/assets/images/cursos/dophp7.webp" alt="do php ao laravel">
                </a>
              </div>
              <div class="ac-posta-meta-content">
                <div class="ac-meta-box">
                  <div class="ac-meta-btn">
                    <span>Nuxt.js</span>
                  </div>
                  <div class="ac-meta-date">
                    <span>01 Jan 2024</span>
                  </div>
                </div>
                <div class="ac-post-img-title">
                  <h3>
                    <a href="/post/teste" class="text-capitalize title-hover">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    </a>
                  </h3>
                </div>
              </div>
            </div>
            <div class="ac-posta-main-content small">
              <div class="ac-post-img img-transition-scale">
                <a href="/post/teste">
                  <img src="assets/images/cursos/dophp8.webp" alt="do php ao laravel">
                </a>
              </div>
              <div class="ac-posta-meta-content">
                <div class="ac-meta-box">
                  <div class="ac-meta-btn">
                    <span>Nuxt.js</span>
                  </div>
                  <div class="ac-meta-date">
                    <span>01 Jan 2024</span>
                  </div>
                </div>
                <div class="ac-post-img-title">
                  <h3>
                    <a href="/post/teste" class="text-capitalize title-hover">
                      Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                    </a>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>