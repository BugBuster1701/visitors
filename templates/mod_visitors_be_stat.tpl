

<div class="clear"></div>
<script type="text/javascript">
PopUp = function(autoapply){
	this.types = [];
	this.defaults = {
		width:800,
		height:600,
		top:0,
		left:0,
		location:false,
		resizable:false,
		scrollbars:false,
		status:false,
		toolbar:false,
		menubar:false,
		center:true,
		title:"<?php echo $this->visitors_export_title; ?>"
	}
	this.addType({
		name:"standard",
		location:true,
		resizable:true,
		scrollbars:true,
		status:true,
		toolbar:true,
		menubar:true
	});
	if(autoapply) this.apply();
}
o = PopUp.prototype;
o.apply = function(){
	var links = document.getElementsByTagName("form"); //a
	if(!links) return;
	for(var i=0;i<links.length;i++){
		var l = links[i];
		if(l.className.indexOf("popup") > -1){
			this.attachBehavior(l,this.getType(l));
		}
	}
}
o.addType = function(type){
	for(var prop in this.defaults){
		if(type[prop] == undefined) type[prop] = this.defaults[prop];
	}
	this.types[type.name] = type;
}
o.getType = function(l){
	for(var type in this.types){
		if(l.className.indexOf(type) > -1) return type;
	}
	return "standard";
}
o.attachBehavior = function(l,type){
	var t = this.types[type];
	l.title = t.title;
	l.popupProperties = {
		type: type,
		ref: this
	};
	l.onclick = function(){
		this.popupProperties.ref.open(this.action,this.popupProperties.type);
		return false;
	}
}
o.booleanToWord = function(bool){
	if(bool) return "yes";
	return "no";
}
o.getTopLeftCentered = function(typeObj){
	var t = typeObj;
	var r = {left:t.left, top:t.top};
	var sh = screen.availHeight-20;
	var sw = screen.availWidth-10;
	if(!sh || !sw) return r;
	r.left = (sw/2)-(t.width/2);
	r.top = (sh/2)-(t.height/2);
	return r;
}
o.getParamsOfType = function(typeObj){
	var t = typeObj;
	var c = this.booleanToWord;
	if(t.center){
		var tc = this.getTopLeftCentered(typeObj);
		t.left = tc.left;
		t.top = tc.top;
	}
	var p = "width="+t.width;
	p+=",height="+t.height;
	p+=",left="+t.left;
	p+=",top="+t.top;
	p+=",location="+c(t.location);
	p+=",resizable="+c(t.resizable);
	p+=",scrollbars="+c(t.scrollbars);
	p+=",status="+c(t.status);
	p+=",toolbar="+c(t.toolbar);
	p+=",menubar="+c(t.menubar);
	return p;
}
o.open = function(url,type){
	if(!type) type = "standard";
	var t = this.types[type];
	var p = this.getParamsOfType(t);
	var w = window.open(url,t.name,p);
	if(w) w.focus();
	return false;
}
</script>
<script type="text/javascript">
window.onload = function(){ // Better use use a modern onDomReady-Event instead
	if(document.getElementById && document.getElementsByTagName){ // Check DOM
		popup = new PopUp(); // create new PopUp-Instance
		popup.addType({
			name: "info",
			width: 300,
			height: 300,
			top: 300,
			status:true
		});
		popup.apply(); // Apply Popup-Behavior to all Links using the Class "popup"		
	}
}
</script>
<?php defined('REQUEST_TOKEN') or define('REQUEST_TOKEN', 'c0n740'); ?>
<div class="tl_panel">
    <!-- Export Zeile //-->
<?php if ($this->visitorskatid>0 && $this->visitorsanzcounter>0) : ?>
    <div style="margin-left: 6px; float:left;">
<?php else: ?>
    <div style="margin-left: 6px; float:left;visibility:hidden;">
