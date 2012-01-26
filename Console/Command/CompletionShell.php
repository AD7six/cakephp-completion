<?php

APP::uses('CommandListShell', 'Console/Command');

class CompletionShell extends CommandListShell {

	/**
	 * Echo no header
	 *
	 */
	public function startup() {
	}

	/**
	 * Not called by the autocomplet shell - this is for curious users
	 */
	public function main() {
		$this->out($this->OptionParser->help());
	}

	/**
	 * list commands
	 */
	public function commands() {
		$options = $this->_commands();
		return $this->output($options);
	}

	/**
	 * list options for the named command
	 */
	public function options() {
		if (!$this->args) {
			$parser = new ConsoleOptionParser();
		} else {
			$Shell = $this->_getShell($this->args[0]);
			if (!$Shell) {
				$parser = new ConsoleOptionParser();
			} else {
				$parser = $Shell->getOptionParser();
			}
		}

		$options = array();
		$array = $parser->options();
		foreach($array as $name => $obj) {
			$options[] = "--$name";
			$short = $obj->short();
			if ($short) {
				$options[] = "-$short";
			}
		}
		return $this->output($options);
	}

	/**
	 * list subcommands for the named command
	 */
	public function subCommands() {
		if (!$this->args) {
			return $this->output();
		}

		$options = $this->_subCommands($this->args[0]);
		return $this->output($options);
	}

	/**
	 * Guess autocomplete from the whole argument string
	 */
	public function fuzzy() {
		return $this->output();
	}

	/**
	 * getOptionParser for _this_ shell
	 */
	public function getOptionParser() {
		$translationDomain = 'bash_completion';

		$parser = AppShell::getOptionParser();

		$parser->description(__d($translationDomain, 'Used by bash to autocomplete command name, options and arguments'))
			->addSubcommand('commands', array(
				'help' => __d($translationDomain, 'Output a list of available commands'),
				'parser' => array(
					'description' => __d($translationDomain, 'List all availables'),
					'arguments' => array(
					)
				)
			))->addSubcommand('subcommands', array(
				'help' => __d($translationDomain, 'Output a list of available subcommands'),
				'parser' => array(
					'description' => __d($translationDomain, 'List subcommands for a command'),
					'arguments' => array(
						'command' => array(
							'help' => __d($translationDomain, 'The command name'),
							'required' => true,
						)
					)
				)
			))->addSubcommand('options', array(
				'help' => __d($translationDomain, 'Output a list of available options'),
				'parser' => array(
					'description' => __d($translationDomain, 'List options'),
					'arguments' => array(
						'command' => array(
							'help' => __d($translationDomain, 'The command name'),
							'required' => false,
						)
					)
				)
			))->epilog(
				array(
					'This command is not intended to be called manually',
				)
			);
		return $parser;
	}

	/**
	 * Return a list of all commands
	 *
	 * @return array
	 */
	protected function _commands() {
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
			$options[] = Inflector::variable($prefix . $shell);
		}

		return $options;
	}

	/**
	 * Return a list of subcommands for a given command
	 *
	 * @param string $commandName
	 * @return array
	 */
	protected function _subCommands($commandName) {
		$Shell = $this->_getShell($commandName);

		if (!$Shell) {
			return array();
		}

		$return = array_map('Inflector::variable', $Shell->tasks);

		$ShellReflection = new ReflectionClass('AppShell');
		$shellMethods = $ShellReflection->getMethods(ReflectionMethod::IS_PUBLIC);
		$shellMethodNames = array('main', 'help');
		foreach($shellMethods as $method) {
			$shellMethodNames[] = Inflector::variable($method->getName());
		}

		$Reflection = new ReflectionClass($Shell);
		$methods = $Reflection->getMethods(ReflectionMethod::IS_PUBLIC);
		$methodNames = array();
		foreach($methods as $method) {
			$methodNames[] = Inflector::variable($method->getName());
		}

		$return += array_diff($methodNames, $shellMethodNames);

		sort($return);

		return $return;
	}

	protected function _getShell($commandName) {
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
		$Shell->initialize();
		$Shell->loadTasks();

		return $Shell;
	}

	/**
	 * Emit results as a string, space delimited
	 *
	 * @param array $options
	 */
	protected function output($options = array()) {
		if ($options) {
			$this->out(implode($options, ' '));
		}
	}
}
