3<div class="indigo white-text">
    <ul id="tabs" class="tabs indigo white-text" style="overflow: hidden;">
        <li class="tab col s2"><a class="white-text active" href="#tab1">Präsidium</a></li>
        <li class="tab col s2"><a class="white-text" href="#tab2">Fraktionen</a></li>
        <li class="tab col s2"><a class="white-text" href="#tab3">Anträge</a></li>
    </ul>
</div>
<div class="container">
    <div class="row">
        <div id="tab1" class="col s12">
            <div class="container">
                <div class="row">
                    <div class="card-panel col s12 m10 offset-m1">
                        <h5>{$page.header}</h5>
                        <p>
                            {$page.text}
                        </p>
                    </div>
                </div>
            </div>
            <style>
                img {
                    width: 100%;
                }
                h1, h2, h3, h4, h6 {
                    font-size: 24px;
                    font-weight: bold;
                }
                h5 {
                    font-weight: bold;
                }
                h6 {
                    font-weight: bold;
                }
            </style>
        </div>
        <div id="tab2" class="col s12">
            <ul class="collection">
                {foreach $page.parties item}
                    <li class="collection-item avatar">
                        {if $item.icon != " "}<img src="{$item.icon}" alt="" class="circle">{else}
                            <i class="indigo circle material-icons">people_outline</i>{/if}
                        <span class="title">{$item.name}</span>
                        <p>{$item.info}
                        </p>
                        <a href="#p=6&id={$item.id}" class="secondary-content"><i class="material-icons">info_outline</i></a>
                    </li>
                {/foreach}
            </ul>
        </div>
        <div id="tab3" class="col s12">
            <ul class="collection">
                {loop $page.appls}
                    <li class="collection-item avatar">
                        <i class="circle indigo" style="font-style: normal; font-size: 12px;">{$aNum}</i>
                        <span class="title">{$title}</span>
                        <p>{$date} von {$name}<br/>
                            {$shorttext}<span class="bg badge {$stateColor}">{$stateText}</span>
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