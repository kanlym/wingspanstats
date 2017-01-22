<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tripwirestat'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tripwirestats index large-9 medium-8 columns content">
    <h3><?= __('Tripwirestats') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('character_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sigCount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('systemsVisited') ?></th>
                <th scope="col"><?= $this->Paginator->sort('systemsViewed') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tripwirestats as $tripwirestat): ?>
            <tr>
                <td><?= $this->Number->format($tripwirestat->id) ?></td>
                <td><?= $tripwirestat->has('character') ? $this->Html->link($tripwirestat->character->character_name, ['controller' => 'Characters', 'action' => 'view', $tripwirestat->character->character_id]) : '' ?></td>
                <td><?= h($tripwirestat->date) ?></td>
                <td><?= $this->Number->format($tripwirestat->sigCount) ?></td>
                <td><?= $this->Number->format($tripwirestat->systemsVisited) ?></td>
                <td><?= $this->Number->format($tripwirestat->systemsViewed) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tripwirestat->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tripwirestat->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tripwirestat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tripwirestat->id)]) ?>
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
