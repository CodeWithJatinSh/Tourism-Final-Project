<style>
    /* This selector is commonly used to hide a modal footer element in a popup dialog box or modal window.*/
    #uni_modal .modal-content>.modal-footer{
        display:none;
    }
</style>

<!-- 

    The form has an action attribute set to an empty string, indicating 
    that it will submit to the current URL. It also has an input element 
    with a name attribute set to "package_id" and a type attribute set to 
    "hidden", which holds a value passed from the previous page via a GET request.

    Inside the form element, there are two form-group elements that contain a label 
    and an input or textarea element. The first form-group contains a set of five radio 
    buttons styled as stars, which allow the user to rate a package from 1 to 5. The 
    second form-group contains a textarea element for the user to leave feedback about 
    the package.

-->

<div class="container-fluid">
    <form action="" id="rate-review">
            <input name="package_id" type="hidden" value="<?php echo $_GET['id'] ?>" >
        <div class="form-group">
            <label for="" class="control-label">Rate</label>
            <div class="stars">
                    <input value="5" class="star star-5" id="star-5" type="radio" name="rate" /> <label class="star star-5" for="star-5"></label> 
                    <input value="4" class="star star-4" id="star-4" type="radio" name="rate" /> <label class="star star-4" for="star-4"></label> 
                    <input value="3" class="star star-3" id="star-3" type="radio" name="rate" /> <label class="star star-3" for="star-3"></label> 
                    <input value="2" class="star star-2" id="star-2" type="radio" name="rate" /> <label class="star star-2" for="star-2"></label> 
                    <input value="1" class="star star-1" id="star-1" type="radio" name="rate" checked/> <label class="star star-1" for="star-1"></label> 
            </div>
        </div>
        <div class="form-group">
            <label for="review" class="control-label">Feedback</label>
            <textarea name="review" id="review" cols="30" rows="10" class="form form-control summernote"></textarea>
        </div>

    </form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Submit</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
</div>
<script>
    $(function(){
        $('#rate-review').submit(function(e){
            e.preventDefault();
            start_loader()
            $.ajax({
                url:_base_url_+"classes/Master.php?f=rate_review",
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
                        alert_toast("Rate and Review Successfully submitted.")
                        setTimeout(() => {
                                location.reload()
                        }, 1500);
                    }else{
                        console.log(resp)
                        alert_toast("an error occured",'error')
                    end_loader()
                    }
                }
            })
        })
        $('.summernote').summernote({
		        height: 200,
		        toolbar: [
		            [ 'style', [ 'style' ] ],
		            [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
		            [ 'fontname', [ 'fontname' ] ],
		            [ 'fontsize', [ 'fontsize' ] ],
		            [ 'color', [ 'color' ] ],
		            [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
		            [ 'table', [ 'table' ] ],
		            [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
		        ]
		    })
    })
</script>

<!-- 

    This script is written in JavaScript and uses jQuery library. 
    It defines an event handler for the form with an ID of rate-review 
    when it is submitted.

    Inside the event handler, it first prevents the default behavior of the 
    form submission using e.preventDefault(), and then starts a loader using 
    the start_loader() function.

    It then sends an AJAX request to a PHP script named Master.php using the 
    $.ajax() method. The data to be sent is serialized using $(this).serialize(), 
    which refers to the form that triggered the event. The data type of the response 
    is set to JSON using dataType:"json".

    If the AJAX request is successful and the response is an object with a status of 
    "success", it shows a success message using the alert_toast() function, which is 
    defined elsewhere in the code. It also reloads the page after a delay of 1500 milliseconds 
    using the setTimeout() method.

    If the AJAX request fails or the response does not have a status of "success", it shows 
    an error message using alert_toast() and ends the loader using the end_loader() function.

    Finally, it initializes the Summernote plugin for all elements with a class of summernote, 
    which is a WYSIWYG editor for HTML and text. It sets the height of the editor to 200 pixels 
    and specifies the toolbar options.

-->