<div class="indigo white-text">
    <ul class="tabs indigo white-text" style="overflow: hidden;">
        <li class="tab col s2"><a class="white-text active" href="#tab1">Orgateam</a></li>
        <li class="tab col s2"><a class="white-text" href="#tab2">Parlament</a></li>
        <li class="tab col s2"><a class="white-text" href="#tab3">AKs</a></li>
        <li class="tab col s2"><a class="white-text" href="#tab4">Sonstige</a></li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <div id="tab1" class="col s12">
            <ul class="collection">
                {foreach $page.items item}
                    {if $item.typeNo == 1}
                        <li class="collection-item">
                            <div>{$item.info} - <b>{$item.name}</b>
                                <a href="{$item.dl}" class="secondary-content indigo-text waves-effect waves-circle waves-ripple"><i class="mdi mdi-download"></i></a>
                            </div>
                        </li>
                    </paper-shadow>
                    {/if}
                {/foreach}
            </ul>
        </div>
        <div id="tab2" class="col s12">
            <ul class="collection">
                {foreach $page.items item}
                    {if $item.typeNo == 2}
                        <li class="collection-item">
                            <div>{$item.name}
                                <a href="{$item.dl}" class="secondary-content indigo-text waves-effect waves-circle waves-ripple"><i class="mdi mdi-download"></i></a>
                            </div>
                        </li>
                        </paper-shadow>
                    {/if}
                {/foreach}
            </ul>
        </div>
        <div id="tab3" class="col s12">
            <ul class="collection">
                {foreach $page.items item}
                    {if $item.typeNo <= 6 and $item.typeNo >= 3}
                        <li class="collection-item">
                            <div>{$item.name}
                                <a href="{$item.dl}" class="secondary-content indigo-text waves-effect waves-circle waves-ripple"><i class="mdi mdi-download"></i></a>
                            </div>
                        </li>
                        </paper-shadow>
                    {/if}
                {/foreach}
            </ul>
        </div>
        <div id="tab4" class="col s12">
            <ul class="collection">
                {foreach $page.items item}
                    {if $item.typeNo == 7}
                        <li class="collection-item">
                            <div>{$item.name}
                                <a href="{$item.dl}" class="secondary-content indigo-text waves-effect waves-circle waves-ripple"><i class="mdi mdi-download"></i></a>
                            </div>
                        </li>
                        </paper-shadow>
                    {/if}
                {/foreach}
            </ul>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('ul.tabs').tabs();
    });
</script>