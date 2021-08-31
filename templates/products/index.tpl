{include file="header.tpl" h1="Список товаров"}
<p>
    <a href='/products/add'>Добавить</a>
</p>

        <nav>
            <ul class="pagination">
                {section loop=$pages_count name=pagination}
                    <li class="page-item {if $smarty.get.p == $smarty.section.pagination.iteration}active {/if}">
                        <a class="page-link" href="{$smarty.server.PATH_INFO}?p={$smarty.section.pagination.iteration}">
                            {$smarty.section.pagination.iteration}
                        </a>
                    </li>
                {/section}
            </ul>
        </nav>

        <table class="table-products">
            <thead>
                <th>#</th>
                <th>Название товара</th>
                <th>Категория</th>
                <th>Артикул</th>
                <th>Цена</th>
                <th>Количество на складе</th>
                <th>Описание</th>
                <th>#</th>
                <th>#</th>
            </thead>
            <tbody>
            {foreach from=$products item=product}
            <tr>
                <td>{$product->getId()}</td>
                <td>{$product->getName()}
                    {if $product->getImages()}
                        <br>
                        {foreach from=$product->getImages() item=image}
                            <img src="{$image->getPath()}" alt="{$image->getName()}" width=50>
                        {/foreach}
                    {/if}
                </td>
                {assign var=productCategory value=$product->getCategory()}
                <td>{$productCategory->getName()}</td>
                <td>{$product->getArticle()}</td>
                <td>{$product->getPrice()}</td>
                <td>{$product->getAmount()}</td>
                <td>{$product->getDescription()}</td>
                <td><a href='/products/edit?id={$product->getId()}'>Редактировать</a></td>
                <td><form action="/products/delete" method="post" style="display:inline"><input type="hidden" name="id" value="{$product->getId()}"><input type="submit" value="Удалить"></form></td>
            </tr>
            {/foreach}
            </tbody>
        </table>
{include file="bottom.tpl"}