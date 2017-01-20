<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Kill'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Solar Systems'), ['controller' => 'SolarSystems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Solar System'), ['controller' => 'SolarSystems', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Agent Kills'), ['controller' => 'AgentKills', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Agent Kill'), ['controller' => 'AgentKills', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="kills index large-9 medium-8 columns content">
    <h3><?= __('Kills') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('character_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ship_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('solar_system_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('kill_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('agent_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('totalWingspanPct') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($kills as $kill): ?>
            <tr>
                <td><?= $kill->has('character') ? $this->Html->link($kill->character->character_name, ['controller' => 'Characters', 'action' => 'view', $kill->character->character_id]) : '' ?></td>
                <td><?= $kill->has('ship_type') ? $this->Html->link($kill->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $kill->ship_type->ship_type_id]) : '' ?></td>
                <td><?= $kill->has('solar_system') ? $this->Html->link($kill->solar_system->name, ['controller' => 'SolarSystems', 'action' => 'view', $kill->solar_system->solar_system_id]) : '' ?></td>
                <td><?= h($kill->date) ?></td>
                <td><?= $this->Number->format($kill->value) ?></td>
                <td><?= $this->Number->format($kill->kill_id) ?></td>
                <td><?= $this->Number->format($kill->agent_id) ?></td>
                <td><?= $this->Number->format($kill->totalWingspanPct) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $kill->kill_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $kill->kill_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $kill->kill_id], ['confirm' => __('Are you sure you want to delete # {0}?', $kill->kill_id)]) ?>
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
