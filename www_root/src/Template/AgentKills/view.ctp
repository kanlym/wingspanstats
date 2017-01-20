<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Agent Kill'), ['action' => 'edit', $agentKill->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Agent Kill'), ['action' => 'delete', $agentKill->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agentKill->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Agent Kills'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Agent Kill'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Kills'), ['controller' => 'Kills', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Kill'), ['controller' => 'Kills', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Corporations'), ['controller' => 'Corporations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Corporation'), ['controller' => 'Corporations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="agentKills view large-9 medium-8 columns content">
    <h3><?= h($agentKill->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character') ?></th>
            <td><?= $agentKill->has('character') ? $this->Html->link($agentKill->character->character_name, ['controller' => 'Characters', 'action' => 'view', $agentKill->character->character_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Kill') ?></th>
            <td><?= $agentKill->has('kill') ? $this->Html->link($agentKill->kill->kill_id, ['controller' => 'Kills', 'action' => 'view', $agentKill->kill->kill_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ship Type') ?></th>
            <td><?= $agentKill->has('ship_type') ? $this->Html->link($agentKill->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $agentKill->ship_type->ship_type_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Corporation') ?></th>
            <td><?= $agentKill->has('corporation') ? $this->Html->link($agentKill->corporation->corporation_name, ['controller' => 'Corporations', 'action' => 'view', $agentKill->corporation->corporation_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($agentKill->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DamageDone') ?></th>
            <td><?= $this->Number->format($agentKill->damageDone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('KillingBlow') ?></th>
            <td><?= $agentKill->killingBlow ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