<?php endif; ?>
    <fieldset>
    <legend> <?php echo $this->visitors_exportfield; ?> </legend>
        <div style="float:left; padding-left: 4px;">
            <form method="get" class="popup info" action="<?php echo $this->visitors_base; ?>system/modules/visitors/export/VisitorsStatExport.php?tl_field=csvc&amp;tl_katid=<?php echo $this->visitorskatid; ?>">
            <div class="tl_formbody">
                <input type="submit" value="CSV ','" alt="Export CSV ," class="tl_submit"/>
            </div>
            </form>
        </div>
        <div style="float:left; padding-left: 6px;">
            <form method="get" class="popup info" action="<?php echo $this->visitors_base; ?>system/modules/visitors/export/VisitorsStatExport.php?tl_field=csvs&amp;tl_katid=<?php echo $this->visitorskatid; ?>">
            <div class="tl_formbody">
                <input type="submit" value="CSV ';'" alt="Export CSV ;" class="tl_submit"/>
            </div>
            </form>
        </div>
        <div style="float:left; padding-left: 6px;">
            <form method="get" class="popup info" action="<?php echo $this->visitors_base; ?>system/modules/visitors/export/VisitorsStatExport.php?tl_field=excel&amp;tl_katid=<?php echo $this->visitorskatid; ?>">
            <div class="tl_formbody">
                <input type="submit" value="Excel" alt="Export Excel" class="tl_submit"/>
            </div>
            </form>
        </div>
    </fieldset>
    <div style="text-align:center;"><?php echo "(".$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['visit'].",".$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['hit'].")" ?></div>
    </div>
    <!-- Export Zeile Ende //-->
    <!-- Kategorie Zeile //-->
    <fieldset style="margin-right: 6px; float:right;">
    <legend> <?php echo $this->visitorsstatkat; ?> </legend>
        <div style="float:left; padding-right: 6px;">
            <form method="post" class="info" action="<?php echo $this->visitors_base_be; ?>/main.php?do=visitorstat">
            <div class="tl_formbody">
                <!-- <input type="hidden" value="visitorstat" name="do" />  //-->
                <input type="hidden" name="REQUEST_TOKEN" value="<?php echo REQUEST_TOKEN; ?>">
                <select class="tl_select" name="id" style="width:300px;">
                <?php foreach ($this->visitorskats as $visitorskat): ?>
                    <?php if ($visitorskat['id']==$this->visitorskatid) : ?>
                    <option selected="selected" value="<?php echo $visitorskat['id']; ?>"><?php echo $visitorskat['title']; ?></option>
                    <?php else: ?>
                    <option value="<?php echo $visitorskat['id']; ?>"><?php echo $visitorskat['title']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
                </select>
                <input class="tl_img_submit" type="image" alt="<?php echo specialchars($GLOBALS['TL_LANG']['MSC']['showOnly']); ?>" title="<?php echo specialchars($GLOBALS['TL_LANG']['MSC']['showOnly']); ?>" value="statistics" src="system/themes/<?php echo $this->theme; ?>/images/reload.gif" />
            </div>
            </form>
        </div>
     </fieldset>
     <!-- Kategorie Ende //-->
    <div class="clear"></div>
</div>
<br /> <br />
<?php if ($this->visitorsanzcounter==0) : ?>
	<table cellpadding="0" cellspacing="0" summary="Table lists records" class="mod_visitors_be_table_max">
	<tbody>
	<tr>
	    <td class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['no_data']; ?></td>
	</tr>
	<tr>
	    <td>&nbsp;</td>
	</tr>
	</tbody>
	</table>
