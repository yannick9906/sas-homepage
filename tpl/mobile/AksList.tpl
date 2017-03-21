<div class="container">
    <div class="row">
        <div class="card-panel col s12 m12">
            <img src="http://schlopolis.tk/img/other/Organigramm-Orgateam.jpg" width="100%" height="auto"/>
        </div>
        <div class="col s12 m10 offset-m1 ">
        {foreach $page.items item}
                <ul class="collection z-depth-1">
                        <li class="collection-item avatar">
                        <i class="indigo circle mdi mdi-{$item.icon}"></i>
                            <span class="title">{$item.name}</span>
                        <p>{$item.info}
                        </p>
                        <a href="#p=6&id={$item.id}" class="secondary-content"><i class="material-icons">info_outline</i></a>
                    </li>
                </ul>
        {/foreach}
        </div>
    </div>
</div>