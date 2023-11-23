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
                <a href="#" class="button"> shop </a>
                <a href="#" class="button"> community </a>
                <a href="#" class="button"> library </a>
                <a href="#" class="button"> user </a>
                <div class="search-bar">
                    <form>
                        <input placeholder="search">
                    </form>
                </div>
            </div>
        </div>


        <div class="recommended">

            <button onclick="prevImage()" class="svg-button">
                <img src="public/img/arrow-left.svg" alt="SVG Button">
            </button>

            <div class="featured">
                <img class="img-resize" src="public/img/recommended/Mountains_of_Madness.jpg" alt="Image 1">
            </div>

            <button onclick="nextImage()" class="svg-button">
                <img src="public/img/arrow-left.svg" alt="SVG Button">
            </button>

        </div>
    </div>


    <script>
        var currentImageIndex = 0;
        var images = [
            "public/img/recommended/Mountains_of_Madness.jpg",
            "public/img/recommended/Hobbit.jpg",
            "public/img/recommended/1984.jpg"
            // Dodaj pozostałe ścieżki do obrazów
        ];

        function showImage(index) {
            var imageContainer = document.querySelector(".image-container img");
            imageContainer.src = images[index];
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