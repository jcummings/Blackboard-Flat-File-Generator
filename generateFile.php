
	    <p>
	    <b>What does this application do?</b><br/>
	    By default, courses created using the section_XXXXXX.xml file generated from Banner do not associate start and end dates and duration with a given term. This application very simply takes that XML, and uses it to generate a properly formatted Snapshot Feed File that can then be used to change all courses associated with a given term to use term duration and availability.
	    </p>
	    <b>What do I do with the file?</b><br/>
	    Once you have the flat file, you need to create an SIS Integration in Blackboard of type "Flat Feed File" and associate it to the data source within Blackboard that contains the courses you want to modify. You can then upload the feed file this application generates directly to that integration to change the course availability and duration to match the term.
	    </p>	  
	    <b>How do I test this to see what it does?</b><br/>
	    You can enter "section_example.xml" in the section file field, 201304 in the term field, and text.txt in the output file field to see what is generated. Note that the sample XML contains only a single course, but this application will work with any size section.xml file.
	    </p>  
	    </div>
	    
		<?php if($_GET["action"] != "createfile"){ ?>
		<form name="bbfilegenerator" method="post" action="bb.php?action=createfile">
			Name of the Section XML file (must be in the same directory as this script): <input type="text" name="filename"><br/>
			Term that you want to use for availability (format 201304, 201305, etc.) <input type="text" name="term"><br/>
			What name would you like to give the flat file output? <input type="text" name="flatfilename"><br/>
			<input type="submit">
		</form>
		<?php } ?>
		<?php
		if($_GET["action"] == "createfile"){
			//echo "Please wait. Creating your file. This might take a few moments.....<br/>";
			$bb_flat_file = $_POST["flatfilename"];
			$xml = simplexml_load_file($_POST["filename"]);
			$term = $_POST["term"];
			$startrow = 0;
			
			$course = $xml->group;

			$fh = fopen($bb_flat_file, 'w') or die("can't open file");
			fwrite($fh,"EXTERNAL_COURSE_KEY|COURSE_ID|COURSE_NAME|DURATION|TERM_KEY|AVAILABLE_IND|USE_TERM_AVAILABILITY_IND" . "\n");
			foreach ($course as $i) {
				if($startrow != 0){
					fwrite($fh,$i->sourcedid->id . "|" . $i->sourcedid->id . "|" . $i->description->long . "|TERM|" . $term . "|TERM|Y" . "\n");
				}
				$startrow++;
			}
			fclose($fh);
			echo "You can download your file by right clicking and 'saving as' <a href=".$bb_flat_file.">this link.</a>";
			echo $course;
		}
		?>
 
