<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= siteTitle ?> - Home</title>
    <link rel="stylesheet" href="<?= resourceURL ?>/css/home.css">
</head>
<body>
<!-- Header Section -->
<section class="section" id="header">
    <div class="container">
        <a href="./login"><button class="button">Login</button></a>
    </div>
</section>

<!-- Welcome Section -->
<section class="section" id="welcome">
    <div class="container">
        <h1>Welcome to User Manager</h1>
        <p>Imagine a world where managing user data is effortless, secure, and efficient. User Manager is your gateway to this digital utopia.</p>
    </div>
</section>

<!-- Product Section -->
<section class="section" id="product">
    <div class="container">
        <h1>Our Product</h1>
        <p>Our user-friendly platform empowers you to:</p>
        <ul>
            <li>Effortlessly manage user profiles and data.</li>
            <li>Streamline communication with users.</li>
            <li>And much more...</li>
        </ul>
    </div>
</section>

<!-- Gallery Section -->
<section class="section" id="gallery">
    <div class="container">
        <h1>Gallery</h1>
        <div id="previewCarousel" class="carousel">
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item">
                    <img src="<?= resourceURL ?>/images/Manager.png" alt="The user manager">
                    <div class="carousel-caption">
                        <h3>User Manager</h3>
                        <p>A simple dashboard to manage users.</p>
                    </div>
                </div>

                <div class="item active">
                    <img src="<?= resourceURL ?>/images/AddUser.png" alt="Create a user">
                    <div class="carousel-caption">
                        <h3>Create a user</h3>
                        <p>Creating a user is as easy as filling out a form.</p>
                    </div>
                </div>

                <div class="item">
                    <img src="<?= resourceURL ?>/images/EditUser.png" alt="Edit a user">
                    <div class="carousel-caption">
                        <h3>Edit a user</h3>
                        <p>Editing a user is as easy as filling out a form.</p>
                    </div>
                </div>

                <div class="item">
                    <img src="<?= resourceURL ?>/images/EditAdmin.png" alt="Edit an admin">
                    <div class="carousel-caption">
                        <h3>Edit an admin</h3>
                        <p>Editing an admin is as easy as filling out a form.</p>
                    </div>
                </div>

                <div class="item">
                    <img src="<?= resourceURL ?>/images/TerminateUser.png" alt="Terminate a user">
                    <div class="carousel-caption">
                        <h3>Terminate a user</h3>
                        <p>Terminating a user is as easy as accepting the contract.</p>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-left" id="prevSlide">
                <span>&#9664;</span>
            </a>
            <a class="carousel-control-right" id="nextSlide">
                <span>&#9654;</span>
            </a>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="section" id="contact">
    <div class="container">
        <h1>Contact Us</h1>
        <p>Have questions or need assistance? Reach out to us.</p>

        <br>

        <form method="POST">
            <p style="font-size: .9rem; color: #ff0000; text-align: center; margin-bottom: 1rem;">This form is currently disabled due to technical difficulties.</p>
            <div class="input-container">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="This field is currently unavailable" required disabled>
            </div>
            <div class="input-container">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="This field is currently unavailable" required disabled>
            </div>
            <div class="input-container">
                <label for="message">Message</label>
                <textarea id="message" name="message" required disabled>This field is currently unavailable</textarea>
            </div>
            <button type="submit" class="disabled" disabled>Submit</button>
        </form>
    </div>
</section>


<script>
    // JavaScript to handle the custom carousel
    document.addEventListener('DOMContentLoaded', function () {
        const carousel = document.querySelector('.carousel');
        const slides = document.querySelectorAll('.carousel-inner .item');
        let currentIndex = 0;

        document.getElementById('prevSlide').addEventListener('click', () => {
            goToSlide(currentIndex - 1);
        });

        document.getElementById('nextSlide').addEventListener('click', () => {
            goToSlide(currentIndex + 1);
        });

        function goToSlide(index) {
            slides[currentIndex].classList.remove('active');
            currentIndex = (index + slides.length) % slides.length;
            slides[currentIndex].classList.add('active');
        }
    });
</script>
</body>
</html>
