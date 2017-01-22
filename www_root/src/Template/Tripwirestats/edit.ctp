<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tripwirestat->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tripwirestat->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tripwirestats'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tripwirestats form large-9 medium-8 columns content">
    <?= $this->Form->create($tripwirestat) ?>
    <fieldset>
        <legend><?= __('Edit Tripwirestat') ?></legend>
        <?php
            echo $this->Form->input('character_id', ['options' => $characters]);
            echo $this->Form->input('date');
            echo $this->Form->input('sigCount');
            echo $this->Form->input('systemsVisited');
            echo $this->Form->input('systemsViewed');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
