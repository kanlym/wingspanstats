<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Solar System'), ['action' => 'edit', $solarSystem->solar_system_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Solar System'), ['action' => 'delete', $solarSystem->solar_system_id], ['confirm' => __('Are you sure you want to delete # {0}?', $solarSystem->solar_system_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Solar Systems'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Solar System'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Solar Systems'), ['controller' => 'SolarSystems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Solar System'), ['controller' => 'SolarSystems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="solarSystems view large-9 medium-8 columns content">
    <h3><?= h($solarSystem->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($solarSystem->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Solar System') ?></th>
            <td><?= $solarSystem->has('solar_system') ? $this->Html->link($solarSystem->solar_system->name, ['controller' => 'SolarSystems', 'action' => 'view', $solarSystem->solar_system->solar_system_id]) : '' ?></td>
        </tr>
    </table>
</div>
