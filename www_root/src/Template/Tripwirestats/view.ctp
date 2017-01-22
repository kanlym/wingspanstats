<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tripwirestat'), ['action' => 'edit', $tripwirestat->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tripwirestat'), ['action' => 'delete', $tripwirestat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tripwirestat->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tripwirestats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tripwirestat'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tripwirestats view large-9 medium-8 columns content">
    <h3><?= h($tripwirestat->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character') ?></th>
            <td><?= $tripwirestat->has('character') ? $this->Html->link($tripwirestat->character->character_name, ['controller' => 'Characters', 'action' => 'view', $tripwirestat->character->character_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tripwirestat->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('SigCount') ?></th>
            <td><?= $this->Number->format($tripwirestat->sigCount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('SystemsVisited') ?></th>
            <td><?= $this->Number->format($tripwirestat->systemsVisited) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('SystemsViewed') ?></th>
            <td><?= $this->Number->format($tripwirestat->systemsViewed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($tripwirestat->date) ?></td>
        </tr>
    </table>
</div>
