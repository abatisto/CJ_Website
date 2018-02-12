<?php
include 'top.php';
?>

<h2 id="Quote"> "Great things are done by a series of small things brought together."</h2>
<h3 id="QuoteAuthor">-Vincent VanGogh</h3>

<div id='slide-show-container-container'>
<div class="slideshow-container">
  <div class="mySlides fade">
    <div class="numbertext">1 / 3</div>
    <a href ='clips.php'>
        <img class="slideshow" src="Media%20For%20Site/College%20Years/NYCDA%20Classes/Final%20Reel/Face/Full%20Set.jpg" style="width:100%" alt="">
    </a>
    <div class="text">Check out Craig's NYCDA Final Reel!</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">2 / 3</div>
    <a href='photos.php'>
        <img class="slideshow" src="Media%20For%20Site/The%20Abyss%20Afterwards/Face/Face%20BW.jpg" style="width:100%" alt="">
     
    </a>
    <div class="text">Photo Gallery</div>
  </div>

  <div class="mySlides fade">
    <div class="numbertext">3 / 3</div>
    <a href ='roles.php'>
        <img class="slideshow" src="Media%20For%20Site/College%20Years/NYFW/Cu%20Stretcher%202.jpg" style="width:100%" alt="">
    </a>
    <div class="text">Current and Past Projects</div>
  </div>

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span> 
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span> 
</div>
</div>

<script>
    var slideIndex = 0;
    showSlides();

    function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    for (i = 0; i < slides.length; i++) {
       slides[i].style.display = "none";  
    }
    slideIndex++;
    if (slideIndex> slides.length) {slideIndex = 1}    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    setTimeout(showSlides, 5000); // Change image every 2 seconds
}
</script>
<p id = "home">Welcome to the world of Craig Holcomb Jr! Take a look at his performance career through behind 
    the scenes videos, pictures, projects, and more by browsing through this site. If you would like to get in 
    touch with Craig, fill out the contact form <a href ='form-contact.php'>here.</a> Thank you for visiting!
</p>
<?php
include "footer.php";
?>
    
