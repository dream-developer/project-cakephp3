<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>   
    <?= $this->Html->css('basic_css.css') ?>
</head>
<body>
    <?php if (!($this->request->getParam('controller') === 'Users' and ($this->request->getParam('action') === 'login' or $this->request->getParam('action') === 'add'))): ?>
        <?= $this->element('menu/basic_menu') ?>
    <?php endif; ?>    
    <?= $this->Flash->render() ?>
    <div>
        <?= $this->fetch('content') ?>
    </div>
</body>
</html>