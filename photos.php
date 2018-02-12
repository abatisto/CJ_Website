<?php
include 'top.php';
?>

   
        
    <div class="gallery">
        
    <h2>Photos</h2>
    
    <div class="preview">
	<img id="preview" src="Media%20For%20Site/College%20Years/Face/Comedy%20Final.jpg" alt=""/>
    
    
    <div class="thumbnails">
        <?php
        include "PhotoData.php"
        ?>
        
    </div>
    </div>
    <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1} 
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none"; 
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block"; 
        dots[slideIndex-1].className += " active";
    }   
    </script>
    

    </div> <!-- Close the gallery div -->

<?php 
include "footer.php";
?>