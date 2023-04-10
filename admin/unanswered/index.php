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
	This code is an HTML and PHP code snippet that generates a card element 
	that displays a list of unanswered questions. The code starts with a div 
	element with class card card-outline card-primary, which defines a Bootstrap 
	card with an outlined border and a blue primary color. Inside this div, there 
	are two child elements: a div element with class card-header, which contains 
	a h3 element with the text "List of Unanswered Questions", and a div element 
	with class card-body, which contains a container-fluid class and a table 
	element.

    The table element has four columns, defined using colgroup and col tags, and 
	a header row with four cells containing the text "#", "Question", "Total Who Asks", 
	and "Action". The table body is populated dynamically using PHP to retrieve data 
	from the database. For each row in the result set, a new tr element is generated, 
	containing cells with the question number, the question text, the total number of 
	users who have asked the question, and a dropdown menu that provides two actions: 
	create a response and delete the question. The dropdown menu is implemented using 
	Bootstrap's dropdown-menu class and includes a div element with class dropdown-divider 
	to separate the two actions. The delete button has a class delete_data and a data-id 
	attribute that specifies the ID of the question to be deleted.

	<===Summary===>
	This code creates a Bootstrap card that displays a table of unanswered 
	questions. The table has four columns for question number, question text, 
	number of times it has been asked, and an action column with a dropdown 
	menu to create a response or delete the question. The data for the table 
	is fetched from a MySQL database using PHP.
-->
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Unanswered Questions</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped">
				<colgroup>
					<col width="15%">
					<col width="40%">
					<col width="25%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Question</th>
						<th>Total Who Asks</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `unanswered`  order by question asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['question'] ?></td>
							<td class="text-center"><?php echo number_format($row['no_asks']) ?></td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item" href="?page=responses/manage&q=<?php echo $row['question'] ?>"><span class="fa fa-edit text-primary"></span> Create Response</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- 
	This is a JavaScript code that performs the following tasks:

1.)	When the document is ready, it adds a click event listener to all elements 
	with the class "delete_data". When an element with this class is clicked, 
	it displays a confirmation message using the _conf function and passes the 
	ID of the data to be deleted to the "delete_question" function.

2.) It initializes a data table for all tables with the class "table".

3.) The "delete_question" function is called when a confirmation message is accepted. 
	It sends an AJAX request to the server to delete the data with the specified ID 
	using the "delete_unanswer" function in the "Master" class. If the deletion is 
	successful, the page is reloaded. If not, an error message is displayed using the 
	alert_toast function.
-->
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this data?","delete_question",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_question($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_unanswer",
			method:"POST",
			data:{id: $id},
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>