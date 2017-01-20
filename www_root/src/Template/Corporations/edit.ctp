<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $corporation->corporation_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $corporation->corporation_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Corporations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="corporations form large-9 medium-8 columns content">
    <?= $this->Form->create($corporation) ?>
    <fieldset>
        <legend><?= __('Edit Corporation') ?></legend>
        <?php
            echo $this->Form->input('corporation_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
