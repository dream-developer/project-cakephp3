<div class="basic_menu">
<ul>
    <li><?= $this->Html->link(__('messages add'), ['controller' => 'Messages', 'action' => 'add']) ?></li>
    <li><?= $this->Html->link(__('messages list'), ['controller' => 'Messages', 'action' => 'index']) ?></li>
    <li><?= $this->Html->link(__('edit profile'), ['controller' => 'Users', 'action' => 'edit']) ?></li>
    <li><?= $this->Html->link(__('logout'), ['controller' => 'Users', 'action' => 'login']) ?></li>
</ul>
</div>