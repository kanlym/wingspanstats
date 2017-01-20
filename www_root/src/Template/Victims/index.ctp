<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Victim'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="victims index large-9 medium-8 columns content">
    <h3><?= __('Victims') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('character_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ships_lost') ?></th>
                <th scope="col"><?= $this->Paginator->sort('isk_lost') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($victims as $victim): ?>
            <tr>
                <td><?= $this->Number->format($victim->id) ?></td>
                <td><?= $victim->has('character') ? $this->Html->link($victim->character->id, ['controller' => 'Characters', 'action' => 'view', $victim->character->id]) : '' ?></td>
                <td><?= $this->Number->format($victim->ships_lost) ?></td>
                <td><?= $this->Number->format($victim->isk_lost) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $victim->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $victim->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $victim->id], ['confirm' => __('Are you sure you want to delete # {0}?', $victim->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