<?php endif; ?>
<!-- Schleife ueber alle Counter -->
<?php for ($vcid=0; $vcid<$this->visitorsanzcounter; $vcid++) : ?>
<div class="tl_formbody_edit">
	<table cellpadding="0" cellspacing="0" summary="Table lists records" class="mod_visitors_be_table_max">
	<tbody>
	<tr>
	    <td style="width: 320px; padding-left: 2px;"                     class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['name']; ?></td>
	    <td style="width: 60px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['active']; ?></td>
	    <td style="width: 120px; padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['startdate']; ?></td>
	    <td style="padding-left: 2px; text-align: center;" class="tl_folder_tlist">&nbsp;</td>
	    <td style="width: 80px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['reset']; ?></td>
	    <td style="width: 40px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist">&nbsp;</td>
	</tr>
	<tr>
	    <td style="padding-left: 2px;"                     class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][0]['visitors_name']; ?></td>
	    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][0]['visitors_active']; ?></td>
	    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][0]['visitors_startdate']; ?></td>
	    <td style="padding-left: 2px; text-align: center;" class="tl_file_list">&nbsp;</td>
	    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><a href="<?php echo $this->visitors_base_be; ?>/main.php?do=visitorstat&amp;act=zero&amp;zid=<?php echo $this->visitorsstatDays[$vcid][0]['visitors_id']; ?>&amp;id=<?php echo $this->visitorskatid; ?>" title="<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zero']; ?>" onclick="if (!confirm('<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zero_confirm']; ?>')) return false; Backend.getScrollOffset();"><img src="<?php echo $this->visitors_base; ?>system/themes/<?php echo $this->theme; ?>/images/down.gif" alt="<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zero']; ?>" height="16" width="13" /></a></td>
	    <td style="padding-left: 2px; text-align: center;" class="tl_file_list">&nbsp;</td>
	</tr>
	<tr>
	    <td colspan="6">&nbsp;</td>
	</tr>
	</tbody>
	</table>
<?php if ($this->visitorsstatTotals[$vcid]['VisitorsTotalVisitCount'] >0) : ?>
<?php if ($this->visitorskatid>0) : ?>
    <div class="mod_visitors_be_II">
        <div class="mod_visitors_be_statistics">
			<table cellpadding="0" cellspacing="0" summary="Table lists statistik" class="mod_visitors_be_table">
			<tbody>
			<tr>
			    <td style="width: 120px; padding-left: 2px; text-align: left;"   class="tl_folder_tlist">&nbsp;<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['period']; ?></td>
			    <td style="min-width: 70px;  padding-right: 5px; text-align: right;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['visit']; ?></td>
			    <td style="min-width: 70px;  padding-right: 5px; text-align: right;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['hit']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['total']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatTotals[$vcid]['VisitorsTotalVisitCount']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatTotals[$vcid]['VisitorsTotalHitCount']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['today']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][100]['visitors_today_visit']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][100]['visitors_today_hit']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['yesterday']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][100]['visitors_yesterday_visit']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][100]['visitors_yesterday_hit']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['current_week']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatWeeks[$vcid]['CurrentWeekVisits']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatWeeks[$vcid]['CurrentWeekHits']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['last_week']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatWeeks[$vcid]['LastWeekVisits']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatWeeks[$vcid]['LastWeekHits']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['current_month']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatMonths[$vcid]['CurrentMonthVisits']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatMonths[$vcid]['CurrentMonthHits']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['last_month']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatMonths[$vcid]['LastMonthVisits']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatMonths[$vcid]['LastMonthHits']; ?></td>
			</tr>
<?php foreach ($this->visitorsstatOtherMonths[$vcid] AS $otherMonth) : ?>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $otherMonth[0].' '.$otherMonth[1]; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $otherMonth[2]; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $otherMonth[3]; ?></td>
			</tr>
<?php endforeach; ?>
			</tbody>
			</table>
		</div>
		<div class="mod_visitors_be_initial">
