<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Agent Kill'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Kills'), ['controller' => 'Kills', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Kill'), ['controller' => 'Kills', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Corporations'), ['controller' => 'Corporations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Corporation'), ['controller' => 'Corporations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="agentKills index large-9 medium-8 columns content">
    <h3><?= __('Agent Kills') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('character_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('kill_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('killingBlow') ?></th>
                <th scope="col"><?= $this->Paginator->sort('damageDone') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ship_type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('corporation_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($agentKills as $agentKill): ?>
            <tr>
                <td><?= $this->Number->format($agentKill->id) ?></td>
                <td><?= $agentKill->has('character') ? $this->Html->link($agentKill->character->character_name, ['controller' => 'Characters', 'action' => 'view', $agentKill->character->character_id]) : '' ?></td>
                <td><?= $agentKill->has('kill') ? $this->Html->link($agentKill->kill->kill_id, ['controller' => 'Kills', 'action' => 'view', $agentKill->kill->kill_id]) : '' ?></td>
                <td><?= h($agentKill->killingBlow) ?></td>
                <td><?= $this->Number->format($agentKill->damageDone) ?></td>
                <td><?= $agentKill->has('ship_type') ? $this->Html->link($agentKill->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $agentKill->ship_type->ship_type_id]) : '' ?></td>
                <td><?= $agentKill->has('corporation') ? $this->Html->link($agentKill->corporation->corporation_name, ['controller' => 'Corporations', 'action' => 'view', $agentKill->corporation->corporation_id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $agentKill->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $agentKill->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $agentKill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agentKill->id)]) ?>
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
