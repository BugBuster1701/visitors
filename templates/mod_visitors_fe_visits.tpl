<!-- indexer::stop -->
<div class="<?php echo $this->class; ?> block"<?php echo $this->cssID; ?><?php if ($this->style): ?> style="<?php echo $this->style; ?>"<?php endif; ?>>
<?php if ($this->headline): ?>
<<?php echo $this->hl; ?>><?php echo $this->headline; ?></<?php echo $this->hl; ?>>
<?php endif; ?>

<?php foreach ($this->visitors as $visitor): ?>
<span class="visitor_count invisible">{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::count}}</span>
<div class="visitor_name"       ><div id="VisitorsNameLegend"><?php echo $visitor['VisitorsNameLegend'];               ?></div><div id="VisitorsName"       >{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::name}}</div></div>
<div class="visitor_useronline" ><div id="VisitorsOnlineCountLegend"><?php echo $visitor['VisitorsOnlineCountLegend']; ?></div><div id="VisitorsOnlineCount">{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::online}}</div></div>
<div class="visitor_visitstoday"><div id="TodayVisitCountLegend"><?php echo $visitor['TodayVisitCountLegend'];         ?></div><div id="TodayVisitCount"    >{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::todayvisit}}</div></div>
<div class="visitor_visitstotal"><div id="TotalVisitCountLegend"><?php echo $visitor['TotalVisitCountLegend'];         ?></div><div id="TotalVisitCount"    >{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::totalvisit}}</div></div>
<div class="visitor_average" ><?php if ($visitor['AverageVisits']): ?><div id="AverageVisitsLegend"><?php echo $visitor['AverageVisitsLegend']; ?>&nbsp;&Oslash;</div><div id="AverageVisits">{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::averagevisits}}</div><?php endif; ?></div>
<?php if ($visitor['VisitorsStartDate']): ?><div class="visitor_countsince" ><div id="VisitorsStartDateLegend"><?php echo $visitor['VisitorsStartDateLegend']; ?></div><div id="VisitorsStartDate">&nbsp;{{cache_visitors::<?php echo $visitor['VisitorsKatID']; ?>::start}}</div></div><?php endif; ?>
<?php endforeach; ?>
</div>
<!-- indexer::continue -->