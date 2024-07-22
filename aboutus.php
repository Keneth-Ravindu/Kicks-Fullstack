<?php 
    include 'connection.php';
    session_start();
    $user_id = $_SESSION['user_id'];
    if (!isset($user_id)) {
        header('location:login.php');
    }
    if(isset($_POST['logout'])){
        session_destroy();
        header("location: login.php");
    }

     //updating qty
    if (isset($_POST['update_qty_btn'])) {
        $update_qty_id = $_POST['update_qty_id'];
        $update_value = $_POST['update_qty'];

        $update_query = mysqli_query($conn, "UPDATE `cart` SET quantity ='$update_value' WHERE id='$update_qty_id'") or die('query failed');
        if ($update_query) {
            header('location:cart.php');
        }
    }
    //delete product from wishlist
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];

        mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');

        header('location:cart.php');
    }
    //delete product from wishlist
    if (isset($_GET['delete_all'])) {

        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');

        header('location:cart.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+AU+VIC+WA+NT+Hand:wght@400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <title>Kicks About Us</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>About Us</h1>
        </div>
    </div>
    <main class="about-us">
        <section class="our-story">
            <h2>Our Story</h2><br>
            <p>Founded in 2020, Sports Shoe Shop started with a simple mission: to bring high-quality, affordable sports shoes to everyone. Our journey began with a small store, and now we serve thousands of happy customers worldwide.</p>
            <br><br>
            <div class="story-image">
                <img src="Assets/about2.jpg" alt="Our Story">
            </div>
        </section><br><br><br>

        <section class="mission-vision">
            <h2>Our Mission & Vision</h2><br>
            <div class="mission">
                <h3>Mission</h3><br>
                <p>To inspire and empower athletes by providing top-notch footwear that enhances performance and comfort.</p>
            </div><br><br>
            <div class="vision">
                <h3>Vision</h3><br>
                <p>To be the leading provider of innovative and sustainable sports shoes, recognized globally for our commitment to quality and customer satisfaction.</p>
            </div>
        </section><br><br><br>

        <section class="team">
    <h2>Meet the Team</h2><br><br>
    <div class="swiper-container team-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <div class="swiper-slide member">
                <img src="Assets/profile.jpg" alt="Team Member 1">
                <h3>John Doe</h3><br>
                <p>Founder & CEO</p>
            </div>
            <!-- Additional swiper-slide elements -->
        </div>
        
    </div>
    <div class="team-navigation">
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>

        <section class="testimonials">
            <h2>What Our Customers Say</h2><br><br>
            <div class="testimonial-slider">
                <!-- Slider content -->
                <div class="testimonial">
                    <p>"Best sports shoes I've ever bought! Highly recommend." - Alice</p>
                </div>
                <div class="testimonial">
                    <p>"Great quality and fast delivery. I'm very satisfied with my purchase." - Bob</p>
                </div>
                <div class="testimonial">
                    <p>"Excellent customer service and fantastic shoes. Will buy again!" - Charlie</p>
                </div>
                <div class="testimonial">
                    <p>"Excellent customer service and fantastic shoes. Will buy again!" - Charlie</p>
                </div>
                <div class="testimonial">
                    <p>"Excellent customer service and fantastic shoes. Will buy again!" - Charlie</p>
                </div>
                <div class="testimonial">
                    <p>"Excellent customer service and fantastic shoes. Will buy again!" - Charlie</p>
                </div>
                <div class="testimonial">
                    <p>"Excellent customer service and fantastic shoes. Will buy again!" - Charlie</p>
                </div>
            </div>
        </section><br><br><br>

        <section class="call-to-action">
            <h2>Join Our Community</h2><br><br>
            <p>Stay updated with the latest news and exclusive offers by subscribing to our newsletter.</p><br>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form><br>
        </section>

        
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const testimonials = document.querySelector('.testimonial-slider');
        let isDown = false;
        let startX;
        let scrollLeft;

        testimonials.addEventListener('mousedown', (e) => {
            isDown = true;
            testimonials.classList.add('active');
            startX = e.pageX - testimonials.offsetLeft;
            scrollLeft = testimonials.scrollLeft;
        });

        testimonials.addEventListener('mouseleave', () => {
            isDown = false;
            testimonials.classList.remove('active');
        });

        testimonials.addEventListener('mouseup', () => {
            isDown = false;
            testimonials.classList.remove('active');
        });

        testimonials.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - testimonials.offsetLeft;
            const walk = (x - startX) * 3;
            testimonials.scrollLeft = scrollLeft - walk;
        });

        // Initialize Swiper for team slider
        var swiper = new Swiper('.team-slider', {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            },
        });
    });
</script>


    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <?php include 'footer.php'; ?>
    
    
</body>

</html>