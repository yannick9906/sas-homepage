1
<div class="row">
    {if $page.img != " "}<img src="{$page.img}" class="prImg col s12"/>{/if}
    <div class="card-panel col offset-s1 s10" {if $page.img != " "}style="position:relative; top: -50px;"{/if}>
        <h5 class="prHeader">{$page.title}</h5>
        <p class="prContent">
            {$page.text}
        </p>
    </div>
</div>
<style>
    img {
        width: 100%;
    }
    h2 {
        font-size: 24px;
        font-weight: bold;
    }
    h5 {
        font-size: 26px;
        font-weight: bold;
    }
    h6 {
        font-weight: bold;
    }
</style>