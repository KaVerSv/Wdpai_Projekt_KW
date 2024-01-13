<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public\css\style.css">
    <title>Luna</title>
</head>
<body>
    <div class="shop-container">
        <div class="upper-border">
            <div class="top-buttons">
                <img class="resize2" src="public\img\logo_luna_cut.png"/>
                <a href="shop" class="button"> shop </a>
                <a href="#" class="button"> community </a>
                <a href="library" class="button"> library </a>
                <a href="profile" class="button"> user </a>
                <div class="search-bar">
                    <form>
                        <input placeholder="search">
                    </form>
                </div>
            </div>
        </div>


        <div class="recommended">

            <button onclick="prevImage()" class="svg-button left">
                <img src="public/img/arrow-right.svg" alt="SVG Button">
            </button>


            <div class="featured">
                <img class="img-resize image-container" src="public/img/recommended/Mountains_of_Madness.jpg" alt="Image 1">
            </div>


            <button onclick="nextImage()" class="svg-button">
                <img src="public/img/arrow-right.svg" alt="SVG Button">
            </button>
        </div>

        <div class="dots-container">
            <!-- Dodaj 7 kropek -->
            <div class="dot active" onclick="showImage(0)"></div>
            <div class="dot" onclick="showImage(1)"></div>
            <div class="dot" onclick="showImage(2)"></div>
            <div class="dot" onclick="showImage(3)"></div>
            <div class="dot" onclick="showImage(4)"></div>
            <div class="dot" onclick="showImage(5)"></div>
            <div class="dot" onclick="showImage(6)"></div>
            <!-- Dodaj pozostałe kropki -->
        </div>



        <div class="table">

        </div>

        <?php
        // Assuming $books is an array of Book objects
        $id = [];
        $images = [];
        $titles = [];
        $descriptions = [];
        $author = [];
        $prices = [];
        $publish_date = [];

        if (isset($books)) {
            foreach ($books as $book) {
                $id[] = $book->getId();
                $images[] = $book->getImage();
                $titles[] = $book->getTitle();
                $descriptions[] = $book->getDescription();
                $author[] = $book->getAuthor();
                $prices[] = $book->getTitle();
                $publish_date[] = $book->getPublishDate();
            }
        }

        // Convert PHP array to JavaScript array
        $jsArray = json_encode($images);
        ?>

    </div>



    <script>
        var currentImageIndex = 0;
        var images = <?php echo $jsArray; ?>;


        function showImage(index) {
            var imageContainer = document.querySelector(".featured img");
            imageContainer.src = images[index];

            // Usuń aktywność ze wszystkich kropek
            var dots = document.querySelectorAll(".dot");
            dots.forEach(dot => dot.classList.remove("active"));

            // Dodaj aktywność tylko dla wybranej kropki
            dots[index].classList.add("active");
        }

        function prevImage() {
            currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
            showImage(currentImageIndex);
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            showImage(currentImageIndex);
        }
    </script>
</body>
</html>