{include file="header.tpl" h1="Список категорий"}
<p>
    <a href='/categories/add'>Добавить</a>
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
                <td>{$category->getId()}</td>
                <td>{$category->getName()}</td>
                <td><a href='/categories/edit?id={$category->getId()}'>Редактировать</a></td>
                <td><form action="/categories/delete" method="post" style="display:inline"><input type="hidden" name="id" value="{$category->getId()}"><input type="submit" value="Удалить"></form></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
{include file="bottom.tpl"}