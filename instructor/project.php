<?php //do NOT put anything above this line!
    $_GET['page']=$page='Project Setup'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
    $classes=$database->getClasses($session->UID);//function from the database.php file - returns an array of all classes for the provided instructor ID
    //need to add option to edit existing projects!
?>

<h1><?php echo $page;?><img src='../img/help.png' title='help'/></h1>
<!-- start the form! -->
<form id='newproj'  method='post' action='procnew.php'>
    <div id='leftside' class='left half'>
        <input type='hidden' name='inst' value='<?php echo $session->UID;?>'/>
        <div class='m-b-1em'>
            <label for='class'>Class:</label> <select name='class' id='class'>
                <option selected='selected'>Choose one...</option>
                <?php
                    foreach($classes as $class){
                        $id=$class['id'];
                        $name=$class['name'];
                        echo"<option value='$id'>$name</option>";
                    }
                ?>            
            </select>
            <label for='pid' style='margin-left:2em;'>Project ID:</label> <input type='text' id='pid' name='pid' placeholder='Insert project name.' />
            <div class='ui-state-error ui-corner-all' style='display:none;font-style:italic;padding:.1em;width:210px;float:right' id='projname'>
                <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>Project name already in use!
            </div>
        </div>

        <div class='m-b-1em'>
            <button id="add_tab" title='Click to add another group tab.' style="float:right;position:relative;z-index:100;top:2.8em;right:.3em;color:#E17009">Add Group</button><span id='tabWarn' style='display:none'>&nbsp;Don't worry! The groups will be renumbered in order when the project is finalized.</span>
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

        <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em'>
            <div class='ui-corner-top ui-widget-header m-b-1em'>Project Dates:</div>
            <div class=' ui-tabs ui-widget'>
                <label for="oDate" style='margin-right:1em;'>Open Date:</label><input type="date" name="oDate" id="oDate"><br />
                <label for="cDate" style='margin-right:1em;'>Close Date:</label><input type="date" name="cDate" id="cDate" style='margin-left:-2px;'><br />
            </div>
        </div>

        <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em'>
            <div class='ui-corner-top ui-widget-header m-b-1em'>Contracts:</div>
            <div class=' ui-tabs ui-widget'>
                <div class='m-b-1em'>
                    <label>Who is creating the contract? (instructor always has override privileges)</label>
                    <div class='buttonset m-t-05em' id='radioset1'>
                        <input type="radio" name="contract" id='contract1' value="student" checked='checked' />
                        <label for='contract1' title='Allow the students to create their own contract by consensus.'>Students</label>
                        <input type="radio" name="contract" id='contract2' value="instructor" />
                        <label for='contract2' title='Have the students abide by an instructor-created contract.'>Instructor</label>
                    </div>
                </div>
            </div>
        </div>

        <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em'>
            <div class='ui-corner-top ui-widget-header m-b-1em'>Grades and Late Submissions:</div>
            <div class=' ui-tabs ui-widget'>
                <div class='m-b-1em'>
                    <label>Submit grades for (choose one):</label>
                    <div class='buttonset m-b-1em m-t-05em' id='radioset2'>
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

                <div class='m-b-1em'>
                    <label >Prevent Late Submissions:</label>
                    <div id='radioset3' class='buttonset m-b-1em m-t-05em'>
                        <input type="radio" name="late" id="lateyes" value="yes" checked='checked' /><label for="lateyes">Yes</label>
                        <input type="radio" name="late" id="lateno" value="no"/><label for="lateno">No</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id='rightside' class='right half'>
        <div id='studentbox' class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em' style='margin-top:4.8em;min-height:9.2em;'>
            <div class='ui-corner-top ui-widget-header m-b-1em'>Students:</div>
            <div class=' ui-tabs ui-widget'>Please choose a class to the left to populate the student list.</div>
        </div>

        <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em'>
            <div class='ui-corner-top ui-widget-header m-b-1em'>Evaluations:</div>
            <div class=' ui-tabs ui-widget'>
                <div class='m-b-1em'>
                    <label for='numeval'>How many evaluations? </label>
                    <input id='numeval' name='numeval' type="text" class='spin' value="2" size='4' min='0' style='display:inline' title='Grades will be averaged across all evaluations.'>
                </div>
                <div class='m-b-1em'>
                    <label for='points'>How many points to distribute per evaluation? </label>
                    <input id='points' name='points' type="text" value="2" size='4' min='0' style='display:inline' title="Decide on the 'points pool' that students have to divide between their teammates on evaluations.">
                    <br/><span class='hidden' style='font-style: italic;' id='avgpnts'>(For your average group size, we recommend <span id='recpnt'>X</span>.)</span>
                </div>
                <div id='evals'>
                    <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em half' id='e1' style='padding-bottom: 0.5em;'>
                        <div class='ui-corner-top ui-widget-header m-b-1em'>Eval 1:</div>
                        <label for="oDate" style='margin-right:1em;'>Open Date:</label><input type="date" name="e1oDate" id="e1oDate"><br />
                        <label for="cDate" style='margin-right:1em;'>Close Date:</label><input type="date" name="e1cDate" id="e1cDate" style='margin-left:-2px;'>
                    </div>
                    <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em half' id='e2' style='padding-bottom: 0.5em;'>
                        <div class='ui-corner-top ui-widget-header m-b-1em'>Eval 2:</div>
                        <label for="oDate" style='margin-right:1em;'>Open Date:</label><input type="date" name="e2oDate" id="e2oDate"><br />
                        <label for="cDate" style='margin-right:1em;'>Close Date:</label><input type="date" name="e2cDate" id="e2cDate" style='margin-left:-2px;'>
                    </div>
                </div>
            </div>    
        </div>
        <input type='submit' name='createproj' id='createproj' value='Create project' style='color:#E17009;font-size:1.5em;'>
        <input type='reset' name='reset' id='reset' value='Reset form' style='color:#E17009;font-size:1.5em;'>
    </div>

