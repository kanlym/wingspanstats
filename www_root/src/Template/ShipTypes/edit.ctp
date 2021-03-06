<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shipType->ship_type_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shipType->ship_type_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ship Types'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ship Types'), ['controller' => 'ShipTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ship Type'), ['controller' => 'ShipTypes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="shipTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($shipType) ?>
    <fieldset>
        <legend><?= __('Edit Ship Type') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
