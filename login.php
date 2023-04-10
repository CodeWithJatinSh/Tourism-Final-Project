<!--
    This is a CSS code that hides the footer and header of a modal window with the ID "uni_modal".
    by setting the display property at none
-->

<style>
    #uni_modal .modal-content>.modal-footer,#uni_modal .modal-content>.modal-header{
        display:none;
    }
</style>

<!--    
    This code is HTML and it defines a modal with two tabs, one for login and another for registration.

    The outermost tag is a div with the class container-fluid, which is a Bootstrap class for a full-width 
    container that fills the width of the screen.

    Inside this div, there are two child divs, both with the class row. Each of these divs contains a form for 
    login or registration.

    The first form is for login and it has two input fields, one for the username and one for the password. 
    The form has an id of "login-form" and a submit button with the text "Login".

    The second form is for registration and it has four input fields, one for the first name, one for the last name, 
    one for the username, and one for the password. The form has an id of "registration" and a submit button with the text "Register".

    The code also includes some Bootstrap classes for styling the elements, such as col-lg-5 and col-lg-7 to 
    specify the column width for the two divs and form-control to style the input fields.

    In addition, the code also includes a close button with an "x" symbol to close the modal. This button has a 
    class of "close" and it is associated with the data-dismiss="modal" attribute, which specifies that it should 
    close the modal when clicked.
-->
<div class="container-fluid">
    <h3 class="float-left">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </h3>
    <div class="row">
        <div class="col-lg-5 border-right">
            <h3 class="text-center">Login</h3>
            <hr>
            <form action="" id="login-form">
                <div class="form-group">
                    <label for="" class="control-label">Username</label>
                    <input type="text" class="form-control form" name="username" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button class="btn btn-primary btn-flat">Login</button>
                </div>
            </form>
        </div>
        <div class="col-lg-7">
        <h3 class="text-center">Create New Account</h3>
        <hr class='border-primary'>
            <form action="" id="registration">
                <div class="form-group">
                    <label for="" class="control-label">Firstname</label>
                    <input type="text" class="form-control form-control-sm form" name="firstname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Lastname</label>
                    <input type="text" class="form-control form-control-sm form" name="lastname" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Username</label>
                    <input type="text" class="form-control form-control-sm form" name="username" required>
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Password</label>
                    <input type="password" class="form-control form-control-sm form" name="password" required>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button class="btn btn-primary btn-flat">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--
When a form is submitted, the script prevents the default form submission behavior, sends an AJAX 
request to the server with the form data, and then processes the response.

If the response is successful, a success message is displayed and the page is reloaded after a delay. 
If the response contains an error message, an error message is displayed on the form. If the response 
is not successful or does not contain a message, an error message is displayed.

The script also includes functions to start and end a loading spinner, and to display alert messages.
-->
<script>
    $(function(){
        $('#registration').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Master.php?f=register",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Account succesfully registered",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text(resp.msg)
                        $('#registration').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
        $('#login-form').submit(function(e){
            e.preventDefault();
            start_loader()
            if($('.err-msg').length > 0)
                $('.err-msg').remove();
            $.ajax({
                url:_base_url_+"classes/Login.php?f=login_user",
                method:"POST",
                data:$(this).serialize(),
                dataType:"json",
                error:err=>{
                    console.log(err)
                    alert_toast("an error occured",'error')
                    end_loader()
                },
                success:function(resp){
                    if(typeof resp == 'object' && resp.status == 'success'){
                        alert_toast("Login Successfully",'success')
                        setTimeout(function(){
                            location.reload()
                        },2000)
                    }else if(resp.status == 'incorrect'){
                        var _err_el = $('<div>')
                            _err_el.addClass("alert alert-danger err-msg").text("Incorrect Credentials.")
                        $('#login-form').prepend(_err_el)
                        end_loader()
                        
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                        end_loader()
                    }
                }
            })
        })
    })
</script>