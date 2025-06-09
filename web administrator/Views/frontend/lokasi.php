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
                                    <h4 class="fw-bold">Lokasi Kami</h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 box-col-8">
                            <div class="card"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.0313590512565!2d106.80994467627993!3d-6.389955162502856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e9cfa562a66f%3A0xc3e36d467014b62!2sMBT%20Solution!5e0!3m2!1sid!2sid!4v1719909800402!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
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
                                <div class="card-body">
                                    <div class="blog-details">

                                        <h4 class="mb-3 fw-bold">
                                            Alamat
                                        </h4>
                                        <div class="single-blog-content-top">
                                            <p>Jl. Leli 1 No.132, RT.2/RW.7, Depok Jaya, Kec. Pancoran Mas, Kota Depok, Jawa Barat 16432</p>
                                        </div>
                                    </div>
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