<?php if ($this->visitorsstatDays[$vcid][110]['visitors_visit_start']>0 || $this->visitorsstatDays[$vcid][110]['visitors_hit_start']>0) : ?>
            <table cellpadding="0" cellspacing="0" summary="Table lists initial" class="mod_visitors_be_table_330">
			<tbody>
			<tr>
			    <td style="width: 120px; padding-left: 2px; text-align: left;"   class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['parameter']; ?></td>
			    <td style="width: 105px; padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['visit']; ?></td>
			    <td style="width: 105px; padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['hit']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"   class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['initial_values']; ?></td>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][110]['visitors_visit_start']; ?></td>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo $this->visitorsstatDays[$vcid][110]['visitors_hit_start']; ?></td>
			</tr>
			</tbody>
			</table>
			<br />
<?php endif; ?>
            <table cellpadding="0" cellspacing="0" summary="Table lists average" class="mod_visitors_be_table_330">
			<tbody>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"  class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_legend']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_folder_tlist"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageDays']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_folder_tlist"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageDays30']; ?></td>
			    <td style="padding-left: 2px; text-align: right;" class="tl_folder_tlist"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageDays60']; ?></td>
			    
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"   class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_visits']; ?></td>
			    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageVisits']; ?></td>
			    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageVisits30']; ?></td>
			    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageVisits60']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: left;"   class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_hits']; ?></td>
			    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageHits']; ?></td>
			    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageHits30']; ?></td>
			    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatAverages[$vcid]['VisitorsAverageHits60']; ?></td>
			</tr>
			<tr>
				<td colspan="4" style="width: 330px; text-align: center; font-size: 9px;"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['average_tipp']; ?></td>
			</tr>
			</tbody>
			</table>
			<br />
			<table cellspacing="0" cellpadding="0" class="mod_visitors_be_table_330" summary="Table lists day with most visitors">
			<tbody>
			<tr>
			    <td class="tl_folder_tlist" style="padding-left: 2px; text-align: left;"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['most_visitors']; ?>:</td>
			    <td class="tl_folder_tlist" style="padding-left: 2px; text-align: right;">&nbsp;</td>
			    <td class="tl_folder_tlist" style="padding-left: 2px; text-align: right;"><?php echo $this->visitorsstatBestDay[$vcid]['VisitorsBestDayDate']; ?>&nbsp;</td>
			</tr>
			<tr>
			    <td class="tl_file_list" style="padding-left: 2px; text-align: left;"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['visitors_this_day']; ?>:</td>
			    <td class="tl_file_list" style="padding-right: 2px; text-align: right;">&nbsp;</td>
			    <td class="tl_file_list" style="padding-right: 2px; text-align: right;"><?php echo $this->visitorsstatBestDay[$vcid]['VisitorsBestDayVisits']; ?>&nbsp;</td>
			</tr>
			<tr>
			    <td class="tl_file_list" style="padding-left: 2px; text-align: left;"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['hits_this_day']; ?>:</td>
			    <td class="tl_file_list" style="padding-right: 2px; text-align: right;">&nbsp;</td>
			    <td class="tl_file_list" style="padding-right: 2px; text-align: right;"><?php echo $this->visitorsstatBestDay[$vcid]['VisitorsBestDayHits']; ?>&nbsp;</td>
			</tr>
			</tbody>
			</table>
			<br />
			<table cellspacing="0" cellpadding="0" summary="Table lists day with fewest visitors" class="mod_visitors_be_table_330">
				<tbody>
				<tr>
				    <td style="padding-left: 2px; text-align: left;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['fewest_visitors']; ?>:</td>
				    <td style="padding-left: 2px; text-align: right;" class="tl_folder_tlist">&nbsp;</td>
				    <td style="padding-left: 2px; text-align: right;" class="tl_folder_tlist"><?php echo $this->visitorsstatBadDay[$vcid]['VisitorsBadDayDate']; ?>&nbsp;</td>
	        		</tr>
				<tr>
				    <td style="padding-left: 2px; text-align: left;" class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['visitors_this_day']; ?>:</td>
				    <td style="padding-right: 2px; text-align: right;" class="tl_file_list">&nbsp;</td>
				    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatBadDay[$vcid]['VisitorsBadDayVisits']; ?>&nbsp;</td>
				</tr>
				<tr>
				    <td style="padding-left: 2px; text-align: left;" class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['hits_this_day']; ?>:</td>
				    <td style="padding-right: 2px; text-align: right;" class="tl_file_list">&nbsp;</td>
				    <td style="padding-right: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatBadDay[$vcid]['VisitorsBadDayHits']; ?>&nbsp;</td>
				</tr>
				</tbody>
			</table>
			<br />
			<table cellspacing="0" cellpadding="0" class="mod_visitors_be_table_330" summary="Table lists online">
				<tbody>
				<tr>
				    <td class="tl_folder_tlist" style="padding-left: 2px; text-align: left;"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_vivitors_stat']['currently online']; ?>:</td>
				    <td class="tl_folder_tlist" style="padding-left: 2px; text-align: right;"><?php echo $this->visitorsstatOnline[$vcid]; ?>&nbsp;</td>
				</tr>
				</tbody>
			</table>
        </div>
	</div> <!-- 2 -->
	<div style="clear:left;"></div><hr />
	<div class="mod_visitors_be_III">
		<div class="mod_visitors_be_countings">
			<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table">
			<tbody>
			<tr>
			    <td style="width: 120px; padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['date']; ?></td>
			    <td style="min-width: 70px;  padding-right: 5px; text-align: right;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['visit']; ?></td>
			    <td style="min-width: 70px;  padding-right: 5px; text-align: right;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['hit']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][0]['visitors_date'])  ? $this->visitorsstatDays[$vcid][0]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][0]['visitors_visit']) ? $this->visitorsstatDays[$vcid][0]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][0]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][0]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][1]['visitors_date'])  ? $this->visitorsstatDays[$vcid][1]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][1]['visitors_visit']) ? $this->visitorsstatDays[$vcid][1]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][1]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][1]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][2]['visitors_date'])  ? $this->visitorsstatDays[$vcid][2]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][2]['visitors_visit']) ? $this->visitorsstatDays[$vcid][2]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][2]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][2]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][3]['visitors_date'])  ? $this->visitorsstatDays[$vcid][3]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][3]['visitors_visit']) ? $this->visitorsstatDays[$vcid][3]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][3]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][3]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][4]['visitors_date'])  ? $this->visitorsstatDays[$vcid][4]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][4]['visitors_visit']) ? $this->visitorsstatDays[$vcid][4]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][4]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][4]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][5]['visitors_date'])  ? $this->visitorsstatDays[$vcid][5]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][5]['visitors_visit']) ? $this->visitorsstatDays[$vcid][5]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][5]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][5]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][6]['visitors_date'])  ? $this->visitorsstatDays[$vcid][6]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][6]['visitors_visit']) ? $this->visitorsstatDays[$vcid][6]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][6]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][6]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][7]['visitors_date'])  ? $this->visitorsstatDays[$vcid][7]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][7]['visitors_visit']) ? $this->visitorsstatDays[$vcid][7]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][7]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][7]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][8]['visitors_date'])  ? $this->visitorsstatDays[$vcid][8]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][8]['visitors_visit']) ? $this->visitorsstatDays[$vcid][8]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][8]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][8]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][9]['visitors_date'])  ? $this->visitorsstatDays[$vcid][9]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][9]['visitors_visit']) ? $this->visitorsstatDays[$vcid][9]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][9]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][9]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][10]['visitors_date'])  ? $this->visitorsstatDays[$vcid][10]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][10]['visitors_visit']) ? $this->visitorsstatDays[$vcid][10]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][10]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][10]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][11]['visitors_date'])  ? $this->visitorsstatDays[$vcid][11]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][11]['visitors_visit']) ? $this->visitorsstatDays[$vcid][11]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][11]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][11]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][12]['visitors_date'])  ? $this->visitorsstatDays[$vcid][12]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][12]['visitors_visit']) ? $this->visitorsstatDays[$vcid][12]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][12]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][12]['visitors_hit']   : ''); ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][13]['visitors_date'])  ? $this->visitorsstatDays[$vcid][13]['visitors_date']  : '&nbsp;'); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][13]['visitors_visit']) ? $this->visitorsstatDays[$vcid][13]['visitors_visit'] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: right;"  class="tl_file_list"><?php echo (isset($this->visitorsstatDays[$vcid][13]['visitors_hit'])   ? $this->visitorsstatDays[$vcid][13]['visitors_hit']   : ''); ?></td>
			</tr>
			</tbody>
			</table>
		</div>
		<div class="mod_visitors_be_chart">
		<?php echo $this->visitorsstatChart[$vcid]; ?>
        </div>
	</div> <!-- 3 -->
	<div style="clear:left;"></div><hr />
	<div class="mod_visitors_be_IV limit_height h64 block" style="height: 64px;"> 
		<div class="mod_visitors_be_browser">
			<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table_360">
			<tbody>
			<tr>
				<td colspan="5"  style="padding-left: 2px; text-align: left;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_top20']; ?></td>
				<td style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><a href="<?php echo $this->visitors_base_be; ?>/main.php?do=visitorstat&amp;act=zerobrowser&amp;zid=<?php echo $this->visitorsstatDays[$vcid][0]['visitors_id']; ?>&amp;id=<?php echo $this->visitorskatid; ?>" title="<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zerobrowser']; ?>" onclick="if (!confirm('<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zerobrowser_confirm']; ?>')) return false; Backend.getScrollOffset();"><img src="<?php echo $this->visitors_base; ?>system/themes/<?php echo $this->theme; ?>/images/down.gif" alt="<?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['zerobrowser']; ?>" height="16" width="13" /></a></td>
			</tr>
			<tr>
				<td colspan="2" style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_version']; ?></td>
			    <td colspan="2" style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_lang']; ?></td>
			    <td colspan="2" style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_os']; ?></td>
			</tr>
