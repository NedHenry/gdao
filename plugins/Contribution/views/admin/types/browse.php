<?php
/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package Contribution
 */

contribution_admin_header(array('Types'));
?>
<p id="add-type" class="add-button">
    <a class="add" href="<?php echo uri(array('action' => 'add')); ?>">Add a Type</a>
</p>
<div id="primary">
    <?php echo flash(); ?>
    <table>
        <thead id="types-table-head">
            <tr>
                <th>Name</th>
                <th>Item Type</th>
                <th>Contributed Items</th>
                <th>File Upload</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody id="types-table-body">
<?php foreach ($contributiontypes as $type): ?>
    <tr>
        <td><strong><?php echo html_escape($type->display_name); ?></strong></td>
        <td><?php echo html_escape($type->ItemType->name); ?></td>
        <td><a href="<?php echo uri('items/browse/contributed/1/type/' . $type->item_type_id); ?>">View</a></td>
        <td><?php echo html_escape($type->file_permissions); ?></td>
        <td><a href="<?php echo uri(array('action' => 'edit', 'id' => $type->id)); ?>" class="edit">Edit</a></td>
    </tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php foot();
