{include file="header.tpl" h1="Список задач"}

<table class="table-products">
    <thead>
    <th>#</th>
    <th>Название задачи</th>
    <th>Статус задачи</th>
    <th>#</th>
    <th>#</th>
    </thead>
    <tbody>
    {foreach from=$tasks_queue item=task}
        <tr>
            <td>{$task.id}</td>
            <td>{$task.name}</td>
            <td>{$task.status}</td>
            <td><a href='/queue/run?id={$task.id}'>Зап</a></td>
            <td><form action="/queue/delete?id={$task.id}" method="post" style="display:inline"><input type="hidden" name="id" value="{$task.id}"><input type="submit" value="Удалить"></form></td>
        </tr>
    {/foreach}
    </tbody>
</table>
{include file="bottom.tpl"}