<?php $vsbu = 0; ?>
<?php foreach ($this->visitorsstatBrowser[$vcid] AS $browser) : ?>
<?php if ( $browser[0][0] ) : ?>
  <?php if ( $browser[0][0] != 'Unknown' && $browser[1][0] != 'Unknown' && $browser[2][0] != 'Unknown' ) : ?>
  <?php $vsbu++; ?>
			<tr>
				<td style="padding-left: 2px; text-align: left;"   class="tl_file_list"><?php echo ($browser[0][0]) ? $browser[0][0].'</td><td style="padding-left: 2px; text-align: right;"  class="tl_file_list">('.$browser[0][1].')' : '</td><td class="tl_file_list">'; ?></td>
				<td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo ($browser[1][0]) ? $browser[1][0].'</td><td style="padding-left: 2px; text-align: right;"  class="tl_file_list">('.$browser[1][1].')' : '</td><td class="tl_file_list">'; ?></td>
				<td style="padding-left: 10px; text-align: left;"  class="tl_file_list"><?php echo ($browser[2][0]) ? $browser[2][0].'</td><td style="padding-right: 2px; text-align: right;" class="tl_file_list">('.$browser[2][1].')' : '</td><td class="tl_file_list">'; ?></td>
			</tr>
  <?php endif; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if ($vsbu == 0) : ?>
			<tr>
		    	<td colspan="6"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_no_data']; ?></td>
			</tr>  
