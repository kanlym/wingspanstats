<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Corporation'), ['action' => 'edit', $corporation->corporation_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Corporation'), ['action' => 'delete', $corporation->corporation_id], ['confirm' => __('Are you sure you want to delete # {0}?', $corporation->corporation_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Corporations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Corporation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Characters'), ['controller' => 'Characters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Character'), ['controller' => 'Characters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="corporations view large-9 medium-8 columns content">
    <h3><?= h($corporation->corporation_name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Corporation Name') ?></th>
            <td><?= h($corporation->corporation_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Corporation Id') ?></th>
            <td><?= $this->Number->format($corporation->corporation_id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Characters') ?></h4>
        <?php if (!empty($corporation->characters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Character Name') ?></th>
                <th scope="col"><?= __('Character Id') ?></th>
                <th scope="col"><?= __('Corporation Id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($corporation->characters as $characters): ?>
            <tr>
                <td><?= h($characters->character_name) ?></td>
                <td><?= h($characters->character_id) ?></td>
                <td><?= h($characters->corporation_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Characters', 'action' => 'view', $characters->character_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Characters', 'action' => 'edit', $characters->character_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Characters', 'action' => 'delete', $characters->character_id], ['confirm' => __('Are you sure you want to delete # {0}?', $characters->character_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
