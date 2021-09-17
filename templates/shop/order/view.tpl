{include file="header.tpl" h1="Просмотре заказа"}
{*<p>     <td><a href='/order/create'>Создать заказ</a></td></p>*}

<h1>Заказ №</h1>

<table class="table-products">
    <thead>
    <th>#</th>
    <th>Итого</th>
{*    <th>Сумма заказа</th>*}
{*    <th>#</th>*}
{*    <th>#</th>*}
    </thead>
    <tbody>
    {foreach from=$order.items item=item}
        <tr>
            <td>{$item.product_id}</td>
            <td>{$item.totalSum}</td>
{*            <td>{$order.totalSum}</td>*}
{*            <td><a href='/order/view/{$order.id}'>Подробнее</a></td>*}
{*            <td><form action="/order/delete" method="post" style="display:inline"><input type="hidden" name="id" value="{$order.id}"><input type="submit" value="Удалить"></form></td>*}
        </tr>
    {/foreach}
    </tbody>
</table>
{include file="bottom.tpl"}