</form>
<div id="dialog" title="Dialog Title">Dialog placeholder <!-- popup success dialog --> </div>
</body>
<script type='text/Javascript'> //Whee-jQuery! 
    $("input:submit, button, #reset").button();

    var spinner = $("#points, #numeval").spinner();
    var blargh;

    $("#radioset1, #radioset2, #radioset3").buttonset();

    function datePick(){
        $('[id$=oDate], [id$=cDate]').datetimepicker({timeFormat: 'hh:mm:ss',ampm: false});
    }



    $(document).ready(function(){
        datePick();        
        var tab_count = 3;
        $("#dialog").dialog({autoOpen:false,title:"Project Creation"});//hides dialog to prepare for use as needed.
        // tabs init with a custom tab template and an "add" callback filling in the content
        var $tabs = $("#groups").tabs({
            tabTemplate: "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close right' title='Removing a group also removes any students added to the group.'>Remove Tab</span></li>",
            add: function(event, ui){
                var tab_content = "<ul class='grouplist' id='gl"+tab_count+"'><li class='placeholder' style='font-style:italic;font-weight:normal'>Add students here</li></ul>";
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

        /* testing way to capture spinner value */
        $(".ui-spinner-button").mouseup(function(){
            var padre=$(this).parent().parent().prev("input[type='text']");
            if(padre.attr('id')=='numeval'){
                var value=padre.val();
                numEvals(value);   
            }
        });
        $(".spin").keyup(function(){
            if($(this).attr('id')=='numeval'){
                var value=$(this).val();
                numEvals(value);
            }
        });
        function numEvals(value){
            var elength=$("#evals").children().length;
            var remain=elength-value;
            while(remain<0){
                elength++;
                var template = "<div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em half' id='e"+elength+"' style='padding-bottom: 0.5em;'><div class='ui-corner-top ui-widget-header m-b-1em'>Eval "+elength+":</div><label for='oDate' style='margin-right:1em;'>Open Date:</label><input type='date' name='e"+elength+"oDate' id='e"+elength+"oDate'><br /><label for='cDate' style='margin-right:1em;'>Close Date:</label><input type='date' name='e1cDate' id='e1cDate' style='margin-left:-2px;'><br /></div>";
                $("#evals").append(template);
                datePick();
                remain++;
            }
            while(remain>0){
                $("#evals").children(':last').remove();
                remain--;
            }
        }


        // actual addTab function: adds new tab using the title input from the form above
        function addTab(){
            //tab_count = $("#grouptabs").children().size()+1;
            $tabs.tabs("add","#groups-"+tab_count,"Group "+tab_count);
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
            tab_count++;
        }

        // close icon: removing the tab on click
        $("#groups span.ui-icon-close").live("click",function(){
            var indx = $("li",$tabs).index($(this).parent());
            $('#gl'+(indx+1)).children().each(function(){
                var lid=$(this).attr('id');
                $("#studentlist > #"+lid).show();
            });
            $tabs.tabs("remove", indx);
            $("#tabWarn").show();
            avgPoints();
        });

        /* fills in student list on change of class select box */
        $("#class").change(function(){
            var value=$(this).val();
            $.ajax({  
                type: "POST",  
                url: "../jx/roster.php?v="+jQuery.Guid.New(),  
                data: "class="+value,  
                success: function(data){
                    $("#studentbox").html(data);
                    $("#studentlist li").draggable({appendTo: "body",helper: "clone",cursor: "move",revert: "invalid"});
                }  
            });
        }); 

        /* tests project names aainst the database to prevent duplicates. */
        $("#pid").keyup(function(){check_availability();});

        function check_availability(){//function to check project name availability  
            $.ajax({
                type:"POST",  
                url: "../jx/projname.php?v="+jQuery.Guid.New(),  
                data: "projname="+$('#pid').val()+"&sid="+jQuery.Guid.New(),
                success:function(data){
                    (data=='1')? ($("#pid").css('backgroundColor','#F0B5B5'),$("#projname").show()) : ($("#pid").css('backgroundColor','#FFF'),$("#projname").hide());
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

        $('#add_tab').click(function(){
            addTab();
            return false;
        });

        $('#reset').click(function(){
            $(".grouplist").each(function(){
                $("#studentbox").html("Please choose class again.");
                $("#class").val('0');
                $(".hasDatepicker").val('');
                $(this).html("<li class='placeholder' style='font-style:italic;font-weight:normal'>Add students here</li>");
            })
        });

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
