#What is this code for - why would I need it?

Admittedly, it’s a very niche use case. If you’re a school that is using Blackboard’s Learn 9.1 LMS, and you’re importing course or section data from a Banner SIS, you may find that you have a need to change the courses after the initial load to set them all to use availability and duration settings that match the term that you’ve defined. 

You can do this in the GUI for one course at a time - but not in bulk. You *can* do it in bulk via the Snapshot Feed File, but generating that file after you’ve already generated and loaded the XML can be a pain in the neck if you’re trying to do it manually. 

This code takes your course or section feed file, parses the XML, pulls out your course nodes, and generates a properly formatted Snapshot Feed File that will set those courses to use the term availability and term duration for whatever term you specify when you run the code.

# How do I use this file?

The usage should be pretty self-explanatory, but basically there are three things that you need to do.

1. Put the “generateFile.php” file somewhere in the web root on a sever capable of executing PHP files.
2. Put the XML file for your course (or sections if you have multiple sections per course) in the same directory as the PHP file.
3. Call the “generateFile.php” URL in a browser, fill out the form and click submit.

#What type of SIS XML does this code work with?

I wrote the code for our specific environment, which (at the time of writing) was Blackboard Learn 9.1 and XML comming out of a Banner SIS in IMS Enterprise Vista 1.1 format.

That being said, it should be fairly simple to modify the code to grab data from whatever type of XML you’re outputting. 

To make it work for any type of XML, just remember:

1. the $xml->group node in the code represents the root node of each course. 
2. I set the loop iterator to 0 on run, and only output a new line if the iteration is not equat to 0 to avoid generating an unnecessary line for a group element that serves as a header in IMS Enterprise Vista 1.1 XML. This may not be necessary in your enironment.
3. I’m assuming (in the form hints) that you’re using the same sort of term nomenclature that we are (201301, 201302, 201303, etc.). You may need to adjust for your environment.

#What do I do with the resulting file?

Set up a pipe delimited snapshot flat file integration in Bb Learn, and point it to the same data source that the courses you are modifying is using.

Upload the resulting file to that integration, making sure you’ve set the type to “Course” and that you’re using the “Store” method. 

Once you’ve done this, you should be good to go.