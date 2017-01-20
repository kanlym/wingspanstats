<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Corporation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="corporations index large-9 medium-8 columns content">
    <h3><?= __('Corporations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('corporation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('corporation_name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($corporations as $corporation): ?>
            <tr>
                <td><?= $this->Number->format($corporation->corporation_id) ?></td>
                <td><?= h($corporation->corporation_name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $corporation->corporation_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $corporation->corporation_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $corporation->corporation_id], ['confirm' => __('Are you sure you want to delete # {0}?', $corporation->corporation_id)]) ?>
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
