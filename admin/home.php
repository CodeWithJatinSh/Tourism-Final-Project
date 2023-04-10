<!-- 
  this code generates an h1 heading element that displays 
  the text "Welcome to" followed by the name of a website 
  or application retrieved from a settings object stored 
  in the $_settings variable.
-->

<h1>Welcome to <?php echo $_settings->info('name') ?></h1>

<hr>

<!-- 
  div element with the class name "container" is 
  commonly used in CSS frameworks to provide a 
  container with a fixed width and centered 
  horizontally on the webpage.
-->

<div class="container">
  <?php 

  /* 
  This PHP code fetches all records from a packages table in 
  random order, scans the contents of each directory, validates 
  each image file, and stores the paths to the valid image files 
  in an array called $files.

             <=======Validate Image=======>

  If the file name is not '.' or '..', it calls the validate_image 
  function with the file path as its argument and appends the 
  returned value to the $files array.
  */

    $files = array();
    $packages = $conn->query("SELECT * FROM `packages` order by rand() ");
    while($row = $packages->fetch_assoc()){
      if(!is_dir(base_app.'uploads/package_'.$row['id']))
      continue;
      $fopen = scandir(base_app.'uploads/package_'.$row['id']);
      foreach($fopen as $fname){
        if(in_array($fname,array('.','..')))
          continue;
        $files[]= validate_image('uploads/package_'.$row['id'].'/'.$fname);
      }
    }
  ?>
  <!-- 

    This is a PHP code that generates a responsive slideshow carousel 
    with the validated images retrieved from a previous code snippet. 
    It creates a container for the carousel with attributes to control 
    its behavior, loops through each image, creates a div and an img 
    element for each slide, sets the default active slide, and creates 
    left and right arrows for navigation. The resulting carousel is 
    fully responsive and can be controlled by the user using the 
    arrow buttons.
    
  -->
  <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
      <div class="carousel-inner h-100">
          <?php foreach($files as $k => $img): ?>
          <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
              <img class="d-block w-100  h-100" src="<?php echo $img ?>" alt="">
          </div>
          <?php endforeach; ?>
      </div>
      <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
      </a>
  </div>
</div>
