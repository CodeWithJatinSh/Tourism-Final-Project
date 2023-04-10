<?php 

/* 

This PHP code is checking if there is a parameter with the name "id" in the 
URL (GET request). If it exists, the code will retrieve information about a 
package from the database using the "id" parameter as a reference.

The retrieved package information includes its name, description, price, and 
other relevant details, which are stored in variables using the foreach loop.

Next, the code fetches reviews for the package from the "rate_review" table in 
the database. It retrieves the user's name, rating, and review text, which are 
stored in an array.

After that, the code calculates the average rating for the package based on the 
sum of all the ratings and the number of reviews. It also checks if there are any 
uploaded images associated with the package and adds them to an array if they exist.

Overall, this code retrieves and displays relevant information about a package, 
including its reviews and associated images, if they exist.

*/

if(isset($_GET['id'])){
    $packages = $conn->query("SELECT * FROM `packages` where md5(id) = '{$_GET['id']}'");
    if($packages->num_rows > 0){
        foreach($packages->fetch_assoc() as $k => $v){
            $$k = $v;
        }
    }
$review = $conn->query("SELECT r.*,concat(firstname,' ',lastname) as name FROM `rate_review` r inner join users u on r.user_id = u.id where r.package_id='{$id}' order by unix_timestamp(r.date_created) desc ");
$review_count =$review->num_rows;
$rate = 0;
$feed = array();
while($row= $review->fetch_assoc()){
    $rate += $row['rate'];
    if(!empty($row['review'])){
        $row['review'] = stripslashes(html_entity_decode($row['review']));
        $feed[] = $row;
    }
}
if($rate > 0 && $review_count > 0)
$rate = number_format($rate/$review_count,0,"");
$files = array();
if(is_dir(base_app.'uploads/package_'.$id)){
    $ofile = scandir(base_app.'uploads/package_'.$id);
    foreach($ofile as $img){
        if(in_array($img,array('.','..')))
        continue;
        $files[] = validate_image('uploads/package_'.$id.'/'.$img);
    }
}
}
?>

<!-- 
    The code is a PHP template for a tour detail page that displays information about a tour, 
    including images, ratings, cost, and reviews. The page layout consists of two columns. The 
    left column displays a carousel of tour images and information about ratings and cost. The 
    right column displays the tour's title, location, description, and reviews.

    The PHP code is used to dynamically generate the HTML elements using data from the database.
    A foreach loop is used to iterate through an array of images and create a carousel item for 
    each image. The $rate variable is used to dynamically set the checked state of the rating stars.

    Overall, this code provides a dynamic and informative way to display tour information and allow 
    users to book tours.
-->

<section class="page-section">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
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
                <div class="w-100">
                    <hr class="border-warning">
                    <h5>Ratings (<?php echo $review_count ?>)</h5>
                    <div>
                        <div class="stars">
                                <input disabled class="star star-5" id="star-5" type="radio" name="star" <?php echo $rate == 5 ? "checked" : '' ?>/> <label class="star star-5" for="star-5"></label> 
                                <input disabled class="star star-4" id="star-4" type="radio" name="star" <?php echo $rate == 4 ? "checked" : '' ?>/> <label class="star star-4" for="star-4"></label> 
                                <input disabled class="star star-3" id="star-3" type="radio" name="star" <?php echo $rate == 3 ? "checked" : '' ?>/> <label class="star star-3" for="star-3"></label> 
                                <input disabled class="star star-2" id="star-2" type="radio" name="star" <?php echo $rate == 2 ? "checked" : '' ?>/> <label class="star star-2" for="star-2"></label> 
                                <input disabled class="star star-1" id="star-1" type="radio" name="star" <?php echo $rate == 1 ? "checked" : '' ?>/> <label class="star star-1" for="star-1"></label> 
                        </div>
                    </div>
                    <hr>
                    <div class="w-100 d-flex justify-content-between">
                        <span class="rounded-0 btn-flat btn-sm btn-primary d-flex align-items-center  justify-content-between"><i class="fa fa-tag"></i> <span class="ml-1"><?php echo number_format($cost) ?></span></span>
                        <button class="btn btn-flat btn-warning" type="button" id="book">Book Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <h3><?php echo $title ?></h3>
                <hr class="border-warning">
                <small class='text-muted'>Location: <?php echo $tour_location ?></small>
                <h4>Details</h4>
                <div><?php echo stripslashes(html_entity_decode($description)) ?></div>
                <hr>
                <h5>Reviews (<?php echo count($feed) ?>)</h5>
                <hr class="border-primary">
                <?php foreach($feed as $r): ?>
                <div class="w-100 d-flex justify-content-between  align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="<?php echo validate_image('assets/img/user.jpg') ?>" class="border mr-3 review-user-avatar" alt="">
                        <span><?php echo $r['name'] ?></span>
                    </div>
                    <span class='text-muted'><?php echo date("Y-m-d H:i A",strtotime($r['date_created'])) ?></span>
                </div>
                <div class="w-100 review-feedback">
                    <?php echo $r['review'] ?>
                </div>
                <hr class='border-light'>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<!-- 

    This script is a jQuery function that listens for a click event on 
    the element with the id "book". When clicked, it checks if the user 
    is logged in by getting the user ID from the PHP variable $_settings->userdata('id'). 
    If the user is logged in (ID greater than 0), it opens a modal dialog window with the 
    title "Book Info" and loads the "book_form.php" page with the package ID passed as a 
    GET parameter. If the user is not logged in, it opens a modal dialog window with no 
    title and loads the "login.php" page with a large size.

-->
<script>
    $(function(){
        $('#book').click(function(){
            if("<?php echo $_settings->userdata('id') ?>" > 0)
                uni_modal("Book Info","book_form.php?package_id=<?php echo $id ?>");
            else
                uni_modal("","login.php","large");
        })
    })
</script>