<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ship Type'), ['action' => 'edit', $shipType->ship_type_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ship Type'), ['action' => 'delete', $shipType->ship_type_id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipType->ship_type_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ship Types'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ship Type'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="shipTypes view large-9 medium-8 columns content">
    <h3><?= h($shipType->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($shipType->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ship Type') ?></th>
            <td><?= $shipType->has('ship_type') ? $this->Html->link($shipType->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $shipType->ship_type->ship_type_id]) : '' ?></td>
        </tr>
    </table>
</div>
