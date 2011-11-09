<?php //do NOT put anything above this line!
error_reporting(-1);
    $_GET['page']=$page='Student Input'; //Variable to set up the page title - feeds header.php
    include('../includes/header.php');//this include file has all the paths for the stylsheets and javascript in it.
    $project='756D1205-A1F8-4AFC-9239-BB9DF748A88F';//pass me a project
    $eid=$database->getEID($project);
    $gid=$database->getGroupID($project,$session->UID);
    $team=$database->groupRoster($gid,$session->UID);//get list of group members from database
    $behaviors=$database->getBehaviors($gid);
    $maxval=$database->getMaxPoints($project);
?>
<body class='two-thirds' style='min-width:105em;'>
<h1><?php echo $page;?><img src='../img/help.png' title='help'/></h1>
<form id='behaveform' method='post' action="ACTION GOES HERE">
<input type='hidden' name='id' id='id' value='<?php echo $session->UID;?>'/>
<input type='hidden' name='EID' id='EID' value='<?php echo $eid;?>'/>
   <div class='half' >
        <?php foreach($behaviors as $behave){
                $title=$behave['title'];
                $bid=$behave['id'];
                echo"<h2><a class='behavetitle' href='#' title='".$behave['notes']."'>".$behave['title']."</a></h2>";
                $c=0;
                foreach($team as $teammate){
                    $id=$teammate['id'];
                    $name=$teammate['fname']." ".$teammate['lname'];
                    echo"<div class='ui-corner-all' style='border:1px solid #A6C9E2;border-left:2em solid ".$colors[$c].";'>"
                    ."<textarea rows='5' cols='10' name='comment-$bid.$id'"
                    ."style='border:none;overflow:auto;resize:vertical;width:100%' id='needs to pull rid from dB' placeholder='Enter Comments for $name Here...'></textarea></div>";
                    ($c<6)?$c++:$c=0;//for looping through our rainbow ;)
                }
        }?>

    </div>
     <div class='third' style='position:fixed;left:51%;top:0px;min-width:330px;width:330px;'>
        <div class='half' style='display:inline;margin-right:5%;margin-left:5%'>
            <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em whole'>
                <div class='ui-corner-top ui-widget-header m-b-1em'>Student Overall Scores</div>
                <div id='pie'>Wheel goes here</div>
                <div id='eq'>

                    <ul id='slidelist' style='list-style: none;padding-left:0px;'>
                        <?php
                            $c=0;
                            
                            foreach($team as $teammate){
                                $id=$teammate['id'];
                                $name=$teammate['lname'].", ".$teammate['fname'];
                                echo"<li value='$id' title='$name' style='height:2.1em;width:25em;background-color:".$colors[$c]."'><div id='slider-$id' class='slider' style='float:left;width:35%;margin:.5em;background-color:".$colors[$c].";color:".$colors[$c].";'></div>";
                                echo"<div style='float:left;margin-top:.5em;margin-left:1em;'>$name</div><input id='sval-$id' title='$name' class='slideval' style='float:right;width:2.5em;font-weight:bold;margin-top:.2em;margin-right:.2em;' /><div class='clear'></div></li>";
                                ($c<6)?$c++:$c=0;//for looping through our rainbow ;)
                            }
                        ?>
                    </ul>

                </div>
                <div class='clear'></div>
                <div id='eq-vals'>
                    <?php
                        $c=0;
                        foreach($team as $teammate){
                            $id=$teammate['id'];

                            ($c<6)?$c++:$c=0;//for looping through our rainbow ;)
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class='ui-corner-all ui-tabs ui-widget ui-widget-content m-b-1em' style='min-width:330px;width:330p;'>
            <div class='ui-corner-top ui-widget-header m-b-1em'>Behavior Description:</div>
            <p id='explanation' >Click on a behavior name to get the description of the behavior.</p>
        </div>
    </div>
    <br/>
    <button type="submit" name='save' id='save'>Save Changes</button>
    <button type="submit" name='submit' id='submit'>Submit</button>
    <button type="reset" name='reset' id='reset' onClick='history.go(0)'>Cancel</button>
</form>
<div id='dialog'></div>
<div id='modialog'>You must fill in all comments before scoring.</div>
<script type='text/javascript' src='../js/jquery.linkedsliders.min.js'></script>
<script>
    $(function(){
	$("input:submit, button, #reset").button();
	$( "#dialog" ).dialog({
		height: 140,
		autoOpen:false,
		buttons: {
				Ok: function(){$( this ).dialog( "close" );}
				}
	});
	$( "#modialog" ).dialog({
			height: 140,
			modal: true,
			autoOpen:false,
			buttons: {
				Ok: function(){$( this ).dialog( "close" );}
				}
		});
        //slider stuff:
        function distributeVals(){
            var i=0;
            $('.slider').slider().each(function(i){
                var vid=$(this).attr('id');
                var sval = $( "#"+vid ).slider( "option", "value" );
                $('#sval-'+vid.substr(7)).val(sval);
                chart.series[0].data[i].update(y = sval);
                i++;
            });
        }
        $('.slider').slider({
            orientation: 'horizontal',
            max:21,
            min:1,
            step: 1,
			disabled: true,
            slide:function(event, ui){distributeVals();}
        }).linkedSliders({
            total:25,
            policy:'next'
        });
        $('.slideval').keyup(function(){
            var ival=$(this).val();
            var iid=$(this).attr('id');
            $('#slider-'+iid.substr(5)).slider( "option", "value", ival );
            distributeVals();
        })

        $('.behavetitle').click(function(){
            $('#explanation').text($(this).attr('title'));
            return false;
        })
        $('.ui-slider-handle').mousedown(function(){
			var comments=true;
			$('textarea').each(function(){
				comments=($(this).val().length>0)? false:true;
			});
			if(comments==true){$('#modialog').dialog("open");}else{$( ".slider" ).slider( "option", "disabled", false );}
		});
		
        //pie chart stuff:        
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'pie',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                defaultSeriesType: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.point.value;
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false
                }
            },
            xAxis: [],
            series: [{
                data: [1,21,1,1,1],
                
            }]

        });
		
		$("#submit, #save").click(function(){
		var scorenums;
		$("input[id^=sval-]").each(function(){scorenums+="&"+$(this).attr('id')+"="+$(this).val();});
		$("textarea[name^=comment-]").each(function(){scorenums+="&"+$(this).attr('name')+"="+$(this).val();});
        var id="&id="+$('#id').val();
        var method="method="+$(this).attr('id');
		$.ajax({  
                type:"POST",  
                url: "../jx/sinput.php?v="+jQuery.Guid.New(),  
                data: method+id+scorenums+"&sid="+jQuery.Guid.New(),
                success:function(){
                    $("#dialog").text("Your scoring has been submitted.");
                    $("#dialog").dialog("open");
                },
                error:function(){
                    $("#dialog").text("There was an error, please try again.");
                    $("#dialog").dialog("open");
                }  
            });
			return false;  
        });
		
    });
    </script>
    </body>
</html>
