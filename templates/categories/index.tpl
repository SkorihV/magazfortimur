{include file="header.tpl" h1="Список категорий"}
<p>
    <a href='/category/add'>Добавить</a>
</p>
        <table class="table-products">
            <thead>
                <th>#</th>
                <th>Название категории</th>
                <th>#</th>
                <th>#</th>
            </thead>
            <tbody>
            {foreach from=$categories item=category}
            <tr>
                <td>{$category.id}</td>
                <td>{$category.name}</td>
                <td><a href='/category/edit?id={$category.id}'>Редактировать</a></td>
                <td><form action="/category/delete" method="post" style="display:inline"><input type="hidden" name="id" value="{$category.id}"><input type="submit" value="Удалить"></form></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
{include file="bottom.tpl"}