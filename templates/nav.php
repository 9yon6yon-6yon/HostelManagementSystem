<nav class="breadcrumb sl-breadcrumb">
<?php foreach ($pages as $page): ?>
        <?php if ($page['url']): ?>
            <a class="breadcrumb-item" href="<?php echo $page['url']; ?>"><?php echo $page['label']; ?></a>
        <?php else: ?>
            <span class="breadcrumb-item active"><?php echo $page['label']; ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>