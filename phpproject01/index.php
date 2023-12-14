
<style>

section.hero-banner, section.about-waverly {
  text-align: center; 
}


.hero-content, .about-content {
  max-width: 80%;
  margin: 0 auto;
}
.gallery {
  display: flex;
  justify-content: center; 
  flex-wrap: wrap; 
  gap: 20px; 
}

.picture img {
  max-width: 100%; 
  height: auto;
}

</style>


<?php
  include_once 'header.php';  
?>

<section class="hero-banner">
  <div class="hero-content">
    <h1>Welcome to the Waverly Management System</h1>
    <p>Modern solutions for seamless communication between residents and management. Experience the new era of digital apartment management.</p>
  </div>
</section>

<section class="about-waverly">
  <h2>About The Waverly</h2>
  <div class="about-content">
    <p>Nestled in the heart of Manhattan, the Waverly Residence stands as a testament to luxury, sophistication, and architectural prowess. This iconic building not only redefines the skyline but also the very definition of opulence in urban living.</p>
  </div>
</section>

<section class="building-overview">
  <h2>Gallery</h2>
  <div class="gallery">
    <div class="picture">
      <img src="img/outside.png" alt="Outside" />
    </div>
    <div class="picture">
      <img src="img/pool.png" alt="Pool" />
    </div>
    <div class="picture">
      <img src="img/lounge2.png" alt="Lounge" />
    </div>
    <div class="picture">
      <img src="img/penthouse.png" alt="PentHouse" />
    </div>
    <div class="picture">
      <img src="img/bathroom.png" alt="Bathroom" />
    </div>
  </div>

</section>

<section class="testimonials">
  <h2>What Our Residents Say</h2>
  <div class="testimonial-slider">
    <div class="testimonial">
      <p>"The new system has made life so much easier. I love being able to pay online!"</p>
      <cite>- Jane Doe, Resident</cite>
    </div>

  </div>
</section>


<?php
  include_once 'footer.php';  
?>
