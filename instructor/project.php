<?php
	$_GET['page']='Instructor Setup'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
    $classes=$database->getClasses($session->UID);//function from the database.php file - returns an array of all classes for the provided instructor
?>


<div class='left half'>
    <!-- start the form! -->
    <form id='newproj'  method='post' action='procnew.php' class='m-b-1em'>
        <input type='hidden' name='inst' value='<?php echo $session->UID;?>'/>
        <h1>Instructor Setup<img src='../img/help.png' title='help'/></h1>
        <div class='m-b-1em'>
            Class: <select name='class' id='class'>
                <option selected='selected'>Choose one...</option>
                <?php
                    foreach($classes as $class){
                        $id=$class['id'];
                        $name=$class['name'];
                        echo"<option value='$id'>$name</option>";
                    }
                ?>            
            </select>
        </div>
        <div class='m-b-1em'>
            <label for='pid'>Project ID</label>: <input type='text' id='pid' name='pid' placeholder='Insert project name.' />
            <div class='ui-state-error ui-corner-all' style='display:none;font-style:italic;padding:.1em;width:210px;' id='projname'><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>Project name already in use!</div>
        </div>
        <div class='m-b-1em'>
            <!-- <label for='numgroups'>Number of Groups</label>: <input id='numgroups' name='numgroups' type="number" value="2" size='4' min='2' /> -->
            <button id="add_tab" title='Add another group tab.'>Add Group</button>
        </div>
        <div class='whole clear m-b-1em'>
            <div id='groups' class='ui-corner-all'> <!-- this div contains the tabs -->
                <ul id='grouptabs'>
                    <li><a href="#groups-1" >Group 1</a><span class='ui-icon ui-icon-close right' title='Removing a group also removes any students added to the group.'>Remove Tab</span></li>
                    <li><a href="#groups-2">Group 2</a><span class='ui-icon ui-icon-close right' title='Removing a group also removes any students added to the group.'>Remove Tab</span></li>
                </ul>
                <div id='groups-1'>
                    <ul class='grouplist' id='gl1'>
                        <li class='placeholder' style='font-style:italic;font-weight:normal'>Add students here</li>
                    </ul>
                </div>
                <div id='groups-2'>
                    <ul class='grouplist' id='gl2'>
                        <li class='placeholder' style='font-style:italic;font-weight:normal'>Add students here</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class='m-b-1em'>
            Who is creating the contract? (instructor always has override privileges)
            <div class='buttonset' id='radioset1'>
                <input type="radio" name="contract" id='contract1' value="student" checked='checked' />
                <label for='contract1' title='Allow the students to create their own contract by consensus.'>Students</label>
                <input type="radio" name="contract" id='contract2' value="instructor" />
                <label for='contract2' title='Have the students abide by an instructor-created contract.'>Instructor</label>
            </div>
        </div>

        <div>
            Submit grades for (choose one):
            <div class='buttonset m-b-1em' id='radioset2'>
                <input type="radio" name="grades" id='grades1' value="subject" />
                <label for='grades1' title='Submit a grade for each student without grading them on their ability to peer review.'>Evaluatee only</label>
                <input type="radio" name="grades" id='grades2' value="judge" />
                <label for='grades2' title='Submit a grade for each student only on their ability to peer review.'>Evaluator only</label>
                <input type="radio" name="grades" id='grades3' value="both" checked='checked' />
                <label for='grades3' title='Give each student a separate grade for reviewing and being reviewed.'>Both</label>
                <input type="radio" name="grades" id='grades4' value="none" />
                <label for='grades4' title='No grades associated with Rate-Your-Mate'>None</label>
            </div>
        </div>
        <div  class='m-b-1em'>
            <label for='numeval'>How many evaluations? </label>
            <input id='numeval' name='numeval' type="number" value="2" size='4' min='0' style='display:inline' title='Grades will be averaged across all evaluations.'>
        </div>
        <div class='m-b-1em'>
            <label for='points'>How many points to distribute per evaluation? </label>
            <input id='points' name='points' type="number" value="2" size='4' min='0' style='display:inline' title="Decide on the 'points pool' that students have to divide between their teammates on evaluations.">&nbsp;
            <br/><span class='hidden' style='font-style: italic;' id='avgpnts'>(For your average group size, we recommend <span id='recpnt'>X</span>.)</span>
        </div>
        <div class='m-b-1em'>
            <label for="oDate" style='margin-right:1em;'>Open Date:</label><input type="date" name="oDate" id="oDate"><br />
            <label for="cDate" style='margin-right:1em;'>Close Date:</label><input type="date" name="cDate" id="cDate" style='margin-left:-2px;'><br />
        </div>
        <div class='m-b-1em'>
            Prevent Late Submissions:
            <div id='radioset3' class='buttonset m-b-1em'>
                <input type="radio" name="late" id="lateyes" value="yes" checked='checked' /><label for="lateyes">Yes</label>
                <input type="radio" name="late" id="lateno" value="no"/><label for="lateno">No</label>
            </div>
        </div>
        <input type='submit' name='createproj' id='createproj' value='Create project'>
    </form>
</div>
<div id='studentbox' class='right half ui-widget-content ui-corner-all' style='margin-top:274px;min-height:9em;'>
    student list goes here
