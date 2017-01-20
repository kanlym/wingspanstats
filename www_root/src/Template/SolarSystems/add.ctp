<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Solar Systems'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Solar Systems'), ['controller' => 'SolarSystems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Solar System'), ['controller' => 'SolarSystems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="solarSystems form large-9 medium-8 columns content">
    <?= $this->Form->create($solarSystem) ?>
    <fieldset>
        <legend><?= __('Add Solar System') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
