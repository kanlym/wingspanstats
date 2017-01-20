<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $kill->kill_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $kill->kill_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Kills'), ['action' => 'index']) ?></li>
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
<div class="kills form large-9 medium-8 columns content">
    <?= $this->Form->create($kill) ?>
    <fieldset>
        <legend><?= __('Edit Kill') ?></legend>
        <?php
            echo $this->Form->input('character_id', ['options' => $characters]);
            echo $this->Form->input('ship_type_id', ['options' => $shipTypes]);
            echo $this->Form->input('solar_system_id', ['options' => $solarSystems]);
            echo $this->Form->input('date');
            echo $this->Form->input('value');
            echo $this->Form->input('agent_id');
            echo $this->Form->input('totalWingspanPct');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
