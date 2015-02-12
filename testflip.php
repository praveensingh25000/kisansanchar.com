<div id="container">
    <div class="expandable-panel" id="cp-1">
        <div class="expandable-panel-heading">
            <h2>Content heading 1<span class="icon-close-open"></span></h2>
         </div>
        <div class="expandable-panel-content">
            <p>Panel HTML...</p>
        </div>
    </div>
 
    <div class="expandable-panel" id="cp-2">
        <div class="expandable-panel-heading">
            <h2>Content heading 2<span class="icon-close-open"></span></h2>
         </div>
        <div class="expandable-panel-content">
            <p>Panel HTML...</p>
 
        </div>
  </div>
 
  <div class="expandable-panel" id="cp-3">
     <div class="expandable-panel-heading">
         <h2>Content heading 3<span class="icon-close-open"></span></h2>
     </div>
     <div class="expandable-panel-content">
         <p>Panel HTML...</p>
     </div>
  </div> 
 
</div>

<style>
h2, p, ol, ul, li {
    margin:0px;
    padding:0px;
    font-size:13px;
    font-family:Arial, Helvetica, sans-serif;
}
 
#container {
    width:300px;
    margin:auto;
    margin-top:100px;
}
 
/* --------- COLLAPSIBLE PANELS ----------*/
 
.expandable-panel {
    width:100%;
    position:relative;
    min-height:50px;
    overflow:auto;
    margin-bottom: 20px;
    border:1px solid #999;
}
.expandable-panel-heading {
    width:100%;
    cursor:pointer;
    min-height:50px;
    clear:both;
    background-color:#E5E5E5;
    position:relative;
}
.expandable-panel-heading:hover {
    color:#666;
}
.expandable-panel-heading h2 {
    padding:14px 10px 9px 15px;
    font-size:18px;
    line-height:20px;
}
.expandable-panel-content {
    padding:0 15px 0 15px;
    margin-top:-999px;
}
.expandable-panel-content p {
    padding:4px 0 6px 0;
}
.expandable-panel-content p:first-child  {
    padding-top:10px;
}
.expandable-panel-content p:last-child {
    padding-bottom:15px;
}
.icon-close-open {
    width:20px;
    height:20px;
    position:absolute;
    background-image:url(icon-close-open.png);
    right:15px;
}
.expandable-panel-content img {
    float:right;
    padding-left:12px;
}
.header-active {
    background-color:#D0D7F3;
}
</style>
<script>
(function($) {
    $(document).ready(function () {
        /*-------------------- EXPANDABLE PANELS ----------------------*/
        var panelspeed = 500; //panel animate speed in milliseconds
        var totalpanels = 3; //total number of collapsible panels
        var defaultopenpanel = 0; //leave 0 for no panel open
        var accordian = false; //set panels to behave like an accordian, with one panel only ever open at once      
 
        var panelheight = new Array();
        var currentpanel = defaultopenpanel;
        var iconheight = parseInt($('.icon-close-open').css('height'));
        var highlightopen = true;
 
        //Initialise collapsible panels
        function panelinit() {
                for (var i=1; i<=totalpanels; i++) {
                    panelheight[i] = parseInt($('#cp-'+i).find('.expandable-panel-content').css('height'));
                    $('#cp-'+i).find('.expandable-panel-content').css('margin-top', -panelheight[i]);
                    if (defaultopenpanel == i) {
                        $('#cp-'+i).find('.icon-close-open').css('background-position', '0px -'+iconheight+'px');
                        $('#cp-'+i).find('.expandable-panel-content').css('margin-top', 0);
                    }
                }
        }
 
        $('.expandable-panel-heading').click(function() {
            var obj = $(this).next();
            var objid = parseInt($(this).parent().attr('ID').substr(3,2));
            currentpanel = objid;
            if (accordian == true) {
                resetpanels();
            }
 
            if (parseInt(obj.css('margin-top')) <= (panelheight[objid]*-1)) {
                obj.clearQueue();
                obj.stop();
                obj.prev().find('.icon-close-open').css('background-position', '0px -'+iconheight+'px');
                obj.animate({'margin-top':0}, panelspeed);
                if (highlightopen == true) {
                    $('#cp-'+currentpanel + ' .expandable-panel-heading').addClass('header-active');
                }
            } else {
                obj.clearQueue();
                obj.stop();
                obj.prev().find('.icon-close-open').css('background-position', '0px 0px');
                obj.animate({'margin-top':(panelheight[objid]*-1)}, panelspeed);
                if (highlightopen == true) {
                    $('#cp-'+currentpanel + ' .expandable-panel-heading').removeClass('header-active');
                }
            }
        });
 
        function resetpanels() {
            for (var i=1; i<=totalpanels; i++) {
                if (currentpanel != i) {
                    $('#cp-'+i).find('.icon-close-open').css('background-position', '0px 0px');
                    $('#cp-'+i).find('.expandable-panel-content').animate({'margin-top':-panelheight[i]}, panelspeed);
                    if (highlightopen == true) {
                        $('#cp-'+i + ' .expandable-panel-heading').removeClass('header-active');
                    }
                }
            }
        }
        
       //Uncomment these lines if the expandable panels are not a fixed width and need to resize
       /* $( window ).resize(function() {
          panelinit();
        });*/
 
        $(window).load(function() {
            panelinit();
        }); //END LOAD
    }); //END READY
})(jQuery);
</script>