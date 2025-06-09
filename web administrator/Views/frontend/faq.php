<?= $this->include('partials/frontend/head-css') ?>

<body class="landing-wrraper">
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- header start-->


            <?= $this->include('partials/frontend/menu-header') ?>

            <!-- header end-->
            <!--home section start-->
            <section class=" section-py-space my-5" id="home"><img class="img-fluid bg-img-cover" src="<?= base_url() ?>/public/assets/images/landing/landing-home/home-bg2.jpg" alt="">
                <div class="custom-container">
                    <div class="row">
                        <!--  user profile first-style start-->
                        <div class="col-sm-12 box-col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="fw-bold">FAQ</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 box-col-8">
                            <div class="card"><img class="img-fluid w-100" src="<?= base_url() ?>/public/assets/images/landing/banner.png" alt="blog-main"></div>
                        </div>
                        <div class="col-lg-8 box-col-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="blog-details">

                                        <h4 class="mb-3 fw-bold">
                                            Bantuan
                                        </h4>
                                        <div class="single-blog-content-top">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="header-faq">
                                <h5 class="mb-0">FAQ</h5>
                            </div>
                            <div class="row default-according style-1 faq-accordion" id="accordionoc">
                                <div class="col-xl-12 xl-60 col-lg-6 col-md-7 box-col-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseicon" aria-expanded="false" aria-controls="collapseicon"><i data-feather="help-circle"></i> Integrating WordPress with Your Website?</button>
                                            </h5>
                                        </div>
                                        <div class="collapse" id="collapseicon" aria-labelledby="collapseicon" data-parent="#accordionoc">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseicon2" aria-expanded="false" aria-controls="collapseicon2"><i data-feather="help-circle"></i> WordPress Site Maintenance ?</button>
                                            </h5>
                                        </div>
                                        <div class="collapse" id="collapseicon2" data-parent="#accordionoc">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseicon3" aria-expanded="false" aria-controls="collapseicon2"><i data-feather="help-circle"></i>Meta Tags in WordPress ?</button>
                                            </h5>
                                        </div>
                                        <div class="collapse" id="collapseicon3" data-parent="#accordionoc">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseicon4" aria-expanded="false" aria-controls="collapseicon2"><i data-feather="help-circle"></i> WordPress in Your Language ?</button>
                                            </h5>
                                        </div>
                                        <div class="collapse" id="collapseicon4" data-parent="#accordionoc">
                                            <div class="card-body">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--footer start-->
            <?= $this->include('partials/frontend/footer') ?>
            <!--footer end-->
        </div>
    </div>

    <?= $this->include('partials//frontend/vendor-scripts') ?>
</body>

</html>


<!-- Container-fluid starts-->

<!-- Container-fluid Ends-->