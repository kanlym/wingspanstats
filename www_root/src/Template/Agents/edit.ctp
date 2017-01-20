<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $agent->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $agent->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Agents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="agents form large-9 medium-8 columns content">
    <?= $this->Form->create($agent) ?>
    <fieldset>
        <legend><?= __('Edit Agent') ?></legend>
        <?php
            echo $this->Form->input('character_id', ['options' => $characters]);
            echo $this->Form->input('ships_destroyed');
            echo $this->Form->input('isk_destroyed');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
