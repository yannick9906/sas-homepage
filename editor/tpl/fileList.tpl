{include file="base.tpl"}
<div class="content">
            <table class="pages">
                <thead>
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
                                <div class="list-type">{$filename}</div>
                            </td>
                            <td style="">
                                <a {if $_.perm.file_create == 2}href="files.php?action=edit&fID={$id}" class="normal"{else}class="disabled"{/if}><i class="mdi mdi-pencil"></i></a><a {if $_.perm.admin_file_del == 1}href="files.php?action=del&fID={$id}" class="normal"{else}class="disabled"{/if}><i class="mdi mdi-delete"></i></a><br/>
                            </td>
                        </tr>
                    {/loop}
            </table>
            <div style="position: fixed; bottom: 20px; right: 20px;">
                <div class="fab">
                    <button class="fab__primary btn btn--xl btn--green btn--fab" lx-ripple lx-tooltip="Lorem Ipsum" tooltip-position="left" onclick="parent.location='?action=new'">
                        <i class="mdi mdi-upload"></i>
                        <i class="mdi mdi-file"></i>
                    </button>
                </div>
            </div>
        </div>
{include file="header.tpl" args=$header}
</body>
</html>