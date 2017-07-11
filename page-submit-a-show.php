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
            $(wrapper).append('<div> <div> <h4 class = formWord> BAND: </h4> <input class = "bandinp" type="text" name="bands[]"/></div> <div><h4 class = formWord> BANDCAMP: </h4><input class = "sitesinp" type="url" name="sites[]"/><input class = "check" type="checkbox" name="siteopt" value="bandcamp"> Bandcamp <input type="checkbox" name="siteopt" value="Soundcloud"> Soundcloud <h5></h5></div>  <a href="#" class="remove_field">x</a> <h5></h5> </div>'); //add input box
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

	require('simple_html_dom.php');

	//on submit 
	if(isset($_POST['submit'])){
	//	echo $_POST["bands"][0];
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
		if(isset($_POST["bandsinp"])){
			$count = count($_POST["bandsinp"]);
		} else {

		}
		$sitecount;
		if(isset($_POST["sitesinp"])){
			$sitecount = count($_POST["sitesinp"]);
			echo $sitecount . "  sites";
		} else {

		}
		
		//error check for bandcamp site: make sure site is bandcamp 


		//post creation 
		$post = array(
			'post_type' => 'post',
			'post_title' => 'post',
			'post_content' => 'filler'
		);

		$wp_error = true;
		$postid = wp_insert_post($post, $wp_error);
	//	echo $postid;

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

	//	echo $update['ID'];
	//	echo $update['post_title'];

		$stot = 0;

		//create str for strtotime func

		if( isset($_POST['form_month']) && isset($_POST['form_day']) && isset($_POST['form_hour']) && isset($_POST['form_min'])){
			$t = $_POST['form_month'] . "/" . $_POST['form_day'] . "/2017 " . $in_hour  . ":" . $_POST['form_min'] . ":00";
			//echo $t . "<br\>";
			$stot = strtotime($t);
		//	echo $stot;
		}



		//fields & post update
		update_field('time', $stot, $update['ID']);
		update_field('bands', "filler", $update['ID']);
		update_field('location', $temp, $update['ID']);

		$i = 0;
		echo "  " . $count . " count <h4><br><br><br><br></h4> ";
		while($i < $count){
			//add bands from bands arr
			echo $_POST["bandsinp"][$i] . "<h4><br><br><br></h4>";
			
			$row = array(
				'field_595407b7c5447' => $_POST["bandsinp"][$i],
				'field_59550ff469dd7' => $i
			
			);

			echo $row['field_595407b7c5447'] . " added to row ";
			$a = add_row('field_59540768c5446', $row, $update['ID']);
			echo $a . ": a <h4><br><br></h4>";


			//getting embed data 
		echo  $_POST["sitesinp"][$i] . " url <h3><br></h3>";
		$site = $_POST["sitesinp"][$i];
		trim($site);
		$html = file_get_html($site);
		$embedurl = $html->find("meta[property='og:video']",0)->content;
		echo "embed url:" . $embedurl . "<br>";
		$bandalbum = $html->find("meta[name='title']",0)->content;
		echo $bandalbum . "<br>";
		$href =  $html->find("a[class='thumbthumb']",0)->href;
		echo $href . "<h3><br></h3>";
		$url = $html->find("meta[property='og:url']",0)->content;
		$url = $url . $href;
		echo $url . "<h3><br></h3>";
		$pos = strpos($embedurl, "album=", 0);
		$albumid = substr($embedurl, $pos+6, 10);
		echo " id " . $albumid;


		$content = '<iframe style="border: 0; width: 200px; height: 200px;" src="https://bandcamp.com/EmbeddedPlayer/album='.$albumid . '/size=large/bgcol=ffffff/linkcol=0687f5/minimal=true/transparent=true/" seamless><a href="' . $url . '">' . $bandalbum .'</a></iframe>';
		echo "<br>".$content;

		$post = array(
			'ID' => $update['ID'],
			'post_content' => $content
		);

		wp_update_post($post);
			
			$i++;
		}
		
		wp_set_post_tags($update['ID'], $_POST["bandsinp"], true);
		wp_set_post_tags($update['ID'], $_POST["location"], true);

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
  	<input type="hidden" name="redirect" value="/submission" />
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
    		<button class="add_field_button">ADD BANDS</button><br><br>
    		<div> 	<h4 class = formWord> BAND: </h4>	  <input class = "bandinp" type="text" name="bandsinp[]"></div> 
    		<div> 	<h4 class = formWord> BAND SITE: </h4> <div class="tooltip">?<span class="tooltiptext">Not bandcamp or soundcloud? Just leave the empty value.</span></div> <p></p>	  <input class = "sitesinp" type="url" name="sitesinp[]" value = "Empty">  <input class = "check" type="radio" name="siteopt" value="bandcamp"> Bandcamp <input type="radio" class = "check" name="siteopt" value="Soundcloud"> Soundcloud<br><p></p></div>
		</div>

	  <input class = "submit" type="submit" name="submit" /> 
 
  </form>
</div>
</div>

<?php get_footer();
?>