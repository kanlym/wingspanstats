<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $agentKill->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $agentKill->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Agent Kills'), ['action' => 'index']) ?></li>
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
<div class="agentKills form large-9 medium-8 columns content">
    <?= $this->Form->create($agentKill) ?>
    <fieldset>
        <legend><?= __('Edit Agent Kill') ?></legend>
        <?php
            echo $this->Form->input('character_id', ['options' => $characters]);
            echo $this->Form->input('kill_id', ['options' => $kills]);
            echo $this->Form->input('killingBlow');
            echo $this->Form->input('damageDone');
            echo $this->Form->input('ship_type_id', ['options' => $shipTypes]);
            echo $this->Form->input('corporation_id', ['options' => $corporations]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
