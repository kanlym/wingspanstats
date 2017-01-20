<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Victims'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="victims form large-9 medium-8 columns content">
    <?= $this->Form->create($victim) ?>
    <fieldset>
        <legend><?= __('Add Victim') ?></legend>
        <?php
            echo $this->Form->input('character_id', ['options' => $characters]);
            echo $this->Form->input('ships_lost');
            echo $this->Form->input('isk_lost');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
