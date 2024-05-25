<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include 'control.php';
    include 'process.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    ?>
<section class="home-testimonial">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center testimonial-pos">
            <div class="col-md-12 pt-4 d-flex justify-content-center text-white">
                <h3>Testimonials</h3>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                <h2>Explore the students experience</h2>
            </div>
        </div>
        <section class="home-testimonial-bottom">
            <div class="container testimonial-inner">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-4 style-3">
                        <div class="tour-item ">
                            <div class="tour-desc bg-white">
                                <div class="tour-text color-grey-3 text-center">
                                    <form action="" method="post">
                                    <label for="inp" class="inp">
                                            <input type="text" name="comment" id="inp" placeholder="Write your Comment">
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <span class="focus-bg"></span>
                                        </label>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <a href="newsfeed.php"><button>News Feed</button></a>
</section>
<section class="container bg-light position-absolute p-1 shadow" style="z-index: 100000;">

                <?php
                    View();
                ?>
                
        </section>
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <br><br><br><br><br>
</body>
</html>