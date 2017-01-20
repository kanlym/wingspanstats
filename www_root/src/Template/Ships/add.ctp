<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ships'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ships form large-9 medium-8 columns content">
    <?= $this->Form->create($ship) ?>
    <fieldset>
        <legend><?= __('Add Ship') ?></legend>
        <?php
            echo $this->Form->input('ship_type_id', ['options' => $shipTypes]);
            echo $this->Form->input('ships_destroyed');
            echo $this->Form->input('isk_destroyed');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
