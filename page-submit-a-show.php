<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type = "text/javascript">
	$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //init text box count
    
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input class = "bandinp" type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div><br><br>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
       e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
	
</script>

<p>
<h4><br><br><br></h4>


	<?php
	
	//on submit 
	if(isset($_POST['submit'])){
		echo $_POST["mytext"][0];
		//error checking: make sure inputs are in xx form for date
		$in_month;
		$in_day;
		$in_hour;
		$in_min;
		if(isset($_POST['form_month'])){
			$in_month = $_POST['form_month'];
		} else {
			$error = "Input month";
		}

		if(isset($_POST['form_day'])){
			$in_day = $_POST['form_day'];
			if($in_day == '31'){ //01 03 05 07
 				if($in_month == "02" || $in_month == "04" || $in_month == "06" || $in_month == "09" || $in_month == "11"){
 					$error = "Invalid date";
 					return $error;
 				}
			}
		} else {
			$error = "Input day";
		}

		if(isset($_POST['form_hour'])){
				$in_hour = $_POST['form_hour'];
				if($_POST['ampm'] == "2"){
					$in_hour= $in_hour+12;
				}
		} else {
			$error = "Input hour";
		}

		if(isset($_POST['form_min'])){
			$in_min = $_POST['form_min'];
		} else {
			$error = "Input minute";
		}
		$count = 0;
		if(isset($_POST["mytext"])){
			$count = count($_POST["mytext"]);
		} else {

		}


		//post creation 
		$post = array(
			'post_type' => 'post',
			'post_title' => 'post',
			'post_content' => 'filler'
		);

		$wp_error = true;
		$postid = wp_insert_post($post, $wp_error);
		echo $postid;

		if(is_wp_error($postid)){
			$errors = $postid->get_error_messages();
			foreach($errors as $error){
				echo $error;
			}
		}

		$t = "";

		$temp = "";
		if(isset($_POST['location'])){
			$temp = $_POST['location'];
		}

		$update = array(
			'ID' => $postid,
			'post_title' => $temp
		);

		echo $update['ID'];
		echo $update['post_title'];

		$stot = 0;

		//create str for strtotime func

		if( isset($_POST['form_month']) && isset($_POST['form_day']) && isset($_POST['form_hour']) && isset($_POST['form_min'])){
			$t = $_POST['form_month'] . "/" . $_POST['form_day'] . "/2017 " . $in_hour  . ":" . $_POST['form_min'] . ":00";
			echo $t . "<br\>";
			$stot = strtotime($t);
			echo $stot;
		}


		//fields & post update
		update_field('time', $stot, $update['ID']);
		update_field('bands', "filler", $update['ID']);
		update_field('location', $temp, $update['ID']);

		$i = 0;
		echo "  " . $count . " count <h4><br><br><br><br></h4> ";
		while($i < $count){
			//add bands from mytext arr
			echo $_POST["mytext"][$i] . "<h4><br><br><br></h4>";
			
			$row = array(
				'field_595407b7c5447' => $_POST["mytext"][$i],
				'field_59550ff469dd7' => $i
			
			);

			echo $row['field_595407b7c5447'] . " added to row";
			$a = add_row('field_59540768c5446', $row, $update['ID']);
			echo $a . ": a <h4><br><br></h4>";
			$i++;
		}
		


		$didyou =	wp_update_post($update, true);
		if(is_wp_error($didyou)){
			$errors = $didyou->get_error_messages();
			foreach($errors as $error){
				echo $error;
			}
		}
	}

	?>
</p>

<?php
get_header(); 
?>



