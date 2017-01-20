<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $character->character_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $character->character_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Corporations'), ['controller' => 'Corporations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Corporation'), ['controller' => 'Corporations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="characters form large-9 medium-8 columns content">
    <?= $this->Form->create($character) ?>
    <fieldset>
        <legend><?= __('Edit Character') ?></legend>
        <?php
            echo $this->Form->input('character_name');
            echo $this->Form->input('corporation_id', ['options' => $corporations]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
