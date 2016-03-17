<div class="container">
    <div class="row">
        <div class="card-panel col s12 m10 offset-m1">
            <ul class="collection">
                {foreach $page.items item}
                    <li class="collection-item avatar">
                    <i class="indigo circle mdi mdi-{$item.icon}"></i>
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