<?php endif; ?>
			</tbody>
			</table>
		</div>
		<div class="mod_visitors_be_browser_mini">
			<div class="mod_visitors_be_browser2">
				<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table">
				<tbody>
				<tr style="height: 25px;">
					<td colspan="2"  style="height: 19px; padding-left: 2px; text-align: left;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_top10']; ?></td>
				</tr>
				<tr><td style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_version']; ?></td><td style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['number']; ?></td></tr>
<?php $vsbu = 0; ?>
<?php foreach ($this->visitorsstatBrowser2[$vcid] AS $browser) : ?>
<?php if ( $browser[0] || $vsbu>0 ) : ?>
				<tr><td style="padding-left: 2px; text-align: left;"   class="tl_file_list"><?php echo ($browser[0]) ? $browser[0].'</td>' : '&nbsp;</td>'; ?><td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo ($browser[1]) ? $browser[1].'</td>' : '&nbsp;</td>'; ?></tr>
<?php $vsbu++; ?>
<?php endif; ?>
<?php endforeach; ?>
<?php if ($vsbu == 0) : ?>
				<tr><td colspan="2"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_no_data']; ?></td></tr>
<?php endif; ?>
				</tbody>
				</table>
			</div>
			<div class="mod_visitors_be_browser_other"> <!-- Unknown -->
				<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table">
				<tbody>
				<tr>
					<td colspan="2"  style="padding-left: 2px; text-align: left;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_definition']; ?></td>
				</tr>
