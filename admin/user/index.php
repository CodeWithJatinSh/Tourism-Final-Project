<!-- 
	The code starts by defining a variable called $user which contains 
	a MySQL query to select all data from the "users" table where the 
	"id" column matches the ID of the currently logged-in user.

    Next, the code uses a foreach loop to fetch the results of the 
	MySQL query and assign each key-value pair to a new array called 
	$meta. The fetch_array() method retrieves the result set as an 
	associative array, and the loop assigns each key-value pair to 
	the $meta array.

    The purpose of this code appears to be to retrieve and store 
	user data from a MySQL database into a PHP array for further 
	use in the code.

	<=====Summary=====>
	This code selects user data from a MySQL database based on 
	the ID of the currently logged-in user and stores the data 
	in a PHP array called $meta. The purpose of this code is to 
	retrieve and store user data for further use in the code.
-->
<?php 
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
?>
<?php 
/*
This code checks if a flash message named "success" exists in 
the $_settings variable in PHP. If it does, the code inside the 
if statement is executed, likely to display a success message 
to the user 
*/
if($_settings->chk_flashdata('success')): 
?>

<!-- 
	The purpose of this code is to display a success message to the 
	user in a pop-up alert or toast message after they've completed 
	an action on a web page.
-->
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<!-- 
	This is a HTML code for a form, which is enclosed in a 
	card element with a blue outline and header.

    The form is used for updating user profile information 
	and consists of several input fields such as First Name, 
	Last Name, Username, Password, and an Avatar.

    The values of the input fields are pre-populated with the 
	user's existing profile information, retrieved using the 
	$_settings variable. If the user has not provided any 
	information, the fields will be left blank.

    There is also an image upload field and a preview of the 
	uploaded image. The form has a submit button with the 
	label "Update". When the user clicks the button, the form 
	is submitted to the server for processing.

              <===Summary===>
    The purpose of this code is to provide a user-friendly interface 
	for updating user profile information and to allow users to upload 
	an avatar image.
-->
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo $_settings->userdata('id') ?>">
				<div class="form-group">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
					<small><i>Leave this blank if you dont want to change the password.</i></small>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<!-- 
	2 Functions performed in this script 

	This script contains two functions. The first function, displayImg(), 
	is triggered when an image is selected by the user. It reads the 
	selected image file and displays it on the webpage.

    The second function, which is triggered when the form with id "manage-user" 
	is submitted, prevents the default form submission behavior, starts a loading 
	spinner, and sends an AJAX request to a PHP script to save the form data. If 
	the PHP script returns a value of 1, the page is reloaded. If the PHP script 
	returns any other value, an error message is displayed and the loading spinner 
	is stopped.
-->
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					location.reload()
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					end_loader()
				}
			}
		})
	})

</script>