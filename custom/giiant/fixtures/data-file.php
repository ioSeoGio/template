<?php 

echo "<?php";
?>

return [
<?php foreach ($items as $item): ?>
    [
<?php foreach ($item as $name => $value): ?>
        '<?= $name ?>' => <?= $value ?>,
<?php endforeach; ?>
    ],
<?php endforeach; ?>
];