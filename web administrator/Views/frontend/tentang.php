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
                                    <h4 class="fw-bold">Tentang Kami</h4>
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
                                            Perjalanan Shoes and Care
                                        </h4>
                                        <div class="single-blog-content-top">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="fw-bold"> Hubungi Kami</h4>
                                </div>
                                <div class="card-body ">
                                    <ul>
                                        <li>
                                            <h6 class="mb-3 fw-semibold"><i class="fa fa-envelope"></i> E-Kost Pinkshoecare@mail.com</h6>
                                        </li>

                                        <li>
                                            <h6 class="mb-3 fw-semibold"><i class="fa fa-whatsapp"></i> 08221913124123</h6>
                                        </li>
                                        <li>
                                            <h6 class="mb-3 fw-semibold"><i class="fa fa-instagram"></i> E-Kost Pink_shoecare</h6>
                                        </li>

                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>








            <!--home section end-->

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