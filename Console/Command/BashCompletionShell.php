<?php

APP::uses('CommandListShell', 'Console/Command');

class BashCompletionShell extends CommandListShell {

	/**
	 * Echo no header
	 *
	 */
	public function startup() {
	}

	/**
	 * If there are no args - list all commands
	 * If there is one arg - it's the name of the command to run. list subcommands
	 *
	 */
	public function main() {
		$options = array();

		if (!$this->args) {
			$options = $this->commands();
		}

		if (count($this->args) === 1) {
			$options = $this->subCommands($this->args[0]);
		}

		$this->output($options);
	}

	/**
	 * Return a list of all commands
	 *
	 * @return array
	 */
	public function commands() {
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

		return $options;
	}

	/**
	 * Return a list of subcommands for a given command
	 *
	 * @param string $commandName
	 * @return array
	 */
	public function subcommands($commandName) {
		list($plugin, $name) = pluginSplit($commandName, true);

		$underscored = Inflector::underscore($name);
		$shellList = $this->_getShellList();
		if (empty($shellList[$underscored])) {
			return false;
		}
		if ($plugin === 'CORE.' || $plugin === 'APP.') {
			$plugin = '';
		}

		$name = Inflector::classify($name);
		$plugin = Inflector::classify($plugin);
		$class = $name . 'Shell';
		APP::uses($class, $plugin . 'Console/Command');

		$Shell = new $class();
		$Shell->plugin = trim($plugin, '.');

		$return = $Shell->tasks;

        $ShellReflection = new ReflectionClass('AppShell');
        $shellMethods = $ShellReflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $shellMethodNames = array('main');
        foreach($shellMethods as $method) {
            $shellMethodNames[] = $method->getName();
        }

        $Reflection = new ReflectionClass($Shell);
        $methods = $Reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $methodNames = array();
        foreach($methods as $method) {
            $methodNames[] = $method->getName();
        }

        $return += array_diff($methodNames, $shellMethodNames);

        sort($return);

        return $return;
	}

	/**
	 * Emit results as a string, space delimited
	 *
	 * @param array $options
	 */
	public function output($options) {
		if ($options) {
			$this->out(implode($options, ' '));
		}
	}
}
