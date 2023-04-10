    
</section>
<!-- 

This is a section of HTML and PHP code that displays a table of booked packages for the currently logged-in user.

The section starts with a container div with a heading "Booked Packages" 
and a button to manage the user's account.

A horizontal line is displayed using the hr HTML tag.

A table is displayed with columns for package number, date and time of 
booking, package title, schedule date, status, and action.

** The PHP code retrieves the booked packages data for the currently 
logged-in user from the database and displays it in the table using 
a while loop.**
The if-else statement in the PHP code checks the status of each package 
and displays the appropriate badge.

A dropdown menu with options to edit, submit a review, or cancel the package 
booking is displayed in the "Action" column of the table.

The class attribute of some HTML elements is used for styling, while the data-id 
attribute is used to store the package ID and to trigger JavaScript functions when clicked.

-->
<section class="page-section">
    <div class="container">
    <div class="w-100 justify-content-between d-flex">
        <h4><b>Booked Packages</b></h4>
        <a href="./?page=edit_account" class="btn btn btn-primary btn-flat"><div class="fa fa-user-cog"></div> Manage Account</a>
    </div>
        <hr class="border-warning">
        <table class="table table-stripped text-dark">
            <colgroup>
                <col width="5%">
                <col width="10">
                <col width="25">
                <col width="25">
                <col width="15">
                <col width="10">
            </colgroup>
            <thead>
                <tr>
                    <th>#</th>
                    <th>DateTime</th>
                    <th>Package</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i=1;
                    $qry = $conn->query("SELECT b.*,p.title FROM book_list b inner join `packages` p on p.id = b.package_id where b.user_id ='".$_settings->userdata('id')."' order by date(b.date_created) desc ");
                    while($row= $qry->fetch_assoc()):
                        $review = $conn->query("SELECT * FROM `rate_review` where package_id='{$row['id']}' and user_id = ".$_settings->userdata('id'))->num_rows;
                ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                        <td><?php echo $row['title'] ?></td>
                        <td><?php echo date("Y-m-d",strtotime($row['schedule'])) ?></td>
                        <td class="text-center">
                            <?php if($row['status'] == 0): ?>
                                <span class="badge badge-warning">Pending</span>
                            <?php elseif($row['status'] == 1): ?>
                                <span class="badge badge-primary">Confirmed</span>
                            <?php elseif($row['status'] == 2): ?>
                                <span class="badge badge-danger">Cancelled</span>
                            <?php elseif($row['status'] == 3): ?>
                                <span class="badge badge-success">Done</span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                                <button type="button" class="btn btn-flat btn-default border btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Edit</a>
                                <?php if($row['status'] == 3 && $review <= 0): ?>
                                    <a class="dropdown-item submit_review" href="javascript:void(0)" data-id="<?php echo $row['package_id'] ?>">Submit Review</a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item cancel_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>">Cancel</a>
                                </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    function cancel_book($id){
        start_loader()
        $.ajax({
            url:_base_url_+"classes/Master.php?f=update_book_status",
            method:"POST",
            data:{id:$id,status:2},
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("an error occured",'error')
                end_loader()
            },
            success:function(resp){
                if(typeof resp == 'object' && resp.status == 'success'){
                    alert_toast("Book cancelled successfully",'success')
                    setTimeout(function(){
                        location.reload()
                    },2000)
                }else{
                    console.log(resp)
                    alert_toast("an error occured",'error')
                }
                end_loader()
            }
        })
    }
    $(function(){
        $('.cancel_data').click(function(){
            _conf("Are you sure to cancel this booking?","cancel_book",[$(this).data('id')])
        })
        $('.submit_review').click(function(){
            uni_modal("Rate & Feedback","./rate_review.php?id="+$(this).data('id'),'mid-large')
        })
        $('table').dataTable();
    })
</script>
<!-- 
    
    This script contains a function to cancel a booking using AJAX and a few event listeners.

    The cancel_book() function is called when a booking is to be cancelled. It sends an AJAX request 
    to Master.php passing the booking ID and a status of 2, which means cancelled. Upon success, 
    it displays a success message and reloads the page. Otherwise, it displays an error message.

    The event listeners are attached to the "Cancel" button and the "Submit Review" button. The "Cancel" 
    button, when clicked, prompts the user if they really want to cancel the booking. If confirmed, it 
    calls the cancel_book() function passing the booking ID.

    The "Submit Review" button, when clicked, opens a new modal window that contains a form for rating and 
    giving feedback about the package. The uni_modal() function is used to create the modal window and load 
    the form from rate_review.php.

    Lastly, the script initializes the jQuery DataTables plugin to make the table sortable and searchable.

-->





