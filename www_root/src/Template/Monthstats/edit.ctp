<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $monthstat->date],
                ['confirm' => __('Are you sure you want to delete # {0}?', $monthstat->date)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Monthstats'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="monthstats form large-9 medium-8 columns content">
    <?= $this->Form->create($monthstat) ?>
    <fieldset>
        <legend><?= __('Edit Monthstat') ?></legend>
        <?php
            echo $this->Form->input('statsname');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
