var Weather=null;var console=window.console||{log:function(){}};var theme=$.cookie("theme");$(document).ready(function(){function e(){$("table#delTable tr:odd").addClass("tblOclr");$("table#delTable tr:even").addClass("tblEclr");$("table#delTable tr:first").addClass("tblFclr");$("table#delTable td").addClass("tblbrdr");$("button").button();$("#buttonDiv").buttonset()}function t(){$("#delTable").fadeOut(900,function(){$(this).html('<p><div id="foo"> </div></p>').fadeIn(600);var e=$("#Style a").css("color");var t={lines:15,length:55,width:8,radius:55,corners:.8,rotate:5,color:e,speed:2.1,trail:75,shadow:true,hwaccel:false,className:"spinner",zIndex:2e9,top:"2px",left:"100px"};var n=document.getElementById("foo");var r=(new Spinner(t)).spin(n)});$("#Database").fadeOut(1e3,function(){$("#NewTicket, #tStat, #linx, #eTicket, #Style").slideUp("slow");$(this).load("dbb.php",function(){e()}).fadeIn(2500)})}function n(){setTimeout("window.location.reload()",10)}function r(e){$('<div class="notice"></div>').append('<div class="skin"></div>').append('<b class="Gclose" title="Close Notice">x</b>').append($('<div class="content"></div>').html($(e))).hide().appendTo("#growl").fadeTo("slow",.33).animate({top:"-=405",opacity:"0.8",left:"-10"},1500);$(".notice").fadeOut(4500)}if($.cookie("theme")){$("link").attr({href:$.cookie("theme"),rel:"stylesheet",type:"text/css"})}if($.cookie("Weather")){$("#tacWeather").load("TACweather.php").fadeIn(1e3)}$("#email img").live("click",function(){$("#dialog").dialog("open");return false});$("#dialog").dialog({autoOpen:false,height:625,width:325,modal:false,title:"Email Subscribers",resizeable:false,closeOnEscape:true,open:function(){$(this).load("e2mails.html")},close:function(e,t){$(this).remove();setTimeout("window.location.reload()",10)}});Weather=$.cookie("Weather");$("#NewTicket").load("NewTicket.php");e();$("#linx").load("links.php");$("#eTicket").load("eTicket.php");$("#tStat").load("tick2stats.php");$("#Whois").load("WhoisLogged.php");$("#NewTicket, #linx, #eTicket, #tStat, #Style").hide();$("#tacWeather").dblclick(function(){$(this).fadeOut(2e3).remove();$.cookie("Weather",null)});$("#open").live("click",function(){$("#NewTicket").slideToggle("slow");$("#eTicket, #linx, #tStat, #Style").slideUp("slow")});$("#links").live("click",function(){$("#linx").slideToggle("slow");$("#eTicket, #NewTicket, #tStat, #Style").slideUp("slow")});$("#tEdit").live("click",function(){$("#eTicket").slideToggle("slow");$("#NewTicket, #linx, #tStat, #Style").slideUp("slow")});$("#Stats").live("click",function(){$("#tStat").slideToggle("slow");$("#NewTicket, #linx, #eTicket, #Style").slideUp("slow")});$("#Themes").live("click",function(){$("#Style").slideToggle("slow");$("#NewTicket, #tStat, #linx, #eTicket").slideUp("slow");return false});$("#Tweather").live("click",function(){$("#tacWeather").load("TACweather.php").fadeIn(1e3);$.cookie("Weather","On",{expires:9999,path:"/"})});$("#open, #links, #tEdit, #Stats, #Themes").live("click",function(){$("#Database").toggle("drop")});$("#all_clear").live("click",function(){$(this).hide("explode",1e3);t()});$("#SubButton").live("click",function(){var e=$("input:radio[name=priority]:checked").val();var n=$("#TicketNumber").val();var r=$("#SiteName").val();var i=$("#comments").val();var s=$("#username").text();var o="ticket="+n+"&siteName="+r+"&priority="+e+"&Comments="+i+"&Creator="+s;$.ajax({url:"insertPDO.php?",type:"POST",data:o,success:function(e){if(e=="1"){$("#NewTicket").html('<p id="success"><b>Awesome!</b><br> <img src="loadinganimation.gif" /> <br> You posted Ticket #'+n+"! <br> Let's refresh the Database.</p>").fadeIn("slow").delay(1e3).fadeOut("slow",function(){$("#NewTicket").load("NewTicket.php").fadeIn("slow");t()})}else if(e=="2"){$("#NewTicket").html('<p id="resuccess">Ticket #<strong>'+n+" </strong>has been added back into the Open Queue successfully! <br>"+"<sub>This module will automatically refresh in six seconds. </sub></p>").fadeIn("slow").delay(6e3).fadeOut("slow",function(){$("#NewTicket").load("NewTicket.php").fadeIn("slow");t()})}}});return false});$(document).keyup(function(e){if(e.keyCode==27){t()}});var i=$("#username").text();$("#del").live("click",function(){id=$(this).parent().parent().attr("id");userid="&user="+i;data="id="+id+userid;parent=$(this).parent().parent();site=$("#delTable").find("tr[id^="+id+"] td:nth-child(6)").text();$("#removal").dialog("open");$(".talk").html("<p> Are you sure you want to remove Ticket <u>#<b>"+id+" </b></u>? </p>");return false});$("#removal").dialog({autoOpen:false,height:225,width:325,modal:true,title:"Are you sure, "+i+"?",resizeable:false,closeOnEscape:true,buttons:{Okay:function(){$.ajax({type:"POST",url:"delete_row.php?",data:data,cache:false,error:function(){r("<p>Failed to remove ticket "+id+". <br> Please refresh the page and try again.</p>")},success:function(){$(this).parent().parent().fadeOut(1500,function(){$(this).remove();console.log("Ticket #"+id+" for "+site+" was removed from the open queue")})},complete:function(){$("#table").fadeOut(1e3,function(){$("#Database").load("dbb.php",function(){e()}).fadeIn("slow")})}});$(this).dialog("close");r("<p>"+i+" successfully removed <br>Ticket # "+id+" for "+site+"! </p>")},Cancel:function(){$(this).dialog("close");setTimeout("window.location.reload()",50)}}});$("#growl").find(".Gclose").live("click",function(){$(this).closest(".notice").fadeOut(850);return false});setInterval(function(){t()},555555);setInterval(function(){n()},1111111);$("#tacWeather").draggable();$("#Style a").click(function(){$("table#delTable tr:odd").addClass("tblOclr");$("table#delTable tr:even").addClass("tblEclr");$("table#delTable tr:first").addClass("tblFclr");$("table#delTable td").addClass("tblbrdr");$("link").attr("href",$(this).attr("rel"));$.cookie("theme",$(this).attr("rel"),{expires:9999,path:"/"});t();return false});$("#kill").live("click",function(){$("table#delTable tr:odd").removeClass("tblOclr");$("table#delTable tr:even").removeClass("tblEclr");$("table#delTable tr:first").removeClass("tblFclr");$("table#delTable td").removeClass("tblbrdr");$.cookie("theme",null);setTimeout("window.location.reload()",4)})});