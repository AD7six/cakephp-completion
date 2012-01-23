<?php

APP::uses('CommandListShell', 'Console/Command');

class BashCompletionShell extends CommandListShell {

	public function startup() {
	}

	public function main() {
		$this->shells();
	}

	public function shells() {
		$shellList = $this->_getShellList();

		$options = array();

		foreach($shellList as $shell => $type) {
			$prefix = '';
			if (is_array($type)) {
				$type = key($type);
				if ($type !== 'CORE' && $type !== 'APP') {
					$prefix = $type . '.';
				}
			}
			$options[] = $prefix . $shell;
		}

		$this->output($options);
	}

	public function output($options) {
		$this->out(implode($options, ' '));
	}
}
