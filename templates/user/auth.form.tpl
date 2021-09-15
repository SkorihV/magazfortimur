{include file="header.tpl" h1="Авторизация пользователя"}

<p>
{if $error.massage}
    <div class="alert alert-warning" role="alert">
    {$error.massage}
    </div>
{/if}


<form action="" method="post">

    <div class="form-group">
        <label for="user-email">Email</label>
        <input name="email"{if $smarty.post.email}value="{$smarty.post.email}"{/if} type="email" class="form-control" id="user-email" placeholder="name@example.com">
        {if $error.requiredFields.email}<div class="alert alert-danger">Заполните обязательное поле</div>{/if}

    </div>
    <br>

    <div class="form-group">
        <label for="user-password">Пароль</label>
        <input name="password"  type="password" class="form-control" id="user-password" placeholder="Введите пароль">
        {if $error.requiredFields.password}<div class="alert alert-danger">Заполните обязательное поле</div>{/if}

    </div>
    <br>

    <button type="submit" class="btn btn-primary">Авторизироваться</button>

</form>
</p>
{include file="bottom.tpl"}