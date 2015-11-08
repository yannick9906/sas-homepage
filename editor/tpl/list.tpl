{include(file='base_start.tpl' args=$base)}

    <div class="content-search-header">Seiten</div>
    <div class="content-search-content">
        <table>
            <thead>
            <tr>
                <th><button class="sort" data-sort="id">ID</button></th>
                <th><button class="sort" data-sort="name">Name</button></th>
                <th><button class="sort" data-sort="type">Typ</button></th>
                <th><button class="sort" data-sort="user">Autor</button></th>
                <th><button class="sort" data-sort="version">Version</button></th>
                <th><button class="sort" data-sort="state">Sicherheit</button></th>
                <th><button class="sort" data-sort="views">Aufrufe</button></th>
                <th><button class="sort">Optionen</button></th>
            </tr>
            </thead>
            <!-- IMPORTANT, class="list" have to be at tbody -->
            <tbody class="list">
                {foreach $items item}
                    <tr>
                        <td class="id">{$item.pID}</td>
                        <td class="name">{$item.name}</td>
                        <td class="type">{$item.type}</td>
                        <td class="user">{$item.user}</td>
                        <td class="version">{$item.version}</td>
                        <td class="state">{$item.state}</td>
                        <td class="views">{$item.views}</td>
                        <td class="options"><a href="editor.php?pID={$item.pID}" class="content-search-table-option-open">Editor</a> | <a href="viewMeta.php?pID={$item.pID}" class="content-search-table-option-edit">Metadaten</a> | <a href="viewMeta.php?pID={$item.pID}" class="content-search-table-option-edit">Versionen</a> | <a href="updatePage?pID={$item.pID}&action=delete" class="content-search-table-option-delete">Löschen</a></td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
    </div>
<script>

    var options = {
        valueNames: [ 'id', 'name', 'type', 'user', 'version', 'state', 'views' ]
    };

    var userList = new List('users', options);
</script>
{include("base_end.tpl")}