{include file="header.tpl" h1="Список заказов"}
<p>
     <a href='/order/create'>Создать заказ</a>
</p>
<table class="table-products">
    <thead>
    <th>#</th>
    <th>Дата создания</th>
    <th>Сумма заказа</th>
    <th>#</th>
    <th>#</th>
    </thead>
    <tbody>
    {foreach from=$orders item=order}
        <tr>
            <td>{$order.id}</td>
            <td>{$order.createdAt}</td>
            <td>{$order.totalSum}</td>
            <td><a href='/order/view/{$order.id}'>Подробнее</a></td>
            <td><form action="/order/delete" method="post" style="display:inline"><input type="hidden" name="id" value="{$order.id}"><input type="submit" value="Удалить"></form></td>
        </tr>
    {/foreach}
    </tbody>
</table>
{include file="bottom.tpl"}