<?php if ($this->visitorsstatBrowserDefinition[$vcid]['KNO']>0) : ?>
				<tr>
					<td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_known'].' '.$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_version'].' ('. $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_osdif'] .')'; ?></td>
					<td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatBrowserDefinition[$vcid]['KNO']; ?></td>
				</tr>
				<tr>
					<td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_unknown'].' '.$GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_version']; ?></td>
					<td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatBrowserDefinition[$vcid]['UNK']; ?></td>
				</tr>
				<tr>
					<td style="padding-left: 2px; text-align: left;"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_os'] .' ('. $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_osdif'] .')'; ?></td>
					<td style="padding-left: 2px; text-align: right;" class="tl_file_list"><?php echo $this->visitorsstatBrowserDefinition[$vcid]['OSALL']; ?></td>
				</tr>
<?php else : ?>
				<tr>
			    	<td colspan="2"  class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['browser_no_data']; ?></td>
				</tr>
<?php endif; ?>
	            </tbody>
				</table>
			</div>
		</div>
	</div> <!-- 4 -->
	<div style="clear:left;"></div>
	<hr />
	<div class="mod_visitors_be_V limit_height h64 block" style="height: 64px;"> 
		<div class="mod_visitors_be_searchenginekeywords">
			<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table_360">
			<tbody>
			<tr>
				<td colspan="3"  style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchenginekeywords_top']; ?></td>
			</tr>
			<tr>
			    <td style="width: 110px; padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengine']; ?></td>
			    <td style="padding-left: 2px; text-align: center;"               class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchenginekeywords']; ?></td>
			    <td style="width: 70px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['number']; ?></td>
			</tr>
<?php if ($this->visitorssearchengine !== false) : ?>
	<?php foreach ($this->visitorssearchenginekeywords AS $searchenginekeywords) : ?>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($searchenginekeywords[0]) ? $searchenginekeywords[0] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($searchenginekeywords[1]) ? $searchenginekeywords[1] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($searchenginekeywords[2]) ? $searchenginekeywords[2] : ''); ?></td>
			</tr>
	<?php endforeach; ?>
<?php endif; ?>
			</tbody>
			</table>
		</div>
		<div class="mod_visitors_be_searchengines"> 
			<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table">
			<tbody>
			<tr>
				<td colspan="2"  style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengines_top']; ?></td>
			</tr>
			<tr>
			    <td style="width: 90px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['visit']; ?></td>
			    <td style="padding-left: 2px; text-align: left;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['over']; ?></td>
			</tr>
<?php if ($this->visitorssearchengine !== false) : ?>
	<?php foreach ($this->visitorssearchengines AS $searchengines) : ?>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($searchengines[1]) ? $searchengines[1] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: left;" class="tl_file_list"><?php echo (isset($searchengines[0]) ? $searchengines[0] : ''); ?></td>
			</tr>
	<?php endforeach; ?>
