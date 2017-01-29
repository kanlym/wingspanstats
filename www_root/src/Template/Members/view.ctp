<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Member'), ['action' => 'edit', $member->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Member'), ['action' => 'delete', $member->id], ['confirm' => __('Are you sure you want to delete # {0}?', $member->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Corporations'), ['controller' => 'Corporations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Corporation'), ['controller' => 'Corporations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="members view large-9 medium-8 columns content">
    <h3><?= h($member->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Character') ?></th>
            <td><?= $member->has('character') ? $this->Html->link($member->character->character_name, ['controller' => 'Characters', 'action' => 'view', $member->character->character_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Corporation') ?></th>
            <td><?= $member->has('corporation') ? $this->Html->link($member->corporation->corporation_name, ['controller' => 'Corporations', 'action' => 'view', $member->corporation->corporation_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('LoginIP') ?></th>
            <td><?= h($member->loginIP) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($member->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('LastLogin') ?></th>
            <td><?= h($member->lastLogin) ?></td>
        </tr>
    </table>
</div>
