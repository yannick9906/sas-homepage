<div class="container">
    <div class="row">
        <div class="card-panel col s12 m10 offset-m1">
            <a class="btn-flat blue-text" href="#p=11&id=15">Wahlergebnisse Monarch</a><br/>
            <a class="btn-flat blue-text" href="#p=11&id=14">Wahlergebnisse Parteien</a><br/>
            <ul class="collection">
                {foreach $page.items item}
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
    </div>
</div>