<?php endif; ?>
			</tbody>
			</table>
		</div>
		<table cellpadding="0" cellspacing="0" summary="Table lists records" class="mod_visitors_be_table_max">
		<tbody>
<?php if ($this->visitorssearchengine === false) : ?>
		<tr>
	    	<td class="tl_file_list"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengine_no_data']; ?></td>
		</tr>
<?php else : ?>
		<tr>
	    	<td style="text-align: center; font-size: 9px;"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['searchengine_data']; ?></td>
		</tr>
<?php endif; ?>
		</tbody>
		</table>
	</div> <!-- 5 -->
	<div style="clear:left;"></div>	
	<hr />
	<div class="mod_visitors_be_VI limit_height h64 block" style="height: 64px;"> 
		<div class="mod_visitors_be_referrer">
			<table cellpadding="0" cellspacing="0" summary="Table lists countings" class="mod_visitors_be_table_360">
			<tbody>
			<tr>
				<td colspan="3"  style="padding-left: 2px; text-align: left;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_top']; ?></td>
			</tr>
			<tr>
			    <td style="padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_dns']; ?></td>
			    <td style="width: 70px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['number']; ?></td>
			    <td style="width: 20px;  padding-left: 2px; text-align: center;" class="tl_folder_tlist">&nbsp;</td>
			</tr>
<?php if ($this->visitorsstatReferrer !== false) : ?>
	<?php foreach ($this->visitorsstatReferrer[$vcid] AS $Referrer) : ?>
			<tr>
			    <td style="padding-left: 2px; text-align: left;" class="tl_file_list"><?php echo (isset($Referrer[0]) ? $Referrer[0] : ''); ?></td>
			    <td style="padding-left: 2px; text-align: center;" class="tl_file_list"><?php echo (isset($Referrer[1]) ? $Referrer[1] : ''); ?></td>
			    <td style="text-align: center;" class="tl_file_list"><?php if ($Referrer[2]) : ?><a onclick="Backend.openWindow(this, 746, 600); return false;" title="Details" href="<?php echo $this->visitors_base; ?>system/modules/visitors/ModuleVisitorReferrerDetails.php?tl_referrer=<?php echo str_rot13($Referrer[0]); ?>&amp;tl_vid=<?php echo $Referrer[2]; ?>"><img width="16" height="16" alt="Details" src="system/themes/<?php echo $this->theme; ?>/images/show.gif"></a><?php endif; ?></td>
			</tr>
	<?php endforeach; ?>
			<tr>
	    		<td colspan="3" style="text-align: center; font-size: 9px;"><br /><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['referrer_data']; ?></td>
			</tr>
<?php endif; ?>
			</tbody>
			</table>
		</div>
	</div> <!-- 6 -->
	<div style="clear:left;"></div>	
<?php endif; ?>
<?php else : ?>
	    <table cellpadding="0" cellspacing="0" summary="Table lists records" class="mod_visitors_be_table_max">
		<tbody>
		<tr>
		    <td class="tl_folder_tlist"><?php echo $GLOBALS['TL_LANG']['MSC']['tl_visitors_stat']['no_stat_data']; ?></td>
		</tr>
		<tr>
		    <td>&nbsp;</td>
		</tr>
		</tbody>
		</table>
<?php endif; ?>
</div> <!-- tl_formbody_edit -->
<!-- Schleife Ende -->
<hr />
<?php endfor; ?>
<div class="mod_visitors_be_version">
	<table cellpadding="0" cellspacing="0" summary="Table lists version" class="mod_visitors_be_table_version">
	<tbody>
	<tr>
	    <td style="padding-left: 2px; text-align:right;" class="tl_folder_tlist"><?php echo $this->visitors_version; ?></td>
	</tr>
	</tbody>
	</table>
</div>
<br /> <br />
<span style="padding-left: 18px;"><?php echo $this->visitors_footer; ?></span>