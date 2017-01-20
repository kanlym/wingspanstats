<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Victim'), ['action' => 'edit', $victim->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Victim'), ['action' => 'delete', $victim->id], ['confirm' => __('Are you sure you want to delete # {0}?', $victim->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Victims'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Victim'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="victims view large-9 medium-8 columns content">
    <h3><?= h($victim->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character') ?></th>
            <td><?= $victim->has('character') ? $this->Html->link($victim->character->id, ['controller' => 'Characters', 'action' => 'view', $victim->character->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($victim->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ships Lost') ?></th>
            <td><?= $this->Number->format($victim->ships_lost) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Isk Lost') ?></th>
            <td><?= $this->Number->format($victim->isk_lost) ?></td>
        </tr>
    </table>
</div>
