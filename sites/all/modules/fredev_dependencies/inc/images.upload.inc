<?php
// Traitement pour ajouter une image
function fredev_dependencies_add_img($new_fid, $module_name, $type = 'module')
{
	if($new_fid > 0)
	{
		$file = file_load($new_fid);
		$file->status = FILE_STATUS_PERMANENT;
		file_save($file);
		file_usage_add($file, $module_name, $type, $new_fid);
	}
}

// Traitement pour modifier une image
function fredev_dependencies_delete_img($fid_del, $new_fid, $module_name, $type = 'module')
{
	if($fid_del > 0)
	{
		$file_to_remove = file_load($fid_del);
		$file_to_remove->status = 0;
		file_usage_delete($file_to_remove, $module_name, $type, $fid_del);
		file_delete($file_to_remove);
	}

	fredev_dependencies_add_img($new_fid, $module_name, $type);
}
?>