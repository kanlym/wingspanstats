<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Monthstat'), ['action' => 'edit', $monthstat->date]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Monthstat'), ['action' => 'delete', $monthstat->date], ['confirm' => __('Are you sure you want to delete # {0}?', $monthstat->date)]) ?> </li>
        <li><?= $this->Html->link(__('List Monthstats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Monthstat'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="monthstats view large-9 medium-8 columns content">
    <h3><?= h($monthstat->date) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($monthstat->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Statsname') ?></th>
            <td><?= h($monthstat->statsname) ?></td>
        </tr>
    </table>
</div>