</div>
<div id="dialog" title="Dialog Title">Dialog placeholder <!-- popup success dialog --> </div>
</body>
<script type='text/Javascript'> //Whee-jQuery! 
	$("input:submit, button").button();
	
    var spinner = $("#points, #numeval, #numgroups").spinner();
	
	$("#radioset1, #radioset2, #radioset3").buttonset();
	
    $('#oDate, #cDate').datetimepicker({timeFormat: 'hh:mm:ss',ampm: false});
	
    $(document).ready(function(){
        var tab_counter = 3;
        $("#dialog").dialog({autoOpen:false,title:"Project Creation"});//hides dialog to prepare for use as needed.
        // tabs init with a custom tab template and an "add" callback filling in the content
        var $tabs = $("#groups").tabs({
            tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close right' title='Removing a group also removes any students added to the group.'>Remove Tab</span></li>",
            add: function(event, ui){
                var tab_content = "<ul class='grouplist' id='gl"+tab_counter+"'><li class='placeholder' style='font-style:italic;font-weight:normal'>Add students here</li></ul>";
                $(ui.panel).append(tab_content);
            }
        });
		
        $(".grouplist").droppable({
            activeClass: "ui-state-highlight",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            drop: function(event,ui){
                $(this).find(".placeholder").remove();
                $("<li class='ui-state-highlight student' id='"+ui.draggable.attr('id')+"'>"+ui.draggable.html()+"&nbsp;<a href='#'>[x]</a></li>").appendTo(this);
                ui.draggable.css({display:'none'});
                avgPoints();
            }
        });

        // actual addTab function: adds new tab using the title input from the form above
        function addTab(){
            var tab_title = "Group " + tab_counter;
            $tabs.tabs("add", "#groups-" + tab_counter, tab_title);
            $(".grouplist").droppable({
                activeClass: "ui-state-highlight",
                hoverClass: "ui-state-hover",
                accept: ":not(.ui-sortable-helper)",
                drop: function(event,ui){
                    $(this).find(".placeholder").remove();
                    $("<li class='ui-state-highlight student' id='"+ui.draggable.attr('id')+"'>"+ui.draggable.html()+"&nbsp;<a href='#'>[x]</a></li>").appendTo(this);
                    ui.draggable.css({display:'none'});
                    avgPoints();
                }
            });
            tab_counter++;
        }

        // close icon: removing the tab on click
        $("#groups span.ui-icon-close").live("click",function(){
            var indx = $("li",$tabs).index($(this).parent());
			$('#gl'+(indx+1)).children().each(function(){
                    var lid=$(this).attr('id');
					$("#studentlist > #"+lid).show();
            });
            $tabs.tabs("remove", indx);
            var groupnum=1;
            $("#grouptabs li a").each(function(){$(this).text("Group "+groupnum);groupnum++;});
			tab_counter--;
            avgPoints();
        });
		
        $("#class").change(function(){
            var value=$(this).val();
            $.ajax({  
                type: "POST",  
                url: "../jx/roster.php?v="+jQuery.Guid.New(),  
                data: "class="+value,  
                success: function(data){
                    var insert=data;
                    $("#studentbox").html(insert);
                    $("#studentlist li").draggable({appendTo: "body",helper: "clone",cursor: "move",revert: "invalid"});
                }  
            });
        }); 
		
        $("#pid").keyup(function(){
            check_availability(); 
        });
        
        function check_availability(){//function to check project name availability  
            $.ajax({
                type:"POST",  
                url: "../jx/projname.php?v="+jQuery.Guid.New(),  
                data: "projname="+$('#pid').val()+"&sid="+jQuery.Guid.New(),
                success:function(data){
                    (data=='1')? ($("#pid").css('backgroundColor','#E17009'),$("#projname").show()) : ($("#pid").css('backgroundColor','#FFF'),$("#projname").hide());
                }
            });
        }

        function avgPoints(){
            var ngroups = $('#groups').tabs("length");
            var nkids=0;
            $('.grouplist li').each(function(){($(this).text()!="Add students here")? nkids++ : ngroups--;});
            var npoints=(nkids/ngroups)*6+1;
            $("#recpnt").text(""+npoints+"");
            (npoints>0)? $("#avgpnts").show() : $("#avgpnts").hide();
        }

        $('li>a').live('click', function(){
		var id=$(this).parent().attr('id');
		$(this).parent().remove();
		$("#studentlist > #"+id).show();
		avgPoints();
		});

        $('#add_tab').click(function(){addTab();return false;});            

        $("form#newproj").submit(function(){
            var strng='';
            var prepend='group';
            var remove=' <a href="#">[x]</a>';
            $('.grouplist').each(function(index){//serialize students for each group first
                var id=prepend+"["+$(this).attr('id')+"]";
                var cntr=0;
                $(this).children().each(function(){
                    strng+="&"+id+'['+cntr+']='+$(this).attr('id');
                    cntr++;
                })
            });
            $.ajax({  
                type:"POST",  
                url: "../jx/project.php?v="+jQuery.Guid.New(),  
                data: $("#newproj").serialize()+"&numgroups="+$('#groups').tabs("length")+"&sid="+jQuery.Guid.New()+"&"+strng,
                success:function(){
                    $("#dialog").text("Project and groups successfully created!");
                    $("#dialog").dialog("open");
                },
                error:function(){
                    $("#dialog").text("Project and group creation failed!");
                    $("#dialog").dialog("open");
                }  
            });  
            return false;  
        });
    });
    </script>
</html>
