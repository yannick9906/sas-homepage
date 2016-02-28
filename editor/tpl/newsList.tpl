{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <!--<tr><th colspan="8" class="new">{if $_.perm.news_create == 1}<a href="?action=new">Neuer News Beitrag</a>{/if}</th></tr>-->
                    <tr>
                        <th style="width: 30px; max-width: 30px;">#</th>
                        <th style="width: 80% !IMPORTANT; max-width: 80%;"></th>
                        <th style="width: 250px; max-width: 250px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <tr>
                            <td>{$id}</td>
                            <td>
                                <div class="list-name">{$title}</div>
                                <div class="list-type">{$date} | {$author}</div>
                                <div class="list-type">Letzte Änderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <span class="{$stateCSS}"><i class="mdi mdi-{$stateText}"></i></span></div>
                            </td>
                            <td style="">
                                <a {if !(!$state == 0 and $_.perm.news_approve == 1)}class="disabled"{else}href="news.php?action=approve&vID={$vId}" class="approve"{/if}><i class="mdi mdi-check"></i></a><a {if !(!$state == 0 and $_.perm.news_approve == 1)}class="disabled"{else}href="news.php?action=deny&vID={$vId}" class="deny"{/if}><i class="mdi mdi-close"></i></a>
                                <a {if $_.perm.news_newVersion == 1}href="news.php?action=edit&nID={$id}" class="normal"{else}class="disabled"{/if}><i class="mdi mdi-pencil"></i></a><a {if $_.perm.news_view == 1}href="news.php?action=vers&nID={$id}" class="normal" {else} class="disabled"{/if}><i class="mdi mdi-clock"></i></a><a {if $_.perm.admin_news_del == 1}href="news.php?action=del&nID={$vId}" class="normal"{else}class="disabled"{/if}><i class="mdi mdi-delete"></i></a><br/>
                                <div>{if $stateText == "account-alert"}<span class="{$stateCSS}">Sichtung ausstehend</span>{/if}</div>
                            </td>
                        </tr>
                    {/loop}
            </table>
            <div style="position: fixed; bottom: 20px; right: 20px;">
                <div class="fab">
                    <button class="fab__primary btn btn--xl btn--green btn--fab" lx-ripple lx-tooltip="Lorem Ipsum" tooltip-position="left" onclick="parent.location='?action=new'">
                        <i class="mdi mdi-plus"></i>
                        <i class="mdi mdi-newspaper"></i>
                    </button>
                </div>
            </div>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>