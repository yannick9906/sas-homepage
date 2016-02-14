{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
                    <!--<tr><th colspan="8" class="new">{if $_.perm.site_create == 1}<a href="?action=new">Neue Seite</a>{/if}</th></tr>-->
                    <tr>
                        <th style="width: 30px; max-width: 30px;">#</th>
                        <th style="width: 80% !IMPORTANT; max-width: 80%;"></th>
                        <th style="width: 250px; max-width: 250px;"></th>
                    </tr>
                </thead>
                <tbody>
                    {loop $page.items}
                        <!--<tr>
                            <td>{$id}</td>
                            <td>{$type}</td>
                            <td>{$title}</td>
                            <td>{$author}</td>
                            <td>#{$version} von {$lastEditAuthor}<br/>am {$lastEdit}</td>
                            <td class="{$stateCSS}">{$stateText}</td>
                            <td>
                                <a {if !(!$state == 0 and $_.perm.site_approve == 1)}class="disabled"{else}href="sites.php?action=approve&vID={$vId}" class="edit"{/if}>GENEHMIGEN</a> | <a {if !(!$state == 0 and $_.perm.site_approve == 1)}class="disabled"{else}href="sites.php?action=deny&vID={$vId}" class="delete"{/if}>ABLEHNEN</a><br/>
                                <a {if $_.perm.site_newVersionAll == 1 or ($_.perm.site_newVersionOwn and $author == $_.header.uID)}href="sites.php?action=edit&pID={$id}" class="edit"{else}class="disabled"{/if}>BEARBEITEN</a> | <a {if $_.perm.site_view == 1}href="sites.php?action=vers&pID={$id}" class="version" {else} class="disabled"{/if}>VERSIONEN</a> | <a {if $_.perm.admin_site_del == 1}href="sites.php?action=del&vID={$vId}" class="delete"{else}class="disabled"{/if}>LÖSCHEN</a>
                            </td>
                        </tr>-->
                        <tr>
                            <td>{$id}</td>
                            <td>
                                <div class="list-name">{$title}</div>
                                <div class="list-type">{$type} | {$author}</div>
                                <div class="list-type">Letzte Änderung: {$lastEditAuthor}, {$lastEdit} (#{$version}) <span class="{$stateCSS}"><i class="mdi mdi-{$stateText}"></i></span></div>
                            </td>
                            <td style="">
                                <a {if !(!$state == 0 and $_.perm.site_approve == 1)}class="disabled"{else}href="sites.php?action=approve&vID={$vId}" class="approve"{/if}><i class="mdi mdi-check"></i></a><a {if !(!$state == 0 and $_.perm.site_approve == 1)}class="disabled"{else}href="sites.php?action=deny&vID={$vId}" class="deny"{/if}><i class="mdi mdi-close"></i></a>
                                <a {if $_.perm.site_newVersionAll == 1 or ($_.perm.site_newVersionOwn and $author == $_.header.uID)}href="sites.php?action=edit&pID={$id}" class="normal"{else}class="disabled"{/if}><i class="mdi mdi-pencil"></i></a><a {if $_.perm.site_view == 1}href="sites.php?action=vers&pID={$id}" class="normal" {else} class="disabled"{/if}><i class="mdi mdi-clock"></i></a><a {if $_.perm.admin_site_del == 1}href="sites.php?action=del&vID={$vId}" class="normal"{else}class="disabled"{/if}><i class="mdi mdi-delete"></i></a><br/>
                                <div>{if $stateText == "account-alert"}<span class="{$stateCSS}">Sichtung ausstehend</span>{/if}</div>
                            </td>
                        </tr>
                    {/loop}
            </table>
            <div style="position: fixed; bottom: 20px; right: 20px;">
                <div class="fab">
                    <button class="fab__primary btn btn--xl btn--green btn--fab" lx-ripple lx-tooltip="Lorem Ipsum" tooltip-position="left" onclick="parent.location='?action=new'">
                        <i class="mdi mdi-plus"></i>
                        <i class="mdi mdi-file"></i>
                    </button>

                    <div class="fab__actions fab__actions--up">
                        <button class="btn btn--l btn--black btn--fab" lx-ripple lx-tooltip="AK" tooltip-position="left" onclick="opendDialog('test')"><i class="mdi mdi-account-multiple"></i></button>
                        <button class="btn btn--l btn--black btn--fab" lx-ripple lx-tooltip="Partei" tooltip-position="left"><i class="mdi mdi-receipt"></i></button>
                    </div>
                </div>
            </div>
            <lx-dialog class="dialog dialog--l" id="test" auto-close="true" onclose="closingDialog()" onscrollend="scrollEndDialog()">
            <div class="dialog__header">
                <div class="toolbar bgc-light-blue-500 pl++">
                    <span class="toolbar__label tc-white fs-title">
                        Neue Seite
                    </span>
                </div>
            </div>

            <div class="dialog__content">

            </div>

            <div class="dialog__actions">
                <button class="btn btn--m btn--black btn--flat" lx-ripple lx-dialog-close>Abbrechen</button>
                <button class="btn btn--m btn--black btn--flat" lx-ripple>Seite erstellen</button>
            </div>
        </lx-dialog>
        </div>
{include file="header.tpl" args=$header}
<script>
    angular.module('myModule', ['lumx']);

    function opendDialog(dialogId)
    {
        LxDialogService.open(dialogId);
    }

    function closingDialog()
    {
        LxNotificationService.info('Dialog closed!');
    }
</script>
</body>
</html>