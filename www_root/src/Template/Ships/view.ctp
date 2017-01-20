<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ship'), ['action' => 'edit', $ship->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ship'), ['action' => 'delete', $ship->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ship->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ships'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ship'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ships view large-9 medium-8 columns content">
    <h3><?= h($ship->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Ship Type') ?></th>
            <td><?= $ship->has('ship_type') ? $this->Html->link($ship->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $ship->ship_type->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ship->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ships Destroyed') ?></th>
            <td><?= $this->Number->format($ship->ships_destroyed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Isk Destroyed') ?></th>
            <td><?= $this->Number->format($ship->isk_destroyed) ?></td>
        </tr>
    </table>
</div>
