<?php
namespace severak\vincent;

class vincent
{
	protected $cfgDir;
	protected $cache = [];

	function __construct($cfgDir)
	{
		$this->cfgDir = $cfgDir;
	}
	
	function getCfg($name)
	{
		if (!isset($this->cache[$name])) {
			$this->cache[$name] = parse_ini_file($this->cfgDir . '/' . $name . '.ini', true);
		}
		return $this->cache[$name];
	}
	
	function tables()
	{
		return $this->getCfg('tables');
	}
	
	function menu()
	{
		$menu = [];
		foreach ($this->tables() as $table=>$def) {
			$menu['/'.$table.'/list'] = $def['label'];
		}
		return $menu;
	}
	
	function form($table)
	{
		$def = $this->getCfg('tables/'.$table);
		
		if (empty($def)) {
			return null;
		}
		
		$form = new \severak\forms\form();
		$form->field('id', ['type'=>'hidden']);
		foreach ($def as $name=>$field) {
			
			if (isset($field['options'])) {
				// preprocess options
				
				list($optType, $optSrc) = explode(':',$field['options'],2);
				
				$options = [];
				
				if ($optType=='ini') {
					// ini:section
					$optIni = $this->getCfg('options');
					if (isset($optIni[$optSrc])) $options = $optIni[$optSrc];
				}
				
				if ($optType=='ref') {
					// ref:table id name
					list($table, $id, $label) = explode(' ', $optSrc);
					$rows = \Flight::rows();
					$options = $rows->execute($rows->fragment('SELECT '.$id.','.$label.' FROM '.$table.' ORDER BY '.$label.' ASC'))->fetchAll(\PDO::FETCH_KEY_PAIR);
				}
				
				$field['options'] = $options;
			}
			
			$form->field($name, $field);
		}
		$form->field('_save', ['label'=>'Save', 'type'=>'submit']);
		return $form;
	}
}