<div class = "outer">
<div class="respond">

  <form action="" method="post">
	   <h3 class = formWord >LOCATION:</h3>
	   <input class = "locinp" type = "text" name = "location" required value="<?php if(isset($_POST['location'])){ echo $_POST['location'];}?>">
	   	<h3 class = formWord> DATE: </h3>	
	   <select name = "form_month" required>
		   	<option value = "01"> Jan </option>
		   	<option value = "02"> Feb </option>
		   	<option value = "03"> Mar </option>
		   	<option value = "04"> Apr </option>
		   	<option value = "05"> May </option>
		   	<option value = "06"> Jun </option>
		   	<option value = "07"> Jul </option>
		   	<option value = "08"> Aug </option>
			<option value = "09"> Sep </option>
			<option value = "10"> Oct </option>
			<option value = "11"> Nov </option>
			<option value = "12"> Dec </option>
	   </select>

	   <select name = "form_day" required>
		   	<option value = "01"> 01 </option>
		   	<option value = "02"> 02 </option>
		   	<option value = "03"> 03 </option>
		   	<option value = "04"> 04 </option>
		   	<option value = "05"> 05 </option>
		   	<option value = "06"> 06 </option>
		   	<option value = "07"> 07 </option>
		   	<option value = "08"> 08 </option>
			<option value = "09"> 09 </option>
			<option value = "10"> 10 </option>
			<option value = "11"> 11 </option>
			<option value = "12"> 12 </option>
			<option value = "13"> 13 </option>
		   	<option value = "14"> 14 </option>
		   	<option value = "15"> 15 </option>
		   	<option value = "16"> 16 </option>
		   	<option value = "17"> 17 </option>
		   	<option value = "18"> 18 </option>
		   	<option value = "19"> 19 </option>
		   	<option value = "20"> 20 </option>
			<option value = "21"> 21 </option>
			<option value = "22"> 22 </option>
			<option value = "23"> 23 </option>
			<option value = "24"> 24 </option>
			<option value = "25"> 25 </option>
		   	<option value = "26"> 26 </option>
		   	<option value = "27"> 27 </option>
		   	<option value = "28"> 28 </option>
		   	<option value = "29"> 29 </option>
		   	<option value = "30"> 30 </option>
		   	<option value = "31"> 31 </option>

	   </select>

	  	<h3 class = formWord> TIME: </h3>	   
	  	<select name = "form_hour" required>
		   	<option value = "01"> 01 </option>
		   	<option value = "02"> 02 </option>
		   	<option value = "03"> 03 </option>
		   	<option value = "04"> 04 </option>
		   	<option value = "05"> 05 </option>
		   	<option value = "06"> 06 </option>
		   	<option value = "07"> 07 </option>
		   	<option value = "08"> 08 </option>
			<option value = "09"> 09 </option>
			<option value = "10"> 10 </option>
			<option value = "11"> 11 </option>
			<option value = "12"> 12 </option>
	   </select>

	   <select name = "form_min" required>
		   	<option value = "00"> 00 </option>
		   	<option value = "15"> 15 </option>
		   	<option value = "30"> 30 </option>
		   	<option value = "45"> 45 </option>
	   </select>

	   <select name ="ampm" required>
		   <option value = "1"> AM </option>
		   <option value = "2"> PM </option>
	   </select>


	   <h5></h5>

	 <!--  <input type ="text" name = "form_month" required value="<?php if(isset($_POST['form_month'])){ echo $_POST['form_month'];}?>">
	   Day:
	   <input type = "text" name = "form_day" required value="<?php if(isset($_POST['form_day'])){ echo $_POST['form_day'];}?>">
	   Hour:
	   <input type = "text" name = "form_hour" required value="<?php if(isset($_POST['form_hour'])){ echo $_POST['form_hour'];}?>">
	   Minutes:
	   <input type = "text" name = "form_min" required value="<?php if(isset($_POST['form_min'])){ echo $_POST['form_min'];}?>"> -->
	 

	  <div class="input_fields_wrap">
    		<button class="add_field_button">Add Bands</button><br><br>
    		<div><input class = "bandinp" type="text" name="mytext[]"></div><br><br>
		</div>

	  <input type="submit" name="submit" /> 
 
  </form>
</div>
</div>

<?php get_footer();
?>