{include file="header.tpl" h1="Корзина"}

<table class="table-products">
    <thead>
    <th>#</th>
    <th>Название</th>
    <th>Цена</th>
    <th>Количество</th>
    <th>Сумма</th>
    </thead>
    <tbody>
    {foreach from=$cart->getItems() item=product}
        <tr>
            {assign var=item value=$product->getProductModel()}
            <td>{$item->getId()}</td>
            <td>{$item->getName()}</td>
            <td>{$item->getPrice()}</td>
            <td>{$product->getAmount()}</td>
            <td>{$product->getTotal()}</td>
            <td><form action="/shop/cart/remove?id={$item->getId()}" method="post" style="display:inline"><input type="hidden" name="id" value="{$item->getId()}"><input type="submit" value="Удалить"></form></td>
        </tr>
    {/foreach}
    </tbody>
</table>
{include file="bottom.tpl"}