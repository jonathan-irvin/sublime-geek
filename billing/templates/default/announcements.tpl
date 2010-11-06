{if $twitterusername}
{literal}<script language="javascript">
$(document).ready(function(){
  $.post("announcements.php", { action: "twitterfeed", numtweets: 5 },
    function(data){
      $("#announcementstwitterfeed").html(data);
    });
});
</script>{/literal}
<br />
<div id="announcementstwitter">
<div align="center"><a href="http://twitter.com/{$twitter.username}" target="_blank"><img src="images/twitterlogo.png" width="200" border="0" alt="{$LANG.twitterlatesttweets}" /></a></div>
<div id="announcementstwitterfeed">
<ul><li>{$LANG.loading}</li></ul>
</div>
</div>
{/if}

{foreach key=num item=announcement from=$announcements}
<p class="heading3">{$announcement.date}</p>
<p><a href="{if $seofriendlyurls}announcements/{$announcement.id}/{$announcement.urlfriendlytitle}.html{else}{$smarty.server.PHP_SELF}?id={$announcement.id}{/if}" class="heading2"><img src="images/article.gif" align="absmiddle" border="0" /> {$announcement.title}</a></p>
{$announcement.text|strip_tags|truncate:200:"..."}
{if strlen($announcement.text)>200}<p><a href="{if $seofriendlyurls}announcements/{$announcement.id}/{$announcement.urlfriendlytitle}.html{else}{$smarty.server.PHP_SELF}?id={$announcement.id}{/if}">{$LANG.more} &raquo</a></p>{/if}
<br />
{foreachelse}
<p align="center"><strong>{$LANG.announcementsnone}</strong></p>
{/foreach}

<div style="float: left; width: 100px;">
{if $prevpage}<a href="announcements.php?page={$prevpage}">{/if}&laquo; {$LANG.previouspage}{if $prevpage}</a>{/if}
</div>

<div style="float: right; width: 100px; text-align: right;">
{if $nextpage}<a href="announcements.php?page={$nextpage}">{/if}{$LANG.nextpage} &raquo;{if $nextpage}</a>{/if}
</div>

<br />

<p align="center"><img src="images/rssfeed.gif" align="middle" alt="" /> <a href="announcementsrss.php">{$LANG.announcementsrss}</a></p>

<br />