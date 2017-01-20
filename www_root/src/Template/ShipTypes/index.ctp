<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ship Type'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shipTypes index large-9 medium-8 columns content">
    <h3><?= __('Ship Types') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ship_type_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shipTypes as $shipType): ?>
            <tr>
                <td><?= h($shipType->name) ?></td>
                <td><?= $shipType->has('ship_type') ? $this->Html->link($shipType->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $shipType->ship_type->ship_type_id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $shipType->ship_type_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shipType->ship_type_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shipType->ship_type_id], ['confirm' => __('Are you sure you want to delete # {0}?', $shipType->ship_type_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
