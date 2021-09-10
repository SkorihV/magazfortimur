{include file="header.tpl" h1="Регистрация пользователя"}

<p>
{if $error.massage}
    <div class="alert alert-warning" role="alert">
    {$error.massage}
    </div>
{/if}


<form action="#" method="POST">

    <div class="form-group">
        <label for="user-name">Имя</label>
        <input name="name" {if $smarty.post.name}value="{$smarty.post.name}"{/if} type="text" class="form-control" id="user-name" placeholder="Введите Ваше имя">
        {if $error.requiredFields.name}<div class="alert alert-danger">Заполните обязательное поле</div>{/if}
    </div>
    <br>

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

    <div class="form-group">
        <label for="user-password-repeat">Повторите пароль</label>
        <input name="password-repeat" type="password" class="form-control" id="user-password-repeat" placeholder="Повторите пароль">
        {if $error.requiredFields.passwordRepeat}<div class="alert alert-danger">Заполните обязательное поле</div>{/if}

    </div>
    <br>



    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="user-agree">
        <label class="form-check-label" for="user-agree">Согласен на обработку персональных данных</label>
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>
</p>
{include file="bottom.tpl"}