3<div class="indigo white-text">
    <ul id="tabs" class="tabs indigo white-text" style="overflow: hidden;">
        <li class="tab col s2"><a class="white-text active" href="#tab1">Gesetze</a></li>
        <li class="tab col s2"><a class="white-text" href="#tab2">Sonstige Regelungen</a></li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <div id="tab1" class="col s12">
            <ul class="collection">
                {loop $page.laws}
                    <li class="collection-item avatar">
                        <i class="circle indigo" style="font-style: normal; font-size: {if $font == "big"}12px{else}8px{/if};">{$lwNum}</i>
                        <span class="title">{$title}</span>
                        <p>{$date}<br/>
                            {$shorttext}
                        </p>
                        <span class="secondary-content">
                            <a class="waves-effect waves-circle tooltipped" target="_blank" href="{$filePath}" data-position="top" data-delay="50" data-tooltip="Antrag ansehen (in neuem Tab)">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">visibility</i>
                            </a>
                        </span>
                    </li>
                {/loop}
            </ul>
        </div>
        <div id="tab2" class="col s12">
            <ul class="collection">
                {loop $page.regl}
                    <li class="collection-item avatar">
                        <i class="circle indigo" style="font-style: normal; font-size: {if $font == "big"}12px{else}8px{/if};">{$lwNum}</i>
                        <span class="title">{$title}</span>
                        <p>{$date}<br/>
                            {$shorttext}
                        </p>
                        <span class="secondary-content">
                            <a class="waves-effect waves-circle tooltipped" target="_blank" href="{$filePath}" data-position="top" data-delay="50" data-tooltip="Antrag ansehen (in neuem Tab)">
                                <i style="margin: 0px 5px;" class="material-icons grey-text text-darken-1">visibility</i>
                            </a>
                        </span>
                    </li>
                {/loop}
            </ul>
        </div>
    </div>
</div>