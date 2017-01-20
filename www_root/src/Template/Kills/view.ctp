<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Kill'), ['action' => 'edit', $kill->kill_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Kill'), ['action' => 'delete', $kill->kill_id], ['confirm' => __('Are you sure you want to delete # {0}?', $kill->kill_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Kills'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Kill'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Solar Systems'), ['controller' => 'SolarSystems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Solar System'), ['controller' => 'SolarSystems', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Agent Kills'), ['controller' => 'AgentKills', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Agent Kill'), ['controller' => 'AgentKills', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="kills view large-9 medium-8 columns content">
    <h3><?= h($kill->kill_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character') ?></th>
            <td><?= $kill->has('character') ? $this->Html->link($kill->character->character_name, ['controller' => 'Characters', 'action' => 'view', $kill->character->character_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ship Type') ?></th>
            <td><?= $kill->has('ship_type') ? $this->Html->link($kill->ship_type->name, ['controller' => 'ShipTypes', 'action' => 'view', $kill->ship_type->ship_type_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Solar System') ?></th>
            <td><?= $kill->has('solar_system') ? $this->Html->link($kill->solar_system->name, ['controller' => 'SolarSystems', 'action' => 'view', $kill->solar_system->solar_system_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Value') ?></th>
            <td><?= $this->Number->format($kill->value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Kill Id') ?></th>
            <td><?= $this->Number->format($kill->kill_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Agent Id') ?></th>
            <td><?= $this->Number->format($kill->agent_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('TotalWingspanPct') ?></th>
            <td><?= $this->Number->format($kill->totalWingspanPct) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($kill->date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Agent Kills') ?></h4>
        <?php if (!empty($kill->agent_kills)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Character Id') ?></th>
                <th scope="col"><?= __('Kill Id') ?></th>
                <th scope="col"><?= __('KillingBlow') ?></th>
                <th scope="col"><?= __('DamageDone') ?></th>
                <th scope="col"><?= __('Ship Type Id') ?></th>
                <th scope="col"><?= __('Corporation Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($kill->agent_kills as $agentKills): ?>
                
            <tr>
                <td><?= h($agentKills->id) ?></td>
                <td><?= h($agentKills->character_id) ?></td>
                <td><?= h($agentKills->kill_id) ?></td>
                <td><?= h($agentKills->killingBlow) ?></td>
                <td><?= h($agentKills->damageDone) ?></td>
                <td><?= h($agentKills->ship_type_id) ?></td>
                <td><?= h($agentKills->corporation_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'AgentKills', 'action' => 'view', $agentKills->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'AgentKills', 'action' => 'edit', $agentKills->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'AgentKills', 'action' => 'delete', $agentKills->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agentKills->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
