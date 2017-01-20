<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Character'), ['action' => 'edit', $character->character_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Character'), ['action' => 'delete', $character->character_id], ['confirm' => __('Are you sure you want to delete # {0}?', $character->character_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Corporations'), ['controller' => 'Corporations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Corporation'), ['controller' => 'Corporations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="characters view large-9 medium-8 columns content">
    <h3><?= h($character->character_name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character Name') ?></th>
            <td><?= h($character->character_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Corporation') ?></th>
            <td><?= $character->has('corporation') ? $this->Html->link($character->corporation->corporation_name, ['controller' => 'Corporations', 'action' => 'view', $character->corporation->corporation_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Character Id') ?></th>
            <td><?= $this->Number->format($character->character_id) ?></td>
        </tr>
    </